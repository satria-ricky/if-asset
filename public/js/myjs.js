//FILTER
function getRuanganByJurusan(p) {
    // var jurusan = "jurusan_filter"+p;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var id_jurusan = document.getElementById("jurusan_filter" + p).value;

    $.ajax({
        url: "/getRuanganByJurusan",
        method: "POST",
        dataType: "json",
        data: {
            id_jurusan: id_jurusan,
        },
        success: function (data) {
            //    console.log(data);
            $("#ruangan_filter" + p).empty();
            for (var i in data) {
                $("#ruangan_filter" + p).append(
                    "<option value=" +
                        data[i].id_ruangan +
                        ">" +
                        data[i].nama_ruangan +
                        "</option>"
                );
            }
        },
    });
}

function filter_aset(refresh) {
    var id_jurusan = document.getElementById("jurusan_filter1").value;
    var id_ruangan = document.getElementById("ruangan_filter1").value;
    var id_jenis = document.getElementById("jenis_filter1").value;
    var id_kondisi = document.getElementById("kondisi_filter1").value;

    // console.log(id_jurusan,id_ruangan,id_kondisi);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // $.ajax({
    //     url: "asetByRuangan",
    //     method: "POST",
    //     dataType: "json",
    //     data: {
    //         id_jurusan: id_jurusan,
    //         id_ruangan: id_ruangan,
    //         id_kondisi: id_kondisi,
    //     },
    //     success: function (data) {
    //            console.log(data);
    //     },
    // });

    $("#dataTabelAset").DataTable().destroy();
    var i = 0;
    $("#dataTabelAset").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/asetByRuangan",
            dataType: "json",
            type: "POST",
            data: {
                refresh: refresh,
                id_jurusan: id_jurusan,
                id_ruangan: id_ruangan,
                id_jenis: id_jenis,
                id_kondisi: id_kondisi,
            },
        },
        columns: [
            {
                data: "id_aset",
                render: function (data, type, row, meta) {
                    return (i = i + 1);
                },
                className: "text-center",
            },
            {
                data: "nama_jurusan",
                className: "text-center",
            },
            {
                data: "nama_ruangan",
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
                data: "id_kondisi",
                className: "text-center",
            },
            {
                data: "action",
                className: "text-center",
            },
        ],
    });
}

function filter_laporan(refresh) {
    var refresh = refresh;
    var id_jurusan = document.getElementById("jurusan_filter1").value;
    var id_ruangan = document.getElementById("ruangan_filter1").value;
    var id_jenis = document.getElementById("jenis_filter1").value;
    var tanggal_awal = document.getElementById("tanggal_awal").value;
    var tanggal_akhir = document.getElementById("tanggal_akhir").value;

    // console.log(id_jurusan,id_ruangan,id_jenis,tanggal_awal,tanggal_akhir);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // $.ajax({
    //     url: "/filterLaporan",
    //     method: "POST",
    //     dataType: "json",
    //     data: {
    //         refresh: refresh,
    //         id_jurusan: id_jurusan,
    //         id_ruangan: id_ruangan,
    //         id_jenis: id_jenis,
    //         tanggal_awal: tanggal_awal,
    //         tanggal_akhir: tanggal_akhir,
    //     },
    //     success: function (data) {
    //            console.log(data);
    //     },
    // });

    $("#dataTabelAset").DataTable().destroy();
    var i = 0;

    $("#dataTabelAset").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/filterLaporan",
            dataType: "json",
            type: "POST",
            data: {
                refresh: refresh,
                id_jurusan: id_jurusan,
                id_ruangan: id_ruangan,
                id_jenis: id_jenis,
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir,
            },
        },
        columns: [
            {
                data: "id_laporan",
                render: function (data, type, row, meta) {
                    return (i = i + 1);
                },
                className: "text-center",
            },
            {
                data: "nama_jurusan",
                className: "text-center",
            },
            {
                data: "nama_ruangan",
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
                data: "id_kondisi",
                className: "text-center",
            },
            {
                data: "checked_at",
                className: "text-center",
            },
            {
                data: "keterangan",
                className: "text-center",
            },
            {
                data: "action",
                className: "text-center",
            },
        ],
    });
}

