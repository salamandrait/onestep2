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
if ($_SESSION['impuestoe']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Tabulador de I.S.L.R. </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8 no-pad0lr">
                  <div class="input-group">
                    <span class="input-group-addon"><label>Tipo de Persona:</label></span>
                    <input type="textc" name="cod_impuestoih" id="cod_impuestoih" class="form-control px" placeholder="Codigo" readoly">
                  </div>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8 no-pad0l">
                  <select name="idimpuestoi" id="idimpuestoi" class="form-control">
                  </select>
                </div>
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th style="text-align:center;" class="nd">Opciones</th>
                    <th style="text-align:center;" class="nd">Reg</th>
                    <th style="text-align:center;">Código</th>
                    <th style="text-align:center;">Concepto</th>
                    <th style="text-align:center;" class="nd">% Base Imp </th>
                    <th style="text-align:center;" class="nd">% Retención</th>
                    <th style="text-align:center;" class="nd">Sustraendo</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-6 no-pad0r">
                    <div class="input-group" >
                      <span class="input-group-addon"><label>Tipo de Persona:</label></span>
                      <input type="hidden" name="idimpuestoin" id="idimpuestoif">
                      <input type="textc" name="cod_impuestoi" id="cod_impuestoi" class="form-control" placeholder="Codigo" readonly>
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6 no-pad0l">   
                    <input type="text" name="desc_impuestoi" id="desc_impuestoi" class="form-control" 
                    maxlength="250" placeholder="Descripción" readonly>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-4 no-pad0r">
                    <div class="input-group">
                      <span class="input-group-addon"><label>Concepto:</label></span>
                      <input type="text" name="cod_concepto" id="cod_concepto" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 no-pad0l">
                    <input type="text" name="desc_concepto" id="desc_concepto" class="form-control" readonly>
                  </div>   
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6 no-pad0r">
                    <div class="input-group">
                    <span class="input-group-addon"><label>% Base Imp:</label></span>
                    <input type="text" name="base" id="base" class="form-control numberf" style="text-align:right">
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6 no-pad0r">
                    <div class="input-group">
                    <span class="input-group-addon"><label>% Retención:</label></span>
                    <input type="text" name="retencion" id="retencion" class="form-control numberf" style="text-align:right">
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="input-group">
                    <span class="input-group-addon"><label> Sustraendo:</label></span>
                    <input type="text" name="sustraendo" id="sustraendo" class="form-control numberf" style="text-align:right">
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="idimpuestoid" id="idimpuestoid" class="form-control">
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
<script type="text/javascript" src="scripts/impuestoi.js"></script>
<?php 
}
ob_end_flush();
?>