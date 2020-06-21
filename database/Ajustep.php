<?php
require "../config/Conexion.php";

class Ajustep{

   //Funcion constructor
   public function __construct(){   
   }

   //Actualizamos Codigo de Operacion
   public function ActCod()
   {
      $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbajustep' AND estatus='1'";
      return ejecutarConsulta($sql);
   }

   //Funcion Insertar Registros
   public function Insertar($idusuario,$cod_ajustep,$desc_ajustep,$tipo,$fechareg,
   $idarticulo,$tasa,$tipoprecio,$mgp,$precio,$costo)
   {
      $sql="INSERT INTO tbajustep(idusuario, cod_ajustep, desc_ajustep, estatus, tipo, fechareg, fechadb)
      VALUES('$idusuario','$cod_ajustep','$desc_ajustep','Registrado','$tipo',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      $idajustep=ejecutarConsulta_retornarID($sql);

         $num_elementos=0;
         $sw=true;
         while ($num_elementos < count($idarticulo)) {
            $sql_detalle="INSERT INTO tbajustepd(idajustep,idarticulo,tasa,tipoprecio,mgp,precio,costo)
            VALUES('$idajustep','$idarticulo[$num_elementos]','$tasa[$num_elementos]','$tipoprecio[$num_elementos]',
            '$mgp[$num_elementos]','$precio[$num_elementos]','$costo[$num_elementos]')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
         }
      return $sw;
   }

   //Implementamos Mostrar
   public function MostrarCod($cod_ajustep)
   {
      $sql="SELECT 
      idajustep
      FROM tbajustep
      WHERE cod_ajustep='$cod_ajustep'";
      return ejecutarConsultaSimpleFila($sql);
   }

   public function Procesar($idajustep)
   {
      $sql="UPDATE tbajustep 
      SET estatus='Procesado' 
      WHERE idajustep='$idajustep'";
      return ejecutarConsulta($sql);
   }
   //Funcion Procesar Registros
   public function ProcesarC($idarticulo,$costo)
   {
      $num_elementos=0;
      $sw=true;

      while ($num_elementos < count($idarticulo)) {
         $sql="UPDATE tbarticulo
         SET
         costo='$costo[$num_elementos]'
         WHERE idarticulo='$idarticulo[$num_elementos]'";
         ejecutarConsulta($sql) or $sw = false;
			$num_elementos=$num_elementos + 1;
      }
      return $sw;
   }

   //Funcion Procesar Registros
   public function ProcesarP($tipoprecio,$idarticulo,$mgp,$precio)
   {
      $num_elementos=0;
      $sw=true;
      while ($num_elementos < count($idarticulo)){ 
         if ($tipoprecio[$num_elementos]=='p1') {
            $sql ="UPDATE tbarticulo SET
            precio1='$precio[$num_elementos]',
            mgp1='$mgp[$num_elementos]'
            WHERE 
            idarticulo='$idarticulo[$num_elementos]'";
            ejecutarConsulta($sql) or $sw = false;
            $num_elementos=$num_elementos + 1; 

         } elseif ($tipoprecio[$num_elementos]=='p2'){

            $sql ="UPDATE tbarticulo SET
            precio2='$precio[$num_elementos]',
            mgp2='$mgp[$num_elementos]'
            WHERE 
            idarticulo='$idarticulo[$num_elementos]'";
            ejecutarConsulta($sql) or $sw = false;
            $num_elementos=$num_elementos + 1;

         } elseif ($tipoprecio[$num_elementos]=='p3'){

            $sql ="UPDATE tbarticulo SET
            precio3='$precio[$num_elementos]',
            mgp3='$mgp[$num_elementos]'
            WHERE 
            idarticulo='$idarticulo[$num_elementos]'";
            ejecutarConsulta($sql) or $sw = false;
            $num_elementos=$num_elementos + 1;
         }
      }  
      return $sw;
   }

   //Funcion Eliminar Registros
   public function Eliminar($idajustep)
   {
      $sql="DELETE FROM tbajustep 
      WHERE idajustep='$idajustep'";
      return ejecutarConsulta($sql);
   }

    //Funcion Cambiar Estatus de Registro Activo
   public function Anular($idajustep)
   {
      $sql="UPDATE tbajustep 
      SET estatus='Anulado' 
      WHERE idajustep='$idajustep'";
      return ejecutarConsulta($sql);
   } 

    //Funcion Listar Registros Existentes
   public function Listar()
   {
      $sql="SELECT 
      idajustep,
      cod_ajustep, 
      desc_ajustep,
      estatus,
      tipo,
      DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg
      FROM tbajustep";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Seleccionado
   public function Mostrar($idajustep)
   {
      $sql="SELECT 
      ajp.idajustep,
      ajp.idusuario,
      ajp.cod_ajustep, 
      ajp.desc_ajustep,
      ajp.estatus,
      ajp.tipo,
      ajpd.tipoprecio,
      DATE_FORMAT(ajp.fechareg,'%d/%m/%Y') AS fechareg
      FROM tbajustep ajp
      INNER JOIN tbajustepd ajpd ON ajpd.idajustep=ajp.idajustep 
      WHERE ajp.idajustep='$idajustep'
      GROUP BY ajpd.idajustep";
      return ejecutarConsultaSimpleFila($sql);
   }

   public function MostrarDetalle($idajustep,$tipo){
      switch ($tipo) {
         case 'Costo':
            $sql="SELECT
            ajpd.idarticulo,
            a.cod_articulo,
            a.desc_articulo,
            ajpd.costo,
            ajpd.tasa
            FROM tbajustepd ajpd
            INNER JOIN tbarticulo a ON a.idarticulo=ajpd.idarticulo
            WHERE idajustep='$idajustep'";
            return ejecutarConsulta($sql);
         break;

         case 'Precio':
            $sql="SELECT
            ajpd.idarticulo,
            a.cod_articulo,
            a.desc_articulo,
            ajpd.tipoprecio,
            ajpd.mgp,
            ajpd.precio,
            ajpd.tasa
            FROM tbajustepd ajpd
            INNER JOIN tbarticulo a ON a.idarticulo=ajpd.idarticulo
            WHERE idajustep='$idajustep'";
            return ejecutarConsulta($sql);
         break;
      }
   }

   //Funcion Listar Registros Existentes para Selleccion
   public function Select()
   {
      $sql="SELECT 
      idajustep, 
      cod_ajustep, 
      desc_ajustep,
      estatus
      FROM tbajustep 
      WHERE estatus='1'
      ORDER BY cod_ajustep ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Registros
   public function RptListar()
   {
      $sql="SELECT 
      idajustep, 
      cod_ajustep, 
      desc_ajustep,
      estatus
      FROM tbajustep
      ORDER BY cod_ajustep ASC";
      return ejecutarConsulta($sql);
   }
}

?>