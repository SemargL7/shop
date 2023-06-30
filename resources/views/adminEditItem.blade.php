@extends('layout')
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

    <div class="mx-auto text-center p-5">
        <h1>Edit Item</h1>
        <form method="post" action="/admin/editItem" class="mx-auto text-center" enctype="multipart/form-data" style="max-width: 400px" >
            @csrf
            <input type="text" name="item_id" id="item_id" hidden="hidden">
            <input type="text" name="item_name" id="item_name" placeholder="Item name" class="form-control" value="{{ $item->item_name }}">
            <input type="text" name="item_crm_id" id="item_crm_id" placeholder="Item crm id" class="form-control" value="{{ $item->item_crm_id }}">
            <input type="text" name="item_number" id="item_number" placeholder="Item number" class="form-control" value="{{ $item->item_number }}">
            <input type="text" name="item_facebook_pixel" id="item_facebook_pixel" placeholder="Item facebook pixel" class="form-control" value="{{ $item->item_facebook_pixel }}">
            <textarea type="text" name="description" id="description" placeholder="Description" class="form-control" style="max-height: 400px; height: 200px">{{ $item_info->description }}</textarea>
            <textarea type="text" name="howtouse" id="howtouse" placeholder="How to use" class="form-control" style="max-height: 400px; height: 200px">{{ $item_info->howtouse }}</textarea>

            <div class="characteristics">
                @foreach($characteristics as $characteristic)
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
            @if($images != null)
            @foreach($images as $image)
                <div>
                    @if($image->image_type === 'image/png' || $image->image_type === 'image/jpeg')
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" style="height: 225px; width: 100%; display: block;" src="data:{{ $image->image_type }};base64,{{ base64_encode($image->image) }}" alt="{{ $image->image_name }}" data-holder-rendered="true">
                        <input type="checkbox" name="delete_image[]" value="{{ $image->id }}"> Delete
                    @endif
                </div>
            @endforeach
            @endif
            <button type="submit" class="btn btn-dark form-control mt-4">Update</button>
        </form>
    </div>

    <script>
        document.getElementById('addCharacteristicButton').addEventListener('click', function() {
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
@endsection
