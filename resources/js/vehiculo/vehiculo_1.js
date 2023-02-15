data_Vehiculo = Array;
idVehiculoSelect = '';
function list1() {
    $.ajax({
        type: "get",
        url: "Vehiculo/query_list1",
        data: {},
        // dataType: "dataType",
        success: function (response) {
            list_table(response);
        },
    });
}

function list_table(data) {
    data_Vehiculo = data;
    html_1 = data
        .map(function (p, i) {
            return (h = `
            <tr>
                <td style="text-align:right">${p.id}</td>
                <td style="text-align:right">${p.Placa}</td>
                <td>${p.Responsable}</td>

                <td>
                    <div class="table-actions">
                        <a href="#" onclick="edit_vin(${i})"><i class="ik ik-edit-2"></i></a>
                        <a href="#" onclick="showDetalleVehi(${p.id})"><i class="ik ik-edit-2"></i></a>
                        <a href="#" onclick="showPdfVin(${p.id})"><i class="ik ik-eye"></i></a>
                    </div>
                </td>
            </tr>
        `);
        })
        .join(" ");
    $("#view_1_body_vehi").html(html_1);
}
function showDetalleVehi(id) {
    $.get(
        "Vehiculo/query_detalle_1",
        { id: id },
        function (data, textStatus, jqXHR) {
            html_b = `
            <p>
                Placa: <strong> ${data.Placa}</strong> <br>
                Empresa: <strong> ${data.Empresa}</strong><br>
                Motivo: <strong> ${data.Motivo}</strong><br>
                Fecha Inicial: <strong>${data.FechaIniPer} </strong><br>
                Fecha Final: <strong> ${data.FechaFinPer}</strong><br>
                ------------- <br>
                # de Poliza: <strong> ${data.NroPoliza}</strong><br>
                Marca: <strong> ${data.Marca}</strong><br>
                Tipo: <strong> ${data.Tipo}</strong><br>
                Color: <strong> ${data.Color}</strong><br>
                Empresa Aseguradora: <strong> ${data.EmpresaAseg}</strong><br>
                Areas Autorizadas: <strong> ${data.Areas}</strong><br>
                ------------- <br>
            </p>
            `;
            $("#detalle_vehiculo_p").html(html_b);
        }
    );
}
$("#btn_newVehiculo").click(function (e) {
    e.preventDefault();
    $("#form_newVehiculo").trigger("reset");
    $("#md_newVehiculo").modal("show");
});
$("#form_newVehiculo").submit(function (e) {
    e.preventDefault();
    form_newVehiculo();
});
form_newVehiculo = () => {
    $.ajax({
        type: "post",
        url: "Vehiculo/query_store_1",
        data: $("#form_newVehiculo").serialize(),
        // dataType: "dataType",
        success: function (response) {
            if (response) {
                $("#md_newVehiculo").modal("hide");
                $("#form_newVehiculo").trigger("reset");
                list1();
            }
        },
    });
};

function showPdfVin(id) {
    $("#emb_sec_pdf_vin_v").attr("src", "Vehiculo/pdf_viñeta_1/1/1/" + id);
    $("#md_show_vin").modal("show");
}
function edit_vin(i) {
    idVehiculoSelect = data_Vehiculo[i]['id'];
    $("#md_edit_Vehiculo").modal("show");
    $("#vi_emp_edit").val(data_Vehiculo[i]["Empresa"]);
    $("#vi_placa_edit").val(data_Vehiculo[i]["Placa"]);
    $("#vi_poliza_edit").val(data_Vehiculo[i]["NroPoliza"]);
    $("#vi_resp_edit").val(data_Vehiculo[i]["Responsable"]);
    $("#vi_empAse_edit").val(data_Vehiculo[i]["EmpresaAseg"]);
    $("#vi_aut_edit").val(data_Vehiculo[i]["AutorizadoPor"]);
    $("#vi_feI_edit").val(data_Vehiculo[i]["FechaIniPer"]);
    $("#vi_fef_edit").val(data_Vehiculo[i]["FechaFinPer"]);
    $("#vi_mo_edit").val(data_Vehiculo[i]["Motivo"]);
    $("#vi_color_edit").val(data_Vehiculo[i]["Color"]);
    $("#vi_tipo_edit").val(data_Vehiculo[i]["Tipo"]);
    $("#vi_fab_edit").val(data_Vehiculo[i]["Marca"]);
    $("#vi_AreasCp_edit").val(data_Vehiculo[i]["Areas"]);
}

$("#form_newVehiculo_edit").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "Vehiculo/query_update_1",
        data: $("#form_newVehiculo_edit").serialize() + '&idVei=' + idVehiculoSelect,
        // dataType: "dataType",
        success: function (response) {
            if (response == 1) {
                noti_fi(1, 'Registro Actualizado!.')
                list1();
                $("#md_edit_Vehiculo").modal("hide");
                $("#form_newVehiculo_edit").trigger('reset');
                return
            }
            noti_fi(3, 'Error!.')
        },
    });
});
