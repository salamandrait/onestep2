<?php
// header("Expires: Tue, 13 Jan 2005 16:00:00 GMT"); // Ponemos la fecha siempre en pasado
// header("Pragma: no-cache"); 
// header("Cache-Control: no-cache");
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
  <?php require_once "../view/masterscripts.php";?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header"><!-- Logo -->
        <a href="escritorio.php" class="logo"><!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>O</b>S Admin</span><!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>One Step Administrativo</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation"><!-- Header Navbar: style can be found in header.less -->   
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><!-- Sidebar toggle button-->
            <span class="sr-only">Navegación</span>    
          </a>
          <div class="navbar-custom-menu"><!-- Navbar Right Menu -->
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu" style="border-bottom-left-radius:6px;border-bottom-right-radius:6px;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagenu'];?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['desc_usuario'];?></span>
                  <input id="iduser" value="<?php echo $_SESSION['idusuario'];?>" class="hidden">
                  <input id="name-user" value="<?php echo $_SESSION['desc_usuario'];?>" class="hidden">
                  <input id="image-user" value="../files/usuarios/<?php echo $_SESSION['imagenu'];?>" class="hidden">
                  <input id="loginms" value="login" class="hidden">
                </a>
                <ul class="dropdown-menu">       
                  <li class="user-header bg-blue-active"> <!-- User image -->
                    <img src="../files/usuarios/<?php echo $_SESSION['imagenu']; ?>" class="img-circle" alt="User Image">
                    <p><a href="http://wwww.salamandrair.com" class="text-yellow" target="_blank">wwww.salamandrair.com</a><small>Software Development Study</small>
                    <i class="fa fa-youtube-square"></i><a href="http://www.youtube.com/sit" class=" text-maroon" target="_blank"> www.youtube.com/sit</a>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer bg-gray" style="border-bottom-left-radius:6px;border-bottom-right-radius:6px;">
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding" >
                <button type="cancel" class="btn btn-primary btn-xs" data-dismiss=""> Cerrar</button>          
                <button type="cancel" id="btnCambiarClave" class="btn btn-warning btn-xs" data-dismiss=""> Cambiar Clave</button>
                <button type="button" onclick="Salir()" class="btn btn-danger btn-xs pull-right"> Cerrar Sesion</button>          
                </div>  
              </li>
            </ul>
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>
            <ul class="dropdown-menu">
              <aside class="control-sidebar control-sidebar-dark control-sidebar-open">   
                <h4 class="control-sidebar-heading">Skins</h4>
                <?php
                require 'skin.php';
                ?>
              </aside>
            </ul>
            </li>
            </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">         
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
              <div class="pull-left image">
                <img src="../files/usuarios/<?php echo $_SESSION['imagenu'];?>" class="img-circle bg-aqua" alt="User Image">
              </div>
              <div class="pull-left info">
                <p><?php echo $_SESSION['desc_usuario'];?></p>
                <!-- Status -->
                <h5><span class="label bg-green"><?php echo $_SESSION['desc_macceso'];?></span></h5>
              </div>
            </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li><a href="escritorio.php"><i class="fa fa-tasks"></i><span>Escritorio</span></a></li>

            <li class="treeview">
              <?php if ($_SESSION['inventario']==1){echo'<a href="#"><i class="fa fa-cubes text-aqua"></i><span>Inventario</span>
              <i class="fa fa-angle-left pull-right"></i></a>';}?>
                  <ul class="treeview-menu">
                    <li class="treeview">
                      <a href="#">
                      <i class="fa fa-desktop text-green"></i><span> Tablas</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                      <ul class="treeview-menu">
                        <?php if ($_SESSION['articulo']==1){echo'<li><a href="articulo.php"><i class="fa fa-circle-o text-green"></i> Artículos</a></li>';}?>         
                        <?php if ($_SESSION['categoria']==1){echo'<li><a href="categoria.php"><i class="fa fa-circle-o text-green"></i> Categorías</a></li>';}?>
                        <?php if ($_SESSION['linea']==1){echo'<li><a href="linea.php"><i class="fa fa-circle-o text-green"></i> Línea</a></li>';}?>
                        <?php if ($_SESSION['unidad']==1){echo'<li><a href="unidad.php"><i class="fa fa-circle-o text-green"></i> Unidades</a></li>';}?>
                        <?php if ($_SESSION['deposito']==1){echo'<li><a href="deposito.php"><i class="fa fa-circle-o text-green"></i> Depositos</a></li>';}?>
                        <?php if ($_SESSION['zona']==1){echo'<li><a href="pruebas.php"><i class="fa fa-circle-o text-green"></i> Pruebas</a></li>';}?>
                        <?php if ($_SESSION['rinventario']==1){echo'<li><a href="reporteinv.php"><i class="fa fa-circle-o text-green"></i> Reportes</a></li>';}?>
                      </ul>
                    </li>

                    <li class="treeview">
                      <?php if ($_SESSION['opinventario']==1){echo'<a href="#">
                      <i class="fa fa-bar-chart text-aqua"></i><span> Operaciones</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>';}?>
                      <ul class="treeview-menu">
                        <?php if ($_SESSION['ajuste']==1){echo'<li><a href="ajuste.php"><i class="fa fa-circle-o text-aqua"></i> Ajuste de Inventario</a></li>';}?>
                        <?php if ($_SESSION['traslado']==1){echo'<li><a href="traslado.php"><i class="fa fa-circle-o text-aqua"></i> Traslado de Deposito</a></li>';}?>
                        <?php if ($_SESSION['ajprecio']==1){echo'<li><a href="ajustep.php"><i class="fa fa-circle-o text-aqua"></i> Aj. de Costos y Precios</a></li>';}?>
                      </ul>
                    </li>
                  </ul>
            </li>

            <li class="treeview">
              <?php if ($_SESSION['compras']==1){echo'<a href="#"><i class="fa fa-truck text-maroon"></i>
              <span class="valor"> Compras</span>
              <small class="label bg-blue cxpp"></small>
              <small class="label bg-red cxpf" ></small>
                <i class="fa fa-angle-left pull-right"></i>
                </a>';}?>
                <ul class="treeview-menu">
                  <li class="treeview">
                    <a href="#">    
                      <i class="fa fa-desktop text-green"></i><span> Tablas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                    <ul class="treeview-menu">
                      <?php if ($_SESSION['proveedor']==1){echo'<li><a href="proveedor.php"><i class="fa fa-circle-o text-green"></i> Proveedores</a></li>';}?>          
                      <?php if ($_SESSION['tipoproveedor']==1){echo'<li><a href="tipoproveedor.php"><i class="fa fa-circle-o text-green"></i> Tipos de Proveedores</a></li>';}?> 
                      <?php if ($_SESSION['condpago']==1){echo'<li><a href="condpago.php"><i class="fa fa-circle-o text-green"></i> Cond. de Pago</a></li>';}?>
                      <?php if ($_SESSION['zona']==1){echo'<li><a href="zona.php"><i class="fa fa-circle-o text-green"></i> Zonas</a></li>';}?>
                      <?php if ($_SESSION['rcompra']==1){echo'<li><a href="reportecomp.php"><i class="fa fa-circle-o text-green"></i> Reportes</a></li>';}?>
                    </ul>
                  </li>
                  <li class="treeview">
                    <?php if ($_SESSION['opcompras']==1){echo'<a href="#">    
                      <i class="fa fa-bar-chart text-red"></i><span> Operaciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>';}?>
                    <ul class="treeview-menu">
                      <?php if ($_SESSION['ccompra']==1){echo'<li><a href="comprac.php"><i class="fa fa-circle-o text-aqua"></i> Cotización</a></li>';}?>
                      <?php if ($_SESSION['pcompra']==1){echo'<li><a href="comprap.php"><i class="fa fa-circle-o text-aqua"></i> Pedido <small id="pc" class="label pull-right bg-blue"></small></a></li>';}?>
                      <?php if ($_SESSION['fcompra']==1){echo'<li><a href="compraf.php"><i class="fa fa-circle-o text-aqua"></i> Factura<small id="fc" class="label pull-right bg-red"></small></a></li>';}?>
                      <?php if ($_SESSION['pago']==1){echo'<li><a href="pago.php"><i class="fa fa-circle-o text-aqua"></i> Pagos </a></li>';}?>
                    </ul>
                  </li>
                </ul>
            </li>

            <li class="treeview">
              <?php if ($_SESSION['ventas']==1){echo'<a href="#">
              <i class="fa fa-shopping-cart text-yellow"></i><span> Ventas</span><i class="fa fa-angle-left pull-right">
                </i></a>';}?>
                <ul class="treeview-menu">             
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-desktop text-green"></i><span> Tablas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                    <ul class="treeview-menu">
                      <?php if ($_SESSION['cliente']==1){echo'<li><a href="cliente.php"><i class="fa fa-circle-o text-green"></i> Clientes</a></li>';}?>          
                      <?php if ($_SESSION['tipocliente']==1){echo'<li><a href="tipocliente.php"><i class="fa fa-circle-o text-green"></i> Tipos de Clientes</a></li>';}?>
                      <?php if ($_SESSION['vendedor']==1){echo'<li><a href="vendedor.php"><i class="fa fa-circle-o text-green"></i> Vendedores</a></li>';}?>
                      <?php if ($_SESSION['turnopv']==1){echo'<li><a href="turnopv.php"><i class="fa fa-circle-o text-green"></i> Turno Terminal P. de Venta</a></li>';}?>
                      <?php if ($_SESSION['condpago']==1){echo'<li><a href="condpago.php"><i class="fa fa-circle-o text-green"></i> Cond. de Pago</a></li>';}?>
                      <?php if ($_SESSION['zona']==1){echo'<li><a href="zona.php"><i class="fa fa-circle-o text-green"></i> Zonas</a></li>';}?>
                      <?php if ($_SESSION['rventa']==1){echo'<li><a href="rventa.php"><i class="fa fa-circle-o text-green"></i> Reportes</a></li>';}?>
                    </ul>
                  </li>
                  <li class="treeview">
                    <?php if ($_SESSION['opventas']==1){echo'<a href="#">
                      <i class="fa fa-bar-chart text-aqua"></i><span> Operaciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>';}?>
                    <ul class="treeview-menu">
                      <?php if ($_SESSION['cventa']==1){echo'<li><a href="ventac.php"><i class="fa fa-circle-o text-aqua"></i> Cotización</a></li>';}?>
                      <?php if ($_SESSION['pventa']==1){echo'<li><a href="ventap.php"><i class="fa fa-circle-o text-aqua"></i> Pedido <small id="pv" class="label pull-right bg-blue"></small></a></li>';}?>
                      <?php if ($_SESSION['fventa']==1){echo'<li><a href="ventaf.php"><i class="fa fa-circle-o text-aqua"></i> Factura <small id="fv" class="label pull-right bg-red"></small></a></li>';}?>
                      <?php if ($_SESSION['cobro']==1){echo'<li><a href="cobro.php"><i class="fa fa-circle-o text-aqua"></i> Cobros </a></li>';}?>
                      <?php if ($_SESSION['pventa']==1){echo'<li><a href="pventa.php"><i class="fa fa-circle-o text-aqua"></i> T. Punto de Venta</a></li>';}?>
                    </ul>
                  </li>     
                </ul>
            </li>

            <li class="treeview">
              <?php if ($_SESSION['bancos']==1){echo'<a href="#"><i class="fa fa-bank text-purple"></i><span> Banca y Finazas</span><i class="fa fa-angle-left pull-right">         
              </i></a>';}?>
                <ul class="treeview-menu">
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-desktop text-green"></i><span> Tablas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                    <ul class="treeview-menu">
                      <?php if ($_SESSION['banco']==1){echo'<li><a href="banco.php"><i class="fa fa-circle-o text-green"></i> Bancos</a></li>';}?>          
                      <?php if ($_SESSION['caja']==1){echo'<li><a href="caja.php"><i class="fa fa-circle-o text-green"></i> Cajas</a></li>';}?> 
                      <?php if ($_SESSION['cuenta']==1){echo'<li><a href="cuenta.php"><i class="fa fa-circle-o text-green"></i> Cuentas</a></li>';}?> 
                      <?php if ($_SESSION['beneficiario']==1){echo'<li><a href="beneficiario.php"><i class="fa fa-circle-o text-green"></i> Beneficiarios</a></li>';}?>         
                      <?php if ($_SESSION['ipago']==1){echo'<li><a href="ipago.php"><i class="fa fa-circle-o text-green"></i> Instrumetos de Pago</a></li>';}?>
                      <?php if ($_SESSION['rbanco']==1){echo'<li><a href="rbanco.php"><i class="fa fa-circle-o text-green"></i> Reportes</a></li>';}?>
                    </ul>
                  </li>  
                  <li class="treeview">
                    <?php if ($_SESSION['opbancos']==1){echo'<a href="#">
                      <i class="fa fa-bar-chart text-red"></i><span> Operaciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>';}?>
                    <ul class="treeview-menu">
                      <?php if ($_SESSION['movcaja']==1){echo'<li><a href="movcaja.php"><i class="fa fa-circle-o text-aqua"></i> Movimiento de Caja</a></li>';}?>
                      <?php if ($_SESSION['movbanco']==1){echo'<li><a href="movbanco.php"><i class="fa fa-circle-o text-aqua"></i> Movimiento de Banco</a></li>';}?>
                      <?php if ($_SESSION['depbanco']==1){echo'<li><a href="depbanco.php"><i class="fa fa-circle-o text-aqua"></i> Deposito Bancario</a></li>';}?>
                      <?php if ($_SESSION['odpago']==1){echo'<li><a href="odpago.php"><i class="fa fa-circle-o text-aqua"></i> Orden de Pago</a></li>';}?>
                      <?php if ($_SESSION['conciliacion']==1){echo'<li><a href="conciliacion.php"><i class="fa fa-circle-o text-aqua"></i> Concialiación Bancaria</a></li>';}?>
                    </ul>
                  </li>  
                </ul>
            </li>
   
            <li class="treeview">
              <?php if ($_SESSION['config']==1){echo'<a href="#">
                <i class="fa fa-cogs text-orange"></i>
                <span>Configuracion</span>
                <i class="fa fa-angle-left pull-right"></i>
                  </a>';}?>
                  <ul class="treeview-menu">
                  <?php if ($_SESSION['macceso']==1){echo'<li><a href="macceso.php"><i class="fa fa-circle-o text-green"></i> Perfiles de Accesos</a></li>';}?>
                  <?php if ($_SESSION['usuario']==1){echo'<li><a href="usuario.php"><i class="fa fa-circle-o text-green"></i> Usuarios</a></li>';}?> 
                  <?php if ($_SESSION['empresa']==1){echo'<li><a href="empresa.php"><i class="fa fa-circle-o text-green"></i> Datos Empresa</a></li>';}?>
                  <?php if ($_SESSION['correlativo']==1){echo'<li><a href="correlativo.php"><i class="fa fa-circle-o text-green"></i> Series de Operaciones</a></li>';}?>
                  <?php if ($_SESSION['operacion']==1){echo'<li><a href="operacion.php"><i class="fa fa-circle-o text-green"></i> Tipos de Operaciones</a></li>';}?>
                  <?php if ($_SESSION['impuesto']==1){echo'<li><a href="impuesto.php"><i class="fa fa-circle-o text-green"></i> Impuestos</a></li>';}?>
                  <?php if ($_SESSION['impuestoe']==1){echo'<li><a href="impuestoi.php"><i class="fa fa-circle-o text-green"></i> Tabulador de I.S.L.R</a></li>';}?>
                  <?php if ($_SESSION['pais']==1){echo'  <li><a href="pais.php"><i class="fa fa-circle-o text-green"></i> Pais</a></li>';}?> 
                  <?php if ($_SESSION['moneda']==1){echo'<li><a href="moneda.php"><i class="fa fa-circle-o text-green"></i> Monedas</a></li>';}?>
              </ul>
            </li>

            <li>
                <a href="#">
                  <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                  <small class="label pull-right bg-red">PDF</small>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                  <small class="label pull-right bg-yellow">IT</small>
                </a>
            </li>
            <li>
             <a data-toggle="modal" onclick="Salir()"><i class="fa fa-unlock-alt"></i><span>Cerrar Sesion</span></a>
            </li>
                
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

<div class="modal fade" id="ModalCambiarClave" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:38%">
    <div class="box box-primary">
      <div class="modal-header" style="padding-bottom:0px">
        <h4 class="modal-title"> Cambiar Clave</h4>
      </div>
      <div class="panel-body">
        <form id="formclave"> 
          <input type="hidden" name="idusuario" id="idusuario"> 
          <label for="desc_usuariom"><h4 id="desc_usuariom" class="modal-title"></h4></label>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <label for="">Clave:</label>
            <input type="password" name="clave" id="clave" class="form-control">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <label for="">Confirmar:</label>
            <input type="password" name="clavec" id="clavec" class="form-control">
          </div>       
        </form> 
      </div>
      <div class="modal-footer" style="padding:6px">
        <button type="button" class="btn btn-primary btn-sm" id="btnGuardarCl">Aceptar</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="btnCancelarM">Cancelar</button>
      </div>
    </div>
  </div>
</div>
