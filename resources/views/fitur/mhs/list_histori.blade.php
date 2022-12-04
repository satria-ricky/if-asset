@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Aset</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Daftar Aset</a>
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
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="row ml-2">
                    <p style="font-size: 18px;">Filter Ruangan</p>
                </div>
                <div class="row ml-2">
                    <div style="display:flex;">
                        <select id="idRuangan" class="js-example-basic-single form-control">
                            @foreach ($dataRuangan as $item)
                                <option value="{{ $item->id_ruangan }}"> {{ $item->nama_ruangan }}</option>
                            @endforeach

                        </select>
                        {{-- <button class="btn btn-sm btn-success ml-2" onclick="filterByRuangan()"> Filter</button> --}}
                    </div>


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
                        <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal"> Tambah
                            Aset</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                id="dataTabelAset">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode aset</th>
                                        <th class="text-center">Nama aset</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataAset as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->kode_aset }}</td>
                                            <td class="text-center">{{ $item->nama }}</td>
                                            <td class="text-center">{{ $item->jumlah }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                        class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="/detail_aset/{{ Crypt::encrypt($item->id_aset) }}"
                                                                target="_blank"> Detail</a>
                                                        </li>
                                                        <li>
                                                            <a href="/qr_code/{{ Crypt::encrypt($item->id_aset) }}"
                                                                class="dropdown-item" target="_blank">Generate QR Code</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="/edit_aset/{{ Crypt::encrypt($item->id_aset) }}">
                                                                Edit</a>
                                                        </li>
                                                        <li>
                                                            <form action="/hapus_aset" method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id_aset }}">
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
