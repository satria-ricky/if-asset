@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Ruangan</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">{{ $title }}</a>
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
                        <h5>Ruangan</h5>
                    </div> --}}
                    <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                        <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal"> Tambah
                            Ruangan</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Ruangan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataRuangan as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama_ruangan }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                        class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="/detail_ruangan/{{ Crypt::encrypt($item->id_ruangan) }}"
                                                                target="_blank"> Detail</a>
                                                        </li>
                                                        <li>
                                                            <a href="/qr_codeRuangan/{{ Crypt::encrypt($item->id_ruangan) }}"
                                                                class="dropdown-item" target="_blank">Generate QR Code</a>
                                                        </li>
                                                        <li>
                                                            <button
                                                                    style="border-radius: 3px; color: inherit; line-height: 25px; margin: 4px; text-align: left; font-weight: normal; display: block; padding: 3px 20px; width: 95%;"
                                                                    class="dropdown-item pb-2" 
                                                                    onclick="buttonModalEditRuangan({{ $item }})">
                                                                    Edit</button>
                                                        </li>
                                                        <li>
                                                            <form action="hapus_ruangan" method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id_ruangan }}">
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
                                            {{-- <td class="text-center" style="width: 153px">
                                                <div style="display:flex;">

                                                    <button class="btn btn-sm btn-info " type="button"
                                                        onclick="buttonModalEditRuangan({{ $item }})"><i
                                                            class="fa fa-paste"></i> Edit</button>
                                                    <form action="hapus_ruangan" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id_ruangan }}">
                                                        <button class="btn btn-sm btn-danger ml-2" type="submit"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> Hapus</button>
                                                    </form>
                                                </div>
                                            </td> --}}
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
                    <h4 class="modal-title">Tambah Ruangan</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/tambah_ruangan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Kode Jurusan</label>
                            <select class="js-example-basic-single form-control" style="width: auto" name="id_jurusan"
                                required>
                                @foreach ($dataJurusan as $item)
                                    <option value="{{ $item->id_jurusan }}"> {{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Ruangan</label>
                            <input class="form-control" type="text" name="nama_ruangan" required autocomplete="off">
                            @error('nama_ruangan')
                                <script>
                                    swal("Oppss!", "Nama ruangan telah tersedia!", "error");
                                </script>
                            @enderror

                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="id_foto" type="file" name="foto" accept="image/*"
                                    class="custom-file-input" onchange="cekFoto()">
                                <label class="custom-file-label" for="id_foto">Masukkan foto</label>

                            </div>

                        </div>
                        <img class="img-priview rounded mt-2" width="150" id="priviewFoto">
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="ModalEditRuangan" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit Ruangan</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/edit_ruangan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Kode Jurusan</label>
                            <select class="js-example-basic-single form-control" style="width: auto" name="idSumber"
                                required>
                                @foreach ($dataJurusan as $item)
                                    <option value="{{ $item->id_jurusan }}"> {{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Ruangan</label>
                            <input type="hidden" name="id" id="formModalIdRuangan">
                            <input type="hidden" name="fotoLama" id="formModalFotoLama">
                            <input class="form-control" type="text" name="nama_ruangan" id="formModalNamaRuangan"
                                required autocomplete="off">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="id_foto" type="file" name="foto" accept="image/*"
                                    class="custom-file-input" onchange="cekFoto()">
                                <label class="custom-file-label" for="id_foto">Masukkan foto</label>

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
