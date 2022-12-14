<div class=" col-md-12">
    <div class="card table-card">
        <div class="card-header">
            <h3>Registro de Empresas</h3>
            <div class="card-header-right">
                <!-- <button class="btn btn-facebook" id="btn_modalAdd_user">+</button>
                <input type="text" class="form-control"> -->
                <form class="form-inline">
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input type="text" class="form-control" onkeyup="inp_buscar_empr(this.value)"
                            placeholder="...">
                    </div>
                    <button type="button" class="btn btn-primary mb-2" id="btn_new_terminal"
                        onclick="$('#form_new_terminal').trigger('reset');$('#mod_new_terminal').modal('show'); ">Nuevo
                        <i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-danger mb-2" id="btn_orden_list"> <i
                            class="ik ik-arrow-up"></i><i class="ik ik-arrow-down"></i></button>
                </form>
            </div>

        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover mb-0 without-header">
                    <tbody id="table_list_body_1">
                        <tr>
                            <td>
                                <div class="d-inline-block">
                                    <div class="d-inline-block align-middle">
                                        <h6 class="mb-0">Nombre </h6>
                                        <p class="text-muted mb-0">Cod Usuario</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <h6 class="fw-700">Aeropuerto</h6>
                            </td>
                            <td class="text-right">
                                <h6 class="fw-700">Fecha Ingreso</h6>
                            </td>

                            <td class="text-right">
                                <a href="#!"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>
                                <a href="#!"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- top contact and member performance end -->

<div class="modal fade" id="mod_new_terminal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Registro de Terminal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="form_new_terminal" onsubmit="event.preventDefault(); createTerm(this.id);" >@csrf
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Nombre</span>
                                <input type="text" class="form-control" name="t_nombre" id="t_nombre" maxlength="150"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Abreviacion</span>
                                <input type="text" class="form-control" name="t_abr" id="t_abr" maxlength="5"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Regional dependiente</span>
                                <select name="t_regdep" id="t_regdep" class=" form-control form-control-sm">
                                    <option value="LPB">La Paz</option>
                                    <option value="VVI">Santa Cruz</option>
                                    <option value="CBB">Cochabamba</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mod_edit_empresa" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Registrar Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="form_edit_empresa">@csrf
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Nombre</span>
                                <input type="text" class="form-control" name="Emp_nombre_edit"
                                    id="Emp_nombre_edit" maxlength="150" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Abreviacion</span>
                                <input type="text" class="form-control" name="Emp_abreviacion_edit"
                                    id="Emp_abreviacion_edit" maxlength="5" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Telefono</span>
                                <input type="text" class="form-control" name="Emp_telf_edit" id="Emp_telf_edit"
                                    maxlength="25" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Dirección</span>
                                <input type="text" class="form-control" name="Emp_dir_edit" id="Emp_dir_edit"
                                    maxlength="150" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Representante Legal</span>
                                <input type="text" class="form-control" name="Emp_repLeg_edit"
                                    id="Emp_repLeg_edit" maxlength="50" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Casilla</span>
                                <input type="text" class="form-control" name="Emp_casi_edit" id="Emp_casi_edit"
                                    maxlength="25" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Fax</span>
                                <input type="text" class="form-control" name="Emp_fax_edit" id="Emp_fax_edit"
                                    maxlength="25" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Email</span>
                                <input type="text" class="form-control" name="Emp_email_edit" id="Emp_email_edit"
                                    maxlength="100" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Ruc</span>
                                <input type="text" class="form-control" name="Emp_ruc_edit" id="Emp_ruc_edit"
                                    maxlength="15" autocomplete="off">
                            </div>
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
<!-- modal delete users -->
<div class="modal fade" id="md_delete_user" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Confirmar Petición !</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" onclick="destroy_user()">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('resources/js/terminal/terminal.js') }}"></script>
