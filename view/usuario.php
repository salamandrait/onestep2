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
if ($_SESSION['usuario']==1)
{
?>
<!--Contenido--> 
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Usuarios </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->

              <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:60px">Opciones</th>
                    <th class="text-center" style="width:100px">Código</th>
                    <th>Descripción</th>
                    <th class="text-center" style="width:250px">Perfil de Acceso</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                <div class="panel-body col-lg-9 col-md-9 col-sm-12 col-xs-12">
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label>Codigo:</label>
                    <input type="hidden" name="idusuario" id="midusuario">
                    <input type="textc" name="cod_usuario" id="mcod_usuario" class="form-control" 
                    data-toggle="tooltip" title="Código"  placeholder="Código" required="required" autofocus>
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <label> Perfirl de Acceso:</label>
                      <select class="form-control" name="idmacceso" id="idmacceso" required>
                      </select>
                  </div>
                  <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <label> Fecha de Registro:</label>
                    <div class="input-group date">
                      <input type="textdate" class="form-control ffechareg" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon"><label for="mclave"> Clave :</label></span>
                      <input type="password" class="form-control" name="clave" id="mclave" 
                       data-toggle="tooltip" title="Clave" placeholder="Clave" required="required">
                    </div>
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
                    <input type="text" name="desc_usuario" id="mdesc_usuario" class="form-control" 
                    required="required" maxlength="250"  data-toggle="tooltip" title="Descripción" placeholder="Descripción"  >
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon"><label for="mclave">Confirmar:</label></span>
                      <input type="password" class="form-control" name="clave" id="mclavec" 
                      data-toggle="tooltip" title="Confirmar" placeholder="Confirmar" required="required">
                    </div>
                  </div>
                  <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" name="direccion" id="direccion" 
                    data-toggle="tooltip" title="Dirección"  placeholder="Dirección" maxlength="70">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" 
                    data-toggle="tooltip" title="Teléfono"  placeholder="Teléfono">
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="email" class="form-control" name="email" id="email" maxlength="50" 
                    data-toggle="tooltip" title="Email"  placeholder="Email">
                  </div>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="img-container">
                    <span class="imagen" id="imagenh"><label for="imagen">Cargar Imagen</label>
                      <input type="file" name="imagen" id="imagen">
                      <input type="hidden" name="imagenactual" id="imagenactual"></span>     
                      <img class="img-responsive pad" src="" id="imagenmuestra" style="max-width: 85%">
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
<?php
}
else
{
  require 'noacceso500.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/usuario.js"></script>
<?php 
}
ob_end_flush();
?>