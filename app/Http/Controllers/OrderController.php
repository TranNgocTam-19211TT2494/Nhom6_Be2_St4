<?php

namespace App\Http\Controllers;

use App\Mail\OrderDetail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address' => 'string|required',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'email' => 'string|required',
            'total' => 'integer|required',
            'sub_total' => 'integer|required',
            'shipping' => 'numeric|required',
        ]);
        // return $request->all();

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            request()->session()->flash('error', 'Cart is Empty !');
            return back();
        }
        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;

        $order_data['sub_total'] = $request->sub_total;
        $order_data['quantity'] = $request->quantity;
        $order_data['coupon'] = $request->coupon;
        $order_data['total_amount'] = $request->total;
        $order_data['address'] = $request->address;

        // return $order_data['total_amount'];
        $order_data['status'] = "new";
        if (request('payment_method') == 'paypal') {
            $order_data['payment_method'] = 'paypal';
            $order_data['payment_status'] = 'paid';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Unpaid';
        }
        $order->fill($order_data);
        $order->save();
        // dd($order);
        // if (request('payment_method') == 'paypal') {
        //     return redirect()->route('payment')->with(['id' => $order->id]);
        // } else {
        //     session()->forget('cart');
        //     session()->forget('coupon');
        // }
        // dd($order->id);
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // dd($users);   

        request()->session()->flash('success', 'Your product successfully placed in order');
        //gui mail
        Mail::to($request->email)->send(new OrderDetail($order->id));
        Mail::to(User::where('role', 'admin')->first())->send(new OrderDetail($order->id));
        $details = [
            'title' => 'New order created',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        $users = User::where('role', 'admin')->first();
        Notification::send($users, new StatusNotification($details));
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::findOrFail($id);
        return view('backend.order.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $order = Order::findOrFail($id);
        $order['status'] = $request->status;
        $status = $order->save();
        if ($status) {
            request()->session()->flash('success', 'Order Successfully updated');
        } else {
            request()->session()->flash('error', 'Order can not updated');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Order Successfully deleted');
            } else {
                request()->session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Order not found');
            return redirect()->back();
        }
    }
    // PDF generate
    public function pdfGenerate($id)
    {
        $order = Order::getAllOrder($id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // return $file_name;
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }
}
