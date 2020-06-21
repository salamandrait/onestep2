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
if ($_SESSION['traslado']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Traslado Entre Depositos </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th style="width:90px; text-align:center;" class="nd">Opciones</th>
                    <th style="width:90px; text-align:center;">Fecha</th>
                    <th style="width:100px; text-align:center;">Codigo</th>
                    <th style="width:220px; text-align:center;">Dep. Origen</th>
                    <th style="width:220px; text-align:center;">Dep. Destino</th>
                    <th style="width:150px; text-align:center;">Total</th>
                    <th style="width:100px; text-align:center;" class="nd">Estado</th> 
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_traslado">Codigo:</label>
                    <input type="hidden" name="idtraslado" id="idtraslado">
                    <input type="textc" name="cod_traslado" id="cod_traslado" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-8">
                  <label> Estatus:</label>
                    <B><input type="textD" class="form-control" name="estatus" id="estatus" readonly></B>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-8">
                    <label> Fecha de Registro:</label>
                    <div class="input-group">
                      <input type="text" class="form-control ffechareg ctrl" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">   
                    <input type="text" name="desc_traslado" id="desc_traslado" class="form-control inp" 
                    maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">   
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="input-group"><span class="input-group-addon" style="padding: 4px 5px"><label>Dep. Origen:</label></span>
                      <select name="iddepositoi" id="iddepositoi" class="form-control ctrl">                     
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="input-group"><span class="input-group-addon" style="padding: 4px 5px"><label>Dep. Destino:</label></span>
                      <select name="iddeposito" id="iddeposito" class="form-control ctrl">                     
                      </select>
                    </div>
                  </div>
                  <div class="button-group col-lg-2 col-md-2 col-sm-8 col-xs-8">          
                    <button id="btnAgregarArt" type="button" class="btn btn-primary btn-sm form-control" disabled>
                    <i class="fa fa-truck"></i><B> Agregar Artículos</B></button>
                  </div>
                  <div class="panel-body table-responsive" style="width:100% !important; padding-bottom:0px;">
                    <table id="tbdetalles" class="table compact table-striped table-bordered table-condensed table-hover table-responsive" style="width:100% !important;">
                      <thead class="btn-primary">
                        <th style="text-align:center; width:30px;" class="nd">E</th>
                        <th style="text-align:center; width:120px;" class="nd">Codigo</th>
                        <th style="width:480px;">Artículo</th>
                        <th style="text-align:center; width:60px;" class="nd">Unidad</th>
                        <th style="text-align:right; width:70px;" class="nd">Cantidad</th>
                        <th style="text-align:right; width:120px;" class="nd">Costo</th>
                        <th style="text-align:right; width:150px;" class="nd">Total Reng.</th>
                      </thead>                                  
                    </table>
                    </div>
                    <div class="panel-body table-responsive no-pad-top">
                    <table class="table compact table-bordered table-condensed table-hover">
                      <thead class="bg-gray-active">
                        <th><h5 style="text-align:right;"><B>Total Costo <span id="lbcod_moneda"></span>:</B></h5></th>
                      </thead>
                      <tfoot class="bg-light-blue">
                        <th style="width:500px"><h4 style="text-align:right;"><B><span id="totalv" class="numberf">0.00</span></B></h4></th>
                      </tfoot>
                    </table>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" id="idusuario" name="idusuario" value=<?php echo $_SESSION['idusuario'];?>>
                    <input type="hidden" name="totalh" id="totalh">         
                    <input type="hidden" name="idtraslado" id="idtraslado">
                    <input type="hidden" name="contador" id="contador">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                    <button class="btn btn-danger btn-sm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div> 
                </form>
              </div>

              <div class="modal fade" id="ModalCrearArticulo" tabindex="-1" role="dialog">
                <div class="modal-dialog" style="width:65%">
                  <div class="box box-primary">
                    <div class="modal-header" style="padding-bottom:0px">
                      <h4 class="modal-title"> Seleccionar Artículos</h4>
                    </div>
                      <div class="panel-body">
                      <table id="" class="table table-bordered compactb table-condensed" style="width:100%;">
                        <thead class="bg-primary">
                          <tr>
                            <th style="text-align:center; width:100px;" class="nd">Código</th>
                            <th style="text-align:center; width:290px;">Artículo</th>
                            <th style="text-align:center; width:90px;" class="nd">Unidad</th>
                            <th style="text-align:center; width:80px;" class="nd">Cantidad</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="width:100px;" class="no-padding"><input type="text" name="" id="cod_articulom" class="form-control no-padding control"></td>
                            <td style="width:290px;" class="no-padding"><input type="text" name="" id="desc_articulom" class="form-control no-padding control"></td>
                            <td style="width:90px;" class="no-padding"><select id="idartunidad" class="form-control control no-padding"></select></td>
                            <td style="width:80px;" class="no-padding"><input type="text" name="cantidadm" id="cantidadm" class="form-control text-right control" style="padding:0px 4px !important;"></td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </tfoot>
                      </table>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                          <input type="" name="" id="costom" class="control"> 
                          <input type="" name="" id="desc_unidad" class="control">
                          <input type="" name="" id="valorund" class="control">
                          <input type="" name="" id="tipom" class="control">
                          <input type="" name="" id="stockm" class="control">
                          <input type="" name="" id="dispdestino" class="control">
                          <input type="" name="" id="idarticulom" class="control">
                          <input type="" name="" id="iddeporigen" class="control">
                        </div>
                      </div>
                    <div class="modal-footer" style="padding:6px">
                      <button type="button" class="btn btn-primary btn-sm" id="btnAceptarM">Aceptar</button>
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="btnCancelarM">Cancelar</button>
                    </div>
                  </div>
                </div>
              </div> 
              
              <div class="modal fade" id="ModalArticulo" tabindex="-1" role="dialog">
                <div class="modal-dialog" style="width:70%">
                  <div class="box box-primary">
                    <div class="modal-header" style="padding-bottom:0px">
                      <h4 class="modal-title"> Seleccionar Artículos</h4>
                    </div>
                      <div class="panel-body table-responsive">
                        <table id="tbarticulos" class="table compact table-bordered table-condensed table-hover table-responsive" style="width:100%">
                          <thead class="btn-primary">
                          <th style="text-align:center;" class="nd">Add</th>
                          <th style="text-align:center;">Cod. Artículo</th>
                          <th style="text-align:center;">Descripción</th>
                          <th style="text-align:center;">Referencia</th>
                          <th style="text-align:center;" class="nd">Stock</th>
                          <th style="text-align:center;" class="nd">Costo</th>
                          </thead>
                        </table>
                      </div>
                    <div class="modal-footer" style="padding:6px">
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
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
<script type="text/javascript" src="scripts/traslado.js"></script>
<?php 
}
ob_end_flush();
?>