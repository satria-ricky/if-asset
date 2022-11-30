@extends('app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Tables</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>Tables</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Data Table s</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row mb-3">
        <div class="col-lg-12">
            <form action="/dashboard" method="POST">
                @csrf
                <div class="row">
                  <div class="col">
                    <p style="font-size: 18px;">Jenis Ujian</p>
                    <select class="js-example-basic-single form-control" name="jenis">
                        <option value="AZ">AZ</option>
                        <option value="DP">DP</option>
                        <option value="AI">AI</option>
                      </select>
                  </div>
                  <div class="col">
                    <p style="font-size: 18px;">Waktu</p>
                    <input type="date" name="waktu" id="datepicker"  class="form-control rounded border-0" height="3px" required />
                  </div>
                  <div class="col mt-5">
                    <button class="btn btn-lg btn-primary"> Filter</button>
                  </div>
                </div>
              </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List Jadwal Ujian</h5>
                </div>
                <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                    @if (Auth::user()->level == 0)    
                        <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal4"> Tambah Jadwal</button>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr >
                                    <th class="text-center">Ujian</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam</th>
                                    <th class="text-center">Kuota Tersedia</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr class="gradeA">
                                    <td class="text-center">{{$item["jenis"]}}</td>
                                    <td class="text-center">{{$item["tanggal"]}}</td>
                                    <td class="text-center">{{$item["waktu"]}}</td>
                                    <td class="text-center">{{$item["kuota"]}}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->level ==0)
                                        <form action="hapus_jadwal" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$item['id']}}" name="id">
                                            <button class="btn btn-sm btn-danger" onclick="confirm('Apakah anda yakin?')">Hapus</button>
                                        </form>
                                        @else
                                            @if ($item['kuota'] !=0)
                                            @if ($item["jenis"] =="AI")
                                            @if (Auth::user()->ai)
                                            <form action="simpan_jadwal" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$item['id_jadwal']}}" name="jadwal">
                                                <input type="hidden" value="{{Auth::user()->id}}" name="peserta">
                                                <input type="hidden" value="{{$item['jenis']}}" name="tes">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="confirm('Apakah anda yakin?')" >Daftar</button>
                                            </form>
                                            @else
                                                <p class="btn btn-sm btn-danger" >Daftar</p>
                                            @endif
                                            
                                        @endif

                                        @if ($item["jenis"] =="AZ")
                                            @if (Auth::user()->az)
                                            <form action="simpan_jadwal" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$item['id_jadwal']}}" name="jadwal">
                                                <input type="hidden" value="{{Auth::user()->id}}" name="peserta">
                                                <input type="hidden" value="{{$item['jenis']}}" name="tes">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="confirm('Apakah anda yakin?')" >Daftar</button>
                                            </form>
                                            @else
                                                <p class="btn btn-sm btn-danger" >Daftar</p>
                                            @endif
                                            
                                        @endif

                                        @if ($item["jenis"] =="DP")
                                            @if (Auth::user()->dp)
                                            <form action="simpan_jadwal" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$item['id_jadwal']}}" name="jadwal">
                                                <input type="hidden" value="{{Auth::user()->id}}" name="peserta">
                                                <input type="hidden" value="{{$item['jenis']}}" name="tes">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="confirm('Apakah anda yakin?')" >Daftar</button>
                                            </form>
                                            @else
                                                <p class="btn btn-sm btn-danger" >Daftar</p>
                                            @endif
                                            
                                        @endif
                                            @else
                                            <p class="btn btn-sm btn-danger" >Kosong</p>
                                            @endif
                                            
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

<div class="modal inmodal" id="myModal4" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Tambah Jadwal</h4>
            </div>
            <div class="modal-body bg-white">
                
                <form role="form" method="post" action="/tambah_jadwal">
                    @csrf 
                    <div class="form-group">
                        <label>Tes</label> <br>
                        <select class="form-control" name="tes">
                            <option value="AZ">AZ</option>
                            <option value="DP">DP</option>
                            <option value="AI">AI</option>
                          </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label> 
                        <input class="form-control" type="date" name="tanggal" list="datalistOptions" id="modalTanggal" autocomplete="off">
                    <div class="form-group">
                        <label>Waktu</label> 
                        <input class="form-control" type="time" name="jam" list="datalistWaktu" id="modalWaktu" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Kuota</label> 
                        <input class="form-control" type="number" name="kuota" list="datalistWaktu" id="modalWaktu" autocomplete="off">
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
@endsection