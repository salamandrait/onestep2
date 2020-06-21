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
if ($_SESSION['correlativo']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Series de Operaciones </h1><br>
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
                    <th style="width:100px; text-align:center;">Tabla</th>
                    <th style="width:80px; text-align:center;" class="nd">Prefijo</th>  
                    <th style="width:80px; text-align:center;" class="nd">Cadena</th>
                    <th style="width:80px; text-align:center;">Codigo</th>
                    <th style="width:50px; text-align:center;" class="nd">Largo</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12 no-padding">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12 no-padlr">
                    <label for="cod_correlativo">Codigo:</label>
                    <input type="hidden" name="idcorrelativo" id="idcorrelativo">
                    <input type="textc" name="cod_correlativo" id="cod_correlativo" class="form-control" placeholder="Codigo" required="required" >
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10  no-padlr">
                    <label>Grupo:</label>
                    <select name="grupo" id="grupo" class="form-control">
                      <option value="inventario">Inventario</option>
                      <option value="compras">Compras</option>
                      <option value="ventas">Ventas</option>
                      <option value="bancos">Banco</option>
                      <option value="configuracion">Configuracion</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 no-padlr">
                    <label>Operacion:</label>
                    <input type="text" class="form-control" name="desc_correlativo" id="desc_correlativo" maxlength="50" 
                    placeholder="Operacion" rel="tooltip" data-original-title="Campo Obligatorio" required=required>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10 no-padlr">
                    <label>Tabla:</label>
                    <input type="text" id="tabla" name="tabla" class="form-control" placeholder="Tabla" required=required>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6 no-padlr">
                    <label>Prefijo:</label>
                    <input type="text" id="precadena" name="precadena" class="form-control" placeholder="Prefijo">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6 no-padlr">
                    <label>Cadena:</label>
                    <input type="text" id="cadena" name="cadena" class="form-control" required=required>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10 no-padlr">
                    <label>Codigo:</label>
                    <input type="text" id="cod_num" name="cod_num" class="form-control" placeholder="Codigo" required=required>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10 no-padlr">
                    <label>Largo:</label>
                    <input type="text" id="largo" name="largo" class="form-control" placeholder="Largo" required=required>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
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
<script type="text/javascript" src="scripts/correlativo.js"></script>
<?php 
}
ob_end_flush();
?>