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
if ($_SESSION['cliente']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Clientes </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <button class="btn bg-purple btn-sm ocultar" id="btnImportar" ><i class=" glyphicon glyphicon-open-file"></i> Importar Excel</button> 
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th style="width:90px" class="text-center">Opciones</th>
                    <th style="width:120px" class="text-center">Código</th>
                    <th style="width:350px" class="text-center">Descripción</th>
                    <th style="width:100px" class="text-center">Rif</th>
                    <th style="width:250px" class="text-center">Tipo de Cliente</th>
                    <th style="width:250px" class="text-center nv">Tipo de Operacion</th>
                    <th style="width:250px" class="text-center nv">Vendedor</th>
                    <th style="width:250px" class="text-center nv">Contacto</th>
                    <th style="width:160px" class="text-center nv">Telefono</th>
                    <th style="width:160px" class="text-center nv">Movil</th>
                    <th style="width:250px" class="text-center nv">email</th>
                    <th style="width:130px" class="text-center nv">Limite</th>
                    <th style="width:150px" class="text-center">Saldo</th>
                    <th style="width:130px" class="text-center nd">Estado</th>
                  </thead>
                </table>
              </div>
              <!-- /Fin Listado de Registros -->
              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                    <label for="cod_cliente">Codigo:</label>
                    <input type="hidden" name="idcliente" id="idcliente">
                    <input type="textc" name="cod_cliente" id="cod_cliente" class="form-control" 
                    placeholder="Código" required="required">
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-2 col-xs-2 no-margin">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                    <label> Fecha de Registro:</label>
                    <div class="input-group date">
                      <input type="text" class="form-control input-date ffechareg" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                    <input type="textc" class="form-control" name="rif" id="rif" 
                    placeholder="Rif" required="required">
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" name="desc_cliente" id="desc_cliente" 
                    maxlength="250" placeholder="Descripción" required="required">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <input type="text" class="form-control" name="direccion" id="direccion" 
                    maxlength="250" placeholder="Direccion" required="required">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label>Tipo:</label></span>
                      <select name="idtipocliente" id="idtipocliente" class="form-control no-pad0l">
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label> Tipo de Op:</label></span>
                      <select id="idoperacion" name="idoperacion" data-live-search="true" class="form-control no-pad0l">           
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label>Tab ISLR:</label></span>
                      <select name="idimpuestoi" id="idimpuestoi" class="form-control no-pad0l" data-live-search="true">
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label>Zona:</label></span>
                      <select id="idzona" name="idzona"  class="form-control no-pad0l" data-live-search="true">      
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="ciudad" id="ciudad" maxlength="50" placeholder="Ciudad">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="codpostal" id="codpostal" maxlength="50" placeholder="Codigo Postal">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label>Vendedor:</label></span>
                      <select id="idvendedor" name="idvendedor" class="form-control no-pad0l" data-live-search="true">      
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <input type="text" class="form-control" name="contacto" id="contacto" placeholder="Persona de Contacto">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="tel" class="form-control" name="movil" id="movil" maxlength="50" placeholder="Telefono Movil" multiple>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="tel" class="form-control" name="telefono" id="telefono" maxlength="50" placeholder="Telefonos" multiple>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <input type="url" class="form-control" name="web" id="web" placeholder="Sitio Web" >
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label> Cond. de Pago:</label></span>
                      <select name="idcondpago" id="idcondpago" class="form-control">                    
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">    
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label>Limite:</label></span>
                      <input type="text" class="form-control numberf" name="limite" id="limite" style="text-align:right; padding:4px 4px">
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label>Cont:</label>
                        <input type="checkbox" name="aplicareten" id="aplicareten" class="form-check-input">
                        </span>
                        <input type="text" class="form-control" placeholder=" % " name="montofiscal" id="montofiscal" style="text-align:right; padding:4px 4px">
                    </div>        
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">    
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <span class="input-group-addon"><label> Saldo:</label></span>
                      <input type="text" class="form-control numberf" name="saldo" id="saldo" style="text-align:right; padding:4px 4px" readonly>
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

              <div class="modal fade" id="ModalImportar">
                <div class="modal-dialog" style="width:35%">
                  <div class="modal-content mcr">
                    <div class="modal-header">
                      <h4 class="modal-title">Importar Registros Desde Excel</h4>
                    </div>
                    <div class="panel-body no-padding">
                      <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
                        <a href="../formatos/Excel/CargaClientes.xlsx" download>
                        <button type="button" class="btn btn-sm btn-primary" id="btnFormatoImp">
                        <i class=" glyphicon glyphicon-download-alt"></i> Descargar Formato</button>
                        </a>
                      </div>
                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      </div>
                      <form id="formSubir" method="POST">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                          <span class="formato"><input type="file" name="formato" id="formato"></span>
                          <label for="formato"><span>Cargar</span></label>
                        </div>
                        <div class="form-group col-lg-12 col-md-6 col-sm-12 col-xs-12">
                          <button type="submit" name="submit" class="btn btn-primary" id="btnProcesar" disabled>Procesar</button>
                          <button type="button" class="btn btn-danger pull-right" id="btnCancelar">Cancelar</button>
                        </div>
                      </form> 
                    </div>
                    <div class="modal-footer" style="padding:10px">
                      <button type="button" class="btn btn-sm btn-success" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/cliente.js"></script>
<?php
}
else
{
  require 'noacceso500.php';
}
require 'footer.php';
}
ob_end_flush();
?>