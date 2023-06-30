@extends('layout')
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

    <div class="mx-auto text-center p-5">
        <h1>Create new item</h1>
        <form method="post" action="/admin/createNewItem" class="mx-auto text-center" enctype="multipart/form-data" style="max-width: 400px" >
            @csrf
            <input type="text" name="item_name" id="item_name" placeholder="Item name" class="form-control">
            <input type="text" name="item_crm_id" id="item_crm_id" placeholder="Item cmr id" class="form-control">
            <input type="text" name="item_number" id="item_number" placeholder="Item number" class="form-control">
            <input type="text" name="item_facebook_pixel" id="item_facebook_pixel" placeholder="Item facebook pixel" class="form-control">
            <textarea type="text" name="description" id="description" placeholder="Description" class="form-control" style="max-height: 400px; height: 200px"></textarea>
            <textarea type="text" name="howtouse" id="howtouse" placeholder="How to use" class="form-control" style="max-height: 400px; height: 200px"></textarea>

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





    <script>
        document.getElementById('addCharacteristicButton').addEventListener('click', function() {
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
@endsection
