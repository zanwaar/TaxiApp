<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/svg+xml" href="" />
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>


<body>

    <form action="{{ route('register') }}" method="POST" class="form-signin card-body bg-white rounded" style="position: relative;">
        <div style="position: absolute;top: 17px; left:10px;">
            <div class="d-flex align-items-center ">
                <a href="{{ route('home') }}" class="d-flex align-items-center rounded-circle bg-dark shadow p-1"><span class="material-symbols-outlined">
                        arrow_back
                    </span></a><span>&nbsp;&nbsp;Back Home</span>
            </div>
        </div>
        <h1 class="display-5 font-weight-bold mb-4 pt-5">Buat Akun</h1>
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">UserName</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="exampleInputEmail1" aria-describedby="nameHelp">
            @error('name')
            <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
            @enderror

        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            @error('email')
            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
            @enderror

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            @error('password')
            <small id="pswHelp" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2">
        </div>


        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary mb-3 shadow">Daftar</button>

            <a href="{{ route('login') }}" class="text-primary text-decoration-none">Sudah Punya Akun</a>
        </div>
    </form>
</body>

</html>