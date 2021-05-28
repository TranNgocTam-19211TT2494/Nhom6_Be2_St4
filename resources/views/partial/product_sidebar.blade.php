<div class="sidebar">
    <div class="sidebar__item">
        <h4>Department</h4>
        <ul>
            @foreach ($categories as $category)
            @php
            $countCategories=DB::table('products')->where('cat_id',$category->id)->count();
            @endphp
            <li><a href="{{route('product.category',$category->id)}}">{{$category->title}} ({{$countCategories}})</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="sidebar__item">
        <h4>Price</h4>
        <div class="price-range-wrap">
            <div class="price-range" data-min="0" data-max="0">
            </div>
            <div class="range-slider">
                <div class="price-input">
                    <input type="text" id="minamount" name="start_price" readonly="readonly">
                    <input type="text" id="maxamount" name="end_price" readonly="readonly">
                </div>
            </div>
        </div>

    </div>
    <div class="sidebar__item sidebar__item__color--option">
        <h4>Colors</h4>
        <div class="sidebar__item__color sidebar__item__color--white">
            <label for="white">
                White
                <input type="radio" id="white">
            </label>
        </div>
        <div class="sidebar__item__color sidebar__item__color--gray">
            <label for="gray">
                Gray
                <input type="radio" id="gray">
            </label>
        </div>
        <div class="sidebar__item__color sidebar__item__color--red">
            <label for="red">
                Red
                <input type="radio" id="red">
            </label>
        </div>
        <div class="sidebar__item__color sidebar__item__color--black">
            <label for="black">
                Black
                <input type="radio" id="black">
            </label>
        </div>
        <div class="sidebar__item__color sidebar__item__color--blue">
            <label for="blue">
                Blue
                <input type="radio" id="blue">
            </label>
        </div>
        <div class="sidebar__item__color sidebar__item__color--green">
            <label for="green">
                Green
                <input type="radio" id="green">
            </label>
        </div>
    </div>
    <div class="sidebar__item">
        <h4>Popular Size</h4>
        <div class="sidebar__item__size">
            <label for="large">
                Large
                <input type="radio" id="large">
            </label>
        </div>
        <div class="sidebar__item__size">
            <label for="medium">
                Medium
                <input type="radio" id="medium">
            </label>
        </div>
        <div class="sidebar__item__size">
            <label for="small">
                Small
                <input type="radio" id="small">
            </label>
        </div>
        <div class="sidebar__item__size">
            <label for="tiny">
                Tiny
                <input type="radio" id="tiny">
            </label>
        </div>
    </div>
    <div class="sidebar__item">
        <div class="latest-product__text">
            <h4>Latest Products</h4>
            <div class="latest-product__slider owl-carousel">
                @foreach($products as $position=>$product)
                @if ($position < 3) @php $image=explode(',',$product->photo); @endphp
                    {{--dd($product)--}}
                    <div class="latest-prdouct__slider__item">
                        <a href="{{route('product.detail',$product->slug)}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{$image[0]}}" alt="" style="width:100px;">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>{{$product->title}}</h6>
                                <span>{{number_format($product->price)}}đ</span>
                            </div>
                        </a>
                    </div>

                    @endif

                    @endforeach

            </div>

        </div>
    </div>

    @push('styles')
    <style>
        .price-range span {
            left: 100%;
        }

        .price-range-wrap .range-slider .price-input input {
            font-size: 16px;
            color: #dd2222;
            font-weight: 700;
            max-width: 30%;
            border: none;
            display: inline-block;
        }
    </style>
    @endpush
    @push('scripts')
    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".price-range").slider({
                range: true,
                min: 0,
                max: 1500000,
                values: [75000, 1400000],

                slide: function(event, ui) {

                    $("#minamount").val(ui.values[0]);
                    $("#maxamount").val(ui.values[1]);
                    var start = $('#minamount').val();

                    var end = $('#maxamount').val();
                    $.ajax({
                        type: 'get',
                        url: '',
                        data: "start=" + start + "&end=" + end,

                        success: function(response) {
                            console.log(response);
                            $('#updateDiv').html(response);
                            //Xóa style khi loading thanh range price không bị đẩy css:
                            $('#updateDiv').removeAttr('style');
                        }

                    });
                }
            });
        });
    </script>

    @endpush