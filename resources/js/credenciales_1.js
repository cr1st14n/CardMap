var_delete_credencial = "";
idEmpleadoEdit = "";
idEmpleadoRenovar = "";

function fun_credeEmp_edit(param) {
    $.ajax({
        type: "post",
        url: "credenciales/query_edit_emp",
        data: {
            _token: $("meta[name=csrf-token]").attr("content"),
            id: param,
        },
        // dataType: "dataType",
        success: function (response) {
            $("#md_update_credencial").modal("show");

            console.log(response.Empresa);

            $("input[name=nc_ci_edit]").val(response.CI);
            $("input[name=nc_nom_edit]").val(response.Nombre);
            $("input[name=nc_pa_edit]").val(response.Paterno);
            $("input[name=nc_ma_edit]").val(response.Materno);
            $("#nc_em_edit_id").val(response.Empresa);
            $("input[name=nc_car_edit]").val(response.Cargo);
            $("input[name=nc_codt_edit]").val(response.CodigoTarjeta);
            $("input[name=nc_codMy_edit]").val(response.CodMYFARE);
            $("input[name=nc_he_edit]").val(response.Herramientas);
            $("input[name=nc_areas_acceso_edit]").val(response.AreasAut);
            $("input[name=nc_AreasCp_edit]").val(response.AreasCP);
            $("input[name=nc_gs_edit]").val(response.GSangre);
            $("input[name=nc_fv_edit]").val(response.Vencimiento);
            // $("input[name=nc_acci_edit]").val(response.estado);
            $("input[name=nc_nren_edit]").val(response.NroRenovacion);
            $("input[name=nc_f_in_edit]").val(response.Fecha);
            $("input[name=nc_FNac_edit]").val(response.FechaNac);
            $("input[name=nc_pro_edit]").val(response.Profesion);
            $("input[name=nc_est_edit]").val(response.altura);
            $("input[name=nc_colojo_edit]").val(response.Ojos);
            $("input[name=nc_maCorp_edit]").val(response.Peso);
            $("input[name=nc_Fono_edit]").val(response.TelDom);
            $("input[name=nc_10_edit]").val(response.Direccion);
            $("input[name=nc_11_edit]").val(response.TelTrab);
            $("input[name=nc_12_edit]").val(response.DirTrab);
            $("input[name=nc_13_edit]").val(response.Observacion);

            $("#nc_estCiv_edit").val(response.EstCivil);
            $("#nc_sexo_edit").val(response.Sexo);

            $("#nc_aeropuerto_edit").val(response.aeropuerto_2);
            $("#nc_tipo_edit").val(response.tipo);

            idEmpleadoEdit = response.idEmpleado;
        },
    });
}
function update_creden(val) {
    console.log($("#form_update_creden").serialize());
    if ($("#nc_t_licencia_edit").val() == "") {
        LT = { tipo: "", list: "" };
    }
    $.ajax({
        type: "post",
        url: "credenciales/query_update_emp",
        data:
            $("#form_update_creden").serialize() + LT + "&id=" + idEmpleadoEdit,
        // dataType: "dataType",
        success: function (r) {
            console.log(r);
            if (r.est == 1) {
                $("#md_update_credencial").modal("hide");
                $("#form_update_creden").trigger("reset");
                noti_fi(2, "Datos Actualizados.");
                $(`#td_fi_cren_${r.data.idEmpleado}`).replaceWith(
                    fila_creden(r.data)
                );
            }
        },
    });
}

function fun_credeEmp_delete(param) {
    var_delete_credencial = param;
    $("#md_show_deleteConfirm").modal("show");
}
function destroy_credencial() {
    $.ajax({
        type: "post",
        url: "credenciales/query_destroy_credencial",
        data: {
            _token: $("meta[name=csrf-token]").attr("content"),
            id: var_delete_credencial,
        },
        // dataType: "dataType",
        success: function (response) {
            console.log(response);
            if (response == "error_noAtorizado") {
                noti_fi(3, "Función no atorizada!.");
            }
            if (response.est) {
                var_delete_credencial = "";
                $("#md_show_deleteConfirm").modal("hide");
                noti_fi(1, "Credencial Eliminado");
                $("#td_fi_cren_" + response.id).remove();
            } else {
                console.log("error");
            }
        },
    });
}

