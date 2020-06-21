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
if ($_SESSION['fcompra']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Factura de Compra </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center nd" style="width:120px">Opciones</th>
                    <th class=" text-center" style="width:90px">F.Emisión</th>
                    <th class=" text-center" style="width:100px">Código</th>
                    <th class=" text-center" style="width:350px">Proveedor</th>
                    <th class=" text-center" style="width:100px">Rif</th>
                    <th class=" text-center" style="width:100px">Factura N°</th>
                    <th class=" text-center" style="width:100px">N° Ctrl.</th>
                    <th class=" text-center" style="width:130px">Total</th>
                    <th class="nd text-center" style="width:100px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_compra">Código:</label>
                    <b><input type="textc" name="cod_compra" id="cod_compra" class="form-control" 
                    placeholder="Código" required="required" readonly></b>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Origen:</label>
                    <B><input type="text" name="origend" id="origend" class="form-control" readonly></B>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Origen N°:</label>
                    <B><input type="text" name="origenc" id="origenc" class="form-control" readonly></B>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Fecha de Registro:</label>
                    <div class="input-group">
                      <input type="text" name="fechareg" id="fechareg" class="form-control ffechareg ctrl" disabled="disabled">
                      <div class="input-group-addon"><span class="fa fa-calendar"></span></div>  
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Fecha de Venc.:</label>
                    <div class="input-group">
                      <input type="text" name="fechaven" id="fechaven" class="form-control ffechareg ctrl" disabled="disabled">
                      <div class="input-group-addon"><span class="fa fa-calendar"></span></div>  
                    </div>
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <input type="text" class="form-control ctrl" name="desc_proveedor" id="desc_proveedor" 
                    maxlength="250" placeholder="Proveedor" disabled="disabled">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="cod_proveedor" id="cod_proveedor" class="form-control" 
                    placeholder="Código" readonly>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="rif" id="rif" class="form-control" 
                    placeholder="Rif" readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">
                    <select name="selectcondpago" id="selectcondpago" class="form-control" disabled="disabled">
                    </select>
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="numerod" id="numerod" class="form-control iop" 
                    placeholder="N° de Factura" required="required" readonly>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="numeroc" id="numeroc" class="form-control iop" 
                    placeholder="N° de Control" readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8">
                    <div class="input-group">
                      <span class="input-group-addon"><label>Estado:</label></span>
                      <B><input type="text" name="estatus" id="estatus" class="form-control" readonly></B>
                    </div>  
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon"><label> Depósito:</label></span>
                      <select name="iddeposito" id="iddeposito" class="form-control" disabled></select>
                    </div>  
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <input text class="form-control iop" name="desc_compra" id="desc_compra" 
                    maxlength="250" placeholder="Descripción" readonly>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">      
                    <button type="button" class="btn btn-sm btn-block btn-primary" id="btnAgregar_item" disabled>
                    <i class="fa fa-truck"></i><B> Agregar Item</B></button>
                  </div>         
                  <div class="panel-body table-responsive" style="padding:0px 15px 0px 15px;">
                      <table id="tbdetalles" class="table compact table-striped table-bordered table-condensed table-hover table-responsive" style="width:100%;">
                        <thead class="bg-blue-active">
                          <th style="text-align:center; width:30px;" class="nd">R</th>
                          <th style="text-align:center; width:120px;" class="nd">Código</th>
                          <th style="text-align:center; width:400px;" class="nd">Artículo</th>
                          <th style="text-align:center; width:90px;" class="nd">Unidad</th>
                          <th style="text-align:right; width:80px;" class="nd">Cant.</th>
                          <th style="text-align:right; width:120px;" class="nd">Costo Und</th>
                          <th style="text-align:right; width:130px;" class="nd">Sub Total</th>
                          <th style="text-align:right; width:130px;" class="nd">Imp.</th>
                          <th style="text-align:right; width:140px;" class="nd">Total Reng.</th>
                        </thead>
                      </table>
                  </div>
                  <div class="panel-body">
                      <table class="table compact table-striped table-bordered table-condensed" style="border-collapse:collapse">
                        <thead class="bg-gray-active">
                          <th style="width:600px"><h4 style="text-align:right;">Sub Total <span id="lbcod_monedas"></span></h4></th>
                          <th><h4 style="text-align:right;">I.V.A. 16% <span id="lbcod_monedai"></span></h4></th>
                          <th><h4 style="text-align:right;">Total <span id="lbcod_monedat"></span></h4></th>  
                        </thead>
                        <tfoot>
                          <th style="width:600px"><B><span class="pull-left"><h4>Totales:</h4></span></B><h4 style="text-align:right;"><span id="subtotalt" class="numberf"></span></h4></th>
                          <th><h4 style="text-align:right;"><span id="impuestot" class="numberf"></span></h4></th>
                          <th><h4 style="text-align:right;"><B><span id="totalt" class="numberf"></span></B></h4></th> 
                        </tfoot>
                      </table>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="control" name="idcompra" id="idcompra" class="hidden">
                    <input type="control" name="idcompraop" id="idcompraop" class="hidden">
                    <input type="control" name="idproveedor" id="idproveedor" class="hidden">
                    <input type="control" name="idcondpago" id="idcondpago" class="hidden">
                    <input type="controln" name="subtotalh" id="subtotalh" class="hidden">
                    <input type="controln" name="impuestoh" id="impuestoh" class="hidden">
                    <input type="controln" name="totalh" id="totalh" class="hidden">
                    <input type="controln" name="saldoh" id="saldoh" class="hidden"> 
                    <input type="control" name="limite" id="limite" class="hidden">
                    <input type="control" name="dias" id="dias" class="hidden">
                    <input type="hidden" id="idusuario" name="idusuario" value=<?php echo $_SESSION['idusuario'];?> class="hidden">
                    <input type="hidden" name="tipo" id="tipo" value="Factura" class="hidden">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                    <button class="btn btn-danger btn-sm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    <button class="btn btn-success btn-sm" type="button" id="btnImportar" disabled><i class="fa fa-arrow-circle-down"></i> Importar</button>
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
require 'compramodal.php';
}
else
{
  require 'noacceso500.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/compra.js"></script>
<?php 
}
ob_end_flush();
?>