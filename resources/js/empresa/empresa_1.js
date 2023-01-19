// *------
list_Orden = 1;
id_EMP_SEL = "";
//*--------
$(document).ready(function () {
    show_list_empresa_1();
});
function show_list_empresa_1() {
    console.log("mostrar lista");
    $.ajax({
        type: "get",
        url: "Empresa/query_list",
        // data: "data",
        // dataType: "dataType",
        success: function (response) {
            list_table_empresas(response);
        },
    });
}

function inp_buscar_empr(param) {
    $.ajax({
        type: "get",
        url: "Empresa/query_buscar_A",
        data: { data: param },
        // dataType: "dataType",
        success: function (response) {
            list_table_empresas(response);
        },
    });
}

// * ---- lista de empresas
function list_table_empresas(response) {
    html_1 = response
        .map(function (u) {
            return (a = `
        <tr id="tdEmp${u.id}">
            <td width="45%">
                <div class="d-inline-block align-middle">
                    <div class="d-inline-block">
                    <p class="mb-0"> ${
                        u.NombEmpresa != null ? u.NombEmpresa : "..."
                    }</p>
                    <p class="text-muted mb-0">Rep. legal: ${
                        u.RepLegal != null ? u.RepLegal : "..."
                    }</p>
                    <h6 class="text-muted mb-0"> ${u.Empresa} </h6>
                    </div>
                </div>
            </td>
            <td width="45%">
                <div class="d-inline-block align-middle">
                    <div class="d-inline-block">
                        <h6 class="mb-0">Telf: ${
                            u.Telefono != null ? u.Telefono : "###"
                        } , Email: ${u.Email != null ? u.Email : "..."}</h6>
                        <p class="text-muted mb-0">Direccion: ${
                            u.Direccion != null ? u.Direccion : "..."
                        }</p>
                    </div>
                </div>
            </td>
            <td class="text-left" width="10%">
                <a href="#!" onclick="edit_empresa(${
                    u.id
                })"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>
                <a href="#!" onclick="delete_emprea(${
                    u.id
                })"><i class="ik ik-trash-2 f-16 text-red"></i></a>
            </td>
        </tr>
    `);
        })
        .join("");
    $("#table_list_body_1").html(html_1);
}

$("#btn_new_empresa").click(function (e) {
    e.preventDefault();
    $("#form_new_empresa").trigger("reset");
    $("#mod_new_empresa").modal("show");
    $().show();
});
$("#form_new_empresa").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "Empresa/query_create",
        data: $(this).serialize(),
        // dataType: "bolean",
        success: function (response) {
            console.log(response);
            if (response) {
                noti_fi(1, "Usuario Registrado.");
                show_list_empresa_1();
                $("#form_new_empresa").trigger("reset");
                $("#mod_new_empresa").modal("hide");
            } else {
                noti_fi(4, "Error en el registro!.");
            }
        },
    });
});

// *orden lista
$("#btn_orden_list").click(function (e) {
    e.preventDefault();
    $.get(
        "Empresa/query_orden_list_1",
        { o: list_Orden },
        function (data, textStatus, jqXHR) {
            console.log(textStatus);
            if (textStatus) {
                list_Orden += 1;
                list_table_empresas(data);
            } else {
                noti_fi("4", "Error de conexión");
            }
        },
        "json"
    );
});

function edit_empresa(id) {
    id_EMP_SEL = id;
    console.log("blaaa");
    $.get(
        "Empresa/query_edit/",
        { id: id_EMP_SEL },
        function (data, textStatus, jqXHR) {
            console.log(textStatus);
            console.log(data);
            if (textStatus) {
                $("#Emp_nombre_edit").val(data.NombEmpresa);
                $("#Emp_abreviacion_edit").val(data.Empresa);
                $("#Emp_telf_edit").val(data.Telefono);
                $("#Emp_dir_edit").val(data.Direccion);
                $("#Emp_repLeg_edit").val(data.RepLegal);
                $("#Emp_casi_edit").val(data.Casilla);
                $("#Emp_fax_edit").val(data.Fax);
                $("#Emp_email_edit").val(data.Email);
                $("#Emp_ruc_edit").val(data.Ruc);
                $("#mod_edit_empresa").modal("show");
            } else {
                noti_fi(4, "Error! RECARGUE LA PAGINA");
            }
        },
        "json"
    );
}
$("#form_edit_empresa").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "Empresa/query_update/" + id_EMP_SEL,
        data: $(this).serialize(),
        // dataType: "dataType",
        success: function (response) {
            console.log(response);

            if (response) {
                $("#mod_edit_empresa").modal("hide");
                $("#form_edit_empresa").trigger("reset");
                id_EMP_SEL = "";
                noti_fi(2, "Datos Actualizados.");
                show_list_empresa_1();
            } else {
                noti_fi(4, "Error!. ");
            }
        },
    });
});

delete_emprea = (cod) => {
    id_EMP_SEL = cod;
    $("#md_empreaDelete").modal("show");
};
deleteEmpresa1 = () => {
    empresa = id_EMP_SEL;
    empresaMigrate = $("#listEmpresaSel").val();
    $.ajax({
        type: "get",
        url: "Empresa/query_delete/",
        data: { e1: empresa, e2: empresaMigrate },
        // dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.estado == 1) {
                $("#md_empreaDelete").modal("hide");
                $("#tdEmp"+id_EMP_SEL).remove();
                id_EMP_SEL='';
                noti_fi(2,'Registro eliminado')
                if (response.cant!=0) {
                    noti_fi(1,`${response.cant} Empleados migrados`)
                }
            
            }
        },
    });
};
