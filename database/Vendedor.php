<?php
require "../config/Conexion.php";

class Vendedor{

   //Funcion constructor
   public function __construct()
   {   
   }

   //Funcion Insertar Registros
   public function Insertar($cod_vendedor,$desc_vendedor,$rif,$direccion,$telefono,$fechareg,$comisionv, 
   $comisionc,$esvendedor,$escobrador)
   {
      $sql="INSERT INTO tbvendedor(cod_vendedor,desc_vendedor,rif,direccion,telefono,fechareg,comisionv, 
      comisionc,esvendedor,escobrador,estatus)
      VALUES('$cod_vendedor','$desc_vendedor','$rif','$direccion','$telefono',STR_TO_DATE('$fechareg','%d/%m/%Y'),'$comisionv', 
      '$comisionc','$esvendedor','$escobrador','1')";
      return ejecutarConsulta($sql);
   }

   //Funcion Editar Registros
   public function Editar($idvendedor,$cod_vendedor,$desc_vendedor,$rif,$direccion,$telefono,$fechareg,$comisionv, 
   $comisionc,$esvendedor,$escobrador)
   {
      $sql="UPDATE tbvendedor
      SET
      cod_vendedor='$cod_vendedor',
      desc_vendedor='$desc_vendedor',
      rif='$rif',
		direccion='$direccion',
      telefono='$telefono',
		fechareg=STR_TO_DATE('$fechareg','%d/%m/%Y'),
		comisionv='$comisionv', 
		comisionc='$comisionc', 
		esvendedor='$esvendedor', 
		escobrador='$escobrador'
      WHERE idvendedor='$idvendedor'";
      return ejecutarConsulta($sql);
   }

   //Funcion Eliminar Registros
   public function Eliminar($idvendedor)
   {
      $sql="DELETE FROM tbvendedor 
      WHERE idvendedor='$idvendedor'";
      return ejecutarConsulta($sql);
   }

   //Funcion Cambiar Estatus de Registro Inactivo
   public function Activar($idvendedor)
   {
      $sql="UPDATE tbvendedor 
      SET estatus='1' 
      WHERE idvendedor='$idvendedor'";
      return ejecutarConsulta($sql);
   }

    //Funcion Cambiar Estatus de Registro Activo
   public function Desactivar($idvendedor)
   {
      $sql="UPDATE tbvendedor 
      SET estatus='0' 
      WHERE idvendedor='$idvendedor'";
      return ejecutarConsulta($sql);
   } 

    //Funcion Listar Registros Existentes
   public function Listar()
   {
      $sql="SELECT 
      idvendedor, 
      cod_vendedor, 
      desc_vendedor,
      rif,
		direccion,
      telefono,
		DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg, 
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
      FROM tbvendedor";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Seleccionado
   public function Mostrar($idvendedor)
   {
      $sql="SELECT 
      idvendedor, 
      cod_vendedor, 
      desc_vendedor,
      rif,
		direccion,
      telefono,
		DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,  
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
      FROM tbvendedor 
      WHERE idvendedor='$idvendedor'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Funcion Listar Registros Existentes para Selleccion
   public function Select()
   {
      $sql="SELECT 
      idvendedor, 
      cod_vendedor, 
      desc_vendedor,
      rif,
		direccion,
      telefono,
		DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg, 
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
      FROM tbvendedor 
      WHERE estatus='1'
      ORDER BY cod_vendedor ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Registros
   public function RptListar()
   {
      $sql="SELECT 
      idvendedor, 
      cod_vendedor, 
      desc_vendedor,
      rif,
		direccion,
      telefono,
		DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg, 
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
      FROM tbvendedor
      ORDER BY cod_vendedor ASC";
      return ejecutarConsulta($sql);
   }
}

?>