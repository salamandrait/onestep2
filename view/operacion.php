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
if ($_SESSION['operacion']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Tipos de Operaciones </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th class="nd text-center" style="width:110px">Inventario</th>
                    <th class="nd text-center" style="width:110px">Compra</th>
                    <th class="nd text-center" style="width:110px">Venta</th>
                    <th class="nd text-center" style="width:110px">Banco</th>
                    <th class="nd text-center" style="width:110px">Config.</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_operacion">Codigo:</label>
                    <input type="hidden" name="idoperacion" id="idoperacion">
                    <input type="textc" name="cod_operacion" id="cod_operacion" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <label for="desc_operacion">Descripción:</label>
                    <input type="text" name="desc_operacion" id="desc_operacion" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <table id="tbopciones" class="table compactb table-bordered table-condensed table-hover table-responsive">
                      <thead class="bg-gray">
                      <th class="nd text-center nd" style="width:110px">Es Inventario</th>
                      <th class="nd text-center nd" style="width:110px">Es Compra</th>
                      <th class="nd text-center nd" style="width:110px">Es Venta</th>
                      <th class="nd text-center nd" style="width:110px">Es Banco</th>
                      <th class="nd text-center nd" style="width:110px">Es Config.</th>
                      </thead>
                    </table>
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
<script type="text/javascript" src="scripts/operacion.js"></script>
<?php 
}
ob_end_flush();
?>