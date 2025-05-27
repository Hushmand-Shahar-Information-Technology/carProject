
<style>
  .fixed-img {
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
  }
</style>
            @foreach($filteredCars as $car)
                @php
                        $images = $car->images;
                @endphp
                <div class="grid-item">
                    <div class="car-item gray-bg text-center">
                    <div class="car-image">
                    @if(is_array($images) && count($images) > 0)
                        <img class="img-fluid fixed-img" src="{{ asset($images[0]) }}" alt="">
                    @else
                        <p>No image available</p>
                    @endif

                    <div class="car-overlay-banner">
                        <ul>
                        <li><a href="#"><i class="fa fa-link"></i></a></li>
                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    </div>
                    <div class="car-list">
                    <ul class="list-inline">
                        <li><i class="fa fa-registered"></i>{{$car->year}}</li>
                        <li><i class="fa fa-cog"></i> {{$car->transmission_type}} </li>
                        <li><i class="fa fa-shopping-cart"></i> 6,000 mi</li>
                    </ul>
                    </div>
                    <div class="car-content">
                    <div class="star">
                    <i class="fa fa-star orange-color"></i>
                        <i class="fa fa-star orange-color"></i>
                        <i class="fa fa-star orange-color"></i>
                        <i class="fa fa-star orange-color"></i>
                        <i class="fa fa-star-o orange-color"></i>
                    </div>
                    <a href="#">{{$car->model}}</a>
                    <div class="separator"></div>
                    <div class="price">
                        <span class="old-price">${{$car->regular_price}}</span>
                        <span class="new-price">${{$car->sale_price}}</span>
                    </div>
                    </div>
                </div>
                </div>
            @endforeach
