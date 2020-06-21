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
if ($_SESSION['vendedor']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Vendedores </h1><br>
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
                    <th class="text-center">Descripción</th>
                    <th class="nd text-center" style="width:80px">Vendedor</th>
                    <th class="nd text-center" style="width:80px">Comis. %</th>
                    <th class="nd text-center" style="width:80px">Cobrador</th>
                    <th class="nd text-center" style="width:80px">Comis. %</th>
                    <th class="nd text-center"style="width:80px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_vendedor">Codigo:</label>
                    <input type="hidden" name="idvendedor" id="idvendedor">
                    <input type="textc" name="cod_vendedor" id="cod_vendedor" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Fecha de Registro:</label>
                    <div class="input-group">
                      <input type="text" name="fechareg" id="fechareg" class="form-control ffechareg">
                      <div class="input-group-addon"><span class="fa fa-calendar"></span></div>  
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <input type="text" name="rif" id="rif" class="form-control" 
                    required="required" maxlength="250" placeholder="Rif">
                  </div>
                  <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <input type="text" name="desc_vendedor" id="desc_vendedor" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <input type="text" name="direccion" id="direccion" class="form-control" 
                    maxlength="250" placeholder="Dirección">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="text" name="telefono" id="telefono" class="form-control" 
                    maxlength="250" placeholder="Telefono">
                  </div>
                  <div class="col-md-7">
                    <div class="panel panel-primary">
                    <div class="panel-heading" style="padding:5px 15px">Comisiones
                    </div>
                      <table class="table compactb table-bordered table-condensed table-bordered" id="tbopciones">
                        <thead class="bg-gray" style0="margin:2px solid #000">
                          <th class="nd text-center nd">Es Vendedor</th>
                          <th class="nd text-center nd">Comision % </th>
                          <th class="nd text-center nd">Es Cobrador</th>
                          <th class="nd text-center nd">Comision % </th>
                        </thead>
                      </table>
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
<script type="text/javascript" src="scripts/vendedor.js"></script>
<?php 
}
ob_end_flush();
?>