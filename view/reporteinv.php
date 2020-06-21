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
if ($_SESSION['rinventario']==1)
{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row"><!-- row -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- col -->
        <div class="box"><!--  box -->

        <div class="box-header with-border box-primary"><!-- box header-->
          <h1 class="box-title"> Reportes de Inventario </h1>
        </div><!-- /.box header-->

          <!-- Formulario Principal -->
          <div class="panel-body">

            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group col-lg-12">
                <span class="input-group-addon"><label>Reporte:</label></span>
                <select id="tiporeporte" name="tiporeporte" class="form-control" style="padding:0px">         
                  <option value="tablas"> Tablas</option>
                  <option value="rarticulos"> Reportes de Articulos</option>
                  <option value="opinventario"> Operaciones de Inventario</option>
                  <option value="movinventario"> Movimientos de Inventario</option>
                  <option value="analisis"> Análisis de Operaciones</option>
                </select>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <select id="rtablas" name="rtablas" class="form-control hidden" style="padding:0px">
                <option value="tbarticulo"> Articulo</option>
                <option value="tbcategoria"> Categoria</option>
                <option value="tblinea"> Linea</option>
                <option value="tbunidad"> Unidad</option>
                <option value="tbdeposito"> Deposito</option>
              </select>
              <select id="rarticulos" name="rarticulos" class="form-control hidden" style="padding:0px">
                <option value="artstock"> Articulos con su Stock</option>
                <option value="artstockdep"> Articulos con su Stock por Deposito</option>
                <option value="artstockund"> Articulos con sus Unidades</option>
                <option value="artcosto"> Articulos con su Costo</option>
                <option value="artprecio"> Articulos con su Precio</option>
                <option value="artcostoprecio"> Articulos con su Costo y un Precio</option>
                <option value="valoract"> Valor Actual de Inventario</option>
                <option value="valordep"> Valor Actual de Inventario Por Almacen</option>
              </select>
              <select id="roperacion" name="roperacion" class="form-control hidden" style="padding:0px">        
                <option value="opfecha"> Operaciones de Inventario por Fecha</option>
                <option value="optipo"> Operaciones de Inventario por Tipo</option>
                <option value="resumen"> Resumen de Operaciones de Iventario</option>
              </select>
              <select id="rmovimiento" name="rmovimiento" class="form-control hidden" style="padding:0px">
                <option value="movfecha"> Movimiento de Inventario por Fecha</option>
                <option value="movarticulo"> Movimiento de Inventario por Articulo</option>
                <option value="fac"> Facturas de Compras</option>
                <option value="resume"> Resumen de Operaciones</option>
              </select>
              <select id="ranalisis" name="ranalisis" class="form-control hidden" style="padding:0px">
                <option value="cot1"> Libro de Compras</option>
                <option value="ped1"> Proveed</option>
                <option value="fac1"> Total de Operaciones</option>
                <option value="fac1"> Retenciones de I.V.A.</option>
                <option value="fac1"> Retenciones de I.S.L.R.</option>
              </select>     
            </div>

            <!-- Tablas Articulo -->
            <form id="tbform1" class="hidden tabla" method="POST" action="../reportes/rptArticulop.php" target="_blank">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Referencia:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="refa" id="refa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="refb" id="refb" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Tablas Categoria -->
            <form id="tbform2" class="hidden tabla" method="POST" action="../reportes/rptCategoriap.php" target="_blank">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm btntt" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codcategoriaa" id="codcategoriaa" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="desccategoriaa" id="desccategoriaa" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta"><i class="fa fa-sort-alpha-desc"></i> Hasta </button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codcategoriab" id="codcategoriab" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="desccategoriab" id="desccategoriab" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control env">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control env">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Tablas Linea -->
            <form id="tbform3" class="hidden tabla" method="POST" action="../reportes/rptLineap.php" target="_blank">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoría:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codlineaa" id="codlineaa" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="desclineaa" id="desclineaa" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta"><i class="fa fa-sort-alpha-desc"></i> Hasta </button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codlineab" id="codlineab" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="desclineab" id="desclineab" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl env" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control env">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control env">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Tablas Unidad -->
            <form id="tbform4" class="hidden tabla" method="POST" action="../reportes/rptUnidadp.php" target="_blank">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codunidada" id="codunidada" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descunidada" id="descunidada" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta"><i class="fa fa-sort-alpha-desc"></i> Hasta </button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codunidadb" id="codunidadb" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descunidadb" id="descunidadb" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Tablas Deposito -->
            <form id="tbform5" class="hidden tabla" method="POST" action="../reportes/rptDepositop.php" target="_blank">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="coddepositoa" id="coddepositoa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descdepositoa" id="descdepositoa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta"><i class="fa fa-sort-alpha-desc"></i> Hasta </button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="coddepositob" id="coddepositob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descdepositob" id="descdepositob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="btnHasta">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Articulos con Stock -->
            <form id="artform1" class="hidden art" method="POST" action="../reportes/rptArticuloStock.php" target="_blank" >
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Nivel de Stock:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="nivelstock" id="nivelstock" class="form-control cl" style="padding:0px">
                    <option value="diferentecero"> Stock Diferente a 0</option>
                    <option value="igualcero"> Stock Igual a 0</option>     
                    <option value="mayor"> Stock Mayor a 0</option>
                    <option value="menor"> Stock Menor a 0</option>
                    <option value="">Todos</option>     
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Articulos con Stock/Deposito -->
            <form method="POST" action="../reportes/rptArticuloStockDep.php" target="_blank" id="artform2" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Unidad:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Deposito:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Nivel de Stock:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="depa" id="depositoa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="nivelstock" id="nivelstock" class="form-control cl" style="padding:0px">
                    <option value="diferentecero"> Stock Diferente a 0</option>
                    <option value="igualcero"> Stock Igual a 0</option>     
                    <option value="mayor"> Stock Mayor a 0</option>
                    <option value="menor"> Stock Menor a 0</option>
                    <option value="">Todos</option>     
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="depb" id="depositob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Articulos sus Unidades -->
            <form method="POST" action="../reportes/rptArticuloUnd.php" target="_blank" id="artform3" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Referencia:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="refa" id="refa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="refb" id="refb" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Articulos con Su Costo-->
            <form method="POST" action="../reportes/rptArticuloCosto.php" target="_blank" id="artform4" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Referencia:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="refa" id="refa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="refb" id="refb" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Articulos con Costo y un Precio -->
            <form method="GET" action="../reportes/rptArticuloCostoPrecio.php" target="_blank" id="artform5" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Tipo de Precio:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Condicion:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="tipoprecio" id="tipoprecio" class="form-control" style="padding:0px">
                    <option value="Precio1"> Precio1</option>
                    <option value="Precio2"> Precio2</option>   
                    <option value="Precio3"> Precio3</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="condicion" id="condicion" class="form-control cl" style="padding:0px">
                    <option value="sicero"> Excluir Sólo Precio en Cero</option>
                    <option value="nocero"> Incluir Sólo Precio en Cero</option>     
                    <option value=""> Todos</option>     
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Valor del Inventario -->
            <form method="GET" action="../reportes/rptValorInventario.php" target="_blank" id="artform6" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Código:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Descripción:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoria:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Unidad:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Nivel de Stock:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticuloa" id="codarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticuloa" id="descarticuloa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="unidada" id="unidada" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="nivelstock" id="nivelstock" class="form-control cl" style="padding:0px">
                    <option value="diferentecero"> Stock Diferente a 0</option>
                    <option value="igualcero"> Stock Igual a 0</option>     
                    <option value="mayor"> Stock Mayor a 0</option>
                    <option value="menor"> Stock Menor a 0</option>
                    <option value="">Todos</option>     
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="codarticulob" id="codarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="descarticulob" id="descarticulob" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="unidadb" id="unidadb" class="form-control cl" style="padding:0px">  
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Codigo</option>
                      <option value="desc">Descripcion</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option> 
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Movimiento de  Inventario por Articulo -->
            <form method="GET" action="../reportes/rptAMovInventarioFecha.php" target="_blank" id="movform2" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Fecha:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Artículo:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoría:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Tipo de Movimiento:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="text" class="form-control ffecha" name="fecharegini" id="fecharegini">
                  <div class="input-group-addon" style="width:125px"><span class="fa fa-calendar"></span></div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="articuloa" id="articuloa" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <select name="condicion" id="condicion" class="form-control cl" style="padding:0px">
                    <option value="">Todos</option>
                    <option value="Entrada"> Ajuste de Entrada</option>     
                    <option value="Salida"> Ajuste de Salida</option>
                    <option value="Facturac">Factura de Compras</option>
                    <option value="Pedidoc">Pedido de Compras</option>    
                    <option value="Facturav">Factura de Ventas</option>
                    <option value="Pedidov">Pedido de Ventas</option>   
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="text" class="form-control ffecha" name="fecharegfin" id="fecharegfin">
                  <div class="input-group-addon" style="width:125px"><span class="fa fa-calendar"></span></div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="articulob" id="articulob" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Código</option>
                      <option value="desc">Descripción</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option>             
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

            <!-- Movimiento de  Inventario por Articulo -->
            <form method="GET" action="../reportes/rptAMovInventarioArt.php" target="_blank" id="movform1" class="hidden art">
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button class="btn btn-success form-control btn-sm" id="btnreporte"> Generar<i class="fa fa-print"></i></button>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
              <!-- Etiquetas -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px;">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label >Limpiar Campos</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Fecha:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Artículo:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Categoría:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Línea:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="input-group-addon" style="text-align:right;border-color:#fff;padding-top:5px;"><label > Tipo de Movimiento:</label></span>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Desde -->
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="text" class="form-control ffecha" name="fecharegini" id="fecharegini">
                  <div class="input-group-addon" style="width:125px"><span class="fa fa-calendar"></span></div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="articuloa" id="articuloa" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriaa" id="categoriaa" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineaa" id="lineaa" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <select name="condicion" id="condicion" class="form-control cl" style="padding:0px">
                    <option value="">Todos</option>
                    <option value="Entrada"> Ajuste de Entrada</option>     
                    <option value="Salida"> Ajuste de Salida</option>
                    <option value="Facturac">Factura de Compras</option>
                    <option value="Pedidoc">Pedido de Compras</option>    
                    <option value="Facturav">Factura de Ventas</option>
                    <option value="Pedidov">Pedido de Ventas</option>   
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Hasta -->
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-primary form-control" id="btnDesde"> Desde <i class="fa fa-sort-alpha-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="text" class="form-control ffecha" name="fecharegfin" id="fecharegfin">
                  <div class="input-group-addon" style="width:125px"><span class="fa fa-calendar"></span></div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="articulob" id="articulob" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="categoriab" id="categoriab" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="lineab" id="lineab" class="form-control cl" style="padding:0px">              
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
              <!-- Ordenamiento -->
              <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-primary form-control" id="Orden">Ordenamiento <i class="fa fa-sort-amount-asc"></i></button>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                    <select name="torder" id="torder" class="form-control">
                      <option value="cod">Código</option>
                      <option value="desc">Descripción</option>
                    </select> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <select name="order" id="order" class="form-control">
                    <option value="asc">Ascendente </option>
                    <option value="desc">Descendente </option>             
                  </select>
                </div>
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                </div>
              </div>
            </form>

          </div>
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.Main content -->
</div><!-- /.Content-wrapper -->
<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/reporteinv.js"></script>
<?php 
}
ob_end_flush();
?>