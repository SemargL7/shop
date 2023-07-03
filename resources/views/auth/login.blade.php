@extends('layouts.layout')
@section('title')
    Login
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
        <h1>Login</h1>
        <form method="post" action="/login" class="mx-auto text-center" style="max-width: 400px">
            @csrf
            <input type="text" name="username" id="username" placeholder="Email or username" class="form-control"><br>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control"><br>
            <button type="submit" class="btn btn-dark form-control">Submit</button>
            <a href="/register">Sign-up</a>
        </form>
    </div>
@endsection
