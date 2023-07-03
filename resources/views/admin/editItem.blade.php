@extends('layouts.layout')
@section('title', 'Edit Item')
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
                <h1>Edit Item</h1>
            </div>

            <div class="text-center col-md-6">
                <form method="post" action="/admin/updateItem" class="" enctype="multipart/form-data"
                      style="max-width: 400px">
                    @csrf
                    <input type="text" name="item_id" id="item_id" value="{{ $item->id }}" hidden="hidden">
                    <label for="item_name">Item name</label>
                    <input type="text" name="item_name" id="item_name" placeholder="Item name" class="form-control" value="{{ $item->item_name }}" readonly>
                    <input type="text" name="item_crm_id" id="item_crm_id" placeholder="Item cmr id" hidden="hidden"
                           class="form-control" value="{{ $item->item_crm_id }}" readonly>
                    <label for="item_number">Item number</label>
                    <input type="text" name="item_number" id="item_number" placeholder="Item number" class="form-control" value="{{ $item->item_number }}">
                    <label for="item_facebook_pixel">Item facebook pixel</label>
                    <input type="text" name="item_facebook_pixel" id="item_facebook_pixel" placeholder="Item facebook pixel"
                           class="form-control" value="{{ $item->item_facebook_pixel }}">
                    <label for="description">Item description</label>
                    <textarea type="text" oninput="preview(this.id, 'descriptionPreview-space')" name="description" id="description" placeholder="Description" class="form-control"
                              style="max-height: 400px; height: 200px">{{ $item_info->description }}</textarea>
                    <label for="howtouse">Item How to use</label>
                    <textarea type="text" oninput="preview(this.id, 'howtousePreview-space')" name="howtouse" id="howtouse" placeholder="How to use" class="form-control"
                              style="max-height: 400px; height: 200px">{{ $item_info->howtouse }}</textarea>

                    <label for="characteristics">Characteristics</label>
                    <div class="characteristics">
                        @foreach ($characteristics as $characteristic)
                            <div class="m-2">
                                <input type="text" name="characteristics[]" placeholder="Characteristic" class="form-control" value="{{ $characteristic->name }}">
                                <input type="text" name="value[]" placeholder="Value" class="form-control" value="{{ $characteristic->value }}">
                            </div>
                        @endforeach
                    </div>
                    <button id="addCharacteristicButton" class="btn btn-dark m-1" type="button">Add Characteristic</button>
                    <div>
                        <label for="image">Images</label>
                        <input type="file" class="form-control-file" multiple name="image[]" id="image">
                    </div>
                    @foreach($images as $image)
                        <div style="position: relative; display: inline-block;">
                            @if($image->image_type === 'image/png' || $image->image_type === 'image/jpeg')
                                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" style="height: 225px; width: 100%; display: block;" src="data:{{ $image->image_type }};base64,{{ base64_encode($image->image) }}" alt="{{ $image->image_name }}" data-holder-rendered="true">
                                <input type="checkbox" name="delete_image[]" value="{{ $image->id }}" style="position: absolute; top: 0; right: 0;"> Delete
                            @endif
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-dark form-control mt-4">Update</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="descriptionPreview" class="bg-light border w-100 p-5">
                    <h2 class="text-center">Description</h2>
                    <div id="descriptionPreview-space">
                        {!! $item->description !!}
                    </div>
                </div>
                <div id="howtousePreview" class="bg-light border w-100 p-5">
                    <h2 class="text-center">How to use</h2>
                    <div id="howtousePreview-space">
                        {!! $item->howtouse !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('addCharacteristicButton').addEventListener('click', function () {
            var characteristicsDiv = document.querySelector('.characteristics');
            var newCharacteristicDiv = document.createElement('div');
            newCharacteristicDiv.classList.add('m-2');
            newCharacteristicDiv.innerHTML = `
                <input type="text" name="characteristics[]" placeholder="Characteristic" class="form-control">
                <input type="text" name="value[]" placeholder="Value" class="form-control">
            `;
            characteristicsDiv.appendChild(newCharacteristicDiv);
        });
    </script>
    <script>
        function preview(element_read, element_preview) {
            var el_read = document.getElementById(element_read);
            var el_prev = document.getElementById(element_preview);

            el_prev.innerHTML = el_read.value;
        }
        window.onload = function (){
            preview('howtouse', 'howtousePreview-space')
            preview('description', 'descriptionPreview-space')
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
