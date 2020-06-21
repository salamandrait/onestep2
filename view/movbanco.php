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
if ($_SESSION['movbanco']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Movimiento de Banco </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button>
                  </a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                    <th class="text-center nd" style="width:150px">Opciones</th>
                    <th class="text-center" style="width:80px">Fecha</th>
                    <th class="text-center" style="width:100px">Código Op.</th>
                    <th class="text-center" style="width:100px">Cod Cuenta</th>
                    <th class="text-center" style="width:200px">N° de Cuenta</th>
                    <th class="text-center" style="width:140px">Tipo</th>
                    <th class="text-center" style="width:120px">N° Doc.</th>
                    <th class="text-center nd" style="width:150px">Monto</th>
                    <th class="text-center nd" style="width:100px">Estatus</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label for="cod_movbanco">Codigo:</label>
                    <input type="textc" name="cod_movbanco" id="cod_movbanco" 
                    class="form-control" placeholder="Codigo" readonly>
                  </div>
                  <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group date col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Fecha de Registro:</label>
                    <div class="input-group date">
                      <input type="text" class="form-control ffechareg ctrl" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="cod_cuenta" id="cod_cuenta" class="form-control" 
                    placeholder="Cod. Cuenta" required="required" readonly>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <select name="idcuenta" id="idcuenta" class="form-control ctrl" data-live-serach="true">
                    </select>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="text" name="numcuenta" id="numcuenta" class="form-control" placeholder="N° de Cuenta" readonly>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <B><input type="text" name="origen" id="origen" class="form-control" readonly></B>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="cod_banco" id="cod_banco" class="form-control" placeholder="Cod. Banco" readonly>
                  </div>
                  <div class="form-group col-lg-5 col-md-3 col-sm-8 col-xs-8">
                    <input type="text" name="desc_banco" id="desc_banco" class="form-control" placeholder="Descripcion" readonly>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-8">
                    <B><input type="text" class="form-control" name="estatus" id="estatus" readonly placeholder="Estatus"></B>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
                    <div class="input-group">
                      <span class="input-group-addon"><label>Tipo de Movimiento.:</label></span>
                      <select id="tipo" name="tipo" class="form-control ctrl">
                        <option value="NC">Nota de Credito</option>
                        <option value="INT">Interes</option>';
                        <option value="TPOS">Transferencia (+)</option>
                        <option value="DEP">Deposito</option>';
                        <option value="TNEG">Transferencia (-)</option>
                        <option value="CHEQ">Cheque Emitido</option>
                        <option value="ND">Nota de Debito</option>
                        <option value="ITF">Imp TF(-)</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="numerod" id="numerod" class="form-control opi" placeholder="N° de Documento" required>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <input type="text" name="numeroc" id="numeroc" class="form-control opi" placeholder="N° de Doc. Banco">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8" style="padding-left:0px">
                    <div class="input-group">
                      <span class="input-group-addon"><label>Monto:</label></span>
                      <input type="text" name="monto" id="monto" class="form-control numberf opi" placeholder="" required style="text-align:right">
                    </div>
                  </div>
                  <div class="form-group col-lg-5 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon"><label>Tipo Operacion:</label></span>
                      <select id="idoperacion" name="idoperacion" class="form-control ctrl" data-live-serach="true">
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-check form-check-inline col-lg-3 col-md-3 col-sm-4 col-xs-4">    
                    <input type="checkbox" id="saldoinicial" name="saldoinicial" class="form-check-input ctrl">
                    <label class="form-check-label" for="saldoinicial"> Es Saldo Inicial </label>
                  </div>
                  <div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-11">
                    <input type="text" name="desc_movbanco" id="desc_movbanco" class="form-control" 
                    maxlength="250" placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input name="idmovbanco" id="idmovbanco" type="hidden">
                    <input name="saldot" id="saldot" type="hidden">
                    <input name="montod" id="montod" type="hidden">
                    <input name="montoh" id="montoh" type="hidden">
                    <input name="idusuario" id="idusuario" value=<?php echo $_SESSION['idusuario'];?> type="hidden">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                    <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar" style="width: 10%;"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                    <button class="btn btn-success btn-smm" type="button" id="btnEditar" style="width: 10%;"><i class="fa fa-edit"></i> Editar</button>
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
<?php
}
else
{
  require 'noacceso500.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/movbanco.js"></script>
<?php 
}
ob_end_flush();
?>