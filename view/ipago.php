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
if ($_SESSION['ipago']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Instrumentos de Pago </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button>
                  </a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th style="width:80px; text-align:center;" class="nd">Comisión</th>
                    <th style="width:80px; text-align:center;" class="nd">Recargo</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_ipago">Codigo:</label>
                    <input type="hidden" name="idipago" id="idipago">
                    <input type="textc" name="cod_ipago" id="cod_ipago" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <label for="desc_ipago">Descripción:</label>
                    <input type="text" name="desc_ipago" id="desc_ipago" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label> Comisión %:</label></span>     
                      <input type="text" name="comision" id="comision" class="form-control" style="text-align:right">
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label> Recargo %:</label></span>     
                      <input type="text" name="recargo" id="recargo" class="form-control" style="text-align:right">
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
<script type="text/javascript" src="scripts/ipago.js"></script>
<?php 
}
ob_end_flush();
?>