function fun_credeEmp_camera(param) {
    myDropzone.options.url = "credenciales/query_add_photo/" + param;
    myDropzone.removeAllFiles(true);
    $("#md_add_photo").modal("show");
}

// * --------- funciones de generar credencial
showCreden = (tipo) => {
    console.log(tipo);
    fetch(
        "credenciales/query_estImprecion?tipo=" +
            tipo +
            "&" +
            "id=" +
            idEmpleadoRenovar
    )
        .catch((error) => console.log(error))
        .then((response) => response.text())
        .then((data) => printCreden(data, tipo));
};

printCreden = (estado, tipo) => {
    console.log(estado);
    if (estado == 1) {
        console.log("puede imprimir");
        fetch(
            "credenciales/queryUpdateEstadoImpr?id=" +
                idEmpleadoRenovar +
                "&tipo=" +
                tipo
        )
            .catch((error) => console.log(error))
            .then((response) => response.text())
            .then((data) => vistaImprecion(data, tipo));

        return;
        fun_credeEmp_emage(idEmpleadoRenovar, tipo);
    }
    noti_fi(3, "Error, Credencial ya impreso");
    return;
};
let vistaImprecion = (data, tipo) => {
    if (data == 1) {
        fun_credeEmp_emage(idEmpleadoRenovar, tipo);
        return;
    }
    noti_fi(3, "Acción no Permitida");
    return;
};

function fun_credeEmp_emage(param, tipo) {
    console.log(param, tipo);
    if (tipo == "P") {
        var url = `credenciales/pdf_creden_emp_a/${param}/1`;
        $("#emb_sec_pdf_creden").attr("src", url);
        $("#md_show_credencial").modal("show");
        $("#mod_conf_renovacion").modal("hide");
    } else if (tipo == "C") {
        console.log("tipo_2");
        $.get(
            "credenciales/query_cons_1",
            { id: param },
            function (data, textStatus, jqXHR) {
                console.log(data);
                if (data) {
                    var url = `credenciales/pdf_creden_emp_a/${param}/2`;
                    $("#emb_sec_pdf_creden").attr("src", url);
                    $("#md_show_credencial").modal("show");
                    $("#mod_conf_renovacion").modal("hide");
                    return;
                }
                noti_fi(3, "Sin tipo de credencial Registrado!");
            }
        );
    }
}
// * =======//================================
function fun_credeEmp_print(param) {
    console.log(param);
}
// * ----- funciones de busqueeda

function queryShow_1() {
    $("#view_1_body_1").html("");

    // $.ajax({
    //     type: "get",
    //     url: "credenciales/queryShow_1",
    //     // data: "data",
    //     // dataType: "dataType",
    //     success: function (res) {
    //         lista_table_creden(res);
    //     },
    // });
}

let input_busqueda_creden = (param) => {
    if (param.length != 0) {
        $.ajax({
            type: "GET",
            url: "credenciales/query_buscar_A",
            data: { text: param, term: $("#selTerminal").val() },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
                lista_table_creden(response);
            },
        });
    } else {
        queryShow_1();
    }
};
changeTerminal = (val = $("#selTerminal").val()) => {
    if (val == null) {
        noti_fi(3, "Seleccione Terminal Aeropuertuaria");
        return;
    }
    res = window
        .fetch("credenciales/query_buscar_B?text=" + val)
        .then((response) => response.json())
        .then((data) => lista_table_creden(data))
        .catch((err) => console.log("error server "));
};

function lista_table_creden(res) {
    html = "";
    res.map(function (e) {
        html = `${html}${fila_creden(e)}`;
    }).join(" ");
    console.log(html);
    $("#view_1_body_1").html(html);
}

