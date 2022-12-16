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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="date_modified">Jenis aset </label>
                        <select class="js-example-basic-single-2 form-control" id="jenis_filter1">
                            @foreach ($dataJenis as $item)
                                <option value="{{ $item->id_jenis }}"> {{ $item->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="kondisi">Kondisi</label>
                        <select class="js-example-basic-single form-control" id="kondisi_filter1" required>
                            @foreach ($dataKondisi as $item)
                                <option value="{{ $item->id_kondisi }}"> {{ $item->nama_kondisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
            <button class="btn btn-success " onclick="filter_aset()"> Filter </button>
            <button class="btn btn-warning " onclick="filter_aset(1)"> Refresh </button>
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
                                        <th class="text-center">Kode Jurusan</th>
                                        <th class="text-center">Ruangan</th>
                                        <th class="text-center">Kode aset</th>
                                        <th class="text-center">Nama aset</th>
                                        <th class="text-center">Kondisi</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataAset as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama_jurusan }}</td>
                                            <td class="text-center">{{ $item->nama_ruangan }}</td>
                                            <td class="text-center">{{ $item->kode_aset }}</td>
                                            <td class="text-center">{{ $item->nama_aset }}</td>
                                            <td class="text-center">
                                                <p class="btn btn-{{ $item->icon_kondisi }} btn-sm">
                                                    {{ $item->nama_kondisi }} </p>
                                            </td>
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
        <div class="modal-dialog  modal-lg">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Tambah Aset</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/tambah_aset" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode Jurusan</label>
                                    <select class="js-example-basic-single form-control" style="width: auto"
                                        name="kode_jurusan" required id="jurusan_filter2"
                                        onchange="getRuanganByJurusan(2)">
                                        @foreach ($dataJurusan as $item)
                                            <option value="{{ $item->id_jurusan }}"> {{ $item->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Ruangan</label>
                                    <select class="js-example-basic-single form-control" style="width: auto"
                                        name="id_ruangan" id="ruangan_filter2" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="date_modified">Jenis aset </label>
                                    <select class="js-example-basic-single-2 form-control" id="jenis_filter"
                                        name="id_jenis" required>
                                        @foreach ($dataJenis as $item)
                                            <option value="{{ $item->id_jenis }}"> {{ $item->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kode Aset</label>
                            <input class="form-control" type="text" name="kode_aset" required>
                            @error('kode_aset')
                                <script>
                                    swal("Oppss!", "Kode aset telah tersedia!", "error");
                                </script>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Aset</label>
                            <input class="form-control" type="text" name="nama_aset">
                        </div>
                        <div class="form-group">
                            <label>Tahun Pengadaan</label>
                            <select id="id_tahun_pengadaan" name="tahun_pengadaan" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label>NUP</label>
                            <input class="form-control" type="number" name="nup">
                        </div>

                        <div class="form-group">
                            <label>Merk/Type</label>
                            <input class="form-control" type="text" name="merk_type">
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input class="form-control" type="number" name="jumlah">
                        </div>

                        <div class="form-group">
                            <label>Nilai barang</label>
                            <input class="form-control" type="number" name="nilai_barang">
                        </div>

                        <div class="form-group">
                            <label>Kondisi</label>
                            <select class="js-example-basic-single form-control" style="width: auto" name="id_kondisi"
                                required>
                                @foreach ($dataKondisi as $item)
                                    <option value="{{ $item->id_kondisi }}"> {{ $item->nama_kondisi }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <input class="form-control" type="text" name="keterangan">
                        </div>

                        <div class="input-group">
                            <div class="custom-file">
                                <input id="id_foto1" type="file" name="foto" accept="image/*"
                                    class="custom-file-input" onchange="cekFoto(1)">
                                <label class="custom-file-label" for="id_foto">Foto Aset</label>

                            </div>

                        </div>
                        <img class="img-priview rounded mt-2" width="150" id="priviewFoto1">
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
