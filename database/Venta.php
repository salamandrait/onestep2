<?php
require '../config/Conexion.php';

class Venta{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Funcion para Generar Codigo automatico segun tipo de documento
   public function GenerarCod($ftipo)
   {
     if ($ftipo=='Cotizacion') {
       $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum,estatus
       FROM tbcorrelativo WHERE tabla='tbcventa'";
       return ejecutarConsultaSimpleFila($sql);
     } elseif ($ftipo=='Pedido') {
       $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum ,estatus
       FROM tbcorrelativo WHERE tabla='tbpventa'";
       return ejecutarConsultaSimpleFila($sql);
     } elseif ($ftipo=='Factura') {
       $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum ,estatus
       FROM tbcorrelativo WHERE tabla='tbfventa'";
       return ejecutarConsultaSimpleFila($sql);
     }
   }

   //Funcion para Actualizar Codigo automatico segun tipo de documento
   public function ActCod($tipo)
   {
      if ($tipo=='Cotizacion') {
      
         $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbcventa'";
         return ejecutarConsulta($sql);
      
      } else if ($tipo=='Pedido'){
      
         $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbpventa'";
         return ejecutarConsulta($sql);
      
      } else if ($tipo=='Factura'){
      
         $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbfventa'";
         return ejecutarConsulta($sql);
      }
   }

   //Funcion Insertar
   public function Insertar($idcliente,$idvendedor,$idcondpago,$idusuario,$cod_venta,$desc_venta,$numerod,
   $numeroc,$tipo,$origend,$origenc,$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,
   $idartunidad,$idarticulo,$iddeposito,$cantidad,$precio,$tasa,$tipoprecio){

      $sql="INSERT INTO tbventa(idcliente,idvendedor,idcondpago,idusuario,cod_venta,desc_venta,numerod,
      numeroc,tipo,origend,origenc,subtotalh,impuestoh,totalh,saldoh,fechareg,fechaven,estatus,fechadb)
      VALUES('$idcliente','$idvendedor','$idcondpago','$idusuario','$cod_venta','$desc_venta','$numerod',
      '$numeroc','$tipo','$origend','$origenc','$subtotalh','$impuestoh','$totalh','$saldoh',
      STR_TO_DATE('$fechareg','%d/%m/%Y'),STR_TO_DATE('$fechaven','%d/%m/%Y'),'Registrado',NOW())";
      $idventa=ejecutarConsulta_retornarID($sql);  

         $num_elementos=0;
         $sw=true;

