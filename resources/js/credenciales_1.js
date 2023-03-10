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
  if ($("#nc_t_licencia_edit").val() == "") {
    LT = { tipo: "", list: "" };
  }
  $.ajax({
    type: "post",
    url: "credenciales/query_update_emp",
    data: $("#form_update_creden").serialize() + "&id=" + idEmpleadoEdit,
    // dataType: "dataType",
    success: function (r) {
      if (r.est == 1) {
        $("#md_update_credencial").modal("hide");
        $("#form_update_creden").trigger("reset");
        noti_fi(2, "Datos Actualizados.");
        $(`#td_fi_cren_${r.data.idEmpleado}`).replaceWith(fila_creden(r.data));
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
      if (response == "error_noAtorizado") {
        noti_fi(3, "Función no atorizada!.");
      }
      if (response.est) {
        var_delete_credencial = "";
        $("#md_show_deleteConfirm").modal("hide");
        noti_fi(1, "Credencial Eliminado");
        $("#td_fi_cren_" + response.id).remove();
      } else {
        noti_fi(3, "Error!.");
      }
    },
  });
}

function fun_credeEmp_camera(param) {
  myDropzone.options.url = "credenciales/query_add_photo/" + param;
  myDropzone.removeAllFiles(true);
  $("#md_add_photo").modal("show");
}

// TODO --------- funciones de generar credencial
showCreden = (idCredRenov) => {
  data = "?idRenovCred=" + idCredRenov + "&" + "id=" + idEmpleadoRenovar;
  fetch("credenciales/query_estImprecion" + data)
    .catch((error) => console.log(error))
    .then((response) => response.json())
    .then((data) => printCreden(data));
};

