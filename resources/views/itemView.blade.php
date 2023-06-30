@extends('layout')
@section('title', 'Home')
@section('main_content')
    <div class="container p-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{$item->item_name}}</h1>
            </div>
            <div class="col-md-8">
                <img src="your-image1.jpg" alt="Image 1">
            </div>
            <div class="col-md-4">
                <form method="post" action="/makeOrder">
                    <h2>Make order</h2>
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="phone" class="form-control" id="phone" placeholder="Enter your phone">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container border-top p-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Description</h2>
                <p>{{ $item_info->description }}</p>
            </div>
            <div class="col-md-6">
                <img src="your-image2.jpg" alt="Image 2">
            </div>
        </div>
    </div>

    <div class="container border-top p-5">
        <div class="row">

            <div class="col-md-6">
                <img src="your-image3.jpg" alt="Image 3">
            </div>
            <div class="col-md-6">
                <h2>How to use</h2>
                <p>{{ $item_info->howtouse }}</p>
            </div>
        </div>
    </div>

    <!-- Fourth Block: Image and Characteristics -->
    <!-- Table Block -->
    <div class="container p-5">
        <div class="row">
            <div class="col-md-6 text-center">
                <h2>Loan Comparison Table</h2>
                <table class="table">
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

@endsection
