tableTermList = () => {
    $.get("terminal/query_list_1", function (data, textStatus, jqXHR) {
        printTableTerm(data)
    });
};

printTableTerm = (data) => {
    data.map(lista= (e, i) => {
        return (h = `
        <tr>
            <td>
                <div class="d-inline-block">
                    <div class="d-inline-block align-middle">
                        <h6 class="mb-0">${e.ta_sigla} | ${e.ta_nombre}</h6>
                        <p class="text-muted mb-0">${e.ta_depen_cod}</p>
                    </div>
                </div>
            </td>
            <td class="text-right">
                <h6 class="fw-700">Aeropuerto</h6>
            </td>
            <td class="text-right">
                <h6 class="fw-700">Personal registrado: ${e.num}</h6>
            </td>
            <td class="text-right">
                <a href="#!"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>
                <a href="#!"><i class="ik ik-trash-2 f-16 text-red"></i></a>
            </td>
        </tr>
        `);
    }).join(" ");
};
console.log(printTableTerm(tableTermList));
createTerm = (id) => {
    console.log($("#form_new_terminal").serialize());
    $.ajax({
        type: "post",
        url: "terminal/query_create_1",
        data: $("#form_new_terminal").serialize(),
        success: function (response) {
            console.log(response);
            if (response == 1) {
                noti_fi(1, "Terminal regitrada");
                $(`#mod_new_terminal`).modal("hide");
            } else {
                noti_fi(4, "Error. Proceso no realizado !");
            }
        },
    });
};
