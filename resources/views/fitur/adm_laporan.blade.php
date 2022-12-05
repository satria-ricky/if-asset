@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Laporan</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/adm_laporan">{{  $title }}</a>
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

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    {{-- <div class="ibox-title">
                        <h5>Aset</h5>

                    </div> --}}
                    <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                        <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal"> Tambah
                            Laporan</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                id="dataTabelAset">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode aset</th>
                                        <th class="text-center">Nama aset</th>
                                        <th class="text-center">Diperiksa</th>
                                        <th class="text-center">Kondisi</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataLaporan as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->kode_aset }}</td>
                                            <td class="text-center">{{ $item->nama }}</td>
                                            <td class="text-center"> {{ $item->checked_at }}</td>
                                            <td class="text-center">{{ $item->nama_kondisi }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                        class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                                                    <ul class="dropdown-menu">
                                                        {{-- <li>
                                                            <a class="dropdown-item"
                                                                onclick="">
                                                                Edit</a>
                                                        </li> --}}
                                                        <li>
                                                            <form action="/hapus_laporan" method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id_laporan }}">
                                                                <button
                                                                    style="border-radius: 3px; color: inherit; line-height: 25px; margin: 4px; text-align: left; font-weight: normal; display: block; padding: 3px 20px; width: 95%;"
                                                                    class="dropdown-item pb-2" type="submit"
                                                                    onclick="return confirm('Are you sure?')">
                                                                    Hapus</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
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
    <div class="modal inmodal" id="myModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Tambah Laporan</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/tambah_laporan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Kode Aset</label>
                            <select class="js-example-basic-single-2 form-control" name="id_aset" id="IdAsetModalTambah" onchange="setFotoAset()"
                                required>
                                @foreach ($dataAset as $item)
                                    <option value="{{ $item->id_aset }}"> {{ $item->kode_aset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <center>
                            <img src="" id="priviewFoto" class="img-priview rounded mt-2 center" width="150">
                        </center>

                        <div class="form-group">
                            <label>Nama Aset</label>
                            <input class="form-control" readonly type="text" id="NamaAsetModalTambah">
                        </div>

                        <div class="form-group">
                            <label>Kondisi</label>
                            <select class="js-example-basic-single form-control" style="width: auto" name="kondisi" id="IdKondisiModalTambah"
                                required>
                                @foreach ($dataKondisi as $item)
                                    <option value="{{ $item->id_kondisi }}"> {{ $item->nama_kondisi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Diperiksa pada :</label>
                            <input class="form-control" type="datetime-local" name="checked_at">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Are you sure?')">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
