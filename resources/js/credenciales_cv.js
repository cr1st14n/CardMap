$(document).ready(function () {
    query_list_credenVis();
});
id_credenVis = "";
 query_list_credenVis = () => {
    fetch("credenciales/query_listCV")
        .then((data) => {
            return data.json();
        })
        .catch((error) => {
            console.log(error);
        })
        .then((data) => {
            show_list_A(data);
        });
};

 show_list_A = (res) => {
    maq = res
        .map((e) => {
            return fila_1(e);
        })
        .join(" ");
    $("#view_1_body").html(maq);
};

 fila_1 = (e) => {
    let r = "0";
    return (a = `
                <tr id="tcv-${e.id}">
                    <td>${r.repeat(4 - `${e.cv_Codigo}`.length)}${
        e.cv_Codigo
    }-${e.cv_Aeropuerto_2}</td>
                    <td>${e.cv_tarjRfid}</td>
                    <td>${e.cv_tarjMyfare}</td>
                    <td>${e.cv_areas}</td>
                    <td>${e.cv_areas}</td>
                    <td>
                        <div class="table-actions">
                            <a href="#" onclick="fun_credeEmp_emage(${
                                e.id
                            })"><i class="ik ik-clipboard"></i></a>
                            <a href="#" onclick="destroy_creden_visita(1,${
                                e.id
                            })"><i class="ik ik-trash-2"></i></a>
                        </div>
                    </td>
                </tr>
                `);
};

$("#btn_credenCV_add_item").click(function (e) {
    e.preventDefault();
    $("#form_new_creden_visita").trigger("reset");
    $("#md_add_credenVis").modal("show");
});
console.log("abrir");

$("#form_new_creden_visita").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "credenciales/query_createCV",
        data: $(this).serialize(),
        success: function (response) {
            console.log(response);
            if (response.estado == 1) {
                $("#md_add_credenVis").modal("hide");
                query_list_credenVis();
                noti_fi(1, "Credencial Registrado");
            } else {
                noti_fi(3, "Credencial Registrado");
            }
        },
    });
});

 destroy_creden_visita = (t, id) => {
    switch (t) {
        case 1:
            id_credenVis = id;
            $("#md_crevis_deleteConfirm").modal("show");
            break;
        case 2:
            $.ajax({
                type: "post",
                url: "credenciales/query_crevis_destroy",
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                    id: id_credenVis,
                },
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $("#md_crevis_deleteConfirm").modal("hide");
                        $('#tcv-'+id_credenVis).remove();
                        id_credenVis = "";
                        noti_fi(2,'Registro Eliminado')
                    } else {
                    }
                },
            });
            break;

        default:
            break;
    }
};
function fun_credeEmp_emage(param) {
    reg = $("#reg_aero").attr("name");
    var url = `credenciales/pdf_creden_v/${param}`;
    $("#emb_sec_pdf_creden_v").attr("src", url);
    $("#md_show_credencial_v").modal("show");
}
