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
if ($_SESSION['caja']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border box-primary"><!-- box header-->
                <h1 class="box-title"> Cajas </h1><br>
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
                    <th style="width:80px; text-align:center;" class="nd">Moneda</th>
                    <th style="width:120px; text-align:center;">Saldo</th> 
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->
              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6 no-padr">
                    <label for="cod_caja">Codigo:</label>
                    <input type="hidden" name="idcaja" id="idcaja">
                    <input type="textc" name="cod_caja" id="cod_caja" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padl">
                    <label>Moneda:</label>     
                    <select name="idmoneda" id="idmoneda" class="form-control nice-select" data-live-search="true">
                    </select>   
                  </div>
                  <div class="form-group date col-lg-1 col-md-1 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group date col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <label> Fecha de Registro:</label>
                      <div class="input-group datetime">
                        <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                      </div>
                  </div>
                  <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <label for="desc_caja">Descripción:</label>
                    <input type="text" name="desc_caja" id="desc_caja" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="col-md-9">
                    <div class="box box-primary box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title">Saldos</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                      </div><!-- /.box-header -->
                      <div class="box-body" style="">
                        <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
                          <label>Efectivo:</label>
                          <input type="text" class="form-control numberf" name="saldoefectivo" id="saldoefectivo" 
                          placeholder="0.00" style="text-align:right;" readonly>
                        </div>
                        <div class="form-group col-lg-4 col-md-2 col-sm-8 col-xs-8">
                          <label>Documentos:</label>
                          <input type="text" class="form-control numberf" name="saldodocumento" id="saldodocumento" 
                          placeholder="0.00" style="text-align:right;" readonly>
                          </div>
                          <div class="form-group col-lg-4 col-md-2 col-sm-8 col-xs-8">
                            <label>Total:</label>
                            <input type="text" class="form-control numberf" name="saldototal" id="saldototal" 
                            placeholder="0.00" style="text-align:right;" readonly>
                          </div>
                        </div> <!-- /.box-body -->
                    </div><!-- /.box -->
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
<script type="text/javascript" src="scripts/caja.js"></script>
<?php 
}
ob_end_flush();
?>