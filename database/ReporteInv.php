<?php
require '../Config/Conexion.php';

class ReporteInv
{

   public function __construct(){
   }

   public function RptListarArticulo($coda='',$codb='',$desca='',$descb='',$refa='',$refb='',$codca='',$codcb='',$codla='',
   $codlb='',$torder,$order)
   {
      $item = '';
      if ($torder == 'cod') {
         $item = 'a.cod_articulo';
      } else if ($torder == 'desc') {

         $item = 'a.desc_articulo';
      } else if ($torder == 'ref') {

         $item = 'a.artref';
      }

      $sql ="SELECT 
      a.idarticulo,
      a.idcategoria,
      a.idlinea,
      a.idimpuesto,
      a.cod_articulo,
      a.desc_articulo,
      c.cod_categoria,
      c.desc_categoria,
      l.cod_linea,
      l.desc_linea,
      a.artref,
      a.origen,
      a.tipo,
      CONVERT(a.stockmin,DECIMAL(12,2)) AS stockmin,
      CONVERT(a.stockmax,DECIMAL(12,2)) AS stockmax,
      CONVERT(a.stockped,DECIMAL(12,2)) AS stockped,
      CONVERT(a.alto,DECIMAL(12,2)) AS alto,
      CONVERT(a.ancho,DECIMAL(12,2)) AS ancho,
      CONVERT(a.peso,DECIMAL(12,2)) AS peso,
      CONVERT(a.comision,DECIMAL(12,2)) AS comision, 
      IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
      CONVERT(((a.costo*i.tasa)/100)+a.costo,DECIMAL(12,2)) AS costo,
      CONVERT((((((a.precio1*a.mgp1)/100)+a.precio1)*i.tasa)/100)+(((a.precio1*a.mgp1)/100)+a.precio1),DECIMAL(12,2)) AS precio1,
      CONVERT((((((a.precio2*a.mgp2)/100)+a.precio2)*i.tasa)/100)+(((a.precio2*a.mgp2)/100)+a.precio2),DECIMAL(12,2)) AS precio2,
      CONVERT((((((a.precio3*a.mgp3)/100)+a.precio3)*i.tasa)/100)+(((a.precio3*a.mgp3)/100)+a.precio3),DECIMAL(12,2)) AS precio3,
      DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
      WHERE 
        (('$coda'='' OR a.cod_articulo>='$coda') AND ('$codb'='' OR a.cod_articulo<='$codb'))
        AND
        (('$desca'='' OR a.cod_articulo>='$desca') AND ('$descb'='' OR a.cod_articulo<='$descb'))
        AND
        (('$refa'='' OR a.cod_articulo>='$refa') AND ('$refb'='' OR a.cod_articulo<='$refb'))
        AND
        (('$codca'='' OR c.cod_categoria>='$codca') AND ('$codcb'='' OR c.cod_categoria<='$codcb'))
        AND
        (('$codla'='' OR l.cod_linea>='$codla') AND ('$codlb'='' OR l.cod_linea<='$codlb'))
        GROUP BY a.idarticulo
        ORDER BY '$item'' $order'";
      return ejecutarConsulta($sql);
   }   

   public function RptListarCategoria($coda = '', $codb = '', $desca = '', $descb = '', $torder, $order)
   {
      $item = '';
      $torder == 'cod' ? $item = 'cod_categoria' : $item = 'desc_categoria';

      $sql = "SELECT 
      idcategoria, 
      cod_categoria, 
      desc_categoria,
      estatus
      FROM tbcategoria
      WHERE 
      (('$coda'='' OR cod_categoria>='$coda') AND ('$codb'='' OR cod_categoria<='$codb'))
      AND
      (('$desca'='' OR cod_categoria>='$desca') AND ('$descb'='' OR cod_categoria<='$descb'))
      ORDER BY $item $order";
      return ejecutarConsulta($sql);
   }

   public function RptListarLinea($coda = '', $codb = '', $codca = '', $codcb = '', $desca = '', $descb = '', $torder, $order)
   {
      $item = '';
      $torder == 'cod' ? $item = 'cod_linea' : $item = 'desc_linea';

      $sql = "SELECT 
      l.idlinea, 
      l.cod_linea, 
      l.desc_linea,
      c.cod_categoria,
      c.desc_categoria,
      l.estatus
      FROM tblinea l
      INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria
      WHERE 
      (('$coda'='' OR l.cod_linea>='$coda') AND ('$codb'='' OR l.cod_linea<='$codb'))
      AND
      (('$codca'='' OR c.cod_categoria>='$codca') AND ('$codcb'='' OR c.cod_categoria<='$codcb'))
      AND
      (('$desca'='' OR l.cod_linea>='$desca') AND ('$descb'='' OR l.cod_linea<='$descb'))
      ORDER BY $item $order";
      return ejecutarConsulta($sql);
   }

