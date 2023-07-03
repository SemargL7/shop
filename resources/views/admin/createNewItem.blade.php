@extends('layouts.layout')
@section('title', 'Home')
@section('main_content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Create new item</h1>
            </div>

            <div class=" text-center col-md-6">

                <form method="post" action="/admin/createNewItem" class="" enctype="multipart/form-data"
                      style="max-width: 400px">
                    @csrf
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select a category</option>
                            @foreach ($categories['data'] as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select name="product_id" id="product_id" class="form-control" disabled>
                            <option value="">Select a product</option>
                        </select>
                    </div>
                    <label for="item_name">Item name</label>
                    <input type="text" name="item_name" id="item_name" placeholder="Item name" class="form-control" readonly>
                    <input type="text" name="item_crm_id" id="item_crm_id" placeholder="Item cmr id" hidden="hidden"
                           class="form-control" readonly>
                    <label for="item_number">Item number</label>
                    <input type="text" name="item_number" id="item_number" placeholder="Item number" class="form-control">
                    <label for="item_facebook_pixel">Item facebook pixel</label>
                    <input type="text" name="item_facebook_pixel" id="item_facebook_pixel" placeholder="Item facebook pixel"
                           class="form-control">
                    <label for="description">Item description</label>
                    <textarea type="text" oninput="preview(this.id, 'descriptionPreview-space')" name="description" id="description" placeholder="Description" class="form-control"
                              style="max-height: 400px; height: 200px"></textarea>
                    <label for="howtouse">Item How to use</label>
                    <textarea type="text" oninput="preview(this.id, 'howtousePreview-space')" name="howtouse" id="howtouse" placeholder="How to use" class="form-control"
                              style="max-height: 400px; height: 200px"></textarea>

                    <label for="characteristics">Characteristics</label>
                    <div class="characteristics">
                        <div class="m-2">
                            <input type="text" name="characteristics[]" placeholder="Characteristic" class="form-control">
                            <input type="text" name="value[]" placeholder="Value" class="form-control">
                        </div>
                    </div>
                    <button id="addCharacteristicButton" class="btn btn-dark m-1" type="button">Add Characteristic</button>
                    <div>
                        <label for="image">Images</label>
                        <input type="file" class="form-control-file" multiple name="image[]" id="image">
                    </div>


                    <button type="submit" class="btn btn-dark form-control mt-4">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="descriptionPreview" class="bg-light border w-100 p-5">
                    <h2 class="text-center">Description</h2>
                    <div id="descriptionPreview-space">

                    </div>
                </div>
                <div id="howtousePreview" class="bg-light border w-100 p-5">
                    <h2 class="text-center">How to use</h2>
                    <div id="howtousePreview-space">

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // JavaScript code
        document.getElementById('category_id').addEventListener('change', function () {
            var category_id = this.value;
            var productSelect = document.getElementById('product_id');
            var itemCrmIdInput = document.getElementById('item_crm_id');
            var itemNameInput = document.getElementById('item_name');


            if (category_id !== '') {
                // Disable the product selector
                productSelect.disabled = true;

                // Make the AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/products/' + category_id, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var products = JSON.parse(xhr.responseText);
                        // Update the product list on the page
                        productSelect.innerHTML = '<option value="">Select a product</option>';

                        products.forEach(function (product) {
                            var option = document.createElement('option');
                            option.value = product.id;
                            option.textContent = product.name;
                            productSelect.appendChild(option);
                        });

                        // Re-enable the product selector
                        productSelect.disabled = false;
                    }
                };
                xhr.send();
            } else {
                // Reset the product selector if no category is selected
                productSelect.innerHTML = '<option value="">Select a product</option>';
            }
        });

        document.getElementById('product_id').addEventListener('change', function () {
            var selectedProduct = this.options[this.selectedIndex];
            var itemCrmIdInput = document.getElementById('item_crm_id');
            var itemNameInput = document.getElementById('item_name');

            if (selectedProduct.value !== '') {
                // Update the item_crm_id input with the selected product's ID
                itemCrmIdInput.value = selectedProduct.value;
                // Update the item_name input with the selected product's name
                itemNameInput.value = selectedProduct.textContent;
            } else {
                // Reset the item_crm_id and item_name inputs if no product is selected
                itemCrmIdInput.value = '';
                itemNameInput.value = '';
            }
        });
    </script>

    <script>
        document.getElementById('addCharacteristicButton').addEventListener('click', function () {
            var characteristicsDiv = document.querySelector('.characteristics');
            var newCharacteristicDiv = document.createElement('div');
            newCharacteristicDiv.classList.add('m-2')
            newCharacteristicDiv.innerHTML = `
            <input type="text" name="characteristics[]" placeholder="Characteristic" class="form-control">
            <input type="text" name="value[]" placeholder="Value" class="form-control">
        `;
            characteristicsDiv.appendChild(newCharacteristicDiv);
        });
    </script>
    <script>
        function preview(element_read,element_preview){
            var el_read = document.getElementById(element_read);
            var el_prev = document.getElementById(element_preview);

            el_prev.innerHTML = el_read.value
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
