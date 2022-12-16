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
                            <div class="table">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Kode Jurusan</label>
                                            <select class="js-example-basic-single form-control" style="width: auto"
                                                name="kode_jurusan" required id="jurusan_filter2"
                                                onchange="getRuanganByJurusan(2)">
                                                @foreach ($dataJurusan as $item)
                                                    @if ($item->id_jurusan == $dataAset->kode_jurusan)
                                                        <option selected value="{{ $item->id_jurusan }}">
                                                            {{ $item->nama_jurusan }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id_jurusan }}"> {{ $item->nama_jurusan }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Ruangan</label>
                                            <select class="js-example-basic-single form-control" style="width: auto"
                                                name="id_ruangan" id="ruangan_filter2" required>
                                                @foreach ($dataRuangan as $item)
                                                    @if ($item->id_ruangan == $dataAset->id_ruangan)
                                                        <option selected value="{{ $item->id_ruangan }}">
                                                            {{ $item->nama_ruangan }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id_ruangan }}"> {{ $item->nama_ruangan }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label" for="date_modified">Jenis aset </label>
                                            <select class="js-example-basic-single-2 form-control" id="jenis_filter"
                                                name="id_jenis" required>
                                                @foreach ($dataJenis as $item)
                                                    @if ($item->id_jenis == $dataAset->id_jenis)
                                                        <option selected value="{{ $item->id_jenis }}">
                                                            {{ $item->nama_jenis }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id_jenis }}"> {{ $item->nama_jenis }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label>Kode Aset</label>
                                    <input class="form-control" type="text" name="kode_aset" required
                                        value="{{ $dataAset->kode_aset }}">
                                    @error('kode')
                                        <script>
                                            swal("Oppss!", "Kode aset telah tersedia!", "error");
                                        </script>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Aset</label>
                                    <input class="form-control" type="text" name="nama_aset"
                                        value="{{ $dataAset->nama_aset }}">
                                </div>

                                <div class="form-group">
                                    <label>Tahun Pengadaan</label>
                                    <select id="id_tahun_pengadaan" name="tahun_pengadaan" class="form-control"></select>
                                </div>

                                <div class="form-group">
                                    <label>NUP</label>
                                    <input class="form-control" type="number" name="nup" value="{{ $dataAset->nup }}">
                                </div>

                                <div class="form-group">
                                    <label>Merk/Type</label>
                                    <input class="form-control" type="text" name="merk_type"
                                        value="{{ $dataAset->merk_type }}">
                                </div>

                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input class="form-control" type="number" name="jumlah"
                                        value="{{ $dataAset->jumlah }}">
                                </div>


                                <div class="form-group">
                                    <label>Nilai barang</label>
                                    <input class="form-control" type="number" name="nilai_barang"
                                        value="{{ $dataAset->nilai_barang }}">
                                </div>


                                <div class="form-group">
                                    <label>Kondisi</label>
                                    <select class="js-example-basic-single form-control" style="width: auto" name="id_kondisi">
                                        @foreach ($dataKondisi as $item)
                                            @if ($item->id_kondisi == $dataAset->id_kondisi)
                                            <option selected value="{{ $item->id_kondisi }}">
                                                <p class="btn btn-{{ $item->icon_kondisi }} btn-sm">
                                                    {{ $item->nama_kondisi }} </p>
                                            </option>
                                            @else
                                                <option value="{{ $item->id_kondisi }}">
                                                    <p class="btn btn-{{ $item->icon_kondisi }} btn-sm">
                                                        {{ $item->nama_kondisi }} </p>
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input class="form-control" type="text" name="keterangan"
                                        value="{{ $dataAset->keterangan }}">
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $dataAset->foto_aset }}" name="fotoLama">
                                        <input id="id_foto1" type="file" name="foto" accept="image/*"
                                            class="custom-file-input" onchange="cekFoto(1)">
                                        <label class="custom-file-label" for="id_foto1">Foto Aset</label>
                                    </div>
                                </div>
                                @if (old('foto'))
                                    <img class="img-priview rounded mt-2" width="150" id="priviewFoto1">
                                @else
                                    <img src="{{ asset('storage/' . $dataAset->foto_aset) }}"
                                        class="img-priview rounded mt-2" width="150" id="priviewFoto1">
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
