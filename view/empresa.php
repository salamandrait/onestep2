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
if ($_SESSION['empresa']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row"><!-- row -->
      <div class="col-md-12"><!-- col -->
        <div class="box"><!--  box -->

          <div class="box-header with-border box-primary"><!-- box header-->
            <h1 class="box-title"> Empresa </h1><br>
            <button class="btn btn-success btn-sm" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
            <a id="rep" target="_blank">
            <button class="btn btn-primary btn-sm" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
            <div class="box-tools pull-right"></div>
          </div><!-- /.box header-->

          <!-- centro Listado de Registros -->
          <div class="panel-body table-responsive hidden" id="listadoregistros">
            <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover"  style="width:100%">
              <thead class="bg-gray-active">
                <th style="width:120px; text-align:center;" class="nd">Opciones</th>
                <th style="width:120px; text-align:center;" class="nd">Codigo</th>
                <th style="text-align:center;" class="nd">Descripción</th>
                <th style="width:80px; text-align:center;" class="nd">C. Fiscal</th>
                <th style="width:80px; text-align:center;" class="nd">Monto</th>
              </thead>
            </table>   
          </div>
          <!-- /Fin Listado de Registros -->

          <!-- Formulario Ingreso -->
          <div class="panel-body hidden" id="formularioregistros">
            <form name="formulario" id="formulario" method="POST">
              <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                <label>Codigo:</label>
                <input hidden name="idempresa" id="idempresa">
                <input type="textc" name="cod_empresa" id="cod_empresa" class="form-control" 
                placeholder="Codigo" required="required" >
              </div>
              <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <label> Descripción:</label>     
                <input type="text" name="desc_empresa" id="desc_empresa" class="form-control" 
                maxlength="250" placeholder="Descripción" required="required" >
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <label> Rif:</label>
                <input type="text" class="form-control" name="rif" id="rif" placeholder="Rif">
              </div>
              <div class="form-group col-lg-10 col-md-20 col-sm-12 col-xs-12">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon"><label> Dirección Fiscal:</label></span>
                  <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion Fiscal">
                </div>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="codpostal" id="codpostal" placeholder="Codigo Postal">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon"><label> Representante Legal:</label></span>
                  <input type="text" class="form-control" name="contacto" id="contacto" placeholder="Representante Legal">
                </div>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="movil" id="movil" placeholder="Telefono Movil">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon"><label> Correo Electrónico:</label></span>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Correo Electronico">
                </div>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon"><label> Pagina Web:</label></span>
                  <input type="text" class="form-control" name="web" id="web" placeholder="Pagina Web">
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box bg-gray">
                  <ul class="nav nav-tabs nav-justified bg-gray">
                    <li class="active"><a data-toggle="tab" href="#metodotab"><B>Metodos de Cobro</B></a></li>
                    <li><a data-toggle="tab" href="#serailtab"><B>Parametros Fiscales</B></a></li>
                    <li><a data-toggle="tab" href="#imgtab"><B>Imagenes</B></a></li>
                  </ul>
                  <div class="tab-content"> 
                  <div class="form-group col-12 tab-pane fade in active" id="metodotab">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:1px; margin-bottom:2px;">
                    <div class="box box-primary box-solid">
                    <span class="form-control btn-primary"><label>Metodos de Cobro</label></span>
                    <div class="box-body">
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <span class="form-control"><label> Efectivo: <input type="checkbox" name="efectivo" id="efectivo" class="chek"></label></span>       
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <span class="form-control"><label> Tarjeta de Crédito: <input type="checkbox" name="tdc" id="tdc" class="chek"></label></span>       
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <span class="form-control"><label> Targeta de Débito: <input type="checkbox" name="tdd" id="tdd" class="chek"></label></span>       
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <span class="form-control"><label> Trasferencia/Deposito: <input type="checkbox" name="deposito" id="deposito" class="chek"></label></span>      
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <span class="form-control"><label> Pago Ticket: <input type="checkbox" name="ticketa" id="ticketa" class="chek"></label></span>          
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <span class="form-control"><label> Pago Electrónico: <input type="checkbox" name="pagoe" id="pagoe" class="chek"></label></span>          
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <span class="form-control"><label>Efectivo en Divisas: <input type="checkbox" name="divisas" id="divisas" class="chek"></label></span>          
                      </div>
                      <div class="form-group col-lg-3 col-md-2 col-sm-12 col-xs-12">
                      <span class="form-control"><label>Cheque: <input type="checkbox" name="cheque" id="cheque" class="chek"></label></span>          
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-12 tab-pane fade" id="serailtab">
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <div class="box box-primary box-solid">
                    <span class="form-control btn-primary"><label>Parametros Fiscales</label></span>
                    <div class="box-body">          
                      <label> Es Contribuyente:</label>
                      <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <span class="input-group-addon" style="padding-right:10px;">
                          <label>
                          Retencion (%):<input class="chek" type="checkbox" name="esfiscal" id="esfiscal" style="margin-left:10px;">
                          </label></span>   
                          <input type="text" id="montofiscal" name="montofiscal" class="form-control" placeholder="%" style="text-align:right;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-12 tab-pane fade" id="imgtab">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="hidden" name="imagen1actual" id="imagen1actual">
                      <img src="" width="120px" height="120px" id="imagen1muestra"> 
                      <span class="imagen1">
                        <input type="file" class="form-control" name="imagen1" id="imagen1" 
                        style="width:0.1px; height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;">  
                      </span>
                      <label for="imagen1"><span> Logo</span></label>   
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input type="hidden" name="imagen2actual" id="imagen2actual">
                      <img src="" width="400px" height="120px" id="imagen2muestra"> 
                      <span class="imagen2">
                        <input type="file" class="form-control" name="imagen2" id="imagen2" 
                        style="
                        width:0.1px; 
                        height: 0.1px;
                        opacity: 0;
                        overflow: hidden;
                        position: absolute;
                        z-index: -1;
                        ">
                      </span>
                    <label for="imagen2"><span> Imagen</span></label>
                  </div>
                </div>
              </div>
              </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
              </div>
            </form> 
          </div><!--/Fin Formulario Ingreso -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.Main content -->
</div><!-- /.Content-wrapper -->
<!--Fin Contenido-->  
<?php
}
else
{
  require 'noacceso500.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/empresa.js"></script>
<?php 
}
ob_end_flush();
?>