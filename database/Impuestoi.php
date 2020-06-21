<?php
require "../config/Conexion.php";

class Impuestoi
{

  //Implementamos nuestro constructor
  public function __construct()
  {   
  }

   public function Insertar($idimpuestoi,$cod_concepto,$desc_concepto,$base,$retencion,$sustraendo)
   {
      $sql="INSERT INTO tbimpuestoid(idimpuestoi,cod_concepto,desc_concepto,base,retencion,sustraendo) 
      VALUES('$idimpuestoi','$cod_concepto','$desc_concepto',REPLACE('$base',',',''),
      REPLACE('$retencion',',',''), REPLACE('$sustraendo',',',''))";
       return ejecutarConsulta($sql);
   }

  //Implementamos Editar
  public function Editar($idimpuestoid,$base,$retencion,$sustraendo)
  {
    $sql="UPDATE 
    tbimpuestoid 
    SET
    base = REPLACE('$base',',',''),
    retencion = REPLACE('$retencion',',',''),
    sustraendo = REPLACE('$sustraendo',',','')
    WHERE idimpuestoid = '$idimpuestoid'";
    return ejecutarConsulta($sql);
  }

  public function Eliminar($idimpuestoid)
  {
      $sql="DELETE FROM tbimpuestoid WHERE idimpuestoid='$idimpuestoid'";
      return ejecutarConsulta($sql);
  }

  public function ListarTipoImp()
  {
    $sql="SELECT idimpuestoi,cod_impuestoi,desc_impuestoi FROM tbimpuestoi";
    return ejecutarConsulta($sql);
  }


  //Implementamos Listar
  public function Listar($id)
  {
    $sql="SELECT
    idimpuestoid, 
    idimpuestoi, 
    cod_concepto, 
    desc_concepto,
    base,
    retencion,
    sustraendo
    FROM tbimpuestoid WHERE idimpuestoi='$id'
    ORDER BY cod_concepto ASC";
    return ejecutarConsulta($sql);
  }

    //Implementamos Mostrar
    public function MostrarDt($idimpuestoi)
    {
      $sql="SELECT 
      id.idimpuestoid,
      id.idimpuestoi,
      i.cod_impuestoi,
      i.desc_impuestoi
      FROM
      tbimpuestoid id
      INNER JOIN tbimpuestoi i ON i.idimpuestoi=id.idimpuestoi
      WHERE id.idimpuestoi='$idimpuestoi'";
      return ejecutarConsultaSimpleFila($sql);
    }
  

  //Implementamos Mostrar
  public function Mostrar($idimpuestoid)
  {
    $sql="SELECT 
    id.idimpuestoid,
    id.idimpuestoi,
    i.cod_impuestoi,
    i.desc_impuestoi,
    id.cod_concepto,
    id.desc_concepto,
    id.base,
    id.retencion,
    id.sustraendo 
    FROM
    tbimpuestoid id
    INNER JOIN tbimpuestoi i ON i.idimpuestoi=id.idimpuestoi
    WHERE id.idimpuestoid='$idimpuestoid'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idimpuestoi,
    cod_impuestoi,
    desc_impuestoi,
    estatus 
    FROM
    tbimpuestoi";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idimpuestoid, 
    idimpuestoi, 
    cod_concepto, 
    desc_concepto,
    base,
    retencion,
    sustraendo
    FROM tbimpuestoid
    ORDER BY cod_concepto ASC";
    return ejecutarConsulta($sql);
  }

}

?>