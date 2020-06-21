<?php
require "../config/Conexion.php";

class Articulo{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,$artref,
   $stockmin,$stockmax,$stockped,$alto,$ancho,$peso,$comision,$costo,$mgp1,$mgp2,$mgp3,$precio1,$precio2,$precio3,$fechareg,$costoprecio,
   $imagen)
   {
     $sql="INSERT INTO tbarticulo(idcategoria,idlinea,idimpuesto,cod_articulo,desc_articulo,tipo,origen,artref,stockmin
     ,stockmax,stockped,alto,ancho,peso,comision,costo,mgp1,mgp2,mgp3,precio1,precio2,precio3,fechareg,costoprecio,imagen,estatus)
     VALUES ('$idcategoria','$idlinea','$idimpuesto','$cod_articulo','$desc_articulo','$tipo','$origen','$artref',
     '$stockmin','$stockmax','$stockped','$alto','$ancho','$peso','$comision',REPLACE('$costo',',',''),'$mgp1','$mgp2','$mgp3',
     REPLACE('$precio1',',',''),REPLACE('$precio2',',',''),REPLACE('$precio3',',',''),STR_TO_DATE('$fechareg','%d/%m/%Y'),
     '$costoprecio','$imagen','1')";
     return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idarticulo,$idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,
   $origen,$artref,$stockmin,$stockmax,$stockped,$alto,$ancho,$peso,$comision,$costo,$mgp1,$mgp2,$mgp3,$precio1,$precio2,$precio3,
   $fechareg,$imagen,$costoprecio)
   {
     $sql="UPDATE tbarticulo 
     SET
     idcategoria = '$idcategoria',
     idlinea = '$idlinea',
     idimpuesto = '$idimpuesto',
     cod_articulo ='$cod_articulo',
     desc_articulo ='$desc_articulo',
     tipo = '$tipo',
     origen = '$origen',
     artref = '$artref',
     stockmin ='$stockmin',
     stockmax ='$stockmax',
     stockped='$stockped',
     alto ='$alto',
     ancho ='$ancho',
     peso ='$peso',
     comision ='$comision',
     costo = REPLACE('$costo',',',''),
     mgp1='$mgp1',
     mgp2='$mgp2',
     mgp3='$mgp3',
     precio1 =REPLACE('$precio1',',',''),
     precio2 =REPLACE('$precio2',',',''),
     precio3 =REPLACE('$precio3',',',''),
     fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y'),
     imagen = '$imagen',
     costoprecio='$costoprecio'
     WHERE idarticulo ='$idarticulo'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idarticulo)
   {
      $sql="DELETE FROM tbarticulo 
      WHERE idarticulo='$idarticulo'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idarticulo)
   {
      $sql="UPDATE tbarticulo 
      SET estatus='1' 
      WHERE idarticulo='$idarticulo'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idarticulo)
   {
      $sql="UPDATE tbarticulo 
      SET estatus='0' 
      WHERE idarticulo='$idarticulo'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
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
      a.imagen,
      a.estatus,     
      IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
      CONVERT(a.costo,DECIMAL(12,2)) AS costo,
      CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
      CONVERT(a.mgp1,DECIMAL(12,0)) AS mgp1,
      CONVERT(a.mgp2,DECIMAL(12,0)) AS mgp2,
      CONVERT(a.mgp3,DECIMAL(12,0)) AS mgp3,
      CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
      CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
      CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
      DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
      a.costoprecio,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto";
      return ejecutarConsulta($sql);
   }

      //Implementamos Listar
   public function ListarPrecio($idarticulo,$tasa,$tipoprecio)
   {
      $sql="SELECT 
      a.idarticulo,
      CASE 
      WHEN '$tipoprecio'='p1' THEN (((((a.precio1*a.mgp1)/100)+a.precio1)*'$tasa')/100)+(((a.precio1*a.mgp1)/100)+a.precio1)
      WHEN '$tipoprecio'='p2' THEN (((((a.precio2*a.mgp2)/100)+a.precio2)*'$tasa')/100)+(((a.precio2*a.mgp2)/100)+a.precio2)
      WHEN '$tipoprecio'='p3' THEN (((((a.precio3*a.mgp3)/100)+a.precio3)*'$tasa')/100)+(((a.precio3*a.mgp3)/100)+a.precio3)
      END AS precio
      FROM tbarticulo a
      WHERE idarticulo='$idarticulo'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Implementamos Mostrar
   public function Mostrar($idarticulo)
   {
      $sql="SELECT 
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
      a.imagen,
      a.estatus,     
      IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
      CONVERT(a.costo,DECIMAL(12,2)) AS costo,
      CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
      CONVERT(a.mgp1,DECIMAL(12,0)) AS mgp1,
      CONVERT(a.mgp2,DECIMAL(12,0)) AS mgp2,
      CONVERT(a.mgp3,DECIMAL(12,0)) AS mgp3,
      CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
      CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
      CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
      DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
      a.costoprecio,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto 
      WHERE a.idarticulo='$idarticulo'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Implementamos Mostrar
   public function MostrarCod($cod_articulo)
   {
      $sql="SELECT 
      idarticulo
      FROM tbarticulo
      WHERE cod_articulo='$cod_articulo'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Implementamos Select
   public function Select()
   {
      $sql="SELECT 
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
      a.imagen,
      a.estatus,     
      IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
      CONVERT(a.costo,DECIMAL(12,2)) AS costo,
      CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
      CONVERT(a.mgp1,DECIMAL(12,0)) AS mgp1,
      CONVERT(a.mgp2,DECIMAL(12,0)) AS mgp2,
      CONVERT(a.mgp3,DECIMAL(12,0)) AS mgp3,
      CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
      CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
      CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
      DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
      a.costoprecio,
      a.estatus
      FROM tbarticulo a 
      INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
      INNER JOIN tblinea l ON l.idlinea=a.idlinea
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto 
      WHERE a.estatus='1'
      ORDER BY a.cod_articulo ASC";
      return ejecutarConsulta($sql);
   }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
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
    a.imagen,
    a.estatus,     
    IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
    CONVERT(a.costo,DECIMAL(12,2)) AS costo,
    CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
    CONVERT(a.mgp1,DECIMAL(12,0)) AS mgp1,
    CONVERT(a.mgp2,DECIMAL(12,0)) AS mgp2,
    CONVERT(a.mgp3,DECIMAL(12,0)) AS mgp3,
    CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
    CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
    CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
    DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
    a.costoprecio,
    a.estatus
    FROM tbarticulo a 
    INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
    INNER JOIN tblinea l ON l.idlinea=a.idlinea
    INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
    ORDER BY a.cod_articulo ASC";
    return ejecutarConsulta($sql);
  }

   //Implementamos Insertar
   public function InsertarArtUnidad($idarticulo,$idunidad,$principal,$valor)
   {
      $sql="INSERT INTO tbartunidad (idarticulo,idunidad,principal,valor) 
      VALUES('$idarticulo','$idunidad','$principal','$valor')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Insertar
   public function EditarArtUnidad($idartunidad,$idunidad,$principal,$valor)
   {
      $sql="UPDATE 
      tbartunidad 
      SET
      idunidad = '$idunidad',
      valor = '$valor',
      principal = '$principal' 
      WHERE idartunidad = '$idartunidad'";
      return ejecutarConsulta($sql);
   }    

   //Implementamos Eliminar
   public function EliminarUnidad($idartunidad)
   {
      $sql="DELETE FROM tbartunidad 
      WHERE idartunidad='$idartunidad'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Listar
   public function MostrarArtUnidad($idarticulo,$idartunidad)
   {
      $sql="SELECT
      au.idartunidad,
      au.idarticulo,
      au.idunidad,
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      au.valor,
      au.principal
      FROM tbartunidad au 
      INNER JOIN tbarticulo a ON a.idarticulo=au.idarticulo
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE au.idarticulo='$idarticulo' AND au.idartunidad='$idartunidad'";
      return ejecutarConsultaSimpleFila($sql);
   }   
  
   //Implementamos Listar
   public function MostrarArtUnidadId($idartunidad)
   {
      $sql="SELECT
      au.idartunidad,
      au.idarticulo,
      au.idunidad,
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      CONVERT(au.valor,INTEGER) AS valor,
      au.principal
      FROM tbartunidad au 
      INNER JOIN tbarticulo a ON a.idarticulo=au.idarticulo
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE au.idartunidad='$idartunidad'";
      return ejecutarConsultaSimpleFila($sql);
   } 

   //Implementamos Listar
   public function ListarArtUnidad($idarticulo)
   {
      $sql="SELECT
      au.idartunidad,
      au.idarticulo,
      au.idunidad,
      a.cod_articulo,
      a.desc_articulo,
      u.cod_unidad,
      u.desc_unidad,
      CONVERT(au.valor,INTEGER) AS valor,
      au.principal
      FROM tbartunidad au 
      INNER JOIN tbarticulo a ON a.idarticulo=au.idarticulo
      INNER JOIN tbunidad u ON u.idunidad=au.idunidad
      WHERE au.idarticulo='$idarticulo'";
      return ejecutarConsulta($sql);
   }

   //Implementar un método para listar los registros y mostrar en el select
   public function SelectAjuste($iddeposito,$tipo)
   {
      if($tipo=='Entrada'||$tipo=='Salida'){

      $sql="SELECT
      (SELECT cod_deposito FROM tbdeposito WHERE iddeposito='$iddeposito') AS cod_deposito,
      (SELECT desc_deposito FROM tbdeposito WHERE iddeposito='$iddeposito') AS desc_deposito,
      a.cod_articulo,
      a.desc_articulo,
      a.artref,
      a.tipo,
      IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$iddeposito' AND idarticulo=a.idarticulo),'null') AS disp,
      IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$iddeposito' AND idarticulo=a.idarticulo),0) AS stock,
      a.costo,
      i.tasa,
      a.estatus,
      au.idarticulo,
      a.idcategoria,
      a.idimpuesto,
      (SELECT iddeposito FROM tbdeposito WHERE iddeposito='$iddeposito') AS iddeposito 
      FROM tbarticulo a
      INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
      LEFT JOIN tbstock s ON s.idarticulo=a.idarticulo
      LEFT JOIN tbdeposito d ON d.iddeposito=s.iddeposito
      WHERE a.estatus='1' AND a.tipo<>'Servicio'
      GROUP BY a.idarticulo";
      return ejecutarConsulta($sql);

      } else {

      $sql="SELECT 
      d.cod_deposito,
      d.desc_deposito,
      a.cod_articulo,
      a.desc_articulo,
      a.artref,
      a.tipo,
      s.cantidad AS stock,
      s.cantidad AS disp,
      a.costo,
      i.tasa,
      a.estatus,
      au.idarticulo,
      a.idimpuesto,
      d.iddeposito
      FROM tbarticulo a
      INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
      INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
      INNER JOIN tbstock s ON s.idarticulo=a.idarticulo
      INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
      WHERE a.estatus='1' AND s.iddeposito='$iddeposito' AND s.cantidad<>0
      GROUP BY a.idarticulo";
      return ejecutarConsulta($sql);
      }
   }

   public function SelectTraslado($iddepositoi,$iddepositod)
   {
     $sql="SELECT
     a.idarticulo, 
     s.iddeposito,
     a.cod_articulo, 
     a.desc_articulo, 
     a.tipo, 
     a.artref, 
     a.costo,
     s.cantidad AS stock,
     IFNULL((SELECT cantidad FROM tbstock WHERE idarticulo=a.idarticulo AND iddeposito='$iddepositod'),'null') AS disp
     FROM
     tbstock AS s 
     INNER JOIN tbarticulo a ON s.idarticulo = a.idarticulo
     INNER JOIN tbdeposito d ON d.iddeposito = s.iddeposito
     WHERE s.iddeposito='$iddepositoi' AND s.cantidad<>0";
     return ejecutarConsulta($sql);
   }

   public function SelectCompra($iddeposito)
   {
     $sql="SELECT
     a.cod_articulo,
     a.desc_articulo,
     a.tipo AS tipoa,
     a.artref,
     a.costo,
     i.tasa,
     au.idarticulo,
     (SELECT iddeposito FROM tbdeposito WHERE iddeposito='$iddeposito') AS iddeposito,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$iddeposito' AND idarticulo=au.idarticulo),'null') AS disp,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$iddeposito' AND idarticulo=au.idarticulo),0) AS stock
     FROM tbartunidad au
     INNER JOIN tbarticulo a ON a.idarticulo=au.idarticulo
     INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
     WHERE a.estatus='1' 
     GROUP BY au.idarticulo";
     return ejecutarConsulta($sql);
   }

   public function SelectVenta($iddeposito)
   {
     $sql="SELECT
     a.cod_articulo,
     a.desc_articulo,
     a.tipo AS tipoa,
     a.artref,
     i.tasa,
     au.idarticulo,
     (SELECT iddeposito FROM tbdeposito WHERE iddeposito='$iddeposito') AS iddeposito,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$iddeposito' AND idarticulo=au.idarticulo),'null') AS disp,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$iddeposito' AND idarticulo=au.idarticulo),0) AS stock
     FROM tbartunidad au
     INNER JOIN tbarticulo a ON a.idarticulo=au.idarticulo
     INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
     WHERE a.estatus='1' 
     GROUP BY au.idarticulo";
     return ejecutarConsulta($sql);
   }

   public function SelectAjustePrecio($tipoprecio,$costoaprecio){
      if ($costoaprecio==false) {
         $sql="SELECT 
         a.idarticulo,
         a.cod_articulo,
         a.desc_articulo,
         i.tasa,
         a.artref,
         CASE 
         WHEN 'p1'='$tipoprecio' THEN a.mgp1
         WHEN 'p2'='$tipoprecio' THEN a.mgp2
         WHEN 'p3'='$tipoprecio' THEN a.mgp3
         END AS mgp,
         CASE 
         WHEN 'p1'='$tipoprecio' THEN a.precio1
         WHEN 'p2'='$tipoprecio' THEN a.precio2
         WHEN 'p3'='$tipoprecio' THEN a.precio3
         END AS precio
         FROM tbarticulo a
         INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto";
         return ejecutarConsulta($sql);  
      } else {
         $sql="SELECT 
         a.idarticulo,
         a.cod_articulo,
         a.desc_articulo,
         i.tasa,
         a.artref,
         CASE 
         WHEN 'p1'='$tipoprecio' THEN a.mgp1
         WHEN 'p2'='$tipoprecio' THEN a.mgp2
         WHEN 'p3'='$tipoprecio' THEN a.mgp3
         END AS mgp,
         CASE 
         WHEN 'p1'='$tipoprecio' THEN a.costo
         WHEN 'p2'='$tipoprecio' THEN a.costo
         WHEN 'p3'='$tipoprecio' THEN a.costo
         END AS precio
         FROM tbarticulo a
         INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto";
         return ejecutarConsulta($sql);
      }
   }

   public function SelectAjusteCosto(){
      $sql="SELECT 
      a.idarticulo,
      a.cod_articulo,
      a.desc_articulo,
      i.tasa,
      a.costo
      FROM tbarticulo a
      INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto";
      return ejecutarConsulta($sql);       
   }
}

?>