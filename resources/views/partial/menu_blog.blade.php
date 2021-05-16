<div class="blog__sidebar">
    <div class="blog__sidebar__search">
        <form action="{{route('blog.search')}}" method="get">
            <input type="text" name="tukhoa" placeholder="Search...">
            <button type="submit"><i class="fas fa-search"></i></span></button>
        </form>
    </div>
    <div class="blog__sidebar__item">

        <h4>Categories</h4>
        <ul>
            @foreach($post_categories as $item)
            <li><a href="{{route('blog.category',$item->id)}}">{{$item->title}}</a></li>
            @endforeach
        </ul>
    </div>
    <!-- Lấy các bài viết ngẫu nhiên -->
    <div class="blog__sidebar__item">
        <h4>Recent News</h4>
        <div class="blog__sidebar__recent">
            @isset($random_post)
            {{--dd($random_post)--}}
            @foreach ($random_post as $post)
            <a href="{{route('blog.detail',$post->slug)}}" class="blog__sidebar__recent__item">
                <div class="blog__sidebar__recent__item__pic">
                    <img src="{{$post->photo}}" alt="{{$post->title}}" width="70px" height="70px">
                </div>
                <div class="blog__sidebar__recent__item__text">
                    <h6>{{$post->title}}</h6>
                    <span>{{$post->created_at->format('d-m-Y')}}</span>
                </div>
            </a>
            @endforeach
            @endisset
        </div>
    </div>
    <div class="blog__sidebar__item">
        <h4>Search By</h4>
        <div class="blog__sidebar__item__tags">

            @foreach($post_categories as $item)
            <a href="{{asset('blog_caterogy')}}/{{$item->id}}">{{$item->title}}</a>
            @endforeach
        </div>
    </div>
</div>