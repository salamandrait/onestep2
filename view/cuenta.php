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
if ($_SESSION['cuenta']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Cuentas Bancarias </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <!-- <div class="box-tools pull-right"></div> -->
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="nd text-center" style="width:70px">Opciones</th>
                    <th class="text-center" style="width:120px">Código</th>
                    <th>Descripción</th>
                    <th style="text-align:center; width:200px;">Número</th>
                    <th style="text-align:center; width:100px;">Banco</th>
                    <th style="text-align:center; width:130px;" class="nd">Saldo</th>
                    <th class="nd text-center" style="width:70px">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12 no-padr">
                    <label for="cod_cuenta">Codigo:</label>
                    <input type="hidden" name="idcuenta" id="idcuenta">
                    <input type="textc" name="cod_cuenta" id="cod_cuenta" class="form-control" 
                    placeholder="Codigo" required="required">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12 no-padlr">
                    <label> Tipo de Cuenta:</label>
                    <select class="form-control" name="tipo" id="tipo">
                      <option value="Corriente">Corriente</option>
                      <option value="Ahorro">Ahorro</option>
                      <option value="Palzo Fijo">Palzo Fijo</option>
                      <option value="Credito">Credito</option>
                      <option value="Otros">Otros</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padlr">
                    <label> Descripción:</label>
                    <input text class="form-control" name="desc_cuenta" id="desc_cuenta" 
                    maxlength="250" placeholder="Descripción" required="required">
                  </div>
                  <div class="form-group date col-lg-2 col-md-2 col-sm-12 col-xs-12  no-padl">
                    <label> Fecha de Registro:</label>
                    <div class="input-group datetime">
                      <input type="text" class="form-control ffechareg" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12 no-padr">
                    <div class="input-group">
                      <span class="input-group-addon"><label for="idbanco">Banco</label></span>     
                      <input type="text" name="cod_banco" id="cod_banco" class="form-control" placeholder="Cod. Banco" readonly>
                    </div>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padlr">
                    <select name="idbanco" id="idbanco" class="form-control" required="required" ></select>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12 no-padlr">
                    <input type="text" name="cod_moneda" id="cod_moneda" class="form-control" placeholder="Moneda" readonly required>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 no-padl">
                    <input type="text" class="form-control" name="numcuenta" id="numcuenta" placeholder="Numero de Cuenta" required>
                  </div>
                  <div class="form-group col-lg-11 col-md-11 col-sm-12 col-xs-12 no-padlr">
                    <div class="box box-solid">
                      <ul class="nav nav-tabs nav-pills nav-justified no-padlr">  
                        <li class="active"><a data-toggle="tab" href="#tabagencia"><B> Agencia</B></a></li>
                        <li><a data-toggle="tab" href="#tabsaldo"><B> Saldos</B></a></li>
                      </ul>
                      <div class="tab-content tab-pane">   
                        <!-- Agencia -->
                        <div class="form-group col-12 tab-pane fade in active" id="tabagencia">
                          <div class="box-body bg-blue-sky">
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="ejecutivo" id="ejecutivo" placeholder="Ejecutivo">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="agencia" id="agencia" placeholder="Agencia">
                          </div>
                          <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion">
                          </div>
                        </div>          
                        </div>
                        <!-- Saldos -->
                        <div class="form-group col-12 tab-pane fade" id="tabsaldo">
                        <div class="box-body">
                          <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label>Debe:</label>
                            <input type="text" class="form-control numberf" name="saldod" id="saldod" 
                            placeholder="0.00" style="text-align:right;" readonly>
                          </div>
                          <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label>Haber:</label>
                            <input type="text" class="form-control numberf" name="saldoh" id="saldoh" 
                            placeholder="0.00" style="text-align:right;" readonly>
                          </div>
                          <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label>Saldo:</label>
                            <input type="text" class="form-control numberf" name="saldot" id="saldot" 
                            placeholder="0.00" style="text-align:right;" readonly>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          </div>
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
<script type="text/javascript" src="scripts/cuenta.js"></script>
<?php 
}
ob_end_flush();
?>