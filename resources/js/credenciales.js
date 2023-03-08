var myDropzone = new Dropzone("#subImagen", {
    url: "null",
    headers: {
        "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
    },
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 1, // MB
    accept: function (file, done) {
        empleato = 1;
        if (empleato != null) {
            done("");
        } else {
            setTimeout(() => {
                myDropzone.removeFile(file);
            }, 3000);

            done("Error en llenado de detalle");
        }
    },
    success: function (file, response) {
        if (response) {
            $("#md_add_photo").modal("hide");
            queryShow_1();
        } else {
        }
    },
});
// todo --- CREAR CREDENCIAL /START
btn_creden_add_item = () => {
    $("#form_new_creden").trigger("reset");
    $("#md_add_credencial").modal("show");
};

$("#form_new_creden").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "credenciales/query_create_1",
        data: $("#form_new_creden").serialize() ,
        success: function (response) {
            if (response.status == 1) {
                $("#md_add_credencial").modal("hide");
                $("#form_new_creden").trigger("reset");
                noti_fi(1, "Registrado Completado.!");
                var table = document.getElementById("view_1_body_1");
                var row = table.insertRow(0);
                //this adds row in 0 index i.e. first place
                row.innerHTML = fila_creden(response.data);
                return;
            }
            noti_fi(4, "Error!...");
        },
    });
});
// todo --- CREAR CREDENCIAL /END
$(".upload").on("click", function () {
    var formData = new FormData();
    var files = $("#image")[0].files[0];
    formData.append("file", files);
    $.ajax({
        url: "credenciales/query_add_photo",
        type: "get",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 0) {
                $(".card-img-top").attr("src", response);
            } else {
                alert("Formato de imagen incorrecto.");
            }
        },
    });
    return false;
});
