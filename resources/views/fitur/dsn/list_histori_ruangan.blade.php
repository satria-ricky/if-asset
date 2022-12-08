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

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    {{-- <div class="ibox-title">
                        <h5>Aset</h5>
                        
                    </div> --}}
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                id="dataTabelAset">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode aset</th>
                                        <th class="text-center">Nama aset</th>
                                        <th class="text-center">Dipakai pada:</th>
                                        <th class="text-center">Selesai pada:</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataHistori as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
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
                                            <td class="text-center">
                                                @if ($item->selesai == '')
                                                    <form action="/selesai_dipakai" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id_histori }}" name="id">
                                                        <button class="btn btn-rounded btn-danger btn-sm" type="submit"  onclick="return confirm('Are you sure?')" > Have done ? Click here! </button>
                                                    </form>
                                                @else
                                                    <p class="btn btn-rounded btn-success btn-sm"> Great :)
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
@endsection