let fila_creden = (e) => {
    var f = new Date(e.Vencimiento);
    f = f.toLocaleDateString();
    rutaPhoto = e.urlphoto;
    if (e.urlphoto == null) {
        rutaPhoto = "";
    }

    licencia = `<button class="btn btn-sm bg-green" onclick="asig_licencia(${e.idEmpleado})"><i class="fa fa-car fa-1x "></i>${e.CategoriaLic}</button>`;
    if (e.CategoriaLic == null || e.CategoriaLic == "") {
        licencia = `<button class="btn btn-sm bg-yellow" onclick="asig_licencia(${e.idEmpleado})"><i class="fa fa-car fa-1x "></i></button>`;
    }
    return (html = `
                <tr id="td_fi_cren_${e.idEmpleado}">
                    <td>${e.Codigo}</td>
                    <td>${e.Nombre} ${e.Paterno} ${e.Materno}</td>
                    <td>${e.CI}</td>
                    <td>${e.ta_sigla}<br/> <span style="color: red; font-size:10px"> ${e.ta_nombre}</span> </td>
                    <td>${e.Empresa}<br/> <span style="color: red; font-size:10px"> ${e.NombEmpresa}</span> </td>
                    <td>${f}</td>
                    <td>
                        <img src="${rutaPhoto}" width="60px" alt="">
                    </td>
                    <td>${e.NroRenovacion}</td>
                    <td>
                       ${licencia}
                    <td >
                        <div class="btn-group float-md-left mr-1 mb-1">
                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                <i class="ik ik-chevron-down mr-0 align-middle"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item"  onclick="fun_credeEmp_edit('${e.idEmpleado}')">Editar</button>
                                <button class="dropdown-item"  onclick="fun_credeEmp_delete('${e.idEmpleado}')">Eliminar</button>
                                <button class="dropdown-item"  onclick="fun_credeEmp_camera('${e.idEmpleado}')">Cargar Imagen</button>
                                <div role="separator" class="dropdown-divider"></div>
                                <button class="dropdown-item bg-purple"  onclick="confirmarBajaEmpleado('${e.idEmpleado}')">Dar Baja</button>
                                <button class="dropdown-item bg-danger"  onclick="fun_renovar_creden('${e.idEmpleado}',1)">Generar | Renovar</button>
                            </div>
                        </div>
                    </td>
                </tr>
                `);
};

// *----\\\\--------------

