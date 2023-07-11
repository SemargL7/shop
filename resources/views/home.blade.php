@extends('layouts.layout')
@section('title', 'Home')
@section('main_content')
    <main role="main">
        <section class="jumbotron">
            <div class="container">
                <h1 class="jumbotron-heading mx-auto">Асортимент</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/" method="get">
                            <div class="row">
                                <div class="col-md-2 p-0">
                                    <li class="dropdown list-unstyled" id="dropdownCategory">
                                        <button id="category-dropdown-button" class="btn btn-outline-dark me-2 dropdown-toggle w-100 rounded-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Категорії
                                        </button>
                                        <ul class="dropdown-menu rounded-0" id="categories">

                                        </ul>
                                    </li>
                                </div>
                                <div class="col-md-8 p-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control rounded-0 w-100" name="filter"
                                               placeholder="Filter items">
                                    </div>
                                </div>
                                <div class="col-md-2 p-0">
                                    <button type="submit" class="btn btn-dark rounded-0 w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    @foreach($items as $item)
                        @if($item->active)
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top"
                                         data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail"
                                         style="height: 225px; object-fit: cover; width: 100%; display: block;"
                                         src="data:{{ $item->image->image_type }};base64,{{ base64_encode($item->image->image) }}"
                                         alt="{{ $item->image->image_name }}" data-holder-rendered="true">
                                    <div class="card-body">
                                        <p class="card-text">{{ $item->item_name }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <form method="get" action="/product/{{$item->item_number}}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        View
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </main>
    <script>
        window.onload = function () {
            var categoriesSelect = document.getElementById('categories');
            var filterForm = document.getElementById('filterForm');
            var categoriesButton = document.getElementById('category-dropdown-button');
            // Disable the category selector
            categoriesButton.disabled = true;

            // Make the AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/getCategories', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === 'ok') {
                        var categories = response.data;

                        categories.forEach(function (category) {
                            var li = document.createElement('li');
                            li.classList.add("dropdown-item");

                            var input = document.createElement('input');
                            input.type = "checkbox";
                            input.value = category.id;
                            input.id = "checkbox_" + category.id; // Assign a unique ID to each checkbox
                            input.name = "categories[]"; // Include checkboxes in the form submission

                            var label = document.createElement('label');
                            label.setAttribute('for', "checkbox_" + category.id); // Associate the label with the checkbox
                            label.textContent = category.name; // Set the label text

                            li.appendChild(input);
                            li.appendChild(label);
                            categoriesSelect.appendChild(li);
                        });

                        // Re-enable the category selector
                        categoriesButton.disabled = false;
                    }
                }
            };
            xhr.send();

            // Update form action on submission
            filterForm.addEventListener('submit', function () {
                var checkboxes = document.querySelectorAll('input[name="categories[]"]:checked');
                var categories = Array.from(checkboxes).map(function (checkbox) {
                    return checkbox.value;
                });
                var filterUrl = '/' + (categories.length > 0 ? '?categories=' + categories.join(',') : '');

                filterForm.action = filterUrl;
            });
        };
    </script>
@endsection
