@foreach($categoriestest as $cat)
                     
                        <li class="nav-item"> <a href="{{route('website.cat_products',[$cat->category_name,encrypt($cat->id)])}}" class="nav-link" aria-current="page"> <img src="{{asset('uploads/'.$cat->cat_icon)}}"><span class="ms-2">{{$cat->category_name}}</span> </a> </li>
                      
                        @endforeach