      while ($num_elementos < count($idarticulo))
      {
         $sql_detalle ="INSERT INTO tbventad(idventa,idartunidad,idarticulo,iddeposito,cantidad,precio,tasa,tipoprecio) 
         VALUES('$idventa','$idartunidad[$num_elementos]','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',
         '$cantidad[$num_elementos]','$precio[$num_elementos]','$tasa[$num_elementos]','$tipoprecio[$num_elementos]')";
         ejecutarConsulta($sql_detalle) or $sw = false;
         $num_elementos=$num_elementos + 1;
         
      }
      return $sw;
   }

   //Funcion Actualizar Stock en Inventario al Ingresar Documento
   public function AddStockArt($idarticulo,$disp,$tipo,$iddeposito,$cantidad,$valor)
   {
      $num_elementos=0;
      $sw=true;

      while ($num_elementos < count($idarticulo)) 
      {
         switch ($disp[$num_elementos]) {
            
            case 'null':
               if ($tipo[$num_elementos]!='Servicio') {
         
                  $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
                  SELECT '$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',-($cantidad[$num_elementos]*$valor[$num_elementos])
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
      }
      return $sw;
   }



   //Método para Actualizar el Precio de los Articulos en el Almacen Correspondiente
	public function ActualizarPrecio($idarticulo,$precio,$tipoprecio,$valor)
	{	
		$num_elementos=0;
      $sw=true;

      switch ($tipoprecio) {
         case 'p1':
            while ($num_elementos < count($idarticulo)){      
               $sql_detalle ="UPDATE 
               tbarticulo SET
               precio1='$precio[$num_elementos]'/'$valor[$num_elementos]'
               WHERE 
               idarticulo='$idarticulo[$num_elementos]'";
               ejecutarConsulta($sql_detalle) or $sw = false;
               $num_elementos=$num_elementos + 1;
            }
         break; 

         case 'p2':
            while ($num_elementos < count($idarticulo)){      
               $sql_detalle ="UPDATE 
               tbarticulo SET
               precio2='$precio[$num_elementos]'/'$valor[$num_elementos]'
               WHERE 
               idarticulo='$idarticulo[$num_elementos]'";
               ejecutarConsulta($sql_detalle) or $sw = false;
               $num_elementos=$num_elementos + 1;
            }
         break;  

         case 'p3':
            while ($num_elementos < count($idarticulo)){      
               $sql_detalle ="UPDATE 
               tbarticulo SET
               precio3='$precio[$num_elementos]'/'$valor[$num_elementos]'
               WHERE 
               idarticulo='$idarticulo[$num_elementos]'";
               ejecutarConsulta($sql_detalle) or $sw = false;
               $num_elementos=$num_elementos + 1;
            }
         break;
      }
		return $sw;			
   }

   //Funcion Anular Stock en Inventario y asi Desparar Trigger tr_AjStockVenta
   public function ActDetalle($idventa)
	{
		$sql="UPDATE tbventad
      SET 
      anulado='1',
      importado='0'
      WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);		
   }

   //Funcion Anular Stock en Inventario Mediante Trigger sql en documentos Importados
   public function ActDetalleImp($idventaop,$origenc)
   {
      $sql="UPDATE tbventad
      SET 
      importado='$origenc'
      WHERE idventa='$idventaop'";
      return ejecutarConsulta($sql);  	
   }

   //Funcion Actualizar Documento Importado
   public function ProcesarDocumentoImp($idventa)
   {
      $sql_detalle="UPDATE tbventa
      SET 
      estatus='Procesado',
      saldoh=0,
      fechadb=NOW()
      WHERE idventa='$idventa'";
      return ejecutarConsulta($sql_detalle);  
   }

   //Funcion Restablecer Documento Marcado como Procesado
   public function AnularProcesarDocumentoImp($origenc,$origend,$totalh)
   {
      $sql="UPDATE tbventa
      SET 
      estatus='Registrado',
      saldoh='$totalh',
      fechadb=NOW()
      WHERE idventa=(SELECT idventa FROM tbventa WHERE cod_venta='$origenc' AND tipo='$origend')";
      return ejecutarConsulta($sql);
   }

   //Funcion Eliminar Venta
   public function Eliminar($idventa)
   {
      $sql="DELETE FROM tbventa
      WHERE idventa='$idventa'";
      return ejecutarConsulta($sql);
   }

   //Funcion Anular Venta
   public function Anular($idventa)
   {
     $sql="UPDATE tbventa 
     SET estatus='Anulado',
     saldoh=0,
     fechadb=NOW() 
     WHERE idventa='$idventa'";
     return ejecutarConsulta($sql);
   }

   //Funcion Listar Documentos
   public function Listar($tipo)
   {
      $sql="SELECT 
      v.idventa,
      v.idcliente,
      v.idvendedor,
      v.idcondpago,
      v.idusuario,
      v.cod_venta,
      v.desc_venta,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      u.cod_usuario,
      u.desc_usuario,
      vd.cod_vendedor,
      vd.desc_vendedor,
      v.numerod,
      v.numeroc,
      v.tipo,
      v.origend,
      v.origenc,
      v.estatus,
      v.subtotalh,
      v.impuestoh,
      v.totalh,
      v.saldoh,
      DATE_FORMAT(v.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(v.fechaven, '%d/%m/%Y') AS fechaven
      FROM
      tbventa AS v 
      INNER JOIN tbcliente AS cl ON (v.idcliente = cl.idcliente) 
      INNER JOIN tbvendedor AS vd ON (v.idvendedor = vd.idvendedor) 
      INNER JOIN tbcondpago AS cp ON (v.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (v.idusuario = u.idusuario)
      WHERE v.tipo='$tipo'";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Documentos
   public function Mostrar($idventa)
   {
      $sql="SELECT 
      v.idventa,
      v.idcliente,
      v.idvendedor,
      v.idcondpago,
      v.idusuario,
      v.cod_venta,
      v.desc_venta,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      u.cod_usuario,
      u.desc_usuario,
      vd.cod_vendedor,
      vd.desc_vendedor,
      v.numerod,
      v.numeroc,
      v.tipo,
      v.origend,
      v.origenc,
      v.estatus,
      v.subtotalh,
      v.impuestoh,
      v.totalh,
      v.saldoh,
      DATE_FORMAT(v.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(v.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbventa AS v
      INNER JOIN tbcliente AS cl ON (v.idcliente = cl.idcliente) 
      INNER JOIN tbvendedor AS vd ON (v.idvendedor = vd.idvendedor) 
      INNER JOIN tbcondpago AS cp ON (v.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (v.idusuario = u.idusuario) 
      WHERE v.idventa='$idventa'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Funcion Mostrar Detalle de Documentos
   public function MostrarDetalle($idventa)
   {
      $sql="SELECT
      dv.idventad,
      dv.idarticulo,
      dv.iddeposito,
      dv.idartunidad,
      dv.tipoprecio,
      a.cod_articulo,
      a.desc_articulo,
      u.desc_unidad,
      a.tipo,
      dv.cantidad,
      CONVERT(dv.precio,DECIMAL(12,2)) AS precio,
      CONVERT(dv.tasa,DECIMAL(12,0)) AS tasa,
      IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito=dv.iddeposito AND idarticulo=a.idarticulo),0) AS disp,
      au.valor
      FROM tbventad dv
      INNER JOIN tbarticulo a ON a.idarticulo=dv.idarticulo
      INNER JOIN tbartunidad au ON au.idartunidad=dv.idartunidad
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE dv.idventa='$idventa'";
      return ejecutarConsulta($sql);
   }

   //Funcion  Mostrar Documentos a Importar
   public function ImportarDocumento($idcliente='',$estatus,$tipo)
   {
      $sql="SELECT 
      v.idventa AS idventaop ,v.idcliente,v.idvendedor,v.cod_venta AS origenc ,v.estatus,
      cl.cod_cliente,cl.desc_cliente,cl.rif,v.idcondpago,cl.limite,cp.cod_condpago,cp.desc_condpago,
      cp.dias,vd.cod_vendedor,vd.desc_vendedor,v.tipo,v.numerod,v.totalh,
      DATE_FORMAT(v.fechareg,'%d/%m/%Y') AS fechareg, DATE_FORMAT(v.fechaven,'%d/%m/%Y') AS fechaven
      FROM tbventa v
      INNER JOIN tbcliente cl ON cl.idcliente=v.idcliente
      INNER JOIN tbcondpago cp ON cp.idcondpago =v.idcondpago
      INNER JOIN tbvendedor vd ON vd.idvendedor=v.idvendedor
      AND 
      ('$idcliente'='' OR v.idcliente='$idcliente')
      AND (v.tipo='$tipo') 
      AND ( ('$estatus'='todos' AND v.estatus<>'Anulado')
      OR('$estatus'='sinp' AND v.estatus<>'Anulado' AND v.estatus<>'Procesado'))";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar detalle de Documentos a Importar
   public function ImportarDetalle($idventa)
   {
     $sql="SELECT
     dv.idventad,
     dv.idarticulo,
     dv.iddeposito,
     dv.idartunidad,
     dv.tipoprecio,
     a.cod_articulo,
     a.desc_articulo,
     u.desc_unidad,
     a.tipo,
     dv.cantidad,
     CONVERT(dv.precio,DECIMAL(12,2)) AS precio,
     CONVERT(dv.tasa,DECIMAL(12,0)) AS tasa,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito=dv.iddeposito AND idarticulo=a.idarticulo),'null') AS disp,
     au.valor
     FROM tbventad dv 
     INNER JOIN tbarticulo a ON a.idarticulo=dv.idarticulo
     INNER JOIN tbartunidad au ON au.idartunidad=dv.idartunidad
     INNER JOIN tbunidad u ON u.idunidad=au.idunidad
     WHERE dv.idventa='$idventa'";
     return ejecutarConsulta($sql);
   }

   //Funcion Seleccionar Documentos
   public function Select()
   {
      $sql="SELECT 
      v.idventa,
      v.idcliente,
      v.idvendedor,
      v.idcondpago,
      v.idusuario,
      v.cod_venta,
      v.desc_venta,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      vd.cod_vendedor,
      vd.desc_vendedor,
      u.cod_usuario,
      u.desc_usuario,
      v.numerod,
      v.numeroc,
      v.tipo,
      v.origend,
      v.origenc,
      v.estatus,
      v.subtotalh,
      v.impuestoh,
      v.totalh,
      v.saldoh,
      DATE_FORMAT(v.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(v.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbventa AS v 
      INNER JOIN tbcliente AS cl ON (v.idcliente = cl.idcliente)
      INNER JOIN tbvendedor AS vd ON (v.idvendedor = vd.idvendedor) 
      INNER JOIN tbcondpago AS cp ON (v.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (v.idusuario = u.idusuario) 
      WHERE v.estatus='1'
      ORDER BY v.cod_venta ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Documentos
   public function RptListar()
   {
      $sql="SELECT 
      v.idventa,
      v.idcliente,
      v.idvendedor,
      v.idcondpago,
      v.idusuario,
      v.cod_venta,
      v.desc_venta,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      vd.cod_vendedor,
      vd.desc_vendedor,
      u.cod_usuario,
      u.desc_usuario,
      v.numerod,
      v.numeroc,
      v.tipo,
      v.origend,
      v.origenc,
      v.estatus,
      v.subtotalh,
      v.impuestoh,
      v.totalh,
      v.saldoh,
      DATE_FORMAT(v.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(v.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbventa AS v 
      INNER JOIN tbcliente AS cl ON (v.idcliente = cl.idcliente)
      INNER JOIN tbvendedor AS vd ON (v.idvendedor = vd.idvendedor) 
      INNER JOIN tbcondpago AS cp ON (v.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (v.idusuario = u.idusuario)
      ORDER BY v.cod_venta ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Reporte Documento de Venta
   public function RptVentaH($idventa)
   {
      $sql="SELECT 
      v.idventa,
      v.idcliente,
      v.idvendedor,
      v.idcondpago,
      v.idusuario,
      v.cod_venta,
      v.desc_venta,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.direccion,
      cl.telefono,
      cl.movil,
      cl.contacto,
      cl.email,
      cl.web,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      vd.cod_vendedor,
      vd.desc_vendedor,
      u.cod_usuario,
      u.desc_usuario,
      v.numerod,
      v.numeroc,
      v.tipo,
      v.origend,
      v.origenc,
      v.estatus,
      v.subtotalh,
      v.impuestoh,
      v.totalh,
      v.saldoh,
      DATE_FORMAT(v.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(v.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbventa AS v 
      INNER JOIN tbcliente AS cl ON (v.idcliente = cl.idcliente)
      INNER JOIN tbvendedor AS vd ON (v.idvendedor = vd.idvendedor) 
      INNER JOIN tbcondpago AS cp ON (v.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (v.idusuario = u.idusuario) 
      WHERE v.idventa='$idventa'";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Detalle de Reporte Documento de Venta
   public function RptVentaD($idventa)
   {
      $sql="SELECT
      cd.idventad,
      cd.idarticulo,
      cd.iddeposito,
      a.cod_articulo, 
      a.desc_articulo,
      d.cod_deposito,
      d.desc_deposito,
      cd.tasa,
      CONVERT(cd.cantidad, DECIMAL(12,0)) AS cantidad,
      CONVERT(cd.precio, DECIMAL(12,2)) AS precio,
      CONVERT(cd.precio * cd.cantidad, DECIMAL(12,2)) AS subtotald,
      CONVERT(((cd.precio * cd.cantidad) * cd.tasa)/100, DECIMAL(12,2)) AS impsubd,
      CONVERT((((cd.precio * cd.cantidad) * cd.tasa)/100) + (cd.precio * cd.cantidad), DECIMAL(12,2)) AS totald
      FROM tbventad cd
      INNER JOIN tbarticulo a ON a.idarticulo=cd.idarticulo
      INNER JOIN tbdeposito d ON d.iddeposito=cd.iddeposito
      WHERE cd.idventa ='$idventa'";
      return ejecutarConsulta($sql);
   }
}
?>
