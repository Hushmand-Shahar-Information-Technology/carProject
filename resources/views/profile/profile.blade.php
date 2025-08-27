@extends('layouts.layout')
@section('title', 'Profile')
@section('content')

   
    <style>
        .profile-container {
            max-width: 935px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            gap: 30px;
        }
        
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #333;
        }
        
        .profile-info h1 {
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .profile-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .btn-custom {
            background-color: blue;
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .btn-custom:hover {
            background-color: #4a4a4a;
            color: #fff;
        }
        
        .stats {
            display: flex;
            gap: 40px;
            margin-bottom: 20px;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-weight: 600;
            font-size: 16px;
        }
        
        .stat-label {
            color: #a8a8a8;
            font-size: 16px;
        }
        
        .bio {
            max-width: 300px;
        }
        
        .bio h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .bio p {
            font-size: 14px;
            color: #a8a8a8;
            margin-bottom: 5px;
            line-height: 1.4;
        }
        
        .new-post {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .new-post-circle {
            width: 77px;
            height: 77px;
            border: 2px dashed #363636;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
        }
        
        .new-post-circle:hover {
            border-color: #555;
        }
        
        .new-post-circle i {
            font-size: 24px;
            color: #a8a8a8;
        }
        
        .new-post-label {
            font-size: 12px;
            color: #a8a8a8;
            font-weight: 600;
        }
        
        .nav-tabs {
            border-bottom: 1px solid #363636;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            color: #a8a8a8;
            border: none;
            padding: 15px 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .nav-tabs .nav-link.active {
            color: #fff;
            background: none;
            border-bottom: 1px solid #fff;
        }
        
        .nav-tabs .nav-link:hover {
            color: #fff;
            border: none;
        }
        
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3px;
        }
        
        .post-item {
            aspect-ratio: 1;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .post-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .post-overlay {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 4px;
            padding: 4px;
        }
        
        .post-overlay i {
            color: #fff;
            font-size: 12px;
        }
        
        @media (max-width: 768px) {
            /* .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            } */
            
            .profile-pic {
                width: 120px;
                height: 120px;
            }
            
            .stats {
                justify-content: center;
            }
        }


        
    </style>
     <!--================================ -->
    <section class="inner-intro bg-8 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">{{$profile->name}}</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="{{route('home.index')}}"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i>
                        </li>
                        <li><span> profile </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


<div class="container">
   
        <div class="profile-header mt-5">
            <img src="{{asset('images/02.png')}}" alt="Profile Picture" class="profile-pic">
            
            <div class="profile-info">
                <h1>
                    {{$profile->name}}
                    <a href="{{route('profile.edit')}}">
                        <button class="btn btn-custom">Edit profile</button>
                    </a>
                    <i class="fas fa-cog" style="color: #a8a8a8; cursor: pointer;"></i>
                </h1>
                
                <div class="stats">
                    <div class="stat">
                        <div class="stat-number">23</div>
                        <div class="stat-label">posts</div>
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- New Post Section -->
        <a href="{{route('car.create')}}">
            <div class="new-post">
                <div class="new-post-circle">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="new-post-label">New Car</div>
            </div>
        </a>
        
        {{-- <div class="col-lg-9 col-md-8"> --}}
        <div class="sorting-options-main">
        <div class="row">
            @foreach ($profile->cars as $car)
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="car-item gray-bg text-center">
                    <div class="car-image">
                    <img class="img-fluid" src="/storage/{{$car->images[0]}}" alt="">
                    <div class="car-overlay-banner">
                        <ul>
                        <li><a href="{{route('car.show', $car->id)}}"><i class="fa fa-link"></i></a></li>
                        <li><a href="{{route('car.show', $car->id)}}"><i class="fa fa-shopping-cart"></i></a></li>
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
                    <a href="#">Acura Rsx</a>
                    <div class="separator"></div>
                    <div class="price">
                         <span class="old-price">${{$car->regular_price}}</span>
                         <span class="new-price">${{$car->sale_price}}</span>
                    </div>
                    </div>
                </div>
            </div>
           @endforeach
    </div>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add click functionality to tabs
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Add hover effects to post items
        document.querySelectorAll('.post-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'transform 0.2s ease';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>

@endsection    