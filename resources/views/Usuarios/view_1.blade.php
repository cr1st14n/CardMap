<div class=" col-md-12">
    <div class="card table-card">
        <div class="card-header">
            <h3>Usuarios Registrados</h3>
            <div class="card-header-right">
                <button class="btn btn-facebook" id="btn_modalAdd_user">+</button>

            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover mb-0 without-header">
                    <tbody id="table_list_body_1">
                        <tr>
                            <td>
                                <div class="d-inline-block align-middle">
                                    <div class="d-inline-block">
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

<div class="modal fade" id="md_add_users" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Nuevo Credencial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="form_new_user">@csrf
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Nombre Apellido</span>
                                <input type="text" class="form-control" name="usu_nombre" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Codigo</span>
                                <input type="text" class="form-control" name="usu_cod" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Contraseña</span>
                                <input type="text" class="form-control" name="usu_pass" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Aeropuerto</span>
                                <select name="usu_aero" class="form-control" id="" required>
                                    <option value="T">Todas</option>
                                    <option value="LP">La Paz</option>
                                    <option value="CB">Cochabamba</option>
                                    <option value="SC">Santa Cruz</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Provilegio</span>
                                <select name="usu_privilegio" class="form-control" id="" required>
                                    <option value="1">Administrador</option>
                                    <option value="2">enrolador</option>
                                </select>
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
<div class="modal fade" id="md_delete_user" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
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



<script src="{{ asset('resources/js/Users/users_1.js')}}"></script>