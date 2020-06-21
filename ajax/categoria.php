<?php
require_once "../database/Categoria.php";
$categoria=new Categoria();

$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$cod_categoria=isset($_POST["cod_categoria"])? limpiarCadena($_POST["cod_categoria"]):"";
$desc_categoria=isset($_POST["desc_categoria"])? limpiarCadena($_POST["desc_categoria"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
      if (empty($idcategoria)){
       $rspta=$categoria->Insertar($cod_categoria,$desc_categoria);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
      } else {
         $rspta=$categoria->Editar($idcategoria,$cod_categoria,$desc_categoria);
         echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
      }
   break;

   case 'desactivar':
      $rspta=$categoria->Desactivar($idcategoria);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$categoria->Eliminar($idcategoria);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$categoria->Activar($idcategoria);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$categoria->Mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$categoria->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; min-width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcategoria.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idcategoria.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcategoria.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcategoria.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idcategoria.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcategoria.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_categoria.'</h5>',
				"2"=>'<h5>'.$reg->desc_categoria.'</h5>',        
				"3"=>($reg->estatus)?
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

   case'delreporte':
      //Eliminar Reporte
      sleep(20);
      unlink('../reportes/Categoriap.pdf');
   break;
   
}
?>