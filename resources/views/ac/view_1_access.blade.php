<div class="row">


    <div class=" col-md-6 col-sm-12 ">
        <div class="card table-card  border-top border-bottom  border-danger ">
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
                            <div class=" d-flex fl p-2 justify-content-between">
                                <div class=" border-top border-bottom border-danger">
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
                    <form class="form-inline">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search"></i></div>
                            </div>
                            <select id="areaSelect" class=" form-control">
                                <option value="1">1: PISTA Y CALLES DE RODAJE</option>
                                <option value="2">2: PLATAFORMA</option>
                                <option value="3">3: OFICINAS ADMINISTRATIVAS</option>
                                <option value="4">4: BLOQUE TECNICO</option>
                                <option value="5">5: LLEGADAS INT. | NAC. </option>
                                <option value="6">6: PREHENBARQUES INT. | NAC.</option>
                                <option value="7">7: AVIACION GENERAL</option>
                                <option value="8">8: CARGA Y CORREO</option>
                            </select>
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
<script src="http://localhost:3000/socket.io/socket.io.js"></script>

<script>
    socket = io.connect('http://localhost:3000');

    socket.on('lectura:lec_tarjeta', (data) => {
        if ($('#areaSelect').val() === data.area) {
            console.log('Mensaje recibido desde el servidor:', data);
            cardAccess(data.estAccess, data.data)
            table_access_1(data.data)
        }
    });
    socket.emit('chat:message', 'Modulo App escritorio.');
</script>
<script>
    cardAccess = (est, d) => {
        $('#access_image_1').attr('src', d.urlphoto);
        segm_1 = (est) ? ' <h1 class=" text-success ">Acceso: <strong>PERMITIDO</strong></h1>' :
            ' <h1 class=" text-danger ">Acceso: <strong>DENEGADO</strong></h1>';
        $('#estAccess_F1').html(segm_1);
        segm_2 = `
        <strong>${d.Nombre} ${d.Paterno} ${d.Materno}</strong> <br>
        <strong>COD: ${d.Codigo}</strong> <br>
        C.I.: <strong> ${d.CI}</strong> <br>
        Empresa: <br> <strong class=" text-bold"> ${d.Empresa}</strong> <br>
        `
        $('#estAccess_F2').html(segm_2);
    }

    table_access_1 = (data) => {
        fila_a = `
            <tr id="f_001_">
                <td>${data.Codigo}</td>
                <td>
                    <img src="${data.urlphoto}" alt="" width="50px" height="70px">
                </td>
                <td>${data.Nombre}</td>
                <td>${data.Empresa}</td>
                <td></td>
                <td></td>
            </tr>
            `
        $('#table_acces_1').html(fila_a)
    }
</script>
