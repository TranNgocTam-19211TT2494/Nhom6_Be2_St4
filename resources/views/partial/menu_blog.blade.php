<style>
    .blog__sidebar__recent__item__pic img {
        width: 90px;
    }

    .blog__sidebar__recent {
        width: 300px;
    }

    .blog__sidebar__item a {
        text-decoration: none;
        color: black;
    }
</style>
<div class="blog__sidebar">
    <div class="blog__sidebar__search">
        <form action="timkiem" method="get">
            <input type="text" name="tukhoa" placeholder="Search...">
            <button type="submit"><i class="fas fa-search"></i></span></button>
        </form>
    </div>
    <div class="blog__sidebar__item">
    
        <h4><a href="http://localhost/Nhom6_Be2_St4/public/blog">Categories</a></h4>
        <ul>
            @foreach($blog_category as $item)
            <li><a href="{{asset('blog_caterogy')}}/{{$item->id}}">{{$item->category_name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="blog__sidebar__item">
        <h4>Feature</h4>
        <div class="blog__sidebar__recent">
            <a href="http://localhost/Nhom6_Be2_St4/public/blog_detail/2" class="blog__sidebar__recent__item">
                <div class="blog__sidebar__recent__item__pic">
                    <img src="img/blog/blog-8.jpg" alt="">
                </div>
                <div class="blog__sidebar__recent__item__text">
                    <h6>Mẹo vặt với mật ong để có món ăn thơm ngon hơn</h6>
                    <span>2021-04-18 15:11:00</span>
                </div>
            </a>
            <a href="http://localhost/Nhom6_Be2_St4/public/blog_detail/4" class="blog__sidebar__recent__item">
                <div class="blog__sidebar__recent__item__pic">
                    <img src="img/blog/blog-10.jpg" alt="">
                </div>
                <div class="blog__sidebar__recent__item__text">
                    <h6>Uống nước như thế nào là đúng cách?</h6>
                    <span>2021-04-18 15:14:59</span>
                </div>
            </a>
            <a href="http://localhost/Nhom6_Be2_St4/public/blog_detail/6" class="blog__sidebar__recent__item">
                <div class="blog__sidebar__recent__item__pic">
                    <img src="img/blog/blog-12.jpg" alt="">
                </div>
                <div class="blog__sidebar__recent__item__text">
                    <h6>Chữa viêm đại tràng bằng mè đen và mật ong</h6>
                    <span>2021-04-18 15:23:21</span>
                </div>
            </a>
        </div>
    </div>

</div>