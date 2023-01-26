<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Registro de credenciales Visita</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-lg-3" style="text-align: rigth ;">
                            <!-- <div class="input-group mb-2 mr-sm-4">
                                <div class="input-group-prepend ">
                                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                                </div>
                                <input type="text" class="form-control" onkeyup="input_busqueda_creden(this.value)" placeholder="Buscar por NOMBRE o CI">
                            </div> -->
                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3">
                            <button type="button" onclick="query_list_credenVis()" class="btn btn-purple mb-2 btn-block"><i
                                    class="fa fa-line "></i> Listar </button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" id="btn_credenCV_add_item" class="btn btn-primary mb-2 btn-block"><i
                                    class="fa fa-plus-circle"></i> Agregar </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive" style="min-height:250px;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Cod A</th>
                                    <th>Cod B</th>
                                    <th>Areas</th>
                                    <th>Fecha Limite</th>
                                    <th width='5%'>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="view_1_body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="md_add_credenVis" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Nuevo Credencial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="form_new_creden_visita">@csrf
                        <div class="form-group row ">
                            <div class="col-sm-6">
                                <div class="form-group small">
                                    <select class="form-control form-bg-primary" name="ncv_aeropuerto">
                                        @foreach ($emps as $ter)
                                            <option value="{{ $ter->ta_sigla }}">{{ $ter->ta_sigla }} |
                                                {{ $ter->ta_nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <b>Aeropuerto </b>
                                </div>
                            </div>
                            <div class=" col-sm-6"></div>
                            <div class="col-sm-6">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="ncv_codt" required>
                                    <b>Codigo de Tarjeta</b>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group small">
                                    <input type="text" class="form-control" name="ncv_codMy">
                                    <b>Codigo MYFARE</b>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ncv_areas_acceso"
                                        pattern="[0-9_-]{8}" maxlength="8" required placeholder="#-#-##-#, 8 simbolos">
                                    <b>Areas Autorizadas</b>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="ncv_fechaLimite" required>
                                    <b>Fecha de expiración</b>
                                </div>
                            </div>
                            <div class="modal-footer col-sm-12">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="md_update_credencial" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Nuevo Credencial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="form_update_creden">@csrf
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Tipo de credencial</span>
                                    <select class="form-control" name="nc_tipo_edit">
                                        <option value="N">Nacional</option>
                                        <option value="L">Local</option>
                                        <option value="T">Temporal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Carnet de Identidad</span>
                                    <input type="text" class="form-control" name="nc_ci_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Nombre</span>
                                    <input type="text" class="form-control" name="nc_nom_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Ap. Paterno</span>
                                    <input type="text" class="form-control" name="nc_pa_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Ap. Materno</span>
                                    <input type="text" class="form-control" name="nc_ma_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Cargo</span>
                                    <input type="text" class="form-control" name="nc_car_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Codigo de Tarjeta</span>
                                    <input type="text" class="form-control" name="nc_codt_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Codigo MYFARE</span>
                                    <input type="text" class="form-control" name="nc_codMy_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Herramientas</span>
                                    <input type="text" class="form-control" name="nc_he_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Areas Autorizadas</span>
                                    <input type="text" class="form-control" name="nc_areas_acceso_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Grupo Sanguineo</span>
                                    <input type="text" class="form-control" name="nc_gs_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Fecha de Vencimiento</span>
                                    <input type="date" class="form-control" name="nc_fv_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Acciones</span>
                                    <select class="" name="" id="" name="nc_acci_edit">
                                        <option value="C">Dar de Alta</option>
                                        <option value="S">Credencial Extraviada</option>
                                        <option value="V">Credencial Robada</option>
                                        <option value="D">Dar de Baja</option>
                                        <option value="U">Tramite no Concluido</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Nro. Renovación</span>
                                    <input type="text" class="form-control" name="nc_nren_edit">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Información Adicional</h5>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Fecha de Igreso</span>
                                    <input type="date" class="form-control" name="nc_f_in_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Fecha de Nacimiento</span>
                                    <input type="date" class="form-control" name="nc_FNac_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Estado Civil</span>
                                    <select class="form-control" name="nc_estCiv_edit">
                                        <option value="C">Casado</option>
                                        <option value="S">Soltero</option>
                                        <option value="V">Viudo</option>
                                        <option value="D">Divorsiado</option>
                                        <option value="U">Union Libre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Sexo</span>
                                    <select class="form-control" name="nc_sexo_edit">
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Profesion</span>
                                    <input type="text" class="form-control" name="nc_pro_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Estatura CM</span>
                                    <input type="number" class="form-control" name="nc_est_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Color de ojos</span>
                                    <input type="text" class="form-control" name="nc_colojo_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Masa Corporal</span>
                                    <input type="number" class="form-control" name="nc_maCorp_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Fono Domicilio</span>
                                    <input type="text" class="form-control" name="nc_Fono_edit">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <span>Dirección Domicilio</span>
                                    <input type="text" class="form-control" name="nc_10_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span>Fono Trabajo</span>
                                    <input type="text" class="form-control" name="nc_11_edit">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <span>Dirección Trabajo</span>
                                    <input type="text" class="form-control" name="nc_12_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-sm-12">
                                <span>Observaciones</span>
                                <input type="text" class="form-control" name="nc_13_edit">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
    <div class="modal fade" id="md_show_credencial_v" tabindex="-1" role="dialog"
        aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <embed src="" type="" id="emb_sec_pdf_creden_v" width="1000" height="800">
            </div>
        </div>
    </div>
    <!-- modal para delete item -->
    <div class="modal fade" id="md_crevis_deleteConfirm" tabindex="-1" role="dialog"
        aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <p>Confrimar peticion!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary"
                        onclick="destroy_creden_visita(2,0)">Confirmar</button>
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

<script src="{{ asset('resources/js/credenciales_cv.js') }}"></script>
