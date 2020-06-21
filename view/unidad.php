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
if ($_SESSION['unidad']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

              <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Unidades </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep" onclick="javascript:window.pushState('pagina2.html');">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button>
                  </a>
                  <button class="btn bg-purple btn-sm ocultar" id="btnImportar"><i class="fa fa-plus-circle"></i> Importar</button>
                  <div class="box-tools pull-right"></div>
                  <div id="reporte"></div>
              </div><!-- /.box header-->

              <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_unidad">Codigo:</label>
                    <input type="hidden" name="idunidad" id="idunidad">
                    <input type="textc" name="cod_unidad" id="cod_unidad" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <label for="desc_unidad">Descripción:</label>
                    <input type="text" name="desc_unidad" id="desc_unidad" class="form-control" 
                    required="required" maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                    <button class="btn btn-danger btn-sm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div> 
                </form>
              </div>

              <div class="modal fade" id="ModalImportar">
                <div class="modal-dialog">
                  <div class="modal-content mcr">
                    <div class="modal-header mhcp">
                      <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="panel-body">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <a id="linkformato" href="../formatos/Excel/CargaUnidad.xlsx"><button type="button" class="btn btn-sm btn-primary pull-right" id="btnDescargarFormato">
                        <i class="fa fa-download"></i> Descargar Formato </button></a>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    </div>
                    <form method="POST" id="formSubir">
                      <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">     
                        <span class="formato"><input type="file" name="formato" id="formato"></span>
                          <label for="formato"><span>Cargar</span></label>
                        </div>
                        <div class="form-group col-lg-12 col-md-6 col-sm-12 col-xs-12">
                          <input type="submit" name="submit" value="Subir" accept=".xls,.xlsx" class="btn btn-primary" id="btnProcesar" disabled>
                        </div>
                    </form>
                    <div id="mensaje"></div>
                    </div>
                    <div class="modal-footer mfcp">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/unidad.js"></script>
<?php 
}
ob_end_flush();
?>