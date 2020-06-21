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
if ($_SESSION['articulo']==1)
{
?>
<!--Contenido-->
<div class="content-wrapper">
   <section  class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">

               <div class="box-header with-border box-primary"><!-- box header-->
                  <h1 class="box-title"> Artículo </h1><br>
                  <button class="btn btn-success btn-sm ocultar" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                  <a id="rep">
                  <button class="btn btn-primary btn-sm ocultar" id="btnReporte" ><i class="fa fa-print"></i> Reporte</button></a>
                  <div class="box-tools pull-right"></div>
               </div><!-- /.box header-->
                  <!-- centro Listado de Registros -->
              <div class="panel-body table-responsive hidden" id="listadoregistros">
                <table id="tblistado" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100% !important;">
                  <thead class="bg-gray-active">
                  <th style="width:150px;" class="text-center nd">Opciones</th>
                  <th style="width:150px;" class="text-center">Codigo</th>
                  <th style="width:420px;" class="text-center">Descripción</th>
                  <th style="width:300px;" class="text-center">Categoría</th>
                  <th style="width:250px;" class="text-center nd nv">Línea</th>
                  <th style="width:150px;" class="text-center">Ref.</th>
                  <th style="width:80px; " class="text-center nd">Stock</th>
                  <th style="width:150px;" class="text-center nd nv">Costo 1</th>
                  <th style="width:150px;" class="text-center nd nv">Precio 1</th>
                  <th style="width:70px;" class="text-center nd">Estado</th>
                  </thead>
                </table>   
              </div>
              <!-- /Fin Listado de Registros -->

              <!-- Formulario Ingreso -->
              <div class="panel-body hidden" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label for="cod_articulo">Codigo:</label>
                    <input type="textc" name="cod_articulo" id="cod_articulo" class="form-control" placeholder="Codigo" required="required" >
                  </div>
                  <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label> Típo:</label>
                    <select name="tipo" id="tipo" class="form-control nice-select">
                      <option value="General"> General </option>
                      <option value="Servicio"> Servício </option>
                      <option value="Uso Interno"> Uso Interno </option>
                      <option value="Produccion"> Producción </option>
                      <option value="Otro"> Otro </option>
                    </select>
                  </div>
                  <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label> Origen:</label>
                    <select id="origen" name="origen" class="form-control nice-select">
                      <option value="Nacional">Nacional</option>
                      <option value="Importado">Importado</option>
                      <option value="Produccion">Produccion</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
                    <label> Fecha de Registro:</label>
                    <div class="input-group date">
                      <input type="textdate" class="form-control ffechareg" name="fechareg" id="fechareg">
                      <span class="input-group-addon"><span class="fa fa-calendar"></span>
                    </div>
                  </div> 
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" name="desc_articulo" id="desc_articulo" 
                    placeholder="Descripción" required="requiered">
                  </div>
                  <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span class="input-group-addon"><label> Categoría:</label></span>
                    <select name="idcategoria" id="idcategoria" class="form-control sel nice-select" required="requiered">  
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span class="input-group-addon"><label> Línea:</label></span>
                    <select name="idlinea" id="idlinea" class="form-control chosen-select" required="requiered">
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span class="input-group-addon"><label> Imp.:</label></span>
                      <select id="idimpuesto" name="idimpuesto" class="form-control nice-select">
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box bg-gray-light">
                      <ul class="nav nav-tabs nav-justified bg-gray-light">  
                        <li class="active"><a data-toggle="tab" href="#costopreciotab"><B>Costos y Precios</B></a></li>
                        <li><a data-toggle="tab" href="#tabcarat"><B>Caracteristicas</B></a></li>
                        <li><a data-toggle="tab" href="#partab"><B>Parametros Adicionales</B></a></li>
                      </ul>
                      <div class="tab-content">   
                        <!-- Costos y Precios -->
                        <div class="form-group tab-pane fade in active" id="costopreciotab"> 
                          <!-- Costos -->
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label> Costo:</label>
                              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="costo" name="costo" class="form-control numberf" style="text-align:right;">
                              </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>
                          <!-- Impuesto Costos -->
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label> Impuesto:</label>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="costoimp" name="costoimp" 
                              class="form-control numberf" style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>
                          <!-- Total Costo -->
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label> Total Costo:</label>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="tcosto" name="tcosto" 
                              class="form-control numberf" style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>  
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label style="color:#fff">T</label>
                              <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="border-color:#fff; margin-top:5px;"><label> Costo Segun Precio :</label></span>
                                <input type="checkbox" name="costoprecio" id="costoprecio" style="margin-bottom:5px">
                              </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>  
                          </div>
                          <!-- Precio Neto -->
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">       
                            <label> Precio Neto:</label>     
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Precio 1:</label></span>
                              <input type="text" id="precio1" name="precio1" class="form-control numberf" 
                              style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Precio 2:</label></span>
                              <input type="text" id="precio2" name="precio2" class="form-control numberf" 
                              placeholder="0.00" style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Precio 3:</label></span>
                              <input type="text" id="precio3" name="precio3" class="form-control numberf" 
                              placeholder="0.00" style="text-align:right;">
                            </div>
                          </div>
                          <!-- Margen de Ganancia -->
                          <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">       
                            <label> MG (%)</label>     
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="mgp1" name="mgp1" class="form-control numberf2" 
                              placeholder="0" style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="mgp2" name="mgp2" class="form-control numberf2" 
                              placeholder="0" style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="mgp3" name="mgp3" class="form-control numberf2" 
                              placeholder="0" style="text-align:right;">
                            </div>
                          </div>
                          <!-- Precop  + MG -->
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">      
                            <label> Sub Total Precios:</label>     
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Precio 1 + MG:</label></span>
                              <input type="text" id="hprecio1" name="hprecio1" 
                              class="form-control numberf" style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Precio 2 + MG:</label></span>
                              <input type="text" id="hprecio2" name="hprecio1" 
                              class="form-control numberf" style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Precio 3 + MG:</label></span>
                              <input type="text" id="hprecio3" name="hprecio3" 
                              class="form-control numberf" style="text-align:right;" readonly>
                            </div>
                          </div>
                          <!-- Impuesto -->
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">      
                            <label> Impuesto:</label>     
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="precioimp1" name="precioimp1" class="form-control numberf" 
                              placeholder="0.00" style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="precioimp2" name="precioimp2" class="form-control numberf" 
                              placeholder="0.00" style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" id="precioimp3" name="precioimp3" class="form-control numberf" 
                              placeholder="0.00" style="text-align:right;" readonly>
                            </div>
                          </div>
                          <!-- Total Precio 1 -->
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="input-group-addon"><label> Total Precio 1:</label></span>
                                <input type="text" id="tprecio1" name="tprecio1" class="form-control numberf" 
                                style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>
                          <!-- Total Precio 2 -->
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="input-group-addon"><label> Total Precio 2:</label></span>
                                <input type="text" id="tprecio2" name="tprecio2" class="form-control numberf" 
                                style="text-align:right;" readonly>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>
                          <!-- Total Precio 3 -->
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="input-group-addon"><label> Total Precio 3:</label></span>
                                <input type="text" id="tprecio3" name="tprecio3" class="form-control numberf" 
                                style="text-align:right;" readonly>
                            </div>
                          </div>           
                        </div>
                        <!-- Caracteristicas -->
                        <div class="form-group col-12 tab-pane fade" id="tabcarat">
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12"><!--/Deposito-->
                            <label> Existencia:</label>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--/Codigo de Barras-->
                            </div>       
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">           
                            </div>
                            <table id="tblListadoDep" class="table compact table-striped table-bordered table-condensed table-hover" style="width:100%">
                              <thead class="bg-gray-active">
                                <th style="width:50px; text-align:center;" class="nd">Reng</th>
                                <th style="width:200px; text-align:center;" class="nd">Deposito</th>
                                <th style="width:100px; text-align:center;" class="nd">Stock</th>
                              </thead>
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <button class="btn btn-sm btn-primary" type="button" id="btnMostrarUnidad">Unidades</button>
                            </div>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label> Tipos de Existencia:</label>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>    
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="width:130px"><label>Stock Minimo:</label></span>
                              <input type="text" id="stockmin" name="stockmin" class="form-control numberf" 
                              style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="width:130px"><label>Stock Maximo:</label></span>
                              <input type="text" id="stockmax" name="stockmax" class="form-control numberf" 
                              style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="width:130px"><label>Stock Pedido:</label></span>
                              <input type="text" id="stockped" name="stockped" class="form-control numberf" 
                              style="text-align:right;">
                            </div>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label> Parametros de Medida:</label>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div> 
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="width:120px"><label>Ancho:</label></span>
                              <input type="text" id="ancho" name="ancho" class="form-control numberf" style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"  style="width:120px"><label>Alto:</label></span>
                              <input type="text" id="alto" name="alto" class="form-control numberf" style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="width:120px"><label>Peso:</label></span>
                              <input type="text" id="peso" name="peso" class="form-control numberf" style="text-align:right;">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>
                        </div>
                        <!-- Parametros Adicionales    -->
                        <div class="form-group col-12 tab-pane fade" id="partab">
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12"><!--/Codigo de Barras-->
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Cod. Barras:</label></span>
                              <input type="textc" class="form-control" name="artref" id="artref" 
                              placeholder="Codigo de Barras" rel="tooltip" data-original-title="Codigo de Barras" maxlength="50"></div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                              <div class="btn-group" role="group">
                                <button class="btn btn-success btn-sm" type="button" onclick="generarbarcode()"><i class="fa fa-tasks"></i> Generar</button>
                                <button class="btn btn-primary btn-sm print" type="button" onclick="imprimir()"><i class="fa fa-print"></i> Imprimir</button>
                              </div>
                              <div id="print" width="20px;" height="50%"><svg id="barcode" style="width:90%;"></svg></div>    
                          </div>
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-1"> 
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="img-container">
                            <span class="imagena" id="imagenah"><label for="imagena">Cargar Imagen</label>
                              <input type="file" name="imagena" id="imagena">
                              <input type="hidden" name="imagenactual" id="imagenactual"></span>     
                              <img class="img-responsive" src="" id="imagenmuestra" style="max-width: 60%">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" id="tasa" name="tasa">
                    <input type="hidden" name="idarticulo" id="idarticulo">     
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

<div class="modal fade" id="ModalUnidad" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width:35%" role="document">
      <div class="box box-primary">
        <div class="modal-header" style="padding-bottom:0px">
          <h4 class="modal-title">  Unidades <br><span id="uarticulo"></span></h4>
        </div>
        <form id="formUnidad" method="POST">    
        <div class="panel-body col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden" id="select">
            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12 no-padding">
              <div class="input-group">
                <span class="input-group-addon"><label for="idunidad">Unidad</label></span>
                <select name="idunidad" id="idunidad" class="form-control nice-select">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 no-padding" >
              <div class="input-group">
                <span class="input-group-addon"><label for="valor">Valor:</label></span>
                <input type="text" name="valor" id="valor" class="form-control text-right">
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">   
              <input type="checkbox" name="principal" id="principal">
              <label for="principal">Unidad Principal</label>
            </div>
          </div>
          <table id="tblListadoDep2" class="table compact table-striped table-bordered table-condensed table-hover"  style="width:100%">
            <thead class="bg-gray-active">
              <th style="width:50px; text-align:center;" class="nd">Reng</th>
              <th style="width:200px; text-align:center;" class="nd">Deposito</th>
              <th style="width:100px; text-align:center;" class="nd">Stock</th>
            </thead>
          </table>
          <table id="tbartlistado" class="table compact table-striped table-bordered 
          table-condensed table-hover"  style="width:100%; padding:0px 0px 0px 5px">
            <thead class="bg-gray-active">
              <th style="width:90px; text-align:center;">Opción</th>
              <th style="text-align:center;">Descripción</th>
              <th style="width:60px; text-align:center;">Valor</th>
              <th style="width:100px; text-align:center;">Principal</th>
            </thead>
          </table>            
        </div>
        <div class="panel-body no-pad-top">
          <button id="btnNuevo" type="button" class="btn btn-success btn-sm" data-toggle="modal">Agregar</button>
          <button id="btnCancelarU" type="button" class="btn btn-danger btn-sm" disabled>Cancelar</button>
          <button id="btnGuardarU" type="submit" class="btn btn-primary btn-sm" disabled>Guardar</button>
        </div>
        <div class="modal-footer" style="padding:6px;">
          <button id="btnCerrarU" type="button" class="btn btn-info btn-sm" data-dismiss="modal">Cerrar</button>
          <input type="hidden" id="idarticulou" name="idarticulou">
          <input type="hidden" id="idartunidad" name="idartunidad">
        </form>
        </div>
      </div>
    </div>
</div>

<div class="ui-dialog modal fade" id="ModalPrecio" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width:30%">
      <div class="box box-success">
        <div class="modal-header" style="padding-bottom:0px">
          <h4 class="modal-title">Costos y Precios  <br><span id="particulo"></span></h4>
        </div>
        <div class="modal-body">   
          <div class="panel-body">

            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon" style="padding-right:25px;"><label> Total Costo:</label></span>
                <input type="text" id="tcostom" class="form-control numberf" style="text-align:right;" readonly="">
              </div>   
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><label> Total Precio 1:</label></span>
                <input type="text" id="tprecio1m" class="form-control numberf" style="text-align:right;" readonly="">
              </div>   
            </div>
              
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><label> Total Precio 2:</label></span>
                <input type="text" id="tprecio2m" class="form-control numberf" style="text-align:right;" readonly="">
              </div>   
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><label> Total Precio 3:</label></span>
                <input type="text" id="tprecio3m" class="form-control numberf" style="text-align:right;" readonly="">
              </div>   
            </div>

          </div>
        </div>
        <div class="modal-footer" style="padding:6px;">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/articulo.js"></script>
<?php 
}
ob_end_flush();
?>