@foreach($products as $product)
@php $photo = explode(',',$product->photo); @endphp
<div class="col-lg-4 col-md-6 col-sm-6  contentisotope <?php if ($product->condition == 'hot') {
                                                            echo " hot";
                                                        } else {
                                                            echo " new";
                                                        } ?>">
    <div class="product__item">
        <div class="product__item__pic set-bg" data-setbg="{{$photo[0]}}" style="background-image: url('{{$photo[0]}}');">
            <ul class="product__item__pic__hover">
                @php
                $count=0;
                if(Auth::user())
                {
                $count = App\Models\Wishlist::where(['product_id' =>
                $product->id,'user_id'=>Auth::user()->id])->count();
                }
                @endphp
                @if($count == "0")
                <li>
                    <a href="{{route('wishlist.add',$product->id)}}"> <i class="fa fa-heart"></i></a>
                </li>
                @else
                <li><a href="{{route('wishlist.remove',$product->id)}}" style="border: 1px solid red;"><i class="fa fa-heart" style="color: red;"></i></a></li>
                @endif
                <li><a href="{{route('cart.add',$product->slug)}}"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>

        </div>
        <div class="product__item__text">
            <h6><a href="{{route('product.detail',$product->slug)}}">{{$product->title}}</a>
            </h6>
            <h5>{{number_format($product->price)}}đ</h5>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
<!-- or -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<!-- Isotope -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script>
    $(function() {
        // $('.row').isotope({
        //     itemSelector: '.contentisotope',
        // });
        //ẩn div không select được đi:
        $('.nice-select').hide();
        //Xóa style:display:none; trong select;
        $('#SortbyList').removeAttr('style');
        //code cho nut
        $('#SortbyList').change(function() {
            var danhmuc = $('option:selected').attr('data-anh');
            if (danhmuc == '.all') {
                $('#updateDiv').isotope({
                    filter: '*'

                });
            } else {
                $('#updateDiv').isotope({
                    filter: danhmuc

                });
            }
            return false;
        });


    });
</script>
@endpush