   public function RptListarDeposito($coda = '', $codb = '', $desca = '', $descb = '', $torder, $order)
   {
      $item = '';
      $torder == 'cod' ? $item = 'cod_deposito' : $item = 'desc_deposito';

      $sql = "SELECT 
       iddeposito, 
       cod_deposito, 
       desc_deposito,
       responsable,
       direccion,
       DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
       solocompra,
       soloventa,
       estatus
       FROM tbdeposito
       WHERE 
       (('$coda'='' OR cod_deposito>='$coda') AND ('$codb'='' OR cod_deposito<='$codb'))
       AND
       (('$desca'='' OR cod_deposito>='$desca') AND ('$descb'='' OR cod_deposito<='$descb'))
       ORDER BY $item $order";
      return ejecutarConsulta($sql);
   }

   public function RptListarUnidad($coda = '', $codb = '', $desca = '', $descb = '', $torder, $order)
   {
      $item = '';
      $torder == 'cod' ? $item = 'cod_unidad' : $item = 'desc_unidad';

      $sql = "SELECT 
       idunidad, 
       cod_unidad, 
       desc_unidad,
       estatus
       FROM tbunidad
       WHERE 
       (('$coda'='' OR cod_unidad>='$coda') AND ('$codb'='' OR cod_unidad<='$codb'))
       AND
       (('$desca'='' OR cod_unidad>='$desca') AND ('$descb'='' OR cod_unidad<='$descb'))
       ORDER BY $item $order";
      return ejecutarConsulta($sql);
   }

   public function StockGeneral($coda='',$codb='',$desca='',$descb='',$codca='',$codcb='',$codla='',$codlb='',$condicion='',$torder,$order)
   {
      $item='';
      $torder=='cod'?$item='a.cod_articulo':$item='a.desc_articulo';

      $sql="SELECT
      a.idarticulo,
      a.cod_articulo,
      a.desc_articulo,
      c.cod_categoria,
      c.desc_categoria,
      CONVERT(a.stockmin,DECIMAL(12,2)) AS stockmin,
      CONVERT(a.stockmax,DECIMAL(12,2)) AS stockmax,
      CONVERT(IFNULL(SUM(st.cantidad/(SELECT valor FROM tbartunidad WHERE idarticulo=a.idarticulo AND principal=1)),0),INT) AS stock,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON c.idcategoria=a.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      LEFT JOIN tbstock st ON st.idarticulo=a.idarticulo
      WHERE a.tipo<>'Servicio'
      AND
      (('$coda'='' OR a.cod_articulo>='$coda') AND ('$codb'='' OR a.cod_articulo<='$codb'))
      AND
      (('$desca'='' OR a.cod_articulo>='$desca') AND ('$descb'='' OR a.cod_articulo<='$descb'))
      AND
      (('$codca'='' OR c.cod_categoria>='$codca') AND ('$codcb'='' OR c.cod_categoria<='$codcb'))
      AND
      (('$codla'='' OR l.cod_linea>='$codla') AND ('$codlb'='' OR l.cod_linea<='$codlb'))
      AND
      (('$condicion'='') 
      OR ('$condicion'='diferentecero' AND (IFNULL((st.cantidad),0))<>0)
      OR ('$condicion'='igualcero' AND (IFNULL((st.cantidad),0))=0)
      OR ('$condicion'='mayor' AND (IFNULL((st.cantidad),0))>0)
      OR ('$condicion'='menor' AND (IFNULL((st.cantidad),0))<0))
      GROUP BY a.idarticulo
      ORDER BY '$item' '$order'";
      return ejecutarConsulta($sql);
   }

   public function StockPorDeposito($coda='',$codb='',$desca='',$descb='',$codca='',$codcb='',$codla='',$codlb='',
   $codda='',$coddb='',$condicion='',$torder,$order)
   {
      $item='';
      $torder=='cod'?$item='a.cod_articulo':$item='a.desc_articulo';

      $sql="SELECT
      a.idarticulo,
      a.cod_articulo,
      a.desc_articulo,
      c.cod_categoria,
      c.desc_categoria,
      CONVERT(a.stockmin,DECIMAL(12,2)) AS stockmin,
      CONVERT(a.stockmax,DECIMAL(12,2)) AS stockmax,
      CONVERT(IFNULL(SUM(st.cantidad/(SELECT valor FROM tbartunidad WHERE idarticulo=a.idarticulo AND principal=1)),0),INT) AS stock,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON c.idcategoria=a.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      LEFT JOIN tbstock st ON st.idarticulo=a.idarticulo
      WHERE a.tipo<>'Servicio'
      AND
      (('$coda'='' OR a.cod_articulo>='$coda') AND ('$codb'='' OR a.cod_articulo<='$codb'))
      AND
      (('$desca'='' OR a.cod_articulo>='$desca') AND ('$descb'='' OR a.cod_articulo<='$descb'))
      AND
      (('$codca'='' OR c.cod_categoria>='$codca') AND ('$codcb'='' OR c.cod_categoria<='$codcb'))
      AND
      (('$codla'='' OR l.cod_linea>='$codla') AND ('$codlb'='' OR l.cod_linea<='$codlb'))
      AND
      (('$codda'='' OR (SELECT cod_deposito FROM tbdeposito  WHERE iddeposito =st.iddeposito )>='$codda') 
      AND ('$coddb'='' OR (SELECT cod_deposito FROM tbdeposito  WHERE iddeposito =st.iddeposito )<='$coddb'))
      AND
      (('$condicion'='') 
      OR ('$condicion'='diferentecero' AND (IFNULL((st.cantidad),0))<>0)
      OR ('$condicion'='igualcero' AND (IFNULL((st.cantidad),0))=0)
      OR ('$condicion'='mayor' AND (IFNULL((st.cantidad),0))>0)
      OR ('$condicion'='menor' AND (IFNULL((st.cantidad),0))<0))
      GROUP BY a.idarticulo
      ORDER BY '$item' '$order'";
      return ejecutarConsulta($sql);
   }