printCreden = (data) => {
  if (data['estado'] == true) {
    if (data['data']['cr_tipo'] == 'C') {
      tipoCreden = 2
    } else {
      tipoCreden = 1
    }
    if (data['data']['cr_tipo'] == 'C') {
      if (data['data']['LicCategoria'] == null || data['data']['LicCategoria'] == 'N' && tipoCreden == 2
      ) {
        noti_fi(4, 'Error!. Antes de continuar, registre informacion de "PCP"')
        return
      }
    }
    var url = `credenciales/pdf_creden_emp_a/${data['data']['idEmpleado']}/${tipoCreden}/${data['data']['id']}`;
    $("#emb_sec_pdf_creden").attr("src", url);
    $("#md_show_credencial").modal("show");
    $('#mod_conf_renovacion').modal('hide');
    return;
  }
  noti_fi(3, 'Error de validación!')
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
  if (tipo == "P") {
    var url = `credenciales/pdf_creden_emp_a/${param}/1`;
    $("#emb_sec_pdf_creden").attr("src", url);
    $("#md_show_credencial").modal("show");
    $("#mod_conf_renovacion").modal("hide");
  } else if (tipo == "C") {
    $.get("credenciales/query_cons_1", { id: param }, function (
      data,
      textStatus,
      jqXHR
    ) {
      if (data) {
        var url = `credenciales/pdf_creden_emp_a/${param}/2`;
        $("#emb_sec_pdf_creden").attr("src", url);
        $("#md_show_credencial").modal("show");
        $("#mod_conf_renovacion").modal("hide");
        return;
      }
      noti_fi(3, "Sin tipo de credencial Registrado!");
    });
  }
}
// TODO =======//================================
function fun_credeEmp_print(param) { }
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
  param = $('#inp_textBusqueda').val();
  if (param.length != 0) {
    $.ajax({
      type: "GET",
      url: "credenciales/query_buscar_A",
      data: { text: param, term: $("#selTerminal").val() },
      // dataType: "dataType",
      success: function (response) {
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
  res
    .map(function (e) {
      html = `${html}${fila_creden(e)}`;
    })
    .join(" ");
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
  if (e.CategoriaLic == null || e.CategoriaLic == "" || e.CategoriaLic == 'N') {
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
                                <button class="btn btn-block bg-danger" style="color:white"  onclick="confirmarBajaEmpleado('${e.idEmpleado}')">Dar Baja</button>
                                <button class="btn btn-block bg-primary" style="color:white"  onclick="fun_renovar_creden('${e.idEmpleado}',1)">Generar | Renovar</button>
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
          tableBodyHistCredRenov(response);
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
          ren_cred_docRespaldo: $("#ren_cred_docRespaldo").val(),
        },
        // dataType: "dataType",a
        success: function (response) {
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
tableBodyHistCredRenov = (response) => {
  html2 = response.data
    .map(function (p) {
      tipoR = "TIAS";
      if (p.cr_tipo == "C") {
        tipoR = "PCP";
      }
      botton = "Impreso";
      botton2 = `<button onClick="descImpr(${p.id},${p.idEmpleado})" class="btn" ><i class="fa fa-lock"></i></button>`
      if (p.cr_estadoImp == 1) {
        botton2 = '<button class="btn disabled"><i class="fa fa-unlock"></i></button>';
        botton = `<button class="btn btn-block bg-green" 
        style="color: white" onclick="showCreden(${p.id})">
        <i class="fa fa-print"></i> Imprimir</button> `;
      }
      return (a = `
                <tr>
                    <td>${p.created_atn}</td>
                    <td>${p.cr_motivo}</td>
                    <td>${p.cr_nueva_CodigoTarjeta}</td>
                    <td>${p.cr_docRespaldo}</td>
                    <td>${tipoR}</td>
                    <td>${botton}</td>
                    <td>${botton2}</td>
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
};
// todo --- REACTIVAR IMPRECION /START
descImpr = (id, idEmpleado) => {
  datos = `?idCreden=${id}&idEmpleado=${idEmpleado}`
  fetch('credenciales/query_descImpr' + datos)
    .catch((error) => console.error(error))
    .then((response) => response.json())
    .then((data) => desblok(data, idEmpleado))
}
desblok = (data, idEmpleado) => {
  switch (data['estado']) {
    case 1:
      noti_fi(1, 'Función procesada exitosamente.')
      fun_renovar_creden(idEmpleado, 1)
      break;
    case 0:
      noti_fi(2, 'Funcion no Autorizada!')
      break;
    case 3:
      noti_fi(4, 'Error. Vuelva a intentarlo')
      break;
    default:
      noti_fi(4, 'Error.')
      break;
  }
}
// todo --- REACTIVAR IMPRECION /END

function tipoLicen(valor) {
  // switch ($("input[name=tipo_lic]:checked").val()) {
  switch (valor) {
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
// todo --- asignar, editar categoria de licencia---||START
function asig_licencia(id) {

  $("input[name=tipo_lic][value='N']").prop("checked", true);
  $('input[name="g1"]').attr("disabled", true);
  $('input[name="g2"]').attr("disabled", true);
  $('input[name="g3"]').attr("disabled", true);
  $('input[name="g4"]').attr("disabled", true);
  idEmpleadoEdit = id;
  data = `?&idEmp=${id}`;
  fetch('credenciales/query_verEdit_TLC/' + data)
    .catch((error) => console.log(error))
    .then((response) => response.json())
    .then((data) => showModAsigTLC(data))
}
showModAsigTLC = (data) => {
  tipoLicen('N');
  if (data['estado'] == 0) {
    $('#lic_areas').val('');
    $("input[name=pcp_fechaVencimiento").val(data['vencimiento'] ?? '0000-00-00');
    $("#md_show_asign_licencia").modal("show");
  }
  if (data['estado'] == 1) {
    $("#md_show_asign_licencia").modal("show");
    $('#lic_areas').val(data['areas']);
    $("input[name=pcp_fechaVencimiento").val(data['vencimiento'] ?? '0000-00-00');
    $(`input[name=tipo_lic][value='${data['categoria']}']`).prop("checked", true);
    tipoLicen(data['categoria']);
    categorias = data['datos'];
    categorias.forEach(element => {
      $('input[value=' + element + ']').prop("checked", true);
    });

  }

}
// todo ---- asignar, editar categoria licena ----|| END
$("input[name=radio]").change(function (e) {
  e.preventDefault();
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
      if (response == 1) {
        $("#lic_new").trigger("reset");
        noti_fi(2, "Correcto!");
        $("input:checkbox:checked").prop("checked", false);
        $("#lic_areas").val('')
        $("#pcp_fechaVencimiento").val('')
        $("#md_show_asign_licencia").modal("hide");
      } else {
        noti_fi(4, "Error!");
      }
    },
  });
}

// TODO --- funciones para baja de empleado
let empleadoBaja = "";
let confirmarBajaEmpleado = (empleado) => {
  empleadoBaja = empleado;
  $("#md_bajaEmpleado").modal("show");
};

let fun_baja_creden = () => {
  fetch("credenciales/query_baja_creden/?empleado=" + empleadoBaja)
    .catch((error) => console.log("Error"))
    .then((response) => response.text())
    .then((data) => notiBaja(data));
};

let notiBaja = (response) => {
  if (response) {
    noti_fi(2, "Registro dado de baja");
    $("#td_fi_cren_" + empleadoBaja).remove();
    $("#md_bajaEmpleado").modal("hide");
    empleadoBaja = "";
    return;
  }
  noti_fi(4, "Error de proceso");
};
