
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//FILTER
function getRuanganByJurusan() {
    

    var id_jurusan = document.getElementById("jurusan_filter").value;
    
    $.ajax({
        url: "getRuanganByJurusan",
        method: "POST",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}",
            id_jurusan: id_jurusan
        },
        success: function(data) {
           console.log(data);
        },
    })


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
