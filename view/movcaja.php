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
if ($_SESSION['movcaja']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Movimiento de Caja </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="text-center nd" style="width:110px;">Opciones</th>
                    <th class="text-center" style="width:90px;">Fecha</th>
                    <th class="text-center" style="width:100px;">Código</th>
                    <th class="text-center" style="width:200px;">Caja</th>
                    <th class="text-center" style="width:80px;">Tipo</th>
                    <th class="text-center" style="width:80px;">Forma</th>
                    <th class="text-center nd" style="width:150px;">Monto</th>
                    <th class="text-center" style="width:120px;">Doc. N°</th>
                    <th class="text-center" style="width:120px;">Doc.Banco N°</th> 
                    <th class="text-center nd" style="width:100px;">Estatus</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_movcaja">Codigo:</label>
                    <input type="textc" name="cod_movcaja" id="cod_movcaja" class="form-control" 
                    placeholder="Codigo" readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label> Origen:</label>
                    <B><input type="text" class="form-control" name="origen" id="origen" placeholder="Origen" readonly></B>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-8 no-padl">
                    <label> Estatus:</label>
                    <B><input type="text" class="form-control" name="estatus" id="estatus" readonly placeholder="Estatus"></B>
                  </div>
                  <div class="form-group date col-lg-2 col-md-2 col-sm-8 col-xs-8 no-pad0lr">
                    <label> Fecha de Registro:</label>
                    <div class="input-group date">
                      <input type="text" class="form-control ffecha ctrl" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" name="cod_caja" id="cod_caja" placeholder="Cod. Caja" readonly data-live-search="true">
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12 no-pad0l">   
                    <select class="form-control ctrl" name="idcaja" id="idcaja" placeholder="Desc. Caja" data-live-search="true">
                    </select>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12 no-padl">
                    <div class="input-group">
                      <span class="input-group-addon padding-div">
                      <label>Forma:</label></span>
                      <select id="forma" name="forma" class="form-control ctrl">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Tarjeta">Tarjeta</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8 no-pad0lr">
                    <div class="input-group">
                      <span class="input-group-addon padding-div"><label>Tipo:</label></span>
                      <select id="tipo" name="tipo" class="form-control ctrl">
                        <option value="Ingreso">Ingreso</option>
                        <option value="Egreso">Egreso</option>
                    </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" > 
                    <input type="text" class="form-control" name="cod_banco" id="cod_banco"
                    placeholder="Cod. Banco" readonly>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 no-pad0l"> 
                    <select class="form-control" name="idbanco" id="idbanco" placeholder="Banco" disabled>
                    </select>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8 no-pad0lr">
                    <input type="text" name="numeroc" id="numeroc" class="form-control opi" placeholder="N° Documento de Banco" disabled>
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon"><label>Tipo Operacion:</label></span>
                    <select id="idoperacion" name="idoperacion" class="form-control ctrl" data-live-serach="true">
                    </select>
                  </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="text" name="numerod" id="numerod" class="form-control opi" placeholder="N° de Operacion" 
                    required rel="tooltip" data-original-title="Campo Obligatorio">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 no-pad0lr">
                    <div class="input-group">
                      <span class="input-group-addon"><label> Monto:</label></span>
                      <input type="text" class="form-control numberf opi" name="monto" id="monto" style="text-align:right" required="required">
                    </div>
                  </div>
                  <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <input type="text" name="desc_movcaja" id="desc_movcaja" class="form-control opi" 
                    maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-check form-check-inline col-lg-2 col-md-2 col-sm-4 col-xs-4">    
                    <input type="checkbox" id="saldoinicial" name="saldoinicial" class="form-check-input ctrl">
                    <label class="form-check-label" for="saldoinicial"> Es Saldo Inicial</label>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input name="saldototal" id="saldototal" type="hidden">
                    <input name="montod" id="montod" type="hidden">
                    <input name="montoh" id="montoh" type="hidden">
                    <input name="idmovcaja" type="hidden">
                    <input name="idusuario" id="idusuario" value=<?php echo $_SESSION['idusuario'];?> type="hidden">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar" style="width: 10%;"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                    <button class="btn btn-success btn-sm" type="button" id="btnEditar" style="width: 10%;"><i class="fa fa-edit"></i> Editar</button>
                    <button class="btn btn-danger btn-sm" type="button" id="btnCancelar" style="width: 10%;"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script type="text/javascript" src="scripts/movcaja.js"></script>
<?php 
}
ob_end_flush();
?>