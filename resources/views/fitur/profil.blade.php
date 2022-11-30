@extends('app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profil</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>Profil</a>
            </li>
            {{-- <li class="breadcrumb-item active">
                <strong>Edit Profil</strong>
            </li> --}}
        </ol>
    </div>
    <div class="col-lg-2">
    
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                {{-- <div class="ibox-title">
                    <h5>Peserta CATC</h5>
                </div> --}}
                <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group"><label>Tema</label> <input type="text" placeholder="Enter tema" class="form-control" name="tema" value="{{ Auth::user()->tema }}"></div>
                        <div class="form-group"><label>Nama</label> <input type="text" placeholder="Enter name" class="form-control" name="name" value="{{ Auth::user()->nama }}"></div>
                        <div class="form-group"><label>No. Peserta</label> <input type="text" placeholder="Enter No. Peserta" class="form-control" name="no_peserta" value="{{ Auth::user()->no_peserta }}"></div>
                        <div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email" value="{{ Auth::user()->email }}"></div>
                        <div class="form-group"><label>No. Hp</label> <input type="text" placeholder="No.Hp" class="form-control" value="{{ Auth::user()->no_hp }}"></div>
                    </form>
                   

                </div>
            </div>
        </div>
    </div>
</div>

@endsection