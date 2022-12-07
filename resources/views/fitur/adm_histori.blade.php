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
        <div class="ibox-content m-b-sm border-bottom">
            <h3>Filter Waktu Mulai Pemakaian</h3>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_added">Batas awal </label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tanggal_awal"
                                type="datetime-local" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_modified">Batas akhir</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tanggal_akhir"
                                type="datetime-local" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="kondisi">Mahasiswa</label>
                        <select class="js-example-basic-single form-control" style="height: 35px;" id="mahasiswa"
                                required>
                                @foreach ($dataUser as $item)
                                    <option value="{{ $item->id }}"> {{ $item->nama }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-sm-3" style="margin: auto; padding-top: 15px;">
                    <button class="btn btn-success" onclick="FilterHistoriAdm()"> Filter </button>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    {{-- <div class="ibox-title">
                        <h5>Aset</h5>

                    </div> --}}
                    <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                id="dataTableHistori">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Mahasiswa</th>
                                        <th class="text-center">Kode aset</th>
                                        <th class="text-center">Nama aset</th>
                                        <th class="text-center">Dipakai pada:</th>
                                        <th class="text-center">Selesai pada:</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataHistori as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama }}</td>
                                            <td class="text-center">{{ $item->kode_aset }}</td>
                                            <td class="text-center">{{ $item->nama }}</td>
                                            <td class="text-center">{{ $item->mulai }}</td>
                                            <td class="text-center">
                                                @if ($item->selesai == '')
                                                    -
                                                @else
                                                    {{ $item->selesai }}
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
