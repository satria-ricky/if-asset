
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


function cekFoto() {
    const getFoto = document.querySelector("#id_foto");
    const setFoto = document.querySelector("#priviewFoto");
    // console.log(setFoto);

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
