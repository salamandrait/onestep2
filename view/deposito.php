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
if ($_SESSION['deposito']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
  <section  class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Depositos </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover table-responsive" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th style="width:300px;">Descripción</th>
                    <th style="width:150px; text-align:center;">Resposable</th>
                    <th style="text-align:center; width:110px;" class="nd">Solo Compras</th>
                    <th style="text-align:center; width:110px;" class="nd">Solo Ventas</th>
                    <th class="nd text-center" style="width:70px" class="nd">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_deposito">Codigo:</label>
                    <input type="hidden" name="iddeposito" id="iddeposito">
                    <input type="textc" name="cod_deposito" id="cod_deposito" class="form-control" 
                    placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group date col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group date col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <label> Fecha de Registro:</label>
                      <div class="input-group datepicker">
                        <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                      </div>
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" name="desc_deposito" id="desc_deposito" 
                    maxlength="250" placeholder="Descripción" required="required">
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" name="responsable" id="responsable" 
                    maxlength="250" placeholder="Responsable">
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" name="direccion" id="direccion" 
                    maxlength="250" placeholder="Direccion">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-primary box-solid">
                          <div class="box-body">
                          <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Restingido para Compras: </label>
                          <input type="checkbox" name="solocompra" id="solocompra" class="checkbox-inline">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                          <label>Restingido para Ventas: </label>
                          <input type="checkbox" name="soloventa" id="soloventa" class="checkbox-inline">
                        </div> 
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->  
                  </div><!-- /.row -->
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
<script type="text/javascript" src="scripts/deposito.js"></script>
<?php 
}
ob_end_flush();
?>