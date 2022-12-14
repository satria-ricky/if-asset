{{-- <div>

    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->mergeString(Storage::get('public/logo/logoUNRAM.png'),.3)->generate($data)) !!} ">
</div> --}}




<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>

</head>

<body>
    <center>
        <div style="border: solid; width: 260px;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 52px;">Kode : </th>
                        <td>  {{ $aset->kode_aset }} </td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="width: 52px;">Nama : </th>
                        <td>  {{ $aset->nama_aset }} </td>
                    </tr>
                </thead>
            </table>
            <img src="data:image/png;base64, {!! base64_encode(
                QrCode::format('png')->size(250)->mergeString(Storage::get('public/logo/logoUNRAM.png'), 0.3)->generate($data),
            ) !!} ">
        </div>
    </center>
</body>

</html>
