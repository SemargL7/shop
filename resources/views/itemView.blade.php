@extends('layouts.layoutProduct')
@section('title', 'Home')
@section('main_content')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/overlay.css') }}">
    @if(session('$success'))
        <div class="alert alert-success">
            @if(is_array(session('$success')))
                <ul>
                    @foreach(session('$success') as $success)
                        <li>{{ htmlspecialchars($success) }}</li>
                    @endforeach
                </ul>
            @else
                {{ htmlspecialchars(session('$success')) }}
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            @if(is_array(session('error')))
                <ul>
                    @foreach(session('error') as $error)
                        <li>{{ htmlspecialchars($error) }}</li>
                    @endforeach
                </ul>
            @else
                {{ htmlspecialchars(session('error')) }}
            @endif
        </div>
    @endif

    <div class="container p-2">
        <div class="row">
            <div class="col-md-12 text-center bg-light mb-4 rounded">
                <h1>{{$item->item_name}}</h1>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-4 ">
                <div class="mainImage col-md-12 ">
                    <img id="choiceImage" onclick="openImage(this.src)"
                         src="data:{{ $images[0]->image_type }};base64,{{ base64_encode($images[0]->image) }}"
                         class="img-fluid" alt="Overlay Image">
                </div>
                <div id="imageSlider" class="image-container swiper-container col-md-12" style="overflow: hidden;">
                    <div class="swiper-wrapper">
                        @foreach($images as $image)
                            @if($image->image_type === 'image/png' || $image->image_type === 'image/jpeg')
                                <div class="swiper-slide">
                                    <img class="img-fluid"
                                         onclick="chooseImage('{{ $image->image_type }};base64,{{ base64_encode($image->image) }}', '{{ $image->image_name }}')"
                                         src="data:{{ $image->image_type }};base64,{{ base64_encode($image->image) }}"
                                         alt="{{ $image->image_name }}" data-holder-rendered="true">
                                </div>
                            @endif
                        @endforeach
                    </div>
{{--                    <div class="swiper-pagination"></div>--}}
                </div>
            </div>

            <div class="overlay zoom">
                <img id="overlayImage" onclick="closeImage()" src="" class="img-fluid" alt="Overlay Image">
            </div>

            <div class="col-md-2">
            </div>

            <div class="col-md-4 text-center">
                <form method="post" action="/product/{{$item->item_number}}" class="bg-light p-3 rounded border">
                    @csrf
                    <h2>Make order</h2>
                    <h3>
                        {{$product_price}}
                        <span class="h5 bg-danger rounded"><s>{{$product_price*1.3}}</s></span>
                    </h3>
                    <div class="form-group m-2">
                        <label for="name" class="w-100 bg-dark text-light rounded-top">Full name</label>
                        <input type="text" class="form-control rounded-0  w-100" id="name" placeholder="Enter your name"
                               required>
                    </div>
                    <div class="form-group m-2">
                        <label for="phone" class="w-100 bg-dark text-light rounded-top">Phone</label>
                        <input type="text" id="phone" class="form-control rounded-0  w-100"
                               placeholder="Enter your phone" value="+380" pattern="^+380\d{9}$" title="380999999999"
                               required>
                    </div>
                    <button type="submit" class="btn btn-dark rounded-0 w-75 m-2">Submit</button>
                </form>
            </div>
            <div class="col-md-1">
            </div>
        </div>
    </div>


    <div class="container border-top p-5 bg-light">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Description</h2>
                <p>{!! $item_info->description !!}</p>
            </div>
            <div class="col-md-6">
                @if(count($images)>= 2)
                    <img class="img-fluid"
                         src="data:{{ $images[1]->image_type }};base64,{{ base64_encode($images[1]->image) }}"
                         alt="{{ $images[1]->image_name }}" data-holder-rendered="true" style="max-height: 300px">
                @else
                    <img src="{{ asset('images/description-icon.svg') }}" alt="SVG Image" style="max-height: 300px">
                @endif
            </div>
        </div>
    </div>

    <div class="container border-top p-5">
        <div class="row d-flex flex-row-reverse">
            <div class="col-md-6">
                <h2 class="text-center">How to use</h2>
                <p>{!! $item_info->howtouse !!}</p>
            </div>
            <div class="col-md-6">
                @if(count($images)>= 3)
                    <img class="img-fluid"
                         src="data:{{ $images[2]->image_type }};base64,{{ base64_encode($images[2]->image) }}"
                         alt="{{ $images[2]->image_name }}" data-holder-rendered="true" style="max-height: 300px">
                @else
                    <img src="{{ asset('images/description-icon.svg') }}" alt="SVG Image" style="max-height: 300px">
                @endif
            </div>
        </div>
    </div>


    <!-- Fourth Block: Image and Characteristics -->
    <!-- Table Block -->
    <div class="container p-5 bg-light border-top border-bottom">
        <div class="row">
            <div class="col-md-6">
                <h2>Characteristics</h2>
                <table class="table border">
                    <thead>
                    <tr>
                        <th>Characteristics</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($characteristics as $characteristic)
                        <tr>
                            <td>{{ $characteristic->name }}</td>
                            <td>{{ $characteristic->value }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container p-5">
        <!-- Three columns of text below the carousel -->

        <div class="row text-center">
            <h2 class="pb-4">Як зробити замовлення</h2>
            <div class="col-lg-4">
                <img class="" src="{{ asset('images/order.svg') }}" alt="Generic placeholder image" width="140"
                     height="140">
                <h3>Заявка</h3>
                <p>Залиште заявку на нашому сайті, заповнивши форму замовлення.</p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img class="" src="{{ asset('images/call-person.svg') }}" alt="Generic placeholder image" width="140"
                     height="140">
                <h3>Підтвердження</h3>
                <p>Наш менеджер передзвонить вам для уточнення деталей і ми відправимо ваш товар поштою на зазначену
                    адресу.</p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img class="" src="{{ asset('images/deliver.svg') }}" alt="Generic placeholder image" width="140"
                     height="140">
                <h3>Отримання</h3>
                <p>Доставка протягом 1 до 3 робочих днів</p>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div>

    <div class="album py-5 bg-light mt-5">
        <h2 class="mx-auto text-center">In same category</h2>
        <div class="container">
            <div id="item_list" class="row" data-category-id="{{$item->item_category_id}}"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var category_id = $('#item_list').data('category-id');
            $.ajax({
                url: '/api/getItemsByCategory',
                type: 'POST',
                dataType: 'json',
                data: {
                    category_id: category_id
                },
                success: function (response) {
                    var items = response.items.data;
                    var itemList = $('#item_list');
                    itemList.empty();

                    if (items.length > 0) {
                        $.each(items, function (index, item) {
                            itemList.append(
                                '<div class="col-md-3">' +
                                '<div class="card mb-3 box-shadow">' +
                                '<img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" style="height: 225px; object-fit: cover; width: 100%; display: block;" src="data:' + item.image.image_type + ';base64,' + item.image.image + '" alt="' + item.image.image_name + '" data-holder-rendered="true">' +
                                '<div class="card-body">' +
                                '<p class="card-text">' + item.item_name + '</p>' +
                                '<div class="d-flex justify-content-between align-items-center">' +
                                '<div class="btn-group">' +
                                '<form method="get" action="/product/' + item.item_number + '">' +
                                '<button type="submit" class="btn btn-sm btn-outline-secondary">View</button>' +
                                '</form>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );
                            // Customize the HTML structure for displaying items as needed
                        });
                    } else {
                        itemList.append('<div>No items found.</div>');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

    <script>
        var swiper = new Swiper('#imageSlider', {
            slidesPerView: 4,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                }
            }
        });
    </script>
    <script>
        function openImage(imageSrc) {
            var overlay = document.querySelector('.overlay');
            var overlayImage = document.getElementById('overlayImage');

            overlay.style.display = 'flex';
            overlayImage.src = "data:" + imageSrc;
        }

        function closeImage() {
            var overlay = document.querySelector('.overlay');

            overlay.style.display = 'none';
        }
        function chooseImage(imageSrc, imageName) {
            var image = document.querySelector('#choiceImage');
            image.src = "data:" + imageSrc;
            image.alt = imageName;
        }
    </script>

@endsection
