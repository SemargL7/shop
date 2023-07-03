@extends('layouts.layout')
@section('title')
    Register
@endsection
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
        <h1>Register</h1>
        <form method="post" action="/register" class="mx-auto text-center" style="max-width: 400px">
            @csrf

            <input type="text" name="username" id="username" placeholder="Username" class="form-control"><br>
            <input type="email" name="email" id="email" placeholder="Email" class="form-control"><br>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control"><br>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Password confirmation" class="form-control"><br>


            <button type="submit" class="btn btn-dark form-control mt-4">Submit</button>
        </form>
    </div>
@endsection
