<div class="row">


    <div class=" col-md-6 col-sm-12 ">

        <div class="card table-card  border-top border-bottom  border-danger ">
            <div class="card-header">
                <div class="input-group ">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <select id="areaSelect" class=" form-control">
                        @foreach ($puertas as $p)
                            <option value="{{ $p->p_ipCod }}">{{ $p->p_ipCod }} | {{ $p->p_nombre }} |
                                Areas Permididas: {{ $p->p_areas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-block d-flex justify-content-center ">
                <div class=" d-flex">
                    <div class=" p-1 d-flex justify-content-center">
                        <img id="access_image_1" src="public/storage/imagenes/USER.jpg" style="width: 100%;"
                            style="height: 70%" alt="">
                    </div>
                    <div class="d-flex flex-column p-2">
                        <div class=" border-bottom border-danger" id="estAccess_F1">
                            <h1 class=" text-danger ">Acceso: <strong>DENEGADO</strong></h1>
                        </div>

                        <div class=" border-danger">
                            <h4 class=" p-2" id="estAccess_F2">
                                <strong>NOMBRE</strong> <br>
                                <strong>COD: #######</strong> <br>
                                C.I.: <strong> ##########</strong> <br>
                                Empresa: <br> <strong class=" text-bold"> Empresa</strong> <br>
                            </h4>
                            Areas Permitidas:
                            <div class=" d-flex fl p-2 justify-content-between" id="sec_area_accesos">
                                <div class=" border-top border-bottom border-danger " >
                                    <p class=" text-break" style="font-size: 10px">
                                        <strong> 1 : PISTA Y CALLES DE RODAJE</strong> <br>
                                        <strong> 2 : PLATAFORMA</strong> <br>
                                        <strong> 3 : OFICINAS ADMINISTRATIVAS</strong> <br>
                                        <strong> 4 : BLOQUE TECNICO</strong><br>
                                    </p>
                                </div>
                                <div class=" border-top border-bottom border-danger">
                                    <p class=" text-break" style="font-size: 10px">
                                        <strong> 5 : LLEGADAS INT. | NAC. </strong><br>
                                        <strong> 6 : PREHENBARQUES INT. | NAC.</strong> <br>
                                        <strong> 7 : AVIACION GENERAL</strong> <br>
                                        <strong> 8 : CARGA Y CORREO</strong> <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-md-6 col-sm-12 ">
        <div class="card table-card">
            <div class="card-header">
                <div class="card-header-letf">
                    <h2>Estado Conexión al</h2>
                </div>
                <div class=" card-header-right">
                    <form class=" d-flex flex-col-reverse">
                        <div class=" input-group mb-2 mr-sm-2">
                            <div class=" align-items-end badge-aqua rounded rounded-circle p-2 bg-warning"
                                id="log_est_connect">
                                <i class=" fa fa-check-circle fa-3x"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 without-header">
                        <thead>
                            <tr>
                                <th>COD TARJETA</th>
                                <th>FOTO</th>
                                <th>NOMBRE</th>
                                <th>EMPRESA</th>
                                <th>ESTADO</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody id="table_acces_1">
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <img src="" alt="">
</div>
<script src="http://sare.naabol.gob.bo:3009/socket.io/socket.io.js"></script>

<script>
    socket = io.connect('http://sare.naabol.gob.bo:3009');
    socket.on('connect', () => {
        checkSocketStatus()
    });
    socket.on('disconnect', () => {
        checkSocketStatus()
    });
    socket.on('connect_error', (error) => {
        console.error('Error de conexión al servidor Socket.IO:', error.message);
    });
    socket.on('lectura:lec_tarjeta', (data) => {
        if ($('#areaSelect').val() === data.area) {
            console.log('Mensaje recibido desde el servidor:', data);
            cardAccess(data.estAccess, data.data)
            table_access(data.mar)
        }
        if (data.status == 'NOK') {
            console.log('tarjeta no asociada!');
            $('#estAccess_F1').html(
                ' <h1 class=" text-danger ">TARJETA: <strong>NO ASOCIADA A EMPLEADO</strong></h1>');
            $('#estAccess_F2').html('');
            $('#access_image_1').attr('src', 'public/storage/imagenes/USER.jpg');
        }
    });
    socket.emit('chat:message', 'Modulo - Visualizador conectado.');
</script>
<script>
    checkSocketStatus = () => {
        console.log('Estado de Conexion: ',
            socket.connected);
        if (socket.connected) {
            $('#log_est_connect').removeClass('bg-warning');
            $('#log_est_connect').addClass('bg-success');
        } else {
            $('#log_est_connect').removeClass('bg-success');
            $('#log_est_connect').addClass('bg-warning');
        }
    }
    cardAccess = (est, d) => {
        // Carga de Imagen
        $('#access_image_1').attr('src', d.urlphoto);

        // CARGA ESTADO DE ACCESO
        segm_1 = (est === 1) ? ' <h1 class=" text-success ">Acceso: <strong>PERMITIDO</strong></h1>' :
            ' <h1 class=" text-danger ">Acceso: <strong>DENEGADO</strong></h1>';
        $('#estAccess_F1').html(segm_1);

        // CARGA DATOS DEL PERSONAL
        segm_2 = `
        <strong>${d.Nombre} ${d.Paterno} ${d.Materno}</strong> <br>
        <strong>COD: ${d.Codigo}</strong> <br>
        C.I.: <strong> ${d.CI}</strong> <br>
        Empresa: <br> <strong class=" text-bold"> ${d.Empresa}</strong> <br>
        `
        $('#estAccess_F2').html(segm_2);

        // CARGA AREAS DE ACCESO
        const areas = {
            '1': 'Pista y Calles de Rodaje',
            '2': 'Plataforma',
            '3': 'Oficinas Administrativas',
            '4': 'Bloque tecnico',
            '5': 'Llegadas Int. / Nac.',
            '6': 'Prehenbarques Int. / Nac.',
            '7': 'Aviacion General',
            '8': 'Carga y Correo',
            '9': '-----------------------------------',
        }

        const cadena = d.AreasAut;
        const sinGuiones = cadena.replace(/-/g, '');
        const arrayAreas = sinGuiones.split('');

        const htmlArray = `
        <div class=" border-top border-bottom border-danger">
            <p class=" text-break" style="font-size: 10px">
                <strong>${(arrayAreas.includes('1'))? " 1 : PISTA Y CALLES DE RODAJE" : areas['9'] } </strong> <br>
                <strong>${(arrayAreas.includes('2'))? " 2 : PLATAFORMA" : areas['9'] }</strong> <br>
                <strong>${(arrayAreas.includes('3'))? " 3 : OFICINAS ADMINISTRATIVAS" : areas['9'] }</strong> <br>
                <strong>${(arrayAreas.includes('4'))? " 4 : BLOQUE TECNICO" : areas['9'] }</strong><br>
            </p>
        </div>
        <div class=" border-top border-bottom border-danger">
            <p class=" text-break" style="font-size: 10px">
                <strong>${(arrayAreas.includes('5'))? " 5 : LLEGADAS INT. | NAC. " : areas['9'] }</strong><br>
                <strong>${(arrayAreas.includes('6'))? " 6 : PREHENBARQUES INT. | NAC." : areas['9'] }</strong> <br>
                <strong>${(arrayAreas.includes('7'))? " 7 : AVIACION GENERAL" : areas['9'] }</strong> <br>
                <strong>${(arrayAreas.includes('8'))? " 8 : CARGA Y CORREO" : areas['9'] }</strong> <br>
            </p>
        </div>
        `
        $('#sec_area_accesos').html(htmlArray);


    }
    table_access = (data) => {
        html = data.map((e, i) => {
            return table_access_1(e)
        }).join(' ')
        $('#table_acces_1').html(html)
    }
    table_access_1 = (data) => {
        est = (data.ac_estadoAcceso === "1") ? `Permitido` : `Denegado`;
        return fila_a = `
            <tr id="f_001_">
                <td>${data.Codigo}</td>
                <td>
                    <img src="${data.urlphoto}" alt="" width="50px" height="70px">
                </td>
                <td>${data.Nombre}</td>
                <td>${data.Empresa}</td>
                <td>${est} </td>
                <td>${data.created_at}</td>
            </tr>`
    }
</script>