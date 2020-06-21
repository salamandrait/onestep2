<?php
require '../view/header.php';
?>
<!--Contenido-->
<div class="content-wrapper">        
  <section class="content">
    <div class="widget-box">
      <div class="widget-title"><h5><i class="fa fa-exclamation-triangle"></i> Error 401</h5></div>
      <div class="widget-content">
        <div class="error_ex">
          <h1 class="text-center text-red">401</h1>
          <h3 class="text-center"><span><label>Acceso No Autorizado! <br>Notificado Al Administrador del Sistema</label></span></h3>
          <p class="text-center">
            <a href="javascript:history.back()" class="btn btn-primary"><span>Regresar</span></a>
            <a href="../view/escritorio.php" class="btn btn-warning"><span>Ir al Escritorio</span></a>
          </p>
        </div>   
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
require '../view/footer.php';
?>