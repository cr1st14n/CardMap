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
            console.log(response);
            if (response.Sexo == "M") {
                Sexo_1 = "Masculino";
            }
            if (response.Sexo == "F") {
                Sexo_1 = "Femenino";
            }
            if (response.Tipo == "N") {
                tipo_1 = "Nacional";
            }
            if (response.Tipo == "L") {
                tipo_1 = "Local";
            }
            if (response.Tipo == "T") {
                tipo_1 = "Temporal";
            }
            $("#md_update_credencial").modal("show");
            $("#nc_tipo_edit").append(
                `<option value="${response.Tipo}" selected>${tipo_1}</option>`
            );
            $("#nc_aeropuerto_edit").append(
                `<option value="${response.aeropuerto_2}" selected>${response.aeropuerto_2}</option>`
            );
            // $("input[name=nc_cod_edit]").val(response.data.Codigo);
            $("input[name=nc_ci_edit]").val(response.CI);
            $("input[name=nc_nom_edit]").val(response.Nombre);
            $("input[name=nc_pa_edit]").val(response.Paterno);
            $("input[name=nc_ma_edit]").val(response.Materno);
            $("#nc_em_edit_id").append(
                `<option value="${response.Empresa}" selected>${response.Empresa}</option>`
            );
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
            idEmpleadoEdit = response.idEmpleado;
        },
    });
}
function update_creden(val) {
    $.ajax({
        type: "post",
        url: "credenciales/query_update_emp",
        data:
            $("#form_update_creden").serialize() + LT + "&id=" + idEmpleadoEdit,
        // dataType: "dataType",
        success: function (r) {
            console.log(r);
            if (r == 1) {
                $("#md_update_credencial").modal("hide");
                $("#form_update_creden").trigger("reset");
                noti_fi(2, "Datos Actualizados.");
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
            $("#md_show_deleteConfirm").modal("show");
            if (response) {
                var_delete_credencial = "";
                $("#md_show_deleteConfirm").modal("hide");
                queryShow_1();
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
function fun_credeEmp_emage(param, tipo) {
    if (tipo == 1) {
        var url = `credenciales/pdf_creden_emp_a/${param}/${tipo}`;
        $("#emb_sec_pdf_creden").attr("src", url);
        $("#md_show_credencial").modal("show");
    } else if (tipo == 2) {
        console.log("tipo_2");
        $.get(
            "credenciales/query_cons_1",
            { id: param },
            function (data, textStatus, jqXHR) {
                console.log(data);
                if (data) {
                    var url = `credenciales/pdf_creden_emp_a/${param}/${tipo}`;
                    $("#emb_sec_pdf_creden").attr("src", url);
                    $("#md_show_credencial").modal("show");
                    return;
                }
                noti_fi(3, "Sin tipo de credencial Registrado!");
            }
        );
    }
}
// * =======l

function fun_credeEmp_print(param) {
    console.log(param);
}
function queryShow_1() {
    $.ajax({
        type: "get",
        url: "credenciales/queryShow_1",
        // data: "data",
        // dataType: "dataType",
        success: function (res) {
            lista_table_creden(res);
        },
    });
}
function input_busqueda_creden(param) {
    if (param.length != 0) {
        $.ajax({
            type: "get",
            url: "credenciales/query_buscar_A",
            data: { text: param },
            // dataType: "dataType",
            success: function (response) {
                lista_table_creden(response);
            },
        });
    } else {
        queryShow_1();
    }
}
function lista_table_creden(res) {
    html = res
        .map(function (e) {
            var f = new Date(e.Vencimiento);
            f = f.toLocaleDateString();
            rutaPhoto = e.urlphoto;
            if (e.urlphoto == null) {
                rutaPhoto = "";
            }
            return (html = `
                <tr>
                    <td>${e.Codigo}</td>
                    <td>${e.Nombre} ${e.Paterno} ${e.Materno}</td>
                    <td>${e.CI}</td>
                    <td>${e.NombEmpresa}</td>
                    <td>${f}</td>
                    <td>
                        <img src="${rutaPhoto}" width="60px" alt="">
                    </td>
                    <td>${e.NroRenovacion}</td>
                    <td>
                        <div class="btn-group float-md-left mr-1 mb-1">
                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                <i class="ik ik-chevron-down mr-0 align-middle"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item"  onclick="fun_credeEmp_edit('${e.idEmpleado}')">Editar</button>
                                <button class="dropdown-item"  onclick="fun_credeEmp_delete('${e.idEmpleado}')">Eliminar</button>
                                <button class="dropdown-item"  onclick="fun_credeEmp_camera('${e.idEmpleado}')">Cargar Imagen</button>
                                <div role="separator" class="dropdown-divider"></div>
                                <button class="dropdown-item"  onclick="fun_credeEmp_emage('${e.idEmpleado}',1)">Generar Credencial</button>
                                <button class="dropdown-item"  onclick="fun_credeEmp_emage('${e.idEmpleado}',2)">Generar Credencial tipo2</button>
                                <button class="dropdown-item"  onclick="fun_renovar_creden('${e.idEmpleado}',1)">Renovar</button>
                            </div>
                        </div>
                    </td>
                </tr>
                `);
        })
        .join(" ");
    $("#view_1_body_1").html(html);
}

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
                            return (a = `
                            <tr>
                                <th scope="row">${(cont += 1)}</th>
                                <td>${p.fecha}</td>
                                <td>${p.motivo}</td>
                                <td>${p.tarjeta}</td>
                            </tr>
                            `);
                        })
                        .join(" ");
                    $("#table_renov_creden_emp").html(html2);
                    $("#text_creden_vigent").html(
                        "Codigo de credencial Vigente : <strong>" +
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
                },
                // dataType: "dataType",
                success: function (response) {
                    if (response) {
                        console.log(response);
                        $("#mod_conf_renovacion").modal("hide");
                        idEmpleadoRenovar = "";
                    } else {
                        console.log("Completar codigo nueva credencial");
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