function filter_histori_ruangan(refresh) {
    var refresh = refresh;
    var id_jurusan = document.getElementById("jurusan_filter1").value;
    var id_ruangan = document.getElementById("ruangan_filter1").value;
    var id_user = document.getElementById("id_user_filter1").value;
    var tanggal_awal = document.getElementById("tanggal_awal").value;
    var tanggal_akhir = document.getElementById("tanggal_akhir").value;

    // console.log(refresh,id_jurusan,id_ruangan,tanggal_awal,tanggal_akhir);

    $("#dataTabelAset").DataTable().destroy();
    var i = 0;

    $("#dataTabelAset").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/filterHistoriRuangan",
            dataType: "json",
            type: "POST",
            data: {
                refresh: refresh,
                id_jurusan: id_jurusan,
                id_ruangan: id_ruangan,
                id_user: id_user,
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir,
            },
        },
        columns: [
            {
                data: "id_histori_ruangan",
                render: function (data, type, row, meta) {
                    return (i = i + 1);
                },
                className: "text-center",
            },
            {
                data: "nama_jurusan",
                className: "text-center",
            },
            {
                data: "nama_ruangan",
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
            {
                data: "action",
                className: "text-center",
            },
        ],
    });
}

function FilterHistoriAset(refresh) {
    var tanggal_awal = document.getElementById("tanggal_awal").value;
    var tanggal_akhir = document.getElementById("tanggal_akhir").value;
    var id_user = document.getElementById("id_user_filter").value;
    var refresh = refresh;

    // console.log(tanggal_awal,tanggal_akhir,mahasiswa);
    $("#dataTabelAset").DataTable().destroy();
    var i = 0;
    // $.ajax({
    //     url: "/filterHistori",
    //     method: "POST",
    //     dataType: "json",
    //     data: {
    //         tanggal_awal: tanggal_awal,
    //         tanggal_akhir: tanggal_akhir,
    //         id_user: id_user,
    //         refresh: refresh,
    //     },
    //     success: function (data) {
    //         console.log(data);
    //     },
    // });

    $("#dataTabelAset").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/filterHistori",
            dataType: "json",
            type: "POST",
            data: {
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir,
                id_user: id_user,
                refresh:refresh
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
            {
                data: "action",
                className: "text-center",
            },
        ],
    });
}

//MODAL EDIT
function buttonModalEditJurusan(params) {
    $("#ModalEditJurusan").modal("show");
    $("#formModalNamaJurusan").val(params.nama_jurusan);
    $("#formModalIdJurusan").val(params.id_jurusan);
}

function buttonModalEditRuangan(params) {
    // console.log(params)

    $("#ModalEditRuangan").modal("show");
    $("#formModalNamaRuangan").val(params.nama_ruangan);
    $("#formModalNamaJurusan").val(params.id_jurusan).change();
    $("#formModalIdRuangan").val(params.id_ruangan);
    $("#formModalFotoLama").val(params.foto_ruangan);

    $("#priviewFoto2").attr("src", "/storage/" + params.foto_ruangan);
}

function buttonModalEditJenisAset(params) {
    // console.log(params)
    $("#ModalEditRuangan").modal("show");
    $("#formModalNama").val(params.nama_jenis);
    $("#formModalId").val(params.id_jenis);
}

//LAPORAN
function setFotoAset() {
    var id = document.getElementById("IdAsetModalTambah").value;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "post",
        url: "/asetById",
        data: {
            id_aset: id,
        },
        success: function (data) {
            //   console.log(data);

            $("#priviewFoto").attr("src", "/storage/" + data[0].foto_aset);
            document.getElementById("NamaAsetModalTambah").value =
                data[0].nama_aset;
            // document.getElementById('IdKondisiModalTambah').value = data[0].id_kondisi;
            $("#IdKondisiModalTambah").val(data[0].id_kondisi).change();
        },
    });
}

//

function buttonLogout() {
    var link = "formLogout";
    swal({
        title: "Are you sure?",
        // text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(link).submit();
        }
    });
}

function cekFoto(p) {
    const var_getpoto = "#id_foto" + p;
    const var_setpoto = "#priviewFoto" + p;
    // console.log(poto);
    const getFoto = document.querySelector(var_getpoto);
    const setFoto = document.querySelector(var_setpoto);

    var filePath = getFoto.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(filePath)) {
        swal({
            icon: "error",
            title: "Gagal!",
            text: "Format File Tidak Didukung",
        });
        getFoto.value = "";
        setFoto.src = "";
        return false;
    } else {
        // document.getElementById("setFoto").style.display = "none";

        const ofReader = new FileReader();
        ofReader.readAsDataURL(getFoto.files[0]);
        ofReader.onload = function (oFREvent) {
            setFoto.src = oFREvent.target.result;
        };
    }

    // else if (getFoto.files[0].size / 1024 / 1024 > 3) {
    //     Swal.fire({icon: "error", title: "Maaf", text: "Ukuran Terlalu Besar (Maksimal 3MB)"});
    //     getFoto.value = "";
    //     return false;
    // }
}

function show_password() {
    var input = document.getElementById("input_password");
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
