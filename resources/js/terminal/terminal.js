data_terminal = () =>
    $.get("terminal/query_list_1", function (data, textStatus, jqXHR) {
        return (data_terminal = data);
    });

createTerm = (id) => {
  console.log($('#form_new_terminal').serialize());
    $.ajax({
        type: "post",
        url: "terminal/query_create_1",
        data: $('#form_new_terminal').serialize(),
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
