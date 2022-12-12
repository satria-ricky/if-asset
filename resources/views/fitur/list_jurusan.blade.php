@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Jurusan</h2>
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
                        <h5>jurusan</h5>
                    </div> --}}
                    <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                        <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal"> Tambah
                            Kode Jurusan</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Kode Jurusan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataJurusan as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama_jurusan }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown"
                                                        class="btn btn-primary btn-sm dropdown-toggle">Action </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button
                                                                style="border-radius: 3px; color: inherit; line-height: 25px; margin: 4px; text-align: left; font-weight: normal; display: block; padding: 3px 20px; width: 95%;"
                                                                class="dropdown-item pb-2"
                                                                onclick="buttonModalEditJurusan({{ $item }})">
                                                                Edit</button>
                                                        </li>
                                                        <li>
                                                            <form action="/hapus_jurusan" method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id_jurusan }}">
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
                    <h4 class="modal-title">Tambah Kode Kode Jurusan</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/tambah_jurusan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama Kode Jurusan</label>
                            <input class="form-control" type="text" name="nama_jurusan" required autocomplete="off">
                            @error('nama_jurusan')
                                <script>
                                    swal("Oppss!", "Kode jurusan telah tersedia!", "error");
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

    <div class="modal inmodal" id="ModalEditJurusan" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit Kode Jurusan</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/edit_jurusan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama jurusan</label>
                            <input type="hidden" name="id" id="formModalIdJurusan">
                            <input class="form-control" type="text" name="nama_jurusan" id="formModalNamaJurusan">
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
