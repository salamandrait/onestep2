<?php
require_once "../database/Linea.php";
$linea=new Linea();

$idlinea=isset($_POST["idlinea"])? limpiarCadena($_POST["idlinea"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$cod_linea=isset($_POST["cod_linea"])? limpiarCadena($_POST["cod_linea"]):"";
$desc_linea=isset($_POST["desc_linea"])? limpiarCadena($_POST["desc_linea"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idlinea)){
       $rspta=$linea->Insertar($cod_linea,$idcategoria,$desc_linea);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$linea->Editar($idlinea,$idcategoria,$cod_linea,$desc_linea);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$linea->Desactivar($idlinea);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$linea->Eliminar($idlinea);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$linea->Activar($idlinea);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$linea->Mostrar($idlinea);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$linea->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; min-width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idlinea.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idlinea.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idlinea.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idlinea.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idlinea.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idlinea.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
            "1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_linea.'</h5>',
            "2"=>'<h5>'.$reg->desc_linea.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'220px;">'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</h5>',        
				"4"=>($reg->estatus)?
				'<h5 '.$al.'center'.$w.'80px;"><span class="label bg-green">Activado</span></h5>':
				'<h5 '.$al.'center'.$w.'80px;"><span class="label bg-red">Desactivado</span></h5>'
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case 'selectCategoria':
      require_once '../database/Categoria.php';
      $categoria=new Categoria();

      $rspta=$categoria->Select();

      while ($reg=$rspta->fetch_object()) 
      {
         echo '<option value='.$reg->idcategoria.'>'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</option>';
      }
   break;

   case'delreporte':
      //Eliminar Reporte
      sleep(20);
      unlink('../reportes/Listado de Lineas.pdf');
   break;

}
?>