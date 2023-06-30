@extends('layout')
@section('title', 'Home')
@section('main_content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>{{$user_role->role}}</h1>
                <div id="userInfoSection">
                    <h2>User Information</h2>
                    <p><strong>Username:</strong> {{Auth::user()->username}}</p>
                    <p><strong>Email:</strong> {{Auth::user()->email}}</p>
                    <p><strong>Password:</strong> *********</p>
                    <button id="changeInfoBtn" class="btn btn-primary">Change Info</button>
                </div>
                <div id="updateProfileSection" style="display: none;">
                    <h2>Update Profile</h2>
                    <form action="/updateProfile" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" value="{{Auth::user()->username}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <input type="password" class="form-control" name="password">
                        </div>


                        <button type="submit" class="btn btn-primary">Update Profile</button><br>

                        <button type="button" id="backInfoBtn" class="btn btn-primary m-1">Don't change</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                @if($user_role->id == 2)
                    <div id="adminPanelSection">
                        <h1>Admin panel</h1>
                        <a href="/admin/itemsList" class="btn btn-primary">Items List</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById("changeInfoBtn").addEventListener("click", function() {
            document.getElementById("userInfoSection").style.display = "none";
            document.getElementById("updateProfileSection").style.display = "block";
        });

        document.getElementById("backInfoBtn").addEventListener("click", function() {
            document.getElementById("userInfoSection").style.display = "block";
            document.getElementById("updateProfileSection").style.display = "none";
        });
        // You can add similar code for toggling the display of the user info and update profile sections when needed.
    </script>
@endsection
