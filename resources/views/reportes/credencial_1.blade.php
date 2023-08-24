<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header d-block">
                <h3>Reporte Credenciales</h3>
            </div>
            <div class="card-body">
                <div class=" forms-sample">
                    <div class=" row" style="display: none">
                        <div class=" col-sm-12 col-md-6 col-lg-6 form-group">
                            <label for="">Tipo</label>
                            <select name="" id="inp_select_tipo_1" class=" form-control form-control-danger">
                                <option value="">Seleccionar tipo reporte</option>
                                <option value="empres">Empresa</option>
                                <option value="empleado">Empleado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="reportEmpresa">
                        <div class=" col-sm-12 col-md-6 col-lg-6 ">
                            <label for="">Seleccione Empresa</label>
                            <div class="input-group input-group-button">
                                <select name="" id="inp_emp_1" class=" form-control">
                                    <option value="todos">Todas las empresas</option>
                                    @foreach ($empresas as $emp)
                                        <option value="{{ $emp->Empresa }}">{{ $emp->NombEmpresa }} | T.E.:
                                            {{ $emp->total }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button id="btn_empresas_filtrar_1" class="btn btn-primary"
                                        type="button">Procesar</button>
                                </div>
                            </div>
                            <p class=" text-body">
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class=" col-sm-12 col-md-6">
        <div class=" card">
            <div class=" card-body">
                <div class="dt-responsive">
                    <table id="" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Aeropuerto</th>
                                <th>Cod</th>
                                <th>Empresa</th>
                                <th>Empleados registrados</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_empresaEmpleado">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
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
    $('#btn_empresas_filtrar_1').click(async function(e) {
        e.preventDefault();
        campo_1 = $('#inp_emp_1').val();

        if (campo_1 == 'todos') {
            try {
                api_query = await fetch('api/reporte/empresas_t_1')
                response = await api_query.json();
            } catch (error) {
                console.log('ERROR' + error);
            }
            console.log(response);
            $('#tbody_empresaEmpleado').html(make_row_empresas(response.total_empresas_empleado));
        } else {


            try {
                api_query = await fetch('api/reporte/empresas_t_2?cod=' + campo_1)
                response = await api_query.json()
            } catch (error) {
                console.log('ERROR' + error);

            }
            $('#tbody_empresaEmpleado').html('');
            $('#tbody_empresaEmpleado').html(make_row_empresas(response.total_empresas_empleado));
        }




    });

    function make_row_empresas(data) {
        return data.map((e) => {
            return `
            <tr>
                <td>${e.Aeropuerto_2}</td>
                <td>${e.Empresa}</td>
                <td>${e.NombEmpresa ??'-'}</td>
                <td>${e.total}</td>
            </tr> 
            `
        }).join(' ')
    }



    $('#inp_select_tipo_1').change(function(e) {
        e.preventDefault();
        console.log($(this).val());
    });






    $(document).ready(function() {
        $('#tabla_1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'colvis',
                'excel',
                'print'
            ]
        });
    });
</script>
