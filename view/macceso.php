<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["cod_usuario"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['macceso']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border box-primary"><!-- box header-->
                <h1 class="box-title"> Configuración de Accesos </h1><br>
                <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                <a id="rep">
                <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                <div class="box-tools pull-right"></div>
              </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover table-responsive" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->
              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6 no-padr">
                    <label for="cod_macceso">Codigo:</label>
                    <input type="hidden" name="idmacceso" id="idmacceso">
                    <input type="textc" name="cod_macceso" id="cod_macceso" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label> Perfirl de Acceso:</label>
                    <select class="form-control" name="departamento" id="departamento" required>
                      <option value="ADMINISTRACION">Administración</option>
                      <option value="GERENCIA">Gerencia</option>
                      <option value="COMPRAS">Compras</option>
                      <option value="VENTAS">Ventas</option>
                      <option value="TESORERIA">Tesorería</option>
                      <option value="SOPORTE">Soporte</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <label for="desc_macceso">Descripción:</label>
                    <input type="text" name="desc_macceso" id="desc_macceso" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box bg-gray">
                      <ul class="nav nav-tabs nav-justified bg-gray">
                        <li class="active"><a data-toggle="tab" href="#ctab"><B>Accesos Configuracion</B></a></li>
                        <li><a data-toggle="tab" href="#itab"><B>Accesos Inventario</B></a></li>
                        <li><a data-toggle="tab" href="#cxptab"><B>Accesos Compras</B></a></li>
                        <li><a data-toggle="tab" href="#cxctab"><B>Accesos Ventas</B></a></li>
                        <li><a data-toggle="tab" href="#btab"><B>Accesos Bancos</B></a></li>
                      </ul>
                      <div class="tab-content">           
                        <div class="form-group col-12 tab-pane fade in active" id="ctab">
                          <div class="col-md-12" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body table-responsive">
                                <table id="tbconfig" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Descripción</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <button class="btn btn-success btn-sm" type="button" id="btnMTodoscf">
                                  <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                                  <button class="btn btn-danger btn-sm hidden" type="button" id="btnDTodoscf">
                                  <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-12 tab-pane fade" id="itab">
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbinven" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Tablas</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-success btn-sm" type="button" id="btnMTodosi">
                                <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                                <button class="btn btn-danger btn-sm hidden" type="button" id="btnDTodosi">
                                <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                              </div>
                          </div>
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbinvenop" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Operaciones</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-12 tab-pane fade" id="cxptab">
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbcxp" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Tablas</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-success btn-sm" type="button" id="btnMTodosc">
                                <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                                <button class="btn btn-danger btn-sm hidden" type="button" id="btnDTodosc">
                                <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                              </div>                            
                          </div>
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbcxpop" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Operaciones</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-12 tab-pane fade" id="cxctab">
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbcxc" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Tablas</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-success btn-sm" type="button" id="btnMTodosv">
                                <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                                <button class="btn btn-danger btn-sm hidden" type="button" id="btnDTodosv">
                                <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                              </div>                            
                          </div>
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbcxcop" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Operaciones</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-12 tab-pane fade" id="btab">
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbban" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Tablas</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-success btn-sm" type="button" id="btnMTodosb">
                                <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                                <button class="btn btn-danger btn-sm hidden" type="button" id="btnDTodosb">
                                <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                              </div>                            
                          </div>
                          <div class="col-md-6" style="padding:2.5px;">
                            <div class="box box-solid">
                              <div class="box-body">
                                <table id="tbbanop" class="table compactb table-responsive table-striped table-bordered table-condensed">
                                  <thead class="bg-green-active">
                                    <th>Operaciones</th>
                                    <th>Activo</th>                                
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>          
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                    <button class="btn btn-danger btn-sm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div> 
                </form>
              </div>
            </div>
         </div>
      </div>
   </section>
</div>
<!--Fin Contenido-->

<!--Fin Contenido-->
<?php
}
else
{
  require 'noacceso500.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/macceso.js"></script>
<?php 
}
ob_end_flush();
?>