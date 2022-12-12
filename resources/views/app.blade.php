<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>
    <link rel="shortcut icon" type="image/png" href="https://pkl.if.unram.ac.id/assets/img/fav.png" sizes="16x16" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

</head>

<body>
    <div id="wrapper">
        @if (Auth::user()->level == 1)
            @include('template.sidebar')
        @elseif (Auth::user()->level == 2)
            @include('template.sidebar_kaprodi')
        @elseif (Auth::user()->level == 3)
            @include('template.sidebar_mahasiswa')
            @elseif (Auth::user()->level == 4)
            @include('template.sidebar_dosen')
        @endif



        <div id="page-wrapper" class="gray-bg">
            @include('template.header')
            <div class="wrapper wrapper-content">
                @yield('content')
            </div>
            <div class="footer">
                {{-- <div class="float-right">
                    10GB of <strong>250GB</strong> Free.
                </div> --}}
                <div>
                    <strong>Copyright</strong> Inventaris Aset IF-UNRAM &copy; 2022
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
    <script src={{ asset('js/bootstrap.js') }}></script>
    <script src={{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}></script>
    <script src={{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}></script>

    <!-- Custom and plugin javascript -->
    <script src={{ asset('js/inspinia.js') }}></script>
    <script src={{ asset('js/plugins/pace/pace.min.js') }}></script>
    <script src={{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}></script>
    <!-- jQuery UI -->
    <script src={{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}></script>
    {{-- select2 --}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- datatable --}}

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script src="{{ asset('js/myjs.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    </script>

    @if (Request::is('adm_laporan'))
        <script>
            function setFotoAset() {


                var id = document.getElementById("IdAsetModalTambah").value;

                $.ajax({
                    type: "post",
                    url: "{{ url('asetById') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_aset: id,
                    },
                    success: function(data) {
                        //   console.log(data);

                        $('#priviewFoto').attr('src', "{{ asset('storage') }}/" + data[0].foto_aset);
                        document.getElementById("NamaAsetModalTambah").value = data[0].nama;
                        document.getElementById('IdKondisiModalTambah').value = data[0].kondisi;

                    },
                });
            }
        </script>
    @endif


    @if (Request::is('list_laporan'))
        <script>
            function FilterLaporanProdi() {
                var tanggal_awal = document.getElementById("tanggal_awal").value;
                var tanggal_akhir = document.getElementById("tanggal_akhir").value;
                var kondisi = document.getElementById("kondisi").value;

                // console.log(tanggal_awal,tanggal_akhir,kondisi);
                $("#dataTabelAset").DataTable().destroy();
                var i = 0;
                $("#dataTabelAset").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('filterLaporan') }}",
                        dataType: "json",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            awal: tanggal_awal,
                            akhir: tanggal_akhir,
                            kondisi: kondisi
                        },
                    },
                    columns: [{
                            data: "id_aset",
                            render: function(data, type, row, meta) {
                                return (i = i + 1);
                            },
                            className: "text-center",
                        },
                        {
                            data: "kode_aset",
                            className: "text-center",
                        },
                        {
                            data: "nama",
                            className: "text-center",
                        },
                        {
                            data: "checked_at",
                            className: "text-center",
                        },
                        {
                            data: "kondisi",
                            className: "text-center",
                        },
                    ],
                });
            }
        </script>
    @endif


    @if (Request::is('histori_aset'))
        <script>
            function FilterHistoriAdm() {
                var tanggal_awal = document.getElementById("tanggal_awal").value;
                var tanggal_akhir = document.getElementById("tanggal_akhir").value;
                var mahasiswa = document.getElementById("mahasiswa").value;

                // console.log(tanggal_awal,tanggal_akhir,mahasiswa);
                $("#dataTableHistoriAdmin").DataTable().destroy();
                var i = 0;

                // $.ajax({
                //     url: "{{ url('filterHistori') }}",
                //     method: "POST",
                //     dataType: "json",
                //     data: {
                //         _token: "{{ csrf_token() }}",
                //         awal: tanggal_awal,
                //         akhir: tanggal_akhir,
                //         mahasiswa: mahasiswa
                //     },
                //     success: function(dataadad) {
                //        console.log(dataadad);
                //     },
                // })


                $("#dataTableHistoriAdmin").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('filterHistori') }}",
                        dataType: "json",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            awal: tanggal_awal,
                            akhir: tanggal_akhir,
                            mahasiswa: mahasiswa
                        },
                    },
                    columns: [
                        {
                            data: "id_histori",
                            render: function (data, type, row, meta) {
                                return (i = i + 1);
                            },
                            className: "text-center",
                        },
                        {
                            data: "nama_user",
                            className: "text-center",
                        },
                        {
                            data: "kode_aset",
                            className: "text-center",
                        },
                        {
                            data: "nama_aset",
                            className: "text-center",
                        },
                        {
                            data: "mulai",
                            className: "text-center",
                        },
                        {
                            data: "selesai",
                            className: "text-center",
                        },
                    ],
                });
            }
        </script>
    @endif


    <script>
        // Upgrade button class name
        $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-white btn-sm';

        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                // dom: '<"html5buttons"B>lTfgitp',
                // buttons: [{
                //         extend: 'copy'
                //     },
                //     {
                //         extend: 'csv'
                //     },
                //     {
                //         extend: 'excel',
                //         title: 'ExampleFile'
                //     },
                //     {
                //         extend: 'pdf',
                //         title: 'ExampleFile'
                //     },

                //     {
                //         extend: 'print',
                //         customize: function(win) {
                //             $(win.document.body).addClass('white-bg');
                //             $(win.document.body).css('font-size', '10px');

                //             $(win.document.body).find('table')
                //                 .addClass('compact')
                //                 .css('font-size', 'inherit');
                //         }
                //     }
                // ]

            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // console.log("ready!");
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });

            $(document).ready(function() {
                $('.js-example-basic-single-2').select2();
            });
        });
    </script>

    @if (session()->has('success'))
        <script>
            swal("Berhasil!", "{{ session('success') }}", "success");
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            swal("Gagal!", "{{ session('error') }}", "error");
        </script>
    @endif
    @if (session()->has('warning'))
        <script>
            swal("Oppss!", "{{ session('warning') }}", "warning");
        </script>
    @endif


    @if (Request::is('list_jenis_aset'))
        <script>
            function buttonModalEditJenisAset(params) {
                // console.log(params)
                $('#ModalEditRuangan').modal('show');
                $("#formModalNama").val(params.nama_jenis);
                $("#formModalId").val(params.id_jenis);
            }
        </script>
    @endif

    @if (Request::is('list_aset'))
        <script>
            let startYear = 1800;
            let endYear = new Date().getFullYear();
            for (i = endYear; i > startYear; i--) {
                $('#id_tahun_pengadaan').append($('<option />').val(i).html(i));
                // $('#id_perbaikan_terakhir').append($('<option />').val(i).html(i));
            }

            $(document).on('change', '#idRuangan', function() {
                var id = document.getElementById("idRuangan").value;
                $('#dataTabelAset').DataTable().destroy();
                var i = 0;
                $('#dataTabelAset').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('asetByRuangan') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            id_ruangan: id
                        }
                    },
                    "columns": [{
                            "data": "id_aset",
                            render: function(data, type, row, meta) {
                                return i = i + 1;
                            },
                            "className": "text-center",
                        },
                        {
                            "data": "kode_aset",
                            "className": "text-center",
                        },
                        {
                            "data": "nama",
                            "className": "text-center",
                        },
                        {
                            "data": "kondisi",
                            "className": "text-center",
                        },
                        {
                            "data": "action",
                            "className": "text-center",
                        }
                    ]

                });
            });
        </script>
    @endif

    @if (Request::is('edit_aset/*'))
        <script>
            let startYear = 1800;
            let endYear = new Date().getFullYear();
            for (i = endYear; i > startYear; i--) {
                $('#id_tahun_pengadaan').append($('<option />').val(i).html(i));
                document.getElementById('id_tahun_pengadaan').value = {{ $dataAset->tahun_pengadaan }};
            }
        </script>
    @endif


</body>

</html>
