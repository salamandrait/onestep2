<?php
require "../config/Conexion.php";

class Traslado{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Actualizamos Codigo de Operacion
   public function ActCod()
   {
      $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbtraslado' AND estatus='1'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Insertar
   public function Insertar($idusuario,$cod_traslado,$desc_traslado,$totalh,$fechareg,$idarticulo,$iddepositoi,$iddepositod,$cantidad,$costo,$idartunidad)
   {
      $sql="INSERT INTO tbtraslado(idusuario,cod_traslado,desc_traslado,estatus,totalh,fechareg,fechadb)
      VALUES ('$idusuario','$cod_traslado','$desc_traslado','Registrado','$totalh',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      $idtraslado=ejecutarConsulta_retornarID($sql);
      $num_elementos=0;
      $sw=true;
      
        while ($num_elementos < count($idarticulo))
        {
           $sql_detalle ="INSERT INTO tbtrasladod (idtraslado,idarticulo,iddepositoi,iddeposito,cantidad,costo,idartunidad) 
           VALUES ('$idtraslado','$idarticulo[$num_elementos]','$iddepositoi[$num_elementos]','$iddepositod[$num_elementos]',
           '$cantidad[$num_elementos]','$costo[$num_elementos]','$idartunidad[$num_elementos]')";
           ejecutarConsulta($sql_detalle) or $sw = false;
           $num_elementos=$num_elementos + 1;
        }		
        return $sw;
   }

   public function RemoveStockArt($idarticulo,$iddeposito,$cantidad,$valor)
   {
     $num_elementos=0;
     $sw=true;
      while ($num_elementos < count($idarticulo)) 
      {  
         $sql_detalle ="UPDATE 
         tbstock SET
         cantidad=cantidad -($cantidad[$num_elementos]*$valor[$num_elementos])
         WHERE idarticulo='$idarticulo[$num_elementos]' 
         AND iddeposito='$iddeposito[$num_elementos]' 
         AND (SELECT tipo FROM tbarticulo WHERE idarticulo='$idarticulo[$num_elementos]')<>'Servicio'";
         ejecutarConsulta($sql_detalle) or $sw = false;
         $num_elementos=$num_elementos + 1;                  
       }
       return $sw;
   }

   public function AddStockArt($idarticulo,$iddeposito,$cantidad,$valor,$disp,$tipo)
   {
     $num_elementos=0;
     $sw=true;
      while ($num_elementos < count($idarticulo)) 
      {
         switch ($disp[$num_elementos]) {        
            case 'null':
               if ($tipo[$num_elementos]!='Servicio') {
                  $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
                  SELECT '$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',('$cantidad[$num_elementos]'*'$valor[$num_elementos]')
                  FROM DUAL WHERE NOT EXISTS (SELECT idarticulo,iddeposito FROM tbstock 
                  WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]')";
                  ejecutarConsulta($sql_detalle) or $sw = false;
               }
               $num_elementos=$num_elementos + 1;
            break;
                  
            default:
               $sql_detalle ="UPDATE tbstock SET
               cantidad=cantidad +('$cantidad[$num_elementos]'*'$valor[$num_elementos]')
               WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'
               AND (SELECT tipo FROM tbarticulo WHERE idarticulo='$idarticulo[$num_elementos]')<>'Servicio'";
               ejecutarConsulta($sql_detalle) or $sw = false;
               $num_elementos=$num_elementos + 1;
            break;
         }   
      }
      return $sw;
   }

   public function AnularStock($idtraslado)
   {
      $sql="UPDATE tbtrasladod
      SET 
      anular='1'
      WHERE idtraslado='$idtraslado'";
      return ejecutarConsulta($sql);		
   }

   //Implementamos Eliminar
   public function Eliminar($idtraslado)
   {
      $sql="DELETE FROM tbtraslado 
      WHERE idtraslado='$idtraslado'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Anular($idtraslado)
   {
      $sql="UPDATE tbtraslado 
      SET estatus='Anulado' 
      WHERE idtraslado='$idtraslado'";
      return ejecutarConsulta($sql);
   }
   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      tl.idtraslado,tl.cod_traslado,tl.desc_traslado,tl.estatus,tld.iddeposito,
      tld.iddepositoi,d.cod_deposito,d.desc_deposito,di.cod_deposito AS cod_depositoi,
      di.desc_deposito AS desc_depositoi,tl.totalh,DATE_FORMAT(tl.fechareg,'%d-%m-%Y') AS fechareg
      FROM tbtraslado tl
      INNER JOIN tbtrasladod tld ON tld.idtraslado=tl.idtraslado
      INNER JOIN tbdeposito d ON d.iddeposito=tld.iddeposito
      INNER JOIN tbdeposito di ON di.iddeposito=tld.iddepositoi
      GROUP BY tl.idtraslado";
      return ejecutarConsulta($sql);
   }

   //Implementamos Mostrar
   public function Mostrar($idtraslado)
   {
      $sql="SELECT 
      tl.idtraslado,
      tl.cod_traslado,
      tl.desc_traslado,
      tl.estatus,
      tld.iddepositoi,
      tld.iddeposito,
      tl.idusuario,
      (SELECT cod_deposito FROM tbdeposito WHERE iddeposito=tld.iddepositoi) AS cod_depositoi,
      (SELECT desc_deposito FROM tbdeposito WHERE iddeposito=tld.iddepositoi) AS desc_depositoi,
      (SELECT cod_deposito FROM tbdeposito WHERE iddeposito=tld.iddeposito) AS cod_deposito,
      (SELECT desc_deposito FROM tbdeposito WHERE iddeposito=tld.iddeposito) AS desc_deposito,
      tl.totalh,
      DATE_FORMAT(tl.fechareg, '%d-%m-%Y') AS fechareg 
      FROM
      tbtraslado tl 
      INNER JOIN tbtrasladod tld ON tld.idtraslado = tl.idtraslado
      WHERE tl.idtraslado='$idtraslado'
      GROUP BY tl.idtraslado";
      return ejecutarConsultaSimpleFila($sql);
   }

   public function ListarDetalle($idtraslado)
   {
      $sql="SELECT
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      td.cantidad,
      td.costo,
      td.cantidad*td.costo AS totald,
      td.idtrasladod,
      td.idtraslado,
      td.idarticulo,
      td.iddepositoi,
      td.iddeposito
      FROM tbtrasladod td
      INNER JOIN tbarticulo a ON a.idarticulo=td.idarticulo
      INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
      INNER JOIN tbunidad u ON u.idunidad =au.idunidad
      WHERE td.idtraslado='$idtraslado' AND au.principal=1";
      return ejecutarConsulta($sql);
   }

}

?>