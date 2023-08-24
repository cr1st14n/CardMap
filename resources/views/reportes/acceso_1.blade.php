<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header d-block">
                <h3>Reporte Credenciales</h3>
            </div>
            <div class="card-body">
                <div class=" forms-sample">
                    <div class=" row">
                        <div class=" col-sm-12 col-md-6 col-lg-6 form-group">
                            <label for="">Tipo</label>
                            <select name="" id="inp_select_tipo_2" class=" form-control form-control-danger">
                                <option value="">Seleccionar tipo reporte</option>
                                <option value="A">ACCESO</option>
                                <option value="E">EMPLEADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="reportView_Acceso_A" style="display: none">
                        <div class=" col-12 input-group input-group-sm">
                            <label for="" class=" input-group-text input-sm"> Rango de Fechas </label>
                            <input type="date" class=" form-control " placeholder=" " id="acc_fecha_1">
                            <input type="date" class=" form-control " placeholder=" " id="acc_fecha_2">
                        </div>
                        <div class="col-12 dt-responsive">
                            <table id="" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>AEROPUETO</th>
                                        <th>COD</th>
                                        <th>DETALLE</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_empresaEmpleado">
                                    @foreach ($Acceso as $ac)
                                        <tr>
                                            <td>{{ $ac->p_aeroIata }}</td>
                                            <td>{{ $ac->p_ipCod }}</td>
                                            <td>{{ $ac->p_nombre }}</td>
                                            <td style="align-items: center"><button class="btn btn-facebook"
                                                    onclick="listAccesoPuerta('{{ $ac->id }}')"> <i
                                                        class=" fa fa-search"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" id="reportView_Acceso_E" style="display: none">
                        <form id="frm_searchPersonal">
                            <div class=" col-12 input-group">
                                <label for="" class=" input-group-text"> Buscar Personal </label>
                                <input type="text" id="inp_textoDatosEmpleado" required class=" form-control col-10"
                                    placeholder="NOMBRE APELLIDO  ">
                                <button type="submit" class=" btn-danger col-1"><i
                                        class=" fa fa-search fa-1x"></i></button>
                            </div>
                        </form>
                        <div class=" col-12 input-group input-group-sm">
                            <label for="" class=" input-group-text input-sm"> Rango de Fechas </label>
                            <input type="date" class=" form-control " placeholder=" " id="fecha_1">
                            <input type="date" class=" form-control " placeholder=" " id="fecha_2">
                        </div>
                        <div class="col-12 dt-responsive">
                            <table id="" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Regional</th>
                                        <th>Nombre</th>
                                        <th>Cod. TIA</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_list_11">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-sm-12 col-md-6">
        <div class=" card">
            <div class=" card-body">
                <style>
                    #table-container {
                        max-height: calc(90vh - 90px);
                        /* Ajusta la altura según tus necesidades */
                        overflow-y: auto;
                    }
                </style>
                <div class="dt-responsive" id="table-container">
                    <table class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Fecha</th>
                                <th>Acceso</th>
                                <th>Cod TIA.</th>
                                <th>Empleado</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_list_1">
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    console.clear()
    $('#inp_select_tipo_2').change(function(e) {
        e.preventDefault();
        console.log($(this).val());
        if ($(this).val() === 'A') {
            document.getElementById('reportView_Acceso_A').style.display = 'block';
            document.getElementById('reportView_Acceso_E').style.display = 'none';
        }
        if ($(this).val() === 'E') {
            document.getElementById('reportView_Acceso_A').style.display = 'none';
            document.getElementById('reportView_Acceso_E').style.display = 'block';
        }
    });

    async function listAccesoPuerta(id) {
        acc_fecha_1 = $('#acc_fecha_1').val();
        acc_fecha_2 = $('#acc_fecha_2').val();
        if (!isNaN(Date.parse(acc_fecha_1)) && !isNaN(Date.parse(acc_fecha_2))) {
            try {
                url = `api/reporte/listAccesos_1?fecha1=${acc_fecha_1}&fecha2=${acc_fecha_2}&id=${id}`
                api_query = await fetch(url)
                api_response = await api_query.json();
                console.log('aca esta');
                html = api_response.data.map((e) => {
                   return makeArr_listAccesoPuetas(e)
                }).join(' ')
                $('#tbody_list_1').html(html);
            } catch (error) {
                noti_fi(4, 'ERROR')
            }
        } else {
            noti_fi(3, 'Verificar formato, FECHA')
        }
    }

    function makeArr_listAccesoPuetas(e) {
        return `
        <tr>
            <td>${e.created_at}</td>
            <td>${e.id_puntoAcceso}</td>
            <td>${e.id_empleado}</td>
            <td>${e.id_empleado}</td>
        </tr>
        `
    }



    $('#frm_searchPersonal').submit(async function(e) {
        e.preventDefault();
        text = $('#inp_textoDatosEmpleado').val();
        api_query = await fetch('api/empleado/search_1?nombre_apellido=' + text + '')
        api_response = await api_query.json()
        console.log(api_response);
        $('#tbody_list_11').html(makeArr(api_response.data));
    });

    function makeArr(data) {
        return data.map((e) => {
            return `
            <tr>
                <td>${e.Aeropuerto_2} </td>
                <td>${e.Nombre} ${e.Paterno} ${e.Materno}</td>
                <td>${e.Codigo}</td>
                <td><button class="btn btn-danger" onClick="showListAccesosEmpleado(${e.idEmpleado})"><i class="fa fa-search"></i></button></td>
            </tr>
                `
        }).join(' ')
    }

    async function showListAccesosEmpleado(id) {
        fecha_1 = $('#fecha_1').val();
        fecha_2 = $('#fecha_2').val();

        isValidFecha_1 = !isNaN(Date.parse(fecha_1));
        isValidFecha_2 = !isNaN(Date.parse(fecha_2));

        if (isValidFecha_1 && isValidFecha_2) {
            try {
                url =
                    `api/reporte/empleadoMarcaciones?codUsu=${id}&fecha_1=${encodeURIComponent(fecha_1)}&fecha_2=${encodeURIComponent(fecha_2)}`;
                response = await fetch(url);
                data = await response.json();
                console.log(data);
                $('#tbody_list_1').html(makeArrListAccesUser(data));
            } catch (error) {
                console.error('Error:', error);
            }
        } else {}
    }

    function makeArrListAccesUser(data) {
        return data.map((e) => {
            return `
            <tr>
                <td>CM:${e.id}</td>
                <td>${e.created_at}</td>
                <td>${e.p_aeroIata} - ${e.p_nombre}</td>
                <td>${e.Codigo}</td>
                <td>${e.Nombre} ${e.Paterno} ${e.Materno}</td>
            </tr>
            `
        }).join()
    }
</script>
