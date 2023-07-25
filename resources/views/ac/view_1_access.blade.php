<div class="row">


    <div class=" col-md-4 col-sm-12 ">
        <div class="card table-card  border-top border-bottom  border-danger ">
            <div class="card-block d-flex justify-content-center ">
                <div class=" d-flex">
                    <div class=" p-1 d-flex justify-content-center">
                        <img src="public/storage/imagenes/0A1BwJn8r18lVNbXwV8WqkGDOHf0ZlAJxeh2gdKk.jpg"
                            style="width: 100%;" style="height: 100%" alt="">
                    </div>
                    <div class="d-flex flex-column p-2">
                        <div class=" border-bottom border-danger">
                            <h1 class=" text-danger ">Acceso: <strong>DENEGADO</strong></h1>
                        </div>

                        <div class=" border-danger">
                            <h4 class=" p-2">
                                <strong>NOMBRE</strong> <br>
                                <strong>COD: #######</strong> <br>
                                C.I.: <strong> ##########</strong> <br>
                                Empresa: <br> <strong class=" text-bold"> Empresa</strong> <br>
                            </h4>
                            Areas Permitidas:
                            <div class=" d-flex fl p-2 justify-content-between">
                                <div class=" border-top border-bottom border-danger">
                                    <p class=" text-break" style="font-size: 20px">
                                        <strong> 1 : area</strong> <br>
                                        <strong> 2 : area</strong> <br>
                                        <strong> 3 : area</strong> <br>
                                        <strong> 4 : area</strong>
                                    </p>
                                </div>
                                <div class=" border-top border-bottom border-danger">
                                    <p class=" text-break" style="font-size: 20px">
                                        <strong> 1 : area</strong> <br>
                                        <strong> 2 : area</strong> <br>
                                        <strong> 3 : area</strong> <br>
                                        <strong> 4 : area</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-md-8 col-sm-12 ">
        <div class="card table-card">
            <div class="card-header">
                <div class="card-header-letf">
                    <form class="form-inline">
                        <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search"></i></div>
                            </div>
                            <input type="text" class="form-control" id="inp_busc_codTja_1" placeholder="##########">
                        </div>
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
</div>
<script>
    $('#inp_busc_codTja_1').keyup(function(e) {
        if (e.key === "Enter") {
            busc_cod_access();
            $('#inp_busc_codTja_1').val('')
        }
    });
    async function busc_cod_access() {
        area = $('#areaSelect').val();
        numero = $('#inp_busc_codTja_1').val()
        query = await fetch('accesControl/query_accesso_1/' + numero )
        response = await query.json()
        table_access_1(response.data)
        console.log(response);
    }

    table_access_1 = (data) => {
        // if (!Array.isArray(data)) {
        //     console.error("El objeto 'data' no es un array.");
        //     return;
        // }
        fila_a = `
            <tr id="f_001_">
                <td>${data.Codigo}</td>
                <td>${data.urlphoto}</td>
                <td>${data.Nombre}</td>
                <td>${data.Empresa}</td>
                <td></td>
                <td></td>
            </tr>
            `

        $('#table_acces_1').html(fila_a)
    }
</script>
