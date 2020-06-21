<?php
require "../config/Conexion.php";

class Ajuste{

   //Implementamos nuestro constructor
   public function __construct(){   
   }

   //Actualizamos Codigo de Operacion
   public function ActCod()
   {
      $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbajuste' AND estatus='1'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Insertar
   public function Insertar($idusuario,$cod_ajuste,$desc_ajuste,$tipo,$totalstock,$totalh,
	$fechareg,$idarticulo,$iddeposito,$disp,$cantidad,$costo,$idartunidad)
   {
      $sql="INSERT INTO tbajuste(idusuario,cod_ajuste,desc_ajuste,tipo,estatus,totalstock,totalh,fechareg,fechadb)
      VALUES ('$idusuario','$cod_ajuste','$desc_ajuste','$tipo','Registrado',
      '$totalstock','$totalh',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      $idajuste=ejecutarConsulta_retornarID($sql);

      $num_elementos=0;
      $sw=true;

      if ($tipo=='Entrada') {
			while ($num_elementos < count($idarticulo))
			{
				$sql_detalle ="INSERT INTO tbajustee (idajuste,idarticulo,iddeposito,cantidad,costo,tipo,idartunidad) 
				VALUES ('$idajuste','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$cantidad[$num_elementos]',
            '$costo[$num_elementos]','$tipo','$idartunidad[$num_elementos]')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		} else 	if ($tipo=='Salida'){
			while ($num_elementos < count($idarticulo))
			{
				$sql_detalle ="INSERT INTO tbajustes (idajuste,idarticulo,iddeposito,cantidad,costo,tipo,idartunidad) 
				VALUES ('$idajuste','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$cantidad[$num_elementos]',
        '   $costo[$num_elementos]','$tipo','$idartunidad[$num_elementos]')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		} else if ($tipo=='Inventario'){
			while ($num_elementos < count($idarticulo))
			{
            $sql_detalle ="INSERT INTO tbajustei (idajuste,idarticulo,iddeposito,cantidadi,cantidad,costo,tipo,idartunidad) 
            VALUES ('$idajuste','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$disp[$num_elementos]',
            '$cantidad[$num_elementos]','$costo[$num_elementos]','$tipo','$idartunidad[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
			}
		}	
		return $sw;
   }

   public function AddStockArt($idarticulo,$iddeposito,$cantidad,$valor,$tipo,$disp,$tipoa)
   {
     $num_elementos=0;
     $sw=true;
      while ($num_elementos < count($idarticulo)) 
      {
         switch ($tipo) {
            case 'Entrada':
               switch ($disp[$num_elementos]) {        
                  case 'null':
                     if ($tipoa[$num_elementos]!='Servicio') {
               
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
            break;

            case 'Salida':
               switch ($disp[$num_elementos]) {        
                  case 'null':
                     if ($tipoa[$num_elementos]!='Servicio') {
               
                        $sql_detalle="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
                           SELECT '$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',-('$cantidad[$num_elementos]'*'$valor[$num_elementos]')
                           FROM DUAL WHERE NOT EXISTS (SELECT idarticulo,iddeposito FROM tbstock 
                           WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]')";
                        ejecutarConsulta($sql_detalle) or $sw = false;
                     }
                     $num_elementos=$num_elementos + 1;
                  break;
                  
                  default:
                     $sql_detalle ="UPDATE tbstock SET
                     cantidad=cantidad -('$cantidad[$num_elementos]'*'$valor[$num_elementos]')
                     WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'
                     AND (SELECT tipo FROM tbarticulo WHERE idarticulo='$idarticulo[$num_elementos]')<>'Servicio'";
                     ejecutarConsulta($sql_detalle) or $sw = false;
                     $num_elementos=$num_elementos + 1;
                  break;
               }
            break;

            case 'Inventario':
               $sql_detalle ="UPDATE tbstock SET
               cantidad=('$cantidad[$num_elementos]'*'$valor[$num_elementos]')
               WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'
               AND (SELECT tipo FROM tbarticulo WHERE idarticulo='$idarticulo[$num_elementos]')<>'Servicio'";
               ejecutarConsulta($sql_detalle) or $sw = false;
               $num_elementos=$num_elementos + 1;
            break;            
         }
      }
      return $sw;
   }

   public function AnularStock($idajuste,$tipo)
	{
		if ($tipo=='Entrada') {

			$sql="UPDATE tbajustee
			SET 
			anular='1'
			WHERE idajuste='$idajuste'";
			return ejecutarConsulta($sql);
		} 	
		if ($tipo=='Salida'){
			
			$sql="UPDATE tbajustes
			SET 
			anular='1'
			WHERE idajuste='$idajuste'";
			return ejecutarConsulta($sql);			
		}
		if ($tipo=='Inventario'){
			
			$sql="UPDATE tbajustei
			SET 
			anular='1'
			WHERE idajuste='$idajuste'";
			return ejecutarConsulta($sql);		
		}		
   }

   //Implementamos Eliminar
   public function Eliminar($idajuste)
   {
      $sql="DELETE FROM tbajuste 
      WHERE idajuste='$idajuste'";
      return ejecutarConsulta($sql);
   }

	//Implementamos un método para anular Registros
	public function Anular($idajuste)
	{
		$sql="UPDATE 
		tbajuste 
		SET estatus='Anulado' 
		WHERE idajuste='$idajuste'";
		return ejecutarConsulta($sql);
   }

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      aj.idajuste,
      aj.cod_ajuste,
      aj.desc_ajuste,
      aj.tipo,
      aj.estatus,
      CONVERT(aj.totalstock,DECIMAL(12,2)) AS totalstock,
      CASE
      WHEN aj.tipo ='Entrada' THEN CONVERT(aj.totalh,DECIMAL(12,2))
      WHEN aj.tipo ='Salida' THEN CONVERT(-aj.totalh,DECIMAL(12,2))
      ELSE CONVERT(aj.totalh,DECIMAL(12,2)) END AS totalh,
      DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
      FROM tbajuste aj";
      return ejecutarConsulta($sql);
   }

     //Metodo Detalle de Ajuste
   public function ListarDetalle($idajuste)
   {
      $sql="SELECT 
      ajd.idajusted, 
      ajd.idajuste,
      ajd.iddeposito,
      ajd.idartunidad,
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      ajd.cantidad,
      ajd.costo,
      CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald
      FROM tbajustee ajd
      INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
      LEFT JOIN tbartunidad au ON au.idartunidad=ajd.idartunidad
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE ajd.idajuste='$idajuste'

      UNION

      SELECT 
      ajd.idajusted, 
      ajd.idajuste,
      ajd.iddeposito,
      ajd.idartunidad,
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      ajd.cantidad,
      ajd.costo,
      CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald
      FROM tbajustes ajd
      INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
      LEFT JOIN tbartunidad au ON au.idartunidad=ajd.idartunidad
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE ajd.idajuste='$idajuste'

      UNION

      SELECT 
      ajd.idajusted, 
      ajd.idajuste,
      ajd.iddeposito,
      ajd.idartunidad,
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      ajd.cantidad,
      ajd.costo,
      CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald
      FROM tbajustei ajd
      INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
      LEFT JOIN tbartunidad au ON au.idartunidad=ajd.idartunidad
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE ajd.idajuste='$idajuste'";
      return ejecutarConsulta($sql);
   }

   //Implementar un método para mostrar los datos de un registro
   public function Mostrar($idajuste)
   {
      $sql="SELECT
      aj.idajuste,
      aj.cod_ajuste,
      aj.desc_ajuste,
      aj.tipo,
      aj.estatus,
      CASE 
      WHEN aj.tipo='Entrada' THEN aje.iddeposito
      WHEN aj.tipo='Salida' THEN ajs.iddeposito
      WHEN aj.tipo='Inventario' THEN aji.iddeposito
      END AS iddeposito,
      CONVERT(aj.totalstock,DECIMAL(12,2)) AS totalstock,
      CONVERT(aj.totalh,DECIMAL(12,2)) AS totalh,
      aj.fechareg
      FROM tbajuste aj 
      LEFT JOIN tbajustee aje ON aje.idajuste=aj.idajuste
      LEFT JOIN tbajustes ajs ON ajs.idajuste=aj.idajuste
      LEFT JOIN tbajustei aji ON aji.idajuste=aj.idajuste
      WHERE aj.idajuste='$idajuste'
      GROUP BY aj.idajuste";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Implementamos Mostrar
   public function rptAjusteH($idajuste)
   {
      $sql="SELECT 
      aj.idajuste,
      aj.idusuario,
      aj.cod_ajuste,
      aj.desc_ajuste,
      u.cod_usuario,
      u.desc_usuario,
      CASE 
      WHEN aj.tipo='Entrada' THEN aje.iddeposito
      WHEN aj.tipo='Salida' THEN ajs.iddeposito
      WHEN aj.tipo='Inventario' THEN aji.iddeposito
      END AS iddeposito,
      CASE
      WHEN aj.tipo='Entrada' THEN CONCAT(de.cod_deposito,'-',de.desc_deposito)
      WHEN aj.tipo='Salida' THEN CONCAT(ds.cod_deposito,'-',ds.desc_deposito)
      WHEN aj.tipo='Inventario' THEN CONCAT(di.cod_deposito,'-',di.desc_deposito)
      END AS deposito,
      aj.tipo,
      aj.estatus,
      CONVERT(aj.totalh,DECIMAL(12,2)) AS totalh,
      DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
      FROM tbajuste aj
      INNER JOIN tbusuario u ON u.idusuario=aj.idusuario
      LEFT JOIN tbajustei aji ON aji.idajuste=aj.idajuste
      LEFT JOIN tbajustes ajs ON ajs.idajuste=aj.idajuste
      LEFT JOIN tbajustee aje ON aje.idajuste=aj.idajuste
      LEFT JOIN tbdeposito di ON di.iddeposito=aji.iddeposito 
      LEFT JOIN tbdeposito ds ON ds.iddeposito=ajs.iddeposito 
      LEFT JOIN tbdeposito de ON de.iddeposito=aje.iddeposito
      WHERE aj.idajuste='$idajuste'";
      return ejecutarConsultaSimpleFila($sql);
   }

   public function rptGeneral()
   {
     $sql="SELECT 
     aj.idajuste,
     aj.cod_ajuste,
     aj.desc_ajuste,
     aj.tipo,
     aj.estatus,
     aj.totalstock,
     CASE
     WHEN aj.tipo ='Entrada' THEN aj.totalh
     WHEN aj.tipo ='Salida' THEN -aj.totalh
     ELSE aj.totalh END AS totalh,
     DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
     FROM tbajuste aj
     ORDER BY cod_ajuste ASC";
     return ejecutarConsulta($sql);
   }



}

?>