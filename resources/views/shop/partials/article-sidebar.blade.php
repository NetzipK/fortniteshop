<aside class="sidebar">

  <div class="widget widget-checkbox">
    <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">Article Search</a></h3>
    <div class="collapse in" id="widget-discount-collapse" aria-expanded="true" role="tabpanel">
        <div class="widget-body">
            <form id="search-articles" method="GET" action="{{route('shop.search')}}">
                @csrf
                <div class="form-group">
                    <input class="form-control" id="name" name="name" type="text" placeholder="Honey, ...">
                </div>
               <button class="btn btn-danger btn-sm" type="submit" onclick="event.preventDefault(); document.getElementById('search-articles').submit();">Search</button>
                <a href="{{route('shop.index')}}" class="btn btn-info btn-sm"><i class="fa fa-undo"></i></a>
            </form>
        </div>
    </div>
  </div>
  <div class="widget widget-checkbox">
    <h3><a role="button" aria-expanded="true" aria-controls="widget-discount-collapse">Categories</a></h3>
    <div class="widget-body">
            <ul class="list-unstyled">
                @foreach($categories as $category)
                <li style="margin-left: {{$category->category_level}}rem;">
                    <a class="checkbox" @if($category->is_highlighted) style="color: #E87169 !important;" @endif  href="{{route('shop.category', $category->id)}}">
                        
                        @if($category->category_level === 1)
                            <i class="fa fa-arrow-circle-o-right"></i>
                        @endif
                        @if($category->category_level === 2)
                            
                        @endif
                        @if (Route::currentRouteName() === 'shop.category' && Request::segment(4) == $category->id)
                            <strong>{{$category->display_name}}</strong>
                        @else 
                            {{$category->display_name}}
                        @endif

                        @if($category->category_level === 1)
                            <hr style="margin-top: 3px; margin-bottom: 3px;">
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

  </div>

<div class="text-center">
    <img style="max-width: 160px;" src="{{URL::to('/')}}/assets/images/fortnite/lama-min.png"  alt="Fortnitemall.gg Lama">
</div>
    
  
</aside>