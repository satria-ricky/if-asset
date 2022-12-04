<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href={{ asset('css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('font-awesome/css/font-awesome.css') }} rel="stylesheet">
    <link href={{ asset('css/animate.css') }} rel="stylesheet">
    <link href={{ asset('css/style.css') }} rel="stylesheet">
    <link href={{ asset('css/custom.css') }} rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="https://pkl.if.unram.ac.id/assets/img/fav.png" sizes="16x16" />
</head>

<body id="page-top" class="landing-page">
    <div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
            <div class="container">
                <a class="navbar-brand" href="/">PSTI</a>
                <div class="navbar-header page-scroll">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="page-scroll" href="#page-top">Beranda</a></li>
                        <li><a class="page-scroll" href="#features">Statistik</a></li>
                        <li><a class="page-scroll" href="#contact">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>


    <div>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="wow zoomIn animated"> Inventaris Aset </h1>
                        <p class="wow zoomIn animated"> Sistem Informasi Inventaris Aset PSTI-UNRAM </p> <br />
                        <p> <br /> <a class="btn btn-lg btn-success" href="/auth"> <i class="fa fa-lock"></i>
                                &nbsp;Masuk </a> </p>
                    </div>
                    <div class="carousel-image wow zoomIn animated"> <img src="{{ asset('storage/logo/logoPSTI.jpg') }}"
                            alt="Praktek Kerja Lapangan" width="150" height="150"> </div>
                </div>
                <div class="header-back"></div>
            </div>
        </div>
    </div>


    <section id="features" class="container features">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Statistik Penggunaan</h1> <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center wow fadeInLeft">
            </div>
            <div class="col-md-6 text-center  wow zoomIn">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-md-3 text-center wow fadeInRight">
            </div>
        </div>
    </section>

    <section id="contact" class="gray-section contact">
        <div class="container">
            <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1> Hubungi Kami </h1>
                </div>
            </div>
            <div class="row m-b-lg">
                <div class="col-lg-3"></div>
                <div class="col-lg-3 col-lg-offset-3">
                    <address> Jl. Majapahit No. 62, Mataram<br /> NTB (Nusa Tenggara Barat) <br /><br /> <abbr
                            title="Telegram Chat"><i class="fa fa-paper-plane-o"></i></abbr>&nbsp;&nbsp;<a
                            href="https://t.me/unrampustikhelp">Help Desk</a> (chat)<br /> <abbr
                            title="Telegram Channel"><i class="fa fa-bullhorn"></i></abbr>&nbsp;&nbsp;<a
                            href="https://t.me/unramnews">UNRAM News</a> (channel)<br /> </address>
                </div>
                <div class="col-lg-4">
                    <p class="text-color"> Jika memiliki pertanyaan atau mengalami kendala selama proses pengisian
                        silakan menghubungi kami melalui beberapa jalur yang tertera. </p>
                    <p class="text-color"> Untuk <strong>Help Desk</strong> bisa dihubungi melalui Telegram (hanya
                        Chat). </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                    <p><strong>&copy; 2020 &mdash; Teknik Informatika Universitas Mataram</strong></p>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </section>

    <script src={{ asset('js/jquery-2.1.1.js') }}></script>
    <script src={{ asset('js/bootstrap.min.js') }}></script>
    <script src={{ asset('js/inspinia.js') }}></script>
    <script src={{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}></script>
    <script src={{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}></script>
    <script src={{ asset('js/plugins/pace/pace.min.js') }}></script>
    <script src={{ asset('js/plugins/wow/wow.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
    <script src={{ asset('js/beranda.js') }}></script>

    {{-- chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src={{ asset('js/mychart.js') }}></script>



</body>

</html>
