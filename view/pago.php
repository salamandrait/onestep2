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
if ($_SESSION['ccompra']==1)
{
?>
<!-- Contenido-->
<div class="content-wrapper">
  <section  class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">

          <div class="box-header with-border box-primary"><!-- box header-->
            <h1 class="box-title"> Registro de Pagos </h1><br>
              <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
              <a id="rep">
              <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
              <div class="box-tools pull-right"></div>
          </div><!-- /.box header-->
          
          <div class="panel-body table-responsive hidden" id="listadoregistros">
            <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
              <thead class="bg-gray-active">
                <th class="nd text-center" style="width:90px;">Opciones</th>
                <th class="text-center" style="width:80px;">Fecha</th>
                <th class="text-center" style="width:80px;">Código</th>
                <th class="text-center" style="width:120px;">Tipo</th>
                <th class="text-center" style="width:350px;">Proveedor</th>
                <th class="text-center" style="width:100px;">Rif</th>
                <th class="text-center" style="width:150px;">Total</th>
                <th class="nd text-center" style="width:100px">Estado</th>
              </thead>
            </table>   
          </div>

          <div class="panel-body hidden" id="formularioregistros">
            <form name="formulario" id="formulario" method="POST">
              <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                <label>Código:</label>
                <input type="textc" name="cod_pago" id="cod_pago" class="form-control" 
                placeholder="Codigo" style="font-weight:bold;" readonly required>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <label>Estado:</label>
                <input type="text" name="estatus" id="estatus" class="form-control" style="font-weight:bold;" readonly>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <label>Origen:</label>
                <input type="text" name="origend" id="origend" class="form-control" style="font-weight:bold;" readonly>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <label>Origen N°:</label>
                <input type="text" name="origenc" id="origenc" class="form-control" style="font-weight:bold;" readonly>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <label>Fecha de Registro:</label>
                <div class="input-group date">
                  <input type="text" name="fechareg" id="fechareg" class="form-control ffechareg ctrl">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                </div>
              </div>
              <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <input type="text" name="desc_proveedor" id="desc_proveedor" class="form-control ctrl" placeholder="Proveedor" disabled readonly>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <input type="text" name="rif" id="rif" class="form-control" placeholder="Rif" readonly>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <input type="text" name="cod_proveedor" id="cod_proveedor" class="form-control" placeholder="Cod. Proveedor" readonly>
              </div>
              <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <input type="text" name="desc_pago" id="desc_pago" class="form-control" placeholder="Descripción" readonly>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" id="btnDocumentos" class="btn btn-primary pull-right" disabled>Documentos <i class="glyphicon glyphicon-open-file"></i> </button>
              </div>
              <div class="panel-body col-lg-9 col-md-9 col-sm-12 col-xs-12" style="padding: 1px 15px 1px 15px;">
                <table class="table compact table-striped table-bordered table-condensed table-hover table-responsive">
                  <thead class="bg-blue-active">
                    <th style="text-align:center;" class="nd">Código Op.</th>
                    <th style="text-align:right;" class="nd">Fecha R.</th>
                    <th style="text-align:right;" class="nd">Fecha V.</th>
                    <th style="text-align:center;" class="nd">Tipo</th>
                    <th style="text-align:center;" class="nd">Numero Op.</th>
                    <th style="text-align:center;" class="nd">N° Control</th>
                  </thead>
                  <tbody>
                    <tr>
                    <td class="no-padding"><h5 id="cod_compra" class="control" name="cod_compra" style="width:120px; padding-left:3px" readonly></td>
                    <td class="no-padding"><h5 id="fecharegp" class="control" name="fecharegp" style="width:100px; padding-left:3px" readonly></td>        
                    <td class="no-padding"><h5 id="fechaven" class="control" name="fechaven" style="width:100px; padding-left:3px" readonly></td>
                    <td class="no-padding"><h5 id="optipo" class="control" name="optipo" style="width:80px; padding-left:3px" readonly></td> 
                    <td class="no-padding"><h5 id="numerod" class="control" name="numerod" style="width:120px; padding-left:3px" readonly></td>   
                    <td class="no-padding"><h5 id="numeroc" class="control" name="numeroc" style="width:120px; padding-left:3px" readonly></td>        
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="padding:4px 6px;"><label> Pagar desde:</label></span>
                  <select name="tipopago" id="tipopago" class="form-control ctrl">
                    <option value="Banco">Banco</option>
                    <option value="Caja">Caja</option>
                  </select>
                </div>
              </div> 
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin">
              </div> 
              <div class="panel-body table-responsive" style="padding: 1px 15px 1px 15px;">
                <table class="table compact table-striped table-bordered table-condensed table-hover table-responsive">
                  <thead class="bg-blue-active">
                    <th style="text-align:right;" class="nd">Sub. Total</th>
                    <th style="text-align:right;" class="nd">Impuesto</th>
                    <th style="text-align:right;" class="nd">Total</th>
                    <th style="text-align:right;" class="nd">Abono</th>
                    <th style="text-align:right;" class="nd">Saldo</th>
                  </thead>
                  <tbody>
                    <tr>
                    <td class="no-padding"><input type="controln" id="subtotalop" name="subtotalop" class="form-control input_tab control text-right numberf" readonly></td>
                    <td class="no-padding"><input type="controln" id="impuestoh" name="impuestoh" class="form-control input_tab control text-right numberf" readonly></td>
                    <td class="no-padding"><input type="controln" id="totalop" name="totalop" class="form-control input_tab control text-right numberf" readonly></td>
                    <td class="no-padding"><input type="controln" id="montov" name="montov" class="form-control input_tab control text-right numberf">
                    <button class="btn btn-xs btn-success input-addon tot" type="button">Total</button></td>
                    <td class="no-padding"><input type="controln" id="saldoh" name="saldoh" class="form-control input_tab control text-right numberf" readonly></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="checkbox-inline"><input type="checkbox" id="retenciona" name="retenciona" 
                class="text-center control checkbox-inline" readonly>
                <label for="retenciona">Retencion de I.V.A.</label></div>
                <button class="btn bg-blue-active btn-sm" type="button" id="btnRetencionA">
                  <i class="fa fa-file-archive-o"></i> Ret. de I.V.A.</button>
              </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="checkbox-inline"><input type="checkbox" id="retencionb" name="retencionb" 
                class="text-center control checkbox-inline" readonly><label for="retencionb">Retencion de I.S.L.R.</label></div>
                <button class="btn bg-blue-active btn-sm" type="button" id="btnRetencionB">
                  <i class="fa fa-file-archive-o"></i> Ret. I.S.L.R </button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="movbanco">
                <div class="box box-primary no-padding collapsed-box">
                  <div class="box-header with-border">
                    <h3 class="box-title"> Detalles del Pago </h3>
                    <div class="box-tools pull-right">  
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12 no-padding">
                      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padding">
                        <div class="input-group">
                          <span class=" input-group-addon">
                          <label>Cuenta:</label></span>         
                          <input type="text" name="cod_cuenta" id="cod_cuenta" class="form-control" placeholder="Cod. Cuenta" readonly>
                        </div> 
                      </div>
                      <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12 no-padding">
                        <select name="selectcuenta" id="selectcuenta" class="form-control" disabled>
                        </select>
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 no-padding">
                        <div class="input-group">
                          <span class=" input-group-addon" style="padding:4px 4px;">
                          <label>Mov.Banco:</label></span>         
                          <B><input type="textc" name="cod_movbanco" id="cod_movbanco" class="form-control" readonly></B>
                        </div> 
                      </div>
                      <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8 no-padding">
                        <input type="text" name="cod_banco" id="cod_banco" class="form-control" placeholder="Cod. Banco" readonly>
                      </div>
                      <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8 no-padding">
                        <input type="text" name="numcuenta" id="numcuenta" class="form-control" placeholder="N° de Cuenta" readonly>
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-8 col-xs-8 no-padding">
                        <div class=" input-group">
                          <input type="text" name="fecharegb" id="fecharegb" class="form-control ffechareg ctrl">
                          <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                      <div class="input-group">
                        <span class="input-group-addon"><label>Forma de Págo:</label></span>
                        <select id="tipoban" name="tipoban" class="form-control ctrl">
                          <option value="TNEG">Transferencia</option>
                          <option value="CHEQ">Cheque</option>
                        </select>
                      </div>
                      <div class="form-group">
                      </div>
                      <div class="input-group">
                        <span class=" input-group-addon" style="padding:4px 12px;">
                        <label>N° Documento:</label></span>         
                        <input type="text" name="numerocb" id="numerocb" class="form-control"  placeholder="N° de Documento" readonly>
                      </div>
                      <div class="form-group">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" style="padding:4px 16px;">
                        <label>N° Operación:</label></span>
                        <b><input id="numerodb" name="numerodb" class="form-control" placeholder="N° de Operación" readonly></b>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="movcaja">
                <div class="box box-success no-padding">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detalles del Pago</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12 no-padding">
                      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padding">
                        <div class="input-group">
                          <span class=" input-group-addon">
                          <label>Caja:</label></span>         
                          <input type="text" name="cod_caja" id="cod_caja" class="form-control" placeholder="Cod. Caja" readonly>
                        </div> 
                      </div>
                      <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12 no-padding">
                        <select name="selectcaja" id="selectcaja" class="form-control" disabled>
                        </select>
                      </div>
                      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 no-padding">
                        <div class="input-group">
                          <span class=" input-group-addon" style="padding:4px 5px;">
                          <label>Mov. Caja:</label></span>         
                          <B><input type="textc" name="cod_movcaja" id="cod_movcaja" class="form-control" readonly></B>
                        </div> 
                      </div>
                      <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding">
                        <div class=" input-group">
                          <span class="input-group-addon" style="padding:4px 5px;"><label> Fecha Reg.:</label></span>      
                          <input type="text" name="fecharegc" id="fecharegc" class="form-control ffechareg ctrl">
                          <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding">
                      <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">  
                        <div class="input-group">
                          <span class="input-group-addon" style="padding:4px 3px;">
                          <label>N° de Operación:</label></span>
                          <b><input id="numerodc" name="numerodc" class="form-control" placeholder="N° de Operación" readonly></b>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- Botones Guardar Editar -->
                <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
                <button class="btn btn-danger btn-sm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="control" name="idpago" id="idpago">
                <input type="control" name="tipo" id="tipo" value="Pago">
                <input type="control" name="idcompra" id="idcompra">
                <input type="controln" name="saldov" id="saldov">
                <input type="controln" name="totalh" id="totalh">
                <input type="controln" name="montoh" id="montoh">
                <input type="control" name="idproveedor"" id="idproveedor">
                <input type="control" name="idmovbanco" id="idmovbanco">
                <input type="control" name="idcaja" id="idcaja">
                <input type="control" name="idcuenta" id="idcuenta">
                <input type="control" name="idmovcaja" id="idmovcaja">
                <input type="controln" name="saldodisponible" id="saldodisponible">
                <input type="control" id="idoperacion" name="idoperacion">
                <input type="text" class="numberf">
                <input type="" id="idusuario" name="idusuario" value=<?php echo $_SESSION['idusuario'];?>>
              </div>

            </form>
          </div>

        </div>
      </div> 
    </div> 
  </section>              <!-- centro Listado de Registros -->
</div>

<div class="modal fade" id="ModalProveedor" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:60%">
    <div class="modal-content" style="border-radius:5px">
      <div class="modal-header" style="padding-bottom:0px">
        <h4 class="modal-title">Seleccional Proveedor</h4>
      </div>
      <div class="panel-body" style="padding:3px 5px;">
      <table id="tbproveedor" class="table compact table-bordered table-condensed table-hover table-responsive" 
      style="padding:0px; margin-bottom:2px; width:100%; ">
        <thead class="bg-gray-active">
          <th style="width:20px; text-align:center;" class="nd">Add</th>
          <th style="width:100px; text-align:center;">Codigo</th>
          <th style="width:320px; text-align:center;">Descripción</th>
          <th style="width:100px; text-align:center;">Rif</th>
          <th style="width:150px; text-align:right;">Saldo</th>
          </thead>
        </table>
      </div>
      <div class="modal-footer no-pad-top">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="ModalDocumento" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:65%">
    <div class="box box-primary">
      <div class="modal-header" style="padding-bottom:0px">
        <h4 class="modal-title">Seleccional Proveedor</h4>
      </div>
      <div class="panel-body" style="padding:3px 5px;">
        <table id="tbdocumento" class="table compact table-bordered table-condensed table-hover table-responsive"           
          style="padding:0px; margin-bottom:2px; width:100%; ">
            <thead class="bg-gray-active">
              <th style="text-align:center; width:15px;" class="nd">Add</th>
              <th style="text-align:center; width:80px;">Emisión</th>
              <th style="text-align:center; width:100px;">Código</th>
              <th style="text-align:center; width:80px;">Tipo</th>
              <th style="text-align:center; width:100px;">N° de Doc.</th>
              <th style="text-align:center; width:110px;">Total Neto</th>
              <th style="text-align:center; width:110px;">Abono</th>
              <th style="text-align:center; width:110px;">Saldo</th>
            </thead>
          </table>
      </div>
      <div class="modal-footer no-pad-top">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalRetencionA" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:60%">
    <div class="box box-primary">
        <div class="modal-header" style="padding-bottom:0px">
          <h4 class="modal-title"> Retencion de I.V.A.</h4>
        </div>
        <div class="panel-body">
          <table class="table table-bordered compactb table-condensed" style="width:100%; margin-bottom:4px">
            <thead class="bg-primary">
              <tr>
                <th style="text-align:center; width:150px;" class="nd">Base Imponible</th>
                <th style="text-align:center; width:150px;">Impuesto</th>
                <th style="text-align:center; width:50px;" class="nd">% de Retencion</th>
                <th style="text-align:center; width:150px;" class="nd">I.V.A. Retenido</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:150px;" class="no-padding"><input type="text" id="subtotalm" class="form-control text-right input_tab no-padding controln numberf" readonly></td>
                <td style="width:150px;" class="no-padding"><input type="text" id="impuestom" class="form-control text-right input_tab no-padding controln numberf" readonly></td>
                <td style="width:50px;" class="no-padding"><input type="text" id="montofiscalm" class="form-control text-right input_tab no-padding controln numberf" ></td>
                <td style="width:150px;" class="no-padding"><input type="text" id="montoretencion" class="form-control text-right input_tab no-padding controln numberf" readonly></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          </div>
      </div>
      <div class="modal-footer" style="padding:6px">
        <button type="button" class="btn btn-primary btn-sm" id="btnAceptarR">Aceptar</button>
        <button type="button" class="btn btn-danger btn-sm" id="btnCancelarR">Cancelar</button>
        </div>
      </div>
    </div>
  </div>  
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
<script type="text/javascript" src="scripts/pago.js"></script>
<?php 
}
ob_end_flush();
?>