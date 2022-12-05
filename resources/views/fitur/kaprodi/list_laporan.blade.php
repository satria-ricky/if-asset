@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Laporan</h2>
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
            <h3>Filter</h3>
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
                        <label class="col-form-label" for="kondisi">Kondisi</label>
                        <select class="js-example-basic-single form-control" style="height: 35px;" id="kondisi"
                                required>
                                @foreach ($dataKondisi as $item)
                                    <option value="{{ $item->id_kondisi }}"> {{ $item->nama_kondisi }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-sm-3" style="margin: auto; padding-top: 15px;">
                    <button class="btn btn-success" onclick="FilterLaporanProdi()"> Filter </button>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    {{-- <div class="ibox-title">
                        <h5>Aset</h5>

                    </div> --}}
                    <div class="ibox-content">
                        {{-- <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal"> Tambah
                            Aset</button> --}}
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataLaporan as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->kode_aset }}</td>
                                            <td class="text-center">{{ $item->nama }}</td>
                                            <td class="text-center"> {{ $item->checked_at }}</td>
                                            <td class="text-center">
                                                @if ($item->id_kondisi == 1)
                                                    <p class="btn btn-danger btn-sm"> {{ $item->nama_kondisi }}
                                                    </p>
                                                @else
                                                    <p class="btn btn-success btn-sm"> {{ $item->nama_kondisi }}
                                                    </p>
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
    <div class="modal inmodal" id="myModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Tambah Aset</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/tambah_aset" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Ruangan</label>
                            <select class="js-example-basic-single form-control" style="width: auto" name="idRuangan"
                                required>
                                @foreach ($dataRuangan as $item)
                                    <option value="{{ $item->id_ruangan }}"> {{ $item->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Aset</label>
                            <input class="form-control" type="text" name="kode" required>
                            @error('kode')
                                <script>
                                    swal("Oppss!", "Kode aset telah tersedia!", "error");
                                </script>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Aset</label>
                            <input class="form-control" type="text" name="nama">
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input class="form-control" type="number" name="jumlah">
                        </div>
                        <div class="form-group">
                            <label>lokasi</label>
                            <input class="form-control" type="text" name="lokasi">
                        </div>
                        <div class="form-group">
                            <label>Kondisi</label>
                            <input class="form-control" type="text" name="kondisi">
                        </div>
                        <div class="form-group">
                            <label>Tahun Pengadaan</label>
                            <select id="id_tahun_pengadaan" name="tahun_pengadaan" class="form-control"></select>
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="id_foto" type="file" name="foto" accept="image/*"
                                    class="custom-file-input" onchange="cekFoto()">
                                <label class="custom-file-label" for="id_foto">Foto Aset</label>

                            </div>

                        </div>
                        <img class="img-priview rounded mt-2" width="150" id="priviewFoto">
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
