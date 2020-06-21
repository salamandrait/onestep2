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
if ($_SESSION['beneficiario']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Beneficiarios </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body hidden" id="listadoregistros">
                <table id="tblistado" cellspacing="0" class="table compact table-striped table-bordered table-condensed table-hover table-responsive" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th class="nd" style="width:100px; text-align:center;">Rif</th>
                    <th class="nd" style="width:150px; text-align:center;">Telefono</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                    <label for="cod_beneficiario">Codigo:</label>
                    <input type="hidden" name="idbeneficiario" id="idbeneficiario">
                    <input type="textc" name="cod_beneficiario" id="cod_beneficiario" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 no-pad0l">
                    <label>Tipo Fiscal:</label>     
                    <select name="idimpuestoi" id="idimpuestoi" class="form-control" data-live-search="true">
                    </select>   
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8 no-padr">
                    <label> Fecha de Registro </label>
                    <div class="input-group">
                      <input type="text" name="fechareg" id="fechareg" class="form-control ffechareg controld">
                      <div class="input-group-addon"><span class="fa fa-calendar"></span></div>  
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" name="rif" id="rif" maxlength="20" 
                    placeholder="Rif" required rel="tooltip" data-original-title="Campo Obligatorio" required="required">
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12 no-pad0lr">
                    <input text class="form-control" name="desc_beneficiario" id="desc_beneficiario" 
                    placeholder="Descripción" required="required">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 no-padr">
                    <input text class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12 no-padr">
                    <input text class="form-control" name="direccion" id="direccion" placeholder="Direccion">
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
<script type="text/javascript" src="scripts/beneficiario.js"></script>
<?php 
}
ob_end_flush();
?>