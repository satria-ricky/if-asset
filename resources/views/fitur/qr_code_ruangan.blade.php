
<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>

</head>

<body>
    <center>
        <div style="border: solid; width: 260px;">
            <h1> {{ $ruangan->nama_jurusan }} || {{ $ruangan->nama_ruangan }} </h1>
            <img src="data:image/png;base64, {!! base64_encode(
                QrCode::format('png')->size(250)->mergeString(Storage::get('public/logo/logoUNRAM.png'), 0.3)->generate($data),
            ) !!} ">
        </div>
    </center>
</body>

</html>
