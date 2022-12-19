@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Histori</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>{{ $title }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Tables</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>



    <div class="wrapper wrapper-content animated fadeInRight">

        @if (Auth::user()->level == 1)
        <div class="ibox-content m-b-sm border-bottom">
            <h3>Filter</h3>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_added">Kode Jurusan </label>
                        <select class="js-example-basic-single form-control" id="jurusan_filter1"
                            onchange="getRuanganByJurusan(1)">
                            @foreach ($dataJurusan as $item)
                                <option value="{{ $item->id_jurusan }}"> {{ $item->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_modified">Ruangan </label>
                        <select class="js-example-basic-single form-control" id="ruangan_filter1">
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_added">Batas awal dipakai</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tanggal_awal"
                                type="datetime-local" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_modified">Batas akhir dipakai</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tanggal_akhir"
                                type="datetime-local" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-success " onclick="filter_histori_ruangan(0)"> Filter </button>
            <button class="btn btn-warning " onclick="filter_histori_ruangan(1)"> Refresh </button>
        </div>
        @endif


        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    {{-- <div class="ibox-title">
                        <h5>Aset</h5>
                        
                    </div> --}}
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                id="dataTabelAset">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode Jurusan</th>
                                        <th class="text-center">Nama Ruangan</th>
                                        <th class="text-center">Dipakai pada:</th>
                                        <th class="text-center">Selesai pada:</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataHistori as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama_jurusan }}</td>
                                            <td class="text-center">{{ $item->nama_ruangan }}</td>
                                            <td class="text-center">{{ $item->mulai }}</td>
                                            <td class="text-center">
                                                @if ($item->selesai == '')
                                                    <form action="/selesai_dipakai_ruangan" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id_histori_ruangan }}"
                                                            name="id">
                                                        <button class="btn btn-danger btn-sm" type="submit"
                                                            onclick="return confirm('Are you sure?')"> Belum selesai </button>
                                                    </form>
                                                @else
                                                    <p class="btn btn-success btn-sm"> Great :)
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->level == 1)
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown"
                                                            class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form action="/hapus_histori_ruangan" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $item->id_histori_ruangan }}">
                                                                    <button
                                                                        style="border-radius: 3px; color: inherit; line-height: 25px; margin: 4px; text-align: left; font-weight: normal; display: block; padding: 3px 20px; width: 95%;"
                                                                        class="dropdown-item pb-2" type="submit"
                                                                        onclick="return confirm('Are you sure?')">
                                                                        Hapus</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @else
                                                -
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