function fun_renovar_creden(id, param) {
    switch (param) {
        case 1:
            $("#table_renov_creden_emp").html("");
            $("#text_creden_vigent").html("Codigo de credencial Vigente :###");
            $("#form_ren_cred").trigger("reset");
            idEmpleadoRenovar = id;
            $.ajax({
                type: "post",
                url: "credenciales/query_renovar_creden/1",
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                    id: idEmpleadoRenovar,
                },
                // dataType: "dataType",
                success: function (response) {
                    console.log(response);
                    cont = 0;
                    html2 = response.data
                        .map(function (p) {
                            tipoR = "TIAS";
                            if (p.cr_tipo == "C") {
                                tipoR = "PCP";
                            }
                            return (a = `
                            <tr>
                                <th scope="row">${(cont += 1)}</th>
                                <td>${p.created_atn}</td>
                                <td>${tipoR}</td>
                                <td>${p.cr_motivo}</td>
                                <td>${p.cr_nueva_CodigoTarjeta}</td>
                            </tr>
                            `);
                        })
                        .join(" ");
                    $("#table_renov_creden_emp").html(html2);
                    $("#text_creden_vigent").html(
                        "Codigo de credencial-Plataforma Vigente : <strong>" +
                            response.cod +
                            "</strong>"
                    );
                },
            });
            $("#mod_conf_renovacion").modal("show");
            break;
        case 2:
            $.ajax({
                type: "post",
                url: "credenciales/query_renovar_creden/2",
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                    id: idEmpleadoRenovar,
                    ren_cred_motivo: $("#ren_cred_motivo").val(),
                    ren_cred_codigo: $("#ren_cred_codigo").val(),
                    ren_cred_tipo: $("#ren_cred_tipo").val(),
                },
                // dataType: "dataType",a
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        // $("#mod_conf_renovacion").modal("hide");
                        fun_renovar_creden(idEmpleadoRenovar, 1);
                        // idEmpleadoRenovar = "";
                        noti_fi(2, "Datos registrados");
                    } else {
                        noti_fi(4, "Error Server, Informar al Supservisor");
                    }
                },
            });
            break;
        case 3:
            $("#mod_conf_renovacion").modal("hide");
            idEmpleadoRenovar = "";
            break;

        default:
            break;
    }
}
function tipoLicen() {
    console.log($("input[name=tipo_lic]:checked").val());
    switch ($("input[name=tipo_lic]:checked").val()) {
        case "A":
            $('input[name="g1"]').attr("disabled", false);
            $('input[name="g2"]').attr("disabled", true);
            $('input[name="g2"]').prop("checked", false);
            $('input[name="g3"]').attr("disabled", true);
            $('input[name="g3"]').prop("checked", false);
            $('input[name="g4"]').attr("disabled", true);
            $('input[name="g4"]').prop("checked", false);
            break;

        case "B":
            $('input[name="g1"]').attr("disabled", false);
            $('input[name="g2"]').attr("disabled", false);
            $('input[name="g3"]').attr("disabled", true);
            $('input[name="g3"]').prop("checked", false);
            $('input[name="g4"]').attr("disabled", true);
            $('input[name="g4"]').prop("checked", false);
            break;

        case "C":
            $('input[name="g1"]').attr("disabled", false);
            $('input[name="g2"]').attr("disabled", false);
            $('input[name="g3"]').attr("disabled", false);
            $('input[name="g4"]').attr("disabled", true);
            $('input[name="g4"]').prop("checked", false);
            break;

        case "M":
        case "P":
            $('input[name="g1"]').attr("disabled", true);
            $('input[name="g1"]').prop("checked", false);
            $('input[name="g2"]').attr("disabled", true);
            $('input[name="g2"]').prop("checked", false);
            $('input[name="g3"]').attr("disabled", true);
            $('input[name="g3"]').prop("checked", false);
            $('input[name="g4"]').attr("disabled", false);
            break;

        case "N":
            $('input[name="g1"]').attr("disabled", true);
            $('input[name="g1"]').prop("checked", false);
            $('input[name="g2"]').attr("disabled", true);
            $('input[name="g2"]').prop("checked", false);
            $('input[name="g3"]').attr("disabled", true);
            $('input[name="g3"]').prop("checked", false);
            $('input[name="g4"]').attr("disabled", true);
            $('input[name="g4"]').prop("checked", false);
            break;

        default:
            break;
    }
}
function asig_licencia(id) {
    idEmpleadoEdit = id;
    $("#md_show_asign_licencia").modal("show");
    $("input[name=tipo_lic][value='N']").prop("checked", true);
    $('input[name="g1"]').attr("disabled", true);
    $('input[name="g2"]').attr("disabled", true);
    $('input[name="g3"]').attr("disabled", true);
    $('input[name="g4"]').attr("disabled", true);
}

$("input[name=radio]").change(function (e) {
    e.preventDefault();
    console.log("hoal");
});
function saveVeiAut() {
    let t_a = "";
    $("input:checkbox:checked").each(function () {
        t_a += $(this).val() + " ";
    });
    t_a = t_a.split(" ");

    $.ajax({
        type: "get",
        url: "credenciales/query_update_TLC",
        data: {
            data: t_a,
            tipo: $("input[name=tipo_lic]:checked").val(),
            id: idEmpleadoEdit,
            areas: $("#lic_areas").val(),
            pcp_fechaVencimiento: $("#pcp_fechaVencimiento").val(),
            pcp_factura: $("#pcp_factura").val(),
        },
        // dataType: "dataType",
        success: function (response) {
            console.log(response);
            if (response == 1) {
                $("#lic_new").trigger("reset");
                noti_fi(2, "Correcto!");
                $("#md_show_asign_licencia").modal("hide");
            } else {
                noti_fi(4, "Error!");
            }
        },
    });
}

// TODO --- funciones para baja de empleado
let empleadoBaja= ''
let confirmarBajaEmpleado=(empleado)=>{
    empleadoBaja=empleado
    $('#md_bajaEmpleado').modal('show');
}

let fun_baja_creden = () => {
    fetch("credenciales/query_baja_creden/?empleado=" + empleadoBaja)
        .catch((error) => console.log("Error"))
        .then((response) => response.text())
        .then((data) => notiBaja(data));
};

let notiBaja = (response) => {
    if (response) {
        noti_fi(2,'Registro dado de baja')
        $('#td_fi_cren_'+empleadoBaja).remove();
        $('#md_bajaEmpleado').modal('hide');
        empleadoBaja=''
        return
    }
    noti_fi(4,'Error de proceso')
};