   public function StockDeposito($codarticulo,$codda='',$coddb='')
   {
      $sql="SELECT 
      (SELECT cod_deposito FROM tbdeposito  WHERE iddeposito =s.iddeposito ) AS cod_deposito,
      (SELECT desc_deposito FROM tbdeposito  WHERE iddeposito =s.iddeposito ) AS desc_deposito,
      CONVERT(IFNULL(s.cantidad,0),INT) AS stock,
      CASE 
      WHEN '$codda'='' THEN (SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo)
      WHEN '$codda'<>'' THEN  CONVERT(IFNULL(s.cantidad,0),INT) 
      END AS stock2
      FROM tbarticulo a
      LEFT JOIN tbstock s ON s.idarticulo=a.idarticulo
      WHERE a.cod_articulo='$codarticulo'
      AND (('$codda'='' OR (SELECT cod_deposito FROM tbdeposito  WHERE iddeposito =s.iddeposito )>='$codda') 
      AND ('$coddb'='' OR (SELECT cod_deposito FROM tbdeposito  WHERE iddeposito =s.iddeposito )<='$coddb'))";
      return ejecutarConsulta($sql);   
   }

   public function ArtUnidad($codarticulo)
   {
      $sql="SELECT 
      au.idarticulo,
      u.cod_unidad,
      u.desc_unidad,
      au.valor
      FROM tbartunidad au
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE (SELECT cod_articulo FROM tbarticulo WHERE idarticulo =au.idarticulo)='$codarticulo'
      ORDER BY au.valor ASC";
      return ejecutarConsulta($sql);   
   }
   
   public function ArticuloCosto($coda='',$codb='',$desca='',$descb='',$refa='',$refb='',$codca='',$codcb='',$codla='',
   $codlb='',$torder,$order)
   {
      $item = '';
         if ($torder == 'cod') {
            $item = 'a.cod_articulo';
         } else if ($torder == 'desc') {

            $item = 'a.desc_articulo';
         } else if ($torder == 'ref') {

            $item = 'a.artref';
         }

      $sql="SELECT 
      a.idarticulo,
      a.idcategoria,
      a.idlinea,
      a.cod_articulo,
      a.desc_articulo,
      c.cod_categoria,
      c.desc_categoria,
      a.artref,
      a.tipo,
      (SELECT desc_unidad FROM tbunidad 
      WHERE idunidad=(SELECT idunidad FROM tbartunidad WHERE principal='1' AND idarticulo=a.idarticulo)) AS desc_unidad,
      CONVERT(IFNULL(a.costo,0),DECIMAL(12,2)) AS costo,
      CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
      CONVERT((i.tasa*a.costo)/100,DECIMAL(12,2)) AS impuesto,
      CONVERT(a.costo+((i.tasa*a.costo)/100),DECIMAL(12,2)) AS totalcosto,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON c.idcategoria=a.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
      WHERE 
      (('$coda'='' OR a.cod_articulo>='$coda') AND ('$codb'='' OR a.cod_articulo<='$codb'))
      AND
      (('$desca'='' OR a.cod_articulo>='$desca') AND ('$descb'='' OR a.cod_articulo<='$descb'))
      AND
      (('$refa'='' OR a.cod_articulo>='$refa') AND ('$refb'='' OR a.cod_articulo<='$refb'))
      AND
      (('$codca'='' OR c.cod_categoria>='$codca') AND ('$codcb'='' OR c.cod_categoria<='$codcb'))
      AND
      (('$codla'='' OR l.cod_linea>='$codla') AND ('$codlb'='' OR l.cod_linea<='$codlb'))";
      return ejecutarConsulta($sql);
   }    
}
?>