<?php
require_once '../Config/Conexion.php';

Class AjustePrecio{

  public function __construct(){  
  }

  //Actualizamos Codigo de Operacion
  public function ActCod(){
    $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbajustep' AND estatus='1'";
    return ejecutarConsulta($sql);
  }
    
}
?>