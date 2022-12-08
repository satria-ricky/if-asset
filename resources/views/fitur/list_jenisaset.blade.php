@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Jenis Aset</h2>
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
                            Jenis Aset</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Jenis</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataJenis as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama_jenis }}</td>
                                            <td class="text-center" style="width: 153px">
                                                <div style="display:flex;">

                                                    <button class="btn btn-sm btn-info " type="button"
                                                        onclick="buttonModalEditJenisAset({{ $item }})"><i
                                                            class="fa fa-paste"></i> Edit</button>
                                                    <form action="/hapus_jenis_aset" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id_jenis }}">
                                                        <button class="btn btn-sm btn-danger ml-2" type="submit"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> Hapus</button>
                                                    </form>
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
                    <h4 class="modal-title">Tambah Jenis Aset</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/tambah_jenis_aset">
                        @csrf
                        <div class="form-group">
                            <label>Nama Jenis</label>
                            <input class="form-control" type="text" name="nama_jenis" required autocomplete="off">
                            @error('nama_jenis')
                                <script>
                                    swal("Oppss!", "Nama jenis aset telah tersedia!", "error");
                                </script>
                            @enderror

                        </div>
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
                    <h4 class="modal-title">Edit Jenis Aset</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/edit_jenis_aset">
                        @csrf
                        <div class="form-group">
                            <label>Nama Jenis</label>
                            <input type="hidden" name="id" id="formModalId">
                            <input class="form-control" type="text" name="nama_jenis" id="formModalNama"
                                required autocomplete="off">
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
