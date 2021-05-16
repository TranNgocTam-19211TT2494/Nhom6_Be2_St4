<?php

namespace App\Http\Controllers;

use App\Classes\ActivationService;
use App\Models\Order;
use App\Models\UserActivation;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::orderBy('id', 'DESC')->paginate(10);
        return view('backend.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.users.create');
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
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required|unique:users',
                'password' => 'string|required',
                'role' => 'required|in:admin,user,mod,writter',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        // dd($data);
        $status = User::create($data);
        // dd($status);
        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }
        return redirect()->route('users.index');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
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
        $user = User::findOrFail($id);
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
                'role' => 'required|in:admin,user,mod,writter',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        // dd($data);
        $status = $user->fill($data)->save();
        // dd($status);
        if ($status) {
            request()->session()->flash('success', 'Successfully updated user');
        } else {
            request()->session()->flash('error', 'Error occurred while updating user');
        }
        return redirect()->route('users.index');
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
        $user = User::findorFail($id);
        $status = $user->delete();
        if ($status) {
            request()->session()->flash('success', 'User Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $user->fill($data);
        $user['name'] = $request->name;
        $user['photo'] = $request->photo;
        $status = $user->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated your profile');
        } else {
            request()->session()->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }
    //Doi pass user
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        request()->session()->flash('success', 'Password successfully changed');
        return redirect()->route('user.profile');
    }
    //Trang profile của user
    public function userProfile()
    {
        $profile = Auth()->user();
        return view('user.users.profile')->with('profile', $profile);
    }
    //Hiển thị toàn bộ order của user
    public function userOrder($id)
    {
        $order = Order::find($id);
        // return $order;
        return view('user.order.show')->with('order', $order);
    }
    //Active user
    public function activeUser($token)
    {
        $userActivation = new UserActivation;
        $active = new ActivationService($userActivation);
        $active->activateUser($token);
        return redirect()->route('index');
    }
    //User order index
    public function orderIndex()
    {
        $orders = Order::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders', $orders);
    }
    //User order delete
    public function userOrderDelete($id)
    {
        $order = Order::find($id);
        if ($order) {
            if ($order->status == "process" || $order->status == 'delivered' || $order->status == 'cancel') {
                return redirect()->back()->with('error', 'You can not delete this order now');
            } else {
                $status = $order->delete();
                if ($status) {
                    request()->session()->flash('success', 'Order Successfully deleted');
                } else {
                    request()->session()->flash('error', 'Order can not deleted');
                }
                return redirect()->route('user.order.index');
            }
        } else {
            request()->session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }
    //User order show detail
    public function orderShow($id)
    {
        $order = Order::find($id);
        // return $order;
        return view('user.order.show')->with('order', $order);
    }
}
