<!-- Load Bootstrap -->
<link href="{{ asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/libs/jquery.min.js')}}"></script>
<script src="{{ asset('js/libs/sweetalert2.js')}}"></script>
<script src="{{ asset('js/libs/font-awesome/js/all.js')}}"></script>

<script type="text/javascript" src="{{ asset('js/global-variable.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/root.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/header.js') }}"></script>

<head>
    <title>myCacti</title>
    <link rel="icon" href="{{asset('images/logo.png')}}">
</head>

<style>
    .cursor-pointer{
        cursor: pointer;
    }
</style>

<!-- Navbar Content -->
<nav class="navbar navbar-expand-lg navbar-light" style="background: #d9d9d9">
    <div class="container-fluid">
        <img src="{{asset('images/logo.png')}}" width="50px" height="50px" style="margin-right:10px;">

        <a class="navbar-brand" href="{{url('/')}}" style="color:#006600;">myCacti</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="{{url('/')}}">My Plant</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('add-plant')}}">Add Plant</a></li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>