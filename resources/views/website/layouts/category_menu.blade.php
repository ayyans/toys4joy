@foreach($categoriestest as $cat)     
@php
    $subcategories = DB::table('sub_categories')->where('parent_cat' , $cat->id)->where('status' , 2)->get();
@endphp
@if($subcategories->count() == 0)
<li class="nav-item"> <a href="{{route('website.cat_products',[$cat->category_name,encrypt($cat->id)])}}" class="nav-link" aria-current="page"> <img src="{{asset('uploads/'.$cat->cat_icon)}}"><span class="ms-2">{{$cat->category_name}}</span> </a> </li>
@else
<li class="nav-item dropdown">
    <a href="{{route('website.cat_products',[$cat->category_name,encrypt($cat->id)])}}" class="nav-link text-dark"> <img src="{{asset('uploads/'.$cat->cat_icon)}}">
        <span class="ms-2">{{$cat->category_name}} 
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="16" viewBox="0 0 8 16">
              <path id="Vector_14_" data-name="Vector (14)" d="M8,8,0,0H16Z" transform="translate(0 16) rotate(-90)" fill="#d51965"/>
            </svg>
        </span>
    </a> 
    <div class="megadrop">
        <div class="image col">
          <img src="{{asset('uploads/'.$cat->cat_banner)}}">
        </div>
        @foreach($subcategories as $r)
        <div class="col">
          <ul>
            <li><a href="#">{{ $r->subcat_name }}</a></li>
          </ul>
        </div>
        @endforeach
    </div>
</li>

@endif
@endforeach