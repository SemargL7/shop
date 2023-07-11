@extends('layouts.layout')
@section('title', 'Home')
@section('main_content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Items List</h1>
            <p>
                <a href="/admin/createNewItem" class="btn btn-primary">Add New Furniture</a>
            </p>
        </div>
    </section>

    <div class="container text-center">
        <form action="/admin/itemsList" method="get">
            <div class="row">
                <div class="col-md-10 p-0">
                    <div class="form-group">
                        <input type="text" class="form-control rounded-0 w-100" name="filter"
                               placeholder="Filter items" value="{{$filter}}">
                    </div>
                </div>
                <div class="col-md-2 p-0">
                    <button type="submit" class="btn btn-dark rounded-0 w-100">Filter</button>
                </div>
            </div>
        </form>
        @foreach($items as $item)
            <div class="row border mt-2">
                <div class="col-12 col-md-12 bg-dark text-light">
                    <div class="h2">{{$item->item_name}}</div>
                </div>
                <div class="col-12 col-md-2 h6">
                    <div class="p-1">
                        <label><small>Item ID</small></label>
                        {{$item->id}}
                    </div>
                    <div class="p-1">
                        <label><small>Product number</small></label>
                        {{$item->item_number}}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                </div>
                <div class="col-12 col-md-3 m-1 h6">
                    <span>Created at: {{ $item->created_at }}</span><br><br>
                    <span>Updated at: {{ $item->updated_at }}</span><br><br>
                </div>

                <div class="col-12 col-md-2 ">
                    <form method="get" action="/admin/editItem">
                        <input name="item_id" id="item_id" hidden="hidden" value="{{$item->id}}">
                        <button type="submit" class="btn btn-sm btn-outline-dark w-100 m-1">Edit</button>
                    </form>
                    <form method="post" action="/admin/switchActiveShowStatusItem">
                        @csrf
                        <input name="item_id" id="item_id" hidden="hidden" value="{{$item->id}}">
                        <input name="active" id="active" hidden="hidden" value="{{$item->active}}">
                        <button type="submit"
                                class="btn btn-sm btn-outline-dark w-100 m-1">{{$item->active ? 'Disable' : 'Activate'}}</button>
                    </form>
                    <form method="post" action="/admin/deleteItem">
                        @csrf
                        <input name="item_id" id="item_id" hidden="hidden" value="{{$item->id}}">
                        <button type="submit" class="btn btn-sm btn-outline-dark w-100 m-1">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    {{ $items->links() }}
@endsection
