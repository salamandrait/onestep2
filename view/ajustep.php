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
if ($_SESSION['ajprecio']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Ajuste de Costos y Precios </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep" target="ventana_iframe">
                  <button class="btn btn-primary btn-sm ocultar"  id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:100px">Fecha</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th class="nd text-center" style="width:100px">Tipo</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->


              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <label for="cod_ajustep">Codigo:</label>
                    <b><input type="textc" name="cod_ajustep" id="cod_ajustep" class="form-control" 
                    placeholder="Codigo" required="required"></b>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                   <label> Estado:</label>
                    <B><input type="text" class="form-control" name="estatus" id="estatus" readonly></B>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <label> Fecha de Registro:</label>
                    <div class="input-group">
                      <input type="text" class="form-control ffechareg ctrl" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <input type="text" name="desc_ajustep" id="desc_ajustep" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <button type="button" id="btnProcesar" class="btn btn-success" style="width:150px">
                    Procesar <i class="glyphicon glyphicon-save-file"></i></button>
                  </div>   
                  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="input-group">
                    <span class="input-group-addon"><label>Tipo de Ajuste:</label></span>
                      <select id="tipo" name="tipo" class="form-control">
                        <option value="Costo">Costo</option>
                        <option value="Precio">Precio</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="input-group">
                    <span class="input-group-addon"><label>Tipo de Precio:</label></span>
                      <select id="tipopreciom" name="tipopreciom" class="form-control" disabled="disabled">
                        <option value="p1">Precio 1</option>
                        <option value="p2">Precio 2</option>
                        <option value="p3">Precio 3</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-1">
                  </div> 
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <label><input type="checkbox" name="costoaprecio" id="costoaprecio"> Ajuste de Costo a Precio</label>   
                  </div>   
                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <button type="button" id="btnAgregarArt" class="btn btn-primary" disabled="disabled" style="width:150px">
                    Agregar Art. <i class="glyphicon glyphicon-search"></i></button>
                  </div>
                  <div class="panel-body table-responsive no-pad-top paneltb">
                   <table id="tbdetalles" class="table compact table-striped table-bordered 
                   table-condensed table-hover table-responsive no-padding" style="width:100% !important;">
                      <thead class="bg-blue-active">
                        <th style="text-align:center; width:30px;" class="nd">R</th>
                        <th style="text-align:center; width:120px;" class="nd">Código</th>
                        <th style="text-align:center; width:350px;" class="nd">Artículo</th>
                        <th style="text-align:center; width:150px;" class="nd">Cósto</th>
                        <th style="text-align:center; width:120px;" class="nd">Impuesto</th>
                        <th style="text-align:center; width:150px;" class="nd">Precio</th>
                      </thead>                                  
                    </table>
                   </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span class="pull-right">
                    <label>Total Registros </label>
                    <label> : <span id="totalreg"></span></label>
                    </span>
                    <input type="hidden" name="idajustep" id="idajustep">
                    <input type="hidden" name="idusuario" id="idusuario" value=<?php echo $_SESSION['idusuario'];?>>
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
<script type="text/javascript" src="scripts/ajustep.js"></script>
<?php 
}
ob_end_flush();
?>