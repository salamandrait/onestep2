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
if ($_SESSION['escritorio']==1)

{
?>
<!--Contenido-->   
<div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
  <section class="content"><!-- Main content -->
    <div class="row"><!-- row -->
      <div class="col-lg-12 col-md-12"><!-- col -->
        <div class="box"><!--  box -->
          <div class="box-header with-border">
            <h1 class="box-title">Escritorio </h1><div class="box-tools pull-right"></div>
          </div>
          <div class="panel-body">

          <!-- Distribución por Categorias -->
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Distribución por Categorias</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body" style="">
                <canvas id="piecategoria" style="height: 265px; width: 530px;" width="530" height="200"></canvas>
              </div>
            </div>
          </div>

          <!-- Inventario Disponible -->
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="box box-primary inv-box collapsed-box">
              <div class="box-header with-border">
              <h4 class="box-title">Inventario</h4>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                  <div class="small-box bg-navy">
                    <div class="inner" height="200">
                      <h3><span class="totalart"></span></h3>
                      <p><h4>Articulos en Inventario</h4></p>
                      <h3><span class="totalstock"></span></h3>
                      <p><h4>Stock Disponible</h4></p></div>
                    <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                      <a href="articulo.php" class="small-box-footer">Ver Mas <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Articulos con mas Ventas -->
          <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
            <div class="box box-success artmas collapsed-box">
              <div class="box-header with-border box-primary">
              <h4 class="box-title">Articulo con mas Ventas</h4>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body box-success">
                <div class="row">
                  <div class="col-md-12">
                      <table id="artmasventas" class="table compact table-bordered table-condensed table-hover">
                        <thead class="btn-success">
                          <th>Descripcion</th>
                          <th style="text-align:center;">Unds.</th>
                        </thead>
                        <tr>
                          <td>--No Existen Registros--</td>
                          <td class="text-right">0</td>
                        </tr>
                        <tfoot>
                          <th></th>
                          <th></th>
                          <th></th>
                        </thead>
                      </table>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.box-body -->
            </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          </div>
      
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <!-- Clientes-->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class=" fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"> Clientes </span>
                  <span class="info-box-number" id="totalcliente" style="font-size:40px"></span></h5>
                </div>
              </div>
            </div>
            <!-- Cuentas Por Cobrar-->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="small-box bg-green">
                <div class="inner">        
                  <h4>Cuentas por Cobrar <span></span></h4>
                  <h5 style="font-size:22px;" id="saldocxc"  class="text-right"></h5>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus no-ts"></i>
                </div>
                <a href="cliente.php" class="small-box-footer"> Clientes <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- TOTAL PEDIDOS POR COBRAR-->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="small-box bg-aqua-active">
                <div class="inner">        
                  <h4>Pedidos por Cobrar <span></span></h4>
                  <h5 style="font-size:22px;" id="totalpedidov"  class="text-right"></h5>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus no-ts"></i>
                </div>
                <a href="ventap.php" class="small-box-footer"> Pedidos de Venta <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- TOTAL PEDIDOS -->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="info-box">
                <span class="info-box-icon bg-aqua-active"><i class="glyphicon glyphicon-list-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">TOTAL PEDIDOS</span>
                  <span class="info-box-number pull-right" id="totalpv" style="font-size:40px"></span></h5>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-xs-12 no-margin">
            </div>
            <!-- TOTAL FACTURAS-->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="info-box">
                <span class="info-box-icon bg-purple-active"><i class="glyphicon glyphicon-list-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">TOTAL FACTURAS</span>
                  <span class="info-box-number pull-right" id="totalfv" style="font-size:40px"></span></h5>
                </div>
              </div>
            </div>
            <!-- TOTAL FACTURAS POR COBRAR-->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="small-box bg-purple-active">
                <div class="inner">        
                  <h4>Facturas por Cobrar <span></span></h4>
                  <h5 style="font-size:22px;" id="totalfacturav"  class="text-right"></h5>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus no-ts"></i>
                </div>
                <a href="ventaf.php" class="small-box-footer"> Facturas de Venta <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
           <div class="box box-success">
              <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title"> Ultimas 10 Ventas </h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="ventas10" style="height: 230px; width: 510px;" width="510" height="242"></canvas>
                </div>
              </div>
            </div>
          </div>
      
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="box box-danger">
              <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title"> Ultimas 10 Compras </h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="compras10" style="height: 230px; width: 510px;" width="510" height="240"></canvas>
                  <span style="display:inline-block;margin-right:5px;
                  width:30px;height:10px;background-color:#26B99A"></span>
                  Pedidos : 7
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <!--  Proveedores-->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class=" fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Proveedores</span>
                  <span class="info-box-number" id="totalproveedor" style="font-size:40px"></span></h5>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div>
            <!--  Total Cuentas por Pagar-->
            <div class="col-lg-6 col-xs-12 no-padlr"><!-- small box -->
              <div class="small-box btn-warning">
                <div class="inner">        
                  <h4> Total Cuentas por Pagar <span></span></h4>
                  <h5 style="font-size:22px;" id="saldocxp"  class="text-right"></h5>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus no-ts"></i>
                </div>
                <a href="proveedor.php" class="small-box-footer"> Proveedores <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!--TOTAL PEDIDOS POR PAGAR-->
            <div class="col-lg-6 col-xs-12 no-padlr"><!-- small box -->
              <div class="small-box bg-blue-active">
                <div class="inner">        
                  <h4> Pedidos por Pagar <span></span></h4>
                  <h5 style="font-size:22px;" id="totalpedidoc"  class="text-right"></h5>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus no-ts"></i>
                </div>
                <a href="comprap.php" class="small-box-footer"> Pedidos de Compra <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- TOTAL PEDIDOS -->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="info-box">
                <span class="info-box-icon bg-blue-active"><i class="glyphicon glyphicon-list-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">TOTAL PEDIDOS</span>
                  <span class="info-box-number pull-right" id="totalpc" style="font-size:40px"></span></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <!-- TOTAL FACTURAS -->
            <div class="col-lg-6 col-xs-12 no-padlr">
              <div class="info-box">
                <span class="info-box-icon bg-red-active"><i class="glyphicon glyphicon-list-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">TOTAL FACTURAS</span>
                  <span class="info-box-number pull-right" id="totalfc" style="font-size:40px"></span></h5>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div>
            <!--TOTAL FACTURAS POR PAGAR-->
            <div class="col-lg-6 col-xs-12 no-padlr"><!-- small box -->
              <div class="small-box bg-red-active">
                <div class="inner">        
                  <h4> Facturas por Pagar <span></span></h4>
                  <h5 style="font-size:22px;" id="totalfacturac"  class="text-right"></h5>
                </div>
                <div class="icon">
                  <i class="fa fa-truck no-ts"></i>
                </div>
                <a href="compraf.php" class="small-box-footer"> Facturas de Compras <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
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
<script type="text/javascript" src="scripts/escritorio.js"></script>
<script src="../public/js/chart.js"></script>
<script src="../public/js/Chart.bundle.js"></script> 
<?php 
}
ob_end_flush();
?>