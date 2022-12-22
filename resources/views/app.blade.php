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
    <script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
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

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}">
    </script>

    <!-- Page-Level Scripts -->
    <script src="{{ asset('js/myjs.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    </script>
<script>
     $(document).ready(function () {
            $('.dataTables-example').DataTable();
     })
</script>

    @if (Request::is('list_laporan'))
        <script>
            $('#dataTabelAset').DataTable();
        </script>
    @endif


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


    @if (Request::is('list_aset'))
        <script>
            let startYear = 1800;
            let endYear = new Date().getFullYear();
            for (i = endYear; i > startYear; i--) {
                $('#id_tahun_pengadaan').append($('<option />').val(i).html(i));
            }            
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
