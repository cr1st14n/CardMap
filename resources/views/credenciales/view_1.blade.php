<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Registro de credenciales</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-lg-3" style="text-align: rigth ;">
                            <div class="input-group mb-2 mr-sm-4">
                                <div class="input-group-prepend ">
                                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                                </div>
                                <input type="text" class="form-control" onkeyup="input_busqueda_creden(this.value)"
                                    placeholder="Buscar por NOMBRE o CI">
                            </div>
                        </div>
                        <div class="col-lg-7">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" id="btn_creden_add_item" class="btn btn-primary mb-2 btn-block"><i
                                    class="fa fa-plus-circle"></i> Agregar </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive" style="min-height:250px ;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>C.I.</th>
                                    <th>Empresa</th>
                                    <th>Vencimiento</th>
                                    <th>Imagen</th>
                                    <th width='5%'># Re.</th>
                                    <th width='5%'>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="view_1_body_1">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="md_add_credencial" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Nuevo Credencial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="form_new_creden">@csrf
                        <div class="form-group row ">
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="form-control form-bg-danger" name="nc_tipo">
                                        <option value="L">Local</option>
                                        <option value="T">Temporal</option>
                                        <option value="N"><strong class=" text-danger">Nacional</strong> </option>
                                    </select>
                                    <b>Tipo de Credencial</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="form-control form-bg-primary" name="nc_aeropuerto">
                                        <option value="LPB">EL ALTO</option>
                                        <option value="CIJ">CAP. AV. ANIBAL ARAB FADUL</option>
                                    </select>
                                    <b>Aeropuerto </b>
                                </div>
                            </div>
                            <div class=" col-sm-6"></div>
                            <div class="col-sm-3">
                                <div class="form-group  small ">
                                    <input type="text" class="form-control form-control-sm " name="nc_ci" required
                                        maxlength="14" placeholder="######## EXPEDIDO">
                                    <b style="text-transform: upercase ;">Carnet de Indentidad <strong
                                            class=" text-danger">*</strong> </b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_nom" required>
                                    <b>Nombre <strong class=" text-danger">*</strong> </b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_pa">
                                    <b>Ap. Paterno <strong class=" text-danger">*</strong> </b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_ma">
                                    <b>Ap. Materno</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="form-control" id="" name="nc_em">
                                        @foreach ($Empr as $e)
                                            @if ($e->Empresa == 'NABL')
                                                <option selected value="{{ $e->Empresa }}">{{ $e->NombEmpresa }}
                                                </option>
                                            @else
                                                <option value="{{ $e->Empresa }}">{{ $e->NombEmpresa }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <b>Empresa</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_car">
                                    <b>Cargo</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_codt">
                                    <b>Codigo de Tarjeta</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_codMy">
                                    <b>Codigo MYFARE</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_he">
                                    <b>Herramientas</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_areas_acceso"
                                        pattern="[0-9_-]{8}" maxlength="8" required
                                        placeholder="#-#-##-#, 8 simbolos">
                                    <b>Areas Autorizadas</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_gs">
                                    <b>Grupo Sanguineo</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="nc_fv">
                                    <b>Fecha de Vencimiento</b>
                                </div>
                            </div>
                            {{-- <div class="col-sm-3">
                                <div class="form-group">
                                    <select class="form-control" name="" id="" name="nc_acci">
                                        <option value="C">Dar de Alta</option>
                                        <option value="S">Credencial Extraviada</option>
                                        <option value="V">Credencial Robada</option>
                                        <option value="D">Dar de Baja</option>
                                        <option value="U">Tramite no Concluido</option>
                                    </select>
                                    <b>Acciones</b>
                                </div>
                            </div> --}}
                            <br>
                            <h5 class=" col-sm-12">Permiso de Coduccion en tierra</h5>
                            <div class="col-sm-12 row">
                                <div class="col-sm-3">
                                    <div class="form-group small">
                                        <select class="form-control" name="nc_t_licencia" id="nc_t_licencia">
                                            <option value="">Ninguna</option>
                                            <option value="P">Particular P</option>
                                            <option value="A">Profecional A</option>
                                            <option value="B">Profecional B</option>
                                            <option value="C">Profecional C</option>
                                        </select>
                                        <b>Tipo de licencia</b>
                                    </div>
                                </div>
                                <div class="col-sm-9" id="option_tipo_lic_veh">

                                </div>
                                <div class=" col-sm-3 form-group">
                                    <input type="text" class=" form-control form-control-sm" name="nc_AreasCp"
                                        id="nc_AreasCp" id="nc_AreasCp" placeholder="-#-#--#-" pattern="[0-9_-]{8}"
                                        maxlength="8">
                                    <b>Areas Autorizadas</b>
                                </div>
                            </div>
                            <h5 class="col-sm-12">Información Adicional</h5>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="date" class="form-control" name="nc_f_in">
                                    <b>Fecha de Igreso</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="date" class="form-control" name="nc_FNac">
                                    <b>Fecha de Nacimiento</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="form-control" name="nc_estCiv">
                                        <option value="C">Casado</option>
                                        <option value="S">Soltero</option>
                                        <option value="V">Viudo</option>
                                        <option value="D">Divorsiado</option>
                                        <option value="U">Union Libre</option>
                                    </select>
                                    <b>Estado Civil</b>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="form-control" name="nc_sexo">
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <b>Sexo</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_pro">
                                    <b>Profesion</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="number" class="form-control" name="nc_est">
                                    <b>Estatura CM</b>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_colojo">
                                    <b>Color de ojos</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="nc_maCorp">
                                    <b>Masa Corporal</b>
                                </div>
                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>Detalle Domicilio</b>
                                    <input type="number" class="form-control" name="nc_Fono" placeholder="Telf...">
                                    <input type="text" class="form-control" name="nc_10"
                                        placeholder="Dirección">

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>Detalle Trbajo</b>
                                    <input type="number" class="form-control" name="nc_11" placeholder="Telf...">
                                    <input type="text" class="form-control" name="nc_12"
                                        placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="text" class="form-control" name="nc_13">
                                <b>Observaciones</b>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select_update {
            background: transparent;
            border-color: black;
            border: 1px solid #d9d9d9;
            font-size: 14px;
            height: 30px;
            padding: 5px;
            color: white;
            width: 100%;

        }
    </style>
    <div class="modal fade" id="md_update_credencial" tabindex="-1" role="dialog"
        aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h5 class="modal-title" style="color: white" id="demoModalLabel">Actualizar informacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="form_update_creden"
                        onsubmit="event.preventDefault();update_creden()">@csrf
                        <div class="form-group row ">
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <select class="select_update" name="nc_tipo_edit" id="nc_tipo_edit"
                                        style="background-color: blue">
                                        <option value="L">Local</option>
                                        <option value="T">Temporal</option>
                                        <option value="N"><strong class=" text-danger">Nacional</strong>
                                        </option>
                                    </select>
                                    <b>Tipo de Credencial</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <select class="select_update" style="background-color: red"
                                        name="nc_aeropuerto_edit" id="nc_aeropuerto_edit">
                                        <option value="LPB">EL ALTO</option>
                                        <option value="CIJ">CAP. AV. ANIBAL ARAB FADUL</option>
                                    </select>
                                    <b>Aeropuerto </b>
                                </div>
                            </div>
                            <div class=" col-sm-6"></div>
                            <div class="col-sm-3">
                                <div class="form-group  small ">
                                    <input type="text" class="form-control form-control-sm " name="nc_ci_edit"
                                        required maxlength="14" placeholder="######## EXPEDIDO">
                                    <b style="text-transform: upercase ;">Carnet de Indentidad <strong
                                            class=" text-danger">*</strong> </b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_nom_edit" required>
                                    <b>Nombre <strong class=" text-danger">*</strong> </b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_pa_edit">
                                    <b>Ap. Paterno <strong class=" text-danger">*</strong> </b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_ma_edit">
                                    <b>Ap. Materno</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="  select_update" style="color: black" id="nc_em_edit_id"
                                        name="nc_em_edit">
                                        @foreach ($Empr as $e)
                                            <option value="{{ $e->Empresa }}">
                                                {{ $e->NombEmpresa }}</option>
                                        @endforeach
                                    </select>
                                    <b>Empresa</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_car_edit">
                                    <b>Cargo</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_codt_edit">
                                    <b>Codigo de Tarjeta</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_codMy_edit">
                                    <b>Codigo MYFARE</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_he_edit">
                                    <b>Herramientas</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_areas_acceso_edit"
                                        pattern="[0-9_-]{8}" maxlength="8" required
                                        placeholder="#-#-##-#, 8 simbolos">
                                    <b>Areas Autorizadas</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_gs_edit">
                                    <b>Grupo Sanguineo</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="nc_fv_edit">
                                    <b>Fecha de Vencimiento</b>
                                </div>
                            </div>
                            {{-- <div class="col-sm-3">
                                <div class="form-group">
                                    <select name="" id="nc_acci_edit" name="nc_acci_edit" >
                                        <option value="C">Dar de Alta</option>
                                        <option value="S">Credencial Extraviada</option>
                                        <option value="V">Credencial Robada</option>
                                        <option value="D">Dar de Baja</option>
                                        <option value="U">Tramite no Concluido</option>
                                    </select>
                                    <b>Acciones</b>
                                </div>
                            </div> --}}
                            <h5 class=" col-sm-12">Permiso de Coduccion en tierra</h5>

                            <div class="col-sm-12 row">
                                <div class="col-sm-3">
                                    <div class="form-group small">
                                        <select class="select_update" style="background-color:darkslategrey"
                                            name="nc_t_licencia_edit" id="nc_t_licencia_edit">
                                            <option value="">Ninguna</option>
                                            <option value="P">Particular P</option>
                                            <option value="A">Profecional A</option>
                                            <option value="B">Profecional B</option>
                                            <option value="C">Profecional C</option>
                                        </select>
                                        <b>Tipo de licencia</b>
                                    </div>
                                </div>
                                <div class="col-sm-9" id="option_tipo_lic_veh_edit">

                                </div>
                                <div class=" col-sm-3 form-group">
                                    <input type="text" class=" form-control form-control-sm"
                                        name="nc_AreasCp_edit" id="nc_AreasCp_edit" placeholder="-#-#--#-"
                                        pattern="[0-9_-]{8}" maxlength="8">
                                    <b>Areas Autorizadas</b>
                                </div>
                            </div>
                            <h5 class="col-sm-12">Información Adicional</h5>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="date" class="form-control" name="nc_f_in_edit">
                                    <b>Fecha de Igreso</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="date" class="form-control" name="nc_FNac_edit">
                                    <b>Fecha de Nacimiento</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <select class="" name="nc_estCiv_edit" id="nc_estCiv_edit"
                                        style="background: transparent;
                                        border-color:black;
                                        border:1px solid #d9d9d9;
                                    font-size: 14px;
                                    height: 30px;
                                    padding: 5px;
                                    width: 100%;">
                                        <option value="C">Casado</option>
                                        <option value="S">Soltero</option>
                                        <option value="V">Viudo</option>
                                        <option value="D">Divorsiado</option>
                                        <option value="U">Union Libre</option>
                                    </select>
                                    <b>Estado Civil</b>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <select class="select_update" style="background-color: gray" name="nc_sexo_edit"
                                        id="nc_sexo_edit">
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <b>Sexo</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="nc_pro_edit">
                                    <b>Profesion</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group small">
                                    <input type="number" class="form-control" name="nc_est_edit">
                                    <b>Estatura CM</b>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nc_colojo_edit">
                                    <b>Color de ojos</b>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="nc_maCorp_edit">
                                    <b>Masa Corporal</b>
                                </div>
                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>Detalle Domicilio</b>
                                    <input type="number" class="form-control" name="nc_Fono_edit"
                                        placeholder="Telf...">
                                    <input type="text" class="form-control" name="nc_10_edit"
                                        placeholder="Dirección">

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>Detalle Trbajo</b>
                                    <input type="number" class="form-control" name="nc_11_edit"
                                        placeholder="Telf...">
                                    <input type="text" class="form-control" name="nc_12_edit"
                                        placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="text" class="form-control" name="nc_13_edit">
                                <b>Observaciones</b>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->
    <div class="modal fade" id="md_add_photo" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Cargar imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="panel-body" id="myId" style="padding: 0;">
                        <form id="subImagen" class="dropzone">
                            <input type="text" id="textRX1" name="rxfactura" hidden>
                            <input type="text" id="textRX2" name="rxmedicoTratante" hidden>
                            <input type="text" id="textRX3" name="rxDescImagen" hidden>
                            <div class="fallback" id="2121">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="md_show_credencial" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <embed src="" type="" id="emb_sec_pdf_creden" width="1000" height="800">
            </div>
        </div>
    </div>
    <!-- modal para delete item -->
    <div class="modal fade" id="md_show_deleteConfirm" tabindex="-1" role="dialog"
        aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <p>Confrimar peticion!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="destroy_credencial()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmar renovacion credencial -->
    <div class="modal fade" id="mod_conf_renovacion" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h5 id="text_creden_vigent"> <strong></strong></h5>
                    <hr>
                    <div class="row">
                        <p>Historial de renovaciones.</p>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
                                        <th>Codigo de Tarjeta</th>
                                    </tr>
                                </thead>
                                <tbody id="table_renov_creden_emp">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Formulario de renovacion de credencial</h5>
                    <form id="form_ren_cred">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Motivo</label>
                                    <select class="form-control" id="ren_cred_tipo" name="ren_cred_motivo">
                                        <option value="1">Plataforma</option>
                                        <option value="2">Condución</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleSelectGender">Motivo</label>
                                    <select class="form-control" id="ren_cred_motivo" name="ren_cred_motivo">
                                        <option value="Extravio">Extravio</option>
                                        <option value="Deteriorado">Deteriorado</option>
                                        <option value="Caducado">Caducado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Codigo de nuevo credencial</label>
                                    <input type="number" class="form-control" id="ren_cred_codigo"
                                        name="ren_cred_codigo" placeholder="###">
                                </div>
                            </div>
                        </div>
                        <p>Nota: Una vez confirmado, la renovación estara registrada dentro la base de datos y sera
                            expresada en el futuro credencial con la letra <strong>"D"</strong></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="fun_renovar_creden(0,3)" class="btn btn-secondary"
                        data-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="fun_renovar_creden(0,2)" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('resources/js/credenciales.js') }}"></script>
