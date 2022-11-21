show_list_user_1();
// ? variables de inicio---------
id_user_seleccionado = "";
// ? end --------------
$("#btn_modalAdd_user").click(function (e) {
    e.preventDefault();
    $("#md_add_users").modal("show");
});
$("#form_new_user").submit(function (e) {
    e.preventDefault();
    console.log($(this).serialize());
    $.ajax({
        type: "post",
        url: "Usuarios/create_user",
        data: $(this).serialize(),
        // dataType: "dataType",
        success: function (response) {
            console.log(response);
            $("#md_add_users").modal("hide");

            show_list_user_1();
        },
    });
});

function show_list_user_1() {
    console.log("mostrar lista");
    $.ajax({
        type: "get",
        url: "Usuarios/query_list",
        // data: "data",
        // dataType: "dataType",
        success: function (response) {
            console.log(response);

            html_1 = response
                .map(function (u) {
                    return (a = `
                    <tr>
                        <td>
                            <div class="d-inline-block align-middle">
                                <div class="d-inline-block">
                                    <h6 class="mb-0">${u.nombre} </h6>
                                    <p class="text-muted mb-0">Cod: ${(u.codusr =
                                        !null ? u.codusr : "")}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            <h6 class="fw-700">${
                                u.aeropuerto != null ? u.aeropuerto : ""
                            }</h6>
                        </td>
                        <td class="text-right">
                            <h6 class="fw-700">${
                                u.feching != null ? u.feching : ""
                            }</h6>
                        </td>

                        <td class="text-right">
                            <a href="#!" onclick="edit_user(${
                                u.id
                            })"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>
                            <a href="#!" onclick="delete_user(${
                                u.id
                            })"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                        </td>
                    </tr>
                `);
                })
                .join("");
            $("#table_list_body_1").html(html_1);
        },
    });
}

function delete_user(id) {
    id_user_seleccionado = id;
    $("#md_delete_user").modal("show");
}
function destroy_user() {
    $.ajax({
        type: "post",
        url: "Usuarios/query_destroyUser",
        data: {
            _token: $("meta[name=csrf-token]").attr("content"),
            id: id_user_seleccionado,
        },
        // dataType: "dataType",
        success: function (response) {
            if (response) {
                id_user_seleccionado = "";
                $("#md_delete_user").modal("hide");
                show_list_user_1();
            } else {
                console.log("error");
            }
        },
    });
}
