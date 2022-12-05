@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Aset</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Daftar Aset</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Edit Aset</strong>
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
                    <div class="ibox-title">
                        <h5>Edit aset : {{ $dataAset->nama }}</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="/edit_aset" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $dataAset->id_aset }}">
                            <div class="table-responsive">
                                <div class="form-group">
                                    <label>Sumber</label>
                                    <select class="js-example-basic-single form-control" style="width: auto"
                                        name="idSumber" required>
                                        @foreach ($dataSumber as $item)
                                            @if ($item->id_sumber == $dataAset->id_sumber)
                                                <option selected value="{{ $item->id_sumber }}"> {{ $item->nama_sumber }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id_sumber }}"> {{ $item->nama_sumber }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Ruangan</label>
                                    <select class="js-example-basic-single form-control" style="width: auto"
                                        name="idRuangan" required>
                                        @foreach ($dataRuangan as $item)
                                            @if ($item->id_ruangan == $dataAset->id_ruangan)
                                                <option selected value="{{ $item->id_ruangan }}"> {{ $item->nama_ruangan }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id_ruangan }}"> {{ $item->nama_ruangan }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Kode Aset</label>
                                    <input class="form-control" type="text" name="kode" required
                                        value="{{ $dataAset->kode_aset }}">
                                    @error('kode')
                                        <script>
                                            swal("Oppss!", "Kode aset telah tersedia!", "error");
                                        </script>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Aset</label>
                                    <input class="form-control" type="text" name="nama" value="{{ $dataAset->nama }}">
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input class="form-control" type="number" name="jumlah"
                                        value="{{ $dataAset->jumlah }}">
                                </div>
                                <div class="form-group">
                                    <label>lokasi</label>
                                    <input class="form-control" type="text" name="lokasi"
                                        value="{{ $dataAset->lokasi }}">
                                </div>
                                <div class="form-group">
                                    <label>Kondisi</label>
                                    {{-- <input class="form-control" type="text" name="kondisi"
                                        value="{{ $dataAset->kondisi }}"> --}}

                                    <select class="js-example-basic-single form-control" style="width: auto" name="kondisi">
                                        @foreach ($dataKondisi as $item)
                                            @if ($item->id_kondisi == $dataAset->kondisi)
                                                <option selected value="{{ $item->id_kondisi }}">
                                                    {{ $item->nama_kondisi }}
                                                </option>
                                            @else
                                                <option selected value="{{ $item->id_kondisi }}">
                                                    {{ $item->nama_kondisi }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>Tahun Pengadaan</label>
                                    <select id="id_tahun_pengadaan" name="tahun_pengadaan" class="form-control"></select>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $dataAset->foto_aset }}" name="fotoLama">
                                        <input id="id_foto" type="file" name="foto" accept="image/*"
                                            class="custom-file-input" onchange="cekFoto()">
                                        <label class="custom-file-label" for="id_foto">Foto Aset</label>
                                    </div>
                                </div>
                                @if (old('foto'))
                                    <img class="img-priview rounded mt-2" width="150" id="priviewFoto">
                                @else
                                    <img src="{{ asset('storage/' . $dataAset->foto_aset) }}"
                                        class="img-priview rounded mt-2" width="150" id="priviewFoto">
                                @endif

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    {{-- <button class="btn btn-white btn-sm" type="submit">Back</button> --}}
                                    <button class="btn btn-primary btn-sm" type="submit"
                                        onclick="return confirm('Are you sure?')">Apply</button>

                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
