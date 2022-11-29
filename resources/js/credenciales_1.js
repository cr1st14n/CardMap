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
            $("#md_update_credencial").modal("show");
            if (
                response.data_vehi_aut == null ||
                response.data_vehi_aut["tipo"] == null
            ) {
                setTimeout(() => {
                    $("#option_tipo_lic_veh_edit").html("");
                }, 500);
                // LT=''
            } else {
                cad = response.data_vehi_aut["list"].split(",");
                vehi = "";
                cad.forEach((a, i) => {
                    console.log(a);
                    if (a != "0") {
                        vehi += [i];
                    }
                });
                console.log(cad);
                sel_1[response.data_vehi_aut["tipo"]] = cad;
                setTimeout(() => {
                    $("#option_tipo_lic_veh_edit").html("");
                }, 700);
                setTimeout(() => {
                    html = cad
                        .map(function (p, i) {
                            selec_chek = "";
                            if (p == "1") {
                                selec_chek = "checked=true";
                            }
                            return (html = `
                                <div class="checkbox-fade fade-in-default">
                                    <label>
                                        <input type="checkbox" name="tipo_vehiculo_aut${i}" ${selec_chek} value="${p}" onchange="saveTipoLicencia('${
                                response.data_vehi_aut.tipo
                            }','${i}')" >
                                        <span class="cr">
                                            <i class="cr-icon ik ik-check text-warning"></i>
                                        </span>
                                        <span>${
                                            sel[response.data_vehi_aut["tipo"]][
                                                i
                                            ]
                                        }</span>
                                    </label>
                                </div>
                        `);
                        })
                        .join(" ");
                    $("#option_tipo_lic_veh_edit").html(html);
                }, 1000);
            }

            $("#nc_tipo_edit").val(response.Tipo);
            $("#nc_aeropuerto_edit").val(response.aeropuerto_2);
            $("input[name=nc_ci_edit]").val(response.CI);
            $("input[name=nc_nom_edit]").val(response.Nombre);
            $("input[name=nc_pa_edit]").val(response.Paterno);
            $("input[name=nc_ma_edit]").val(response.Materno);
            $("#nc_em_edit_id").val(response.Empresa);

            // $("#nc_em_edit_id").append(
            //     `<option value="${response.Empresa}" selected>${response.NombEmpresa}</option>`
            // );

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
            $("#nc_t_licencia_edit").val(response.data_vehi_aut["tipo"]);
            idEmpleadoEdit = response.idEmpleado;
            $("#option_tipo_lic_veh_edit").html("");
        },
    });
}
function update_creden(val) {
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

            licencia = `<button class="btn btn-sm bg-green" onclick="asig_licencia(${e.idEmpleado})"><i class="fa fa-car fa-1x "></i>${e.CategoriaLic}</button>`;
            if (e.CategoriaLic == null || e.CategoriaLic == "") {
                licencia = `<button class="btn btn-sm bg-yellow" onclick="asig_licencia(${e.idEmpleado})"><i class="fa fa-car fa-1x "></i></button>`;
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
                       ${licencia}
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
    $("input[name=tipo_lic][value='N']").prop("checked",true);
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
            if (response==1) {
                $("#lic_new").trigger("reset");
                noti_fi(2, "Correcto!");
                $("#md_show_asign_licencia").modal("hide");
            } else {
                noti_fi(4, "Error!");
            }
        },
    });
}
