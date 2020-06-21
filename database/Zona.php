<?php
require "../config/Conexion.php";

class Zona{

   //Funcion constructor
   public function __construct(){   
   }

   //Funcion Insertar Registros
   public function Insertar($cod_zona,$desc_zona){
      $sql="INSERT INTO tbzona(cod_zona,desc_zona,estatus)
      VALUES('$cod_zona','$desc_zona','1')";
      return ejecutarConsulta($sql);
   }

   //Funcion Editar Registros
   public function Editar($idzona,$cod_zona,$desc_zona){
      $sql="UPDATE tbzona
      SET
      cod_zona='$cod_zona',
      desc_zona='$desc_zona'
      WHERE idzona='$idzona'";
      return ejecutarConsulta($sql);
   }

   //Funcion Eliminar Registros
   public function Eliminar($idzona){
      $sql="DELETE FROM tbzona 
      WHERE idzona='$idzona'";
      return ejecutarConsulta($sql);
   }

   //Funcion Cambiar Estatus de Registro Inactivo
   public function Activar($idzona){
      $sql="UPDATE tbzona 
      SET estatus='1' 
      WHERE idzona='$idzona'";
      return ejecutarConsulta($sql);
   }

    //Funcion Cambiar Estatus de Registro Activo
   public function Desactivar($idzona){
      $sql="UPDATE tbzona 
      SET estatus='0' 
      WHERE idzona='$idzona'";
      return ejecutarConsulta($sql);
   } 

    //Funcion Listar Registros Existentes
   public function Listar(){
      $sql="SELECT 
      idzona, 
      cod_zona, 
      desc_zona,
      estatus
      FROM tbzona";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Seleccionado
   public function Mostrar($idzona){
      $sql="SELECT 
      idzona, 
      cod_zona, 
      desc_zona,
      estatus
      FROM tbzona 
      WHERE idzona='$idzona'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Funcion Listar Registros Existentes para Selleccion
   public function Select(){
      $sql="SELECT 
      idzona, 
      cod_zona, 
      desc_zona,
      estatus
      FROM tbzona 
      WHERE estatus='1'
      ORDER BY cod_zona ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Registros
   public function RptListar(){
      $sql="SELECT 
      idzona, 
      cod_zona, 
      desc_zona,
      estatus
      FROM tbzona
      ORDER BY cod_zona ASC";
      return ejecutarConsulta($sql);
   }
}

?>