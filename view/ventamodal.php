<?php
?>
<div class="modal fade" id="ModalNuevoCliente" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:60%">
    <div class="box box-success">
      <div class="modal-content" style="border-radius:5px">
        <div class="modal-header" style="padding-bottom:0px">
          <h4 class="modal-title"> Nuevo Cliente </h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered compactb table-condensed" style="width:100%; margin-bottom:4px">
            <thead class="bg-primary">
              <tr>
                <th style="text-align:center; width:80px;" class="nd">Código</th>
                <th style="text-align:center; width:80px;" class="nd">Rif</th>
                <th style="text-align:center; width:350px;" class="nd">Descripción</th>
              </tr>
            </thead>
            <tbody>
            <form method="POST" id="formcliente">
              <tr>  
                <td style="width:80px;" class="no-padding">
                <input type="text" id="cod_clientea" name="cod_clientea" class="form-control input_tab no-padding control" style="padding:5px !important"></td>
                <td style="width:80px;" class="no-padding">
                <input type="text" id="rifa" name="rifa" class="form-control input_tab no-padding control" style="padding:5px !important"></td>
                <td style="width:350px;" class="no-padding">
                <input type="text" id="desc_clientea" name="desc_clientea" class="form-control input_tab no-padding control" style="padding:5px !important"></td>
              </tr>
            </form>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" id="btnGuardarP"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
          <button type="button" class="btn btn-danger btn-sm" id="btnCerrarP"><i class="fa fa-arrow-circle-up"></i> Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:65%">
    <div class="box bg-gray-active">
      <div class="modal-content" style="border-radius:5px">
        <div class="modal-header" style="padding-bottom:0px">
          <h4 class="modal-title"> Seleccionar Cliente 
          <button type="button" id="btnNuevoCliente" class="btn btn-sm btn-primary pull-right">
          Nuevo Cliente <i class="glyphicon glyphicon-user"></i></button></h4>
        </div>
        <div class="modal-body" style="padding:3px 5px;">
          <table id="tbcliente" class="table compact table-bordered table-condensed table-hover table-dark table-responsive table-primary"           
          style="padding:0px; margin-bottom:2px; width:100%;">
            <thead class="bg-gray-active">
              <th style="text-align:center;" class="nd">Add</th>
              <th style="text-align:center;">Código</th>
              <th style="text-align:center;">Descripción</th>
              <th style="text-align:center;">Rif</th>
              <th style="text-align:center;" class="nd">Cond. Pago</th>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalCrearArticulo" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:70%">
    <div class="box box-primary">
        <div class="modal-header" style="padding-bottom:0px">
          <h4 class="modal-title"> Seleccionar Artículos</h4>
        </div>
        <div class="panel-body">
          <table class="table table-bordered compactb table-condensed" style="width:100%; margin-bottom:4px">
            <thead class="bg-primary">
              <tr>
                <th style="text-align:center; width:120px;" class="nd">Código</th>
                <th style="text-align:center; width:250px;">Artículo</th>
                <th style="text-align:center; width:80px;" class="nd">Unidad</th>
                <th style="text-align:center; width:80px;" class="nd">T.Precio</th>
                <th style="text-align:center; width:120px;" class="nd">Precio</th>
                <th style="text-align:center; width:80px;" class="nd">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:120px;" class="no-padding">
                <input type="text" id="cod_articulom" class="form-control input_tab no-padding control">
                </td>
                <td style="width:250px;" class="no-padding">
                <input type="text" id="desc_articulom" class="form-control input_tab no-padding control">
                </td>
                <td style="width:80px;" class="no-padding">
                <select id="idartunidad" class="form-control control input_tab no-padding"></select>
                </td>
                <td style="width:80px;" class="no-padding">
                <select id="tipoprecio" class="form-control control input_tab no-padding">
                  <option value="p1">Precio 1</option>
                  <option value="p2">Precio 2</option>
                  <option value="p3">Precio 3</option>
                </select>
                </td>
                <td style="width:120px;" class="no-padding">
                <input type="text" id="preciom" class="form-control input_tab no-padding text-right control">
                </td>
                <td style="width:80px;" class="no-padding">
                <input type="text" name="cantidadm" id="cantidadm" class="form-control input_tab text-right control" style="padding:0px 4px !important;">
                </td>
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
            <input type="text" id="stockval" class="control">
            <input type="text" id="tipom" class="control">
            <input type="text" id="tasam" class="control">
            <input type="text" id="dispm" class="control">
            <input type="text" id="idarticulom" class="control">
            <input type="text" id="iddepositom" class="control">
            <input type="text" id="desc_unidad" class="control">
            <input type="text" id="valorund" class="control">
          </div>
      </div>
      <div class="modal-footer" style="padding:6px">
        <button type="button" class="btn btn-primary btn-sm" id="btnAceptarM">Aceptar</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="btnCancelarM">Cancelar</button>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="ModalArticulo" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:68%">
    <div class="box box-primary">
      <div class="modal-header" style="padding-bottom:0px">
        <h4 class="modal-title"> Seleccionar Artículos</h4>
      </div>
      <div class="panel-body table-responsive">
        <table id="tbarticulos" class="table compact table-bordered table-condensed table-hover table-responsive" style="width:100%">
           <thead class="btn-primary">
            <th style="text-align:center;" class="nd">Add</th>
            <th style="text-align:center;">Cod. Artículo</th>
            <th style="text-align:center;">Descripción</th>
            <th style="text-align:center;">Referencia</th>
            <th style="text-align:center;" class="nd">Stock</th>
          </thead>
        </table>
      </div>
      <div class="modal-footer" style="padding:6px">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="ModalImportar" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:65%">
    <div class="box box-primary">
      <div class="modal-header" style="padding-bottom:0px">
        <h4 class="modal-title"> Importar Documentos</h4>
        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
          </div>
          <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12  pull-right">
            <div class="input-group">
              <span class="input-group-addon"><label> Importar Desde:</label></span>
              <select name="tipodoc" id="tipodoc" class="form-control">
                <option value="Cotizacion">Cotización</option>
                <option value="Pedido">Pedido</option>
                <option value="Factura">Factura</option>
              </select>
            </div>  
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><label> Estado:</label></span>
              <select name="estatusdoc" id="estatusdoc" class="form-control">
                <option selected="selected" value="sinp">Sin Procesar</option>
                <option value="todos">Todos</option>
              </select>
            </div>  
          </div>
      </div>  
      <div class="panel-body table-responsive">
        <table id="tbdocumento" class="table compact table-bordered table-condensed table-hover" style="width:100%;">
          <thead class="bg-blue">
            <th style="text-align:center; width:25px;" class="nd">Add</th>
            <th style="text-align:center; width:80px;" class="nd">Emisión</th>
            <th style="text-align:center; width:110px;" class="nd">Estado</th>
            <th style="text-align:center; width:100px;" class="nd">Código</th>
            <th style="text-align:center; width:400px;" class="nd">Cliente</th>
            <th style="text-align:center; width:95px;" class="nd">Rif</th>
            <th style="text-align:center; width:100px;" class="nd">N° Doc.</th>
            <th style="text-align:center; width:150px;" class="nd">Monto</th>
          </thead>
        </table>
      </div>
      <div class="modal-footer" style="padding:10px;">
        <button type="button" class="btn btn-danger btn-sm" id="btnCerrarImpDoc">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php
?>