<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>

    <link href={{asset("css/bootstrap.min.css")}} rel="stylesheet">
    <link href={{asset("font-awesome/css/font-awesome.css")}} rel="stylesheet">
    <link href={{asset("css/animate.css")}} rel="stylesheet">
    <link href={{asset("css/style.css")}} rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown" style="padding-top: 20px;">
        <div class="row">

            <div class="col-md-3">
                {{-- <h2 class="font-bold">Welcome to Inventaris Aset IF-UNRAM</h2>

               <img src="img/p6.jpg" width="300px" /> --}}

            </div>
            <div class="col-md-6">
                <div class="logo" style=" margin:25px;">
                    <center> 
                        <img src="{{ asset('storage/logo/logoPSTI.jpg') }}" width="100" height="100" />
                        @if (Session::has('message'))
                        <p class="alert alert-danger mt-2">{{ Session::get('message') }}</p>
                    @endif
                    </center>
                </div>
                <div class="ibox-content">
                    <h1 class="black-text"> Login </h1>
                    <form class="m-t" role="form" method="POST" action="/loginMhs">
                        @csrf
                        <input type="hidden" name="id_aset" value="{{ $id_aset }}">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Username" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        {{-- <a href="#">
                            <small>Forgot password?</small>
                        </a> --}}
                    </form>
                    <p class="m-t">
                        {{-- <small>PSTI UNRAM &copy; 2022</small> --}}
                    </p>
                </div>
            </div>

            <div class="col-md-2">
                {{-- <h2 class="font-bold">Welcome to Inventaris Aset IF-UNRAM</h2>

               <img src="img/p6.jpg" width="300px" /> --}}

            </div>

        </div>
       
        <hr/>
    </div>

</body>
<footer>
    
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            Inventaris Aset IF-UNRAM
            <small>© 2022</small>
        </div>
        <div class="col-md-2 text-right">
           
        </div>
    </div>
</footer>
</html>
