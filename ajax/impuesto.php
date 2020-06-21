<?php
require_once "../database/Impuesto.php";
$impuesto=new Impuesto();

$idimpuesto=isset($_POST["idimpuesto"])? limpiarCadena($_POST["idimpuesto"]):"";
$cod_impuesto=isset($_POST["cod_impuesto"])? limpiarCadena($_POST["cod_impuesto"]):"";
$desc_impuesto=isset($_POST["desc_impuesto"])? limpiarCadena($_POST["desc_impuesto"]):"";
$simbolo=isset($_POST["simbolo"])? limpiarCadena($_POST["simbolo"]):"";
$tasa=isset($_POST["tasa"])? limpiarCadena($_POST["tasa"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idimpuesto)){
       $rspta=$impuesto->Insertar($cod_impuesto,$desc_impuesto,$simbolo,$tasa);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$impuesto->Editar($idimpuesto,$cod_impuesto,$desc_impuesto,$simbolo,$tasa);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$impuesto->Desactivar($idimpuesto);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$impuesto->Eliminar($idimpuesto);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$impuesto->Activar($idimpuesto);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$impuesto->Mostrar($idimpuesto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$impuesto->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idimpuesto.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idimpuesto.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idimpuesto.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idimpuesto.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idimpuesto.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idimpuesto.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_impuesto.'</h5>',
            "2"=>'<h5>'.$reg->desc_impuesto.'</h5>', 
            "3"=>'<h5 '.$al.'right'.$w.'60px;">'.$reg->tasa.'%</h5>',         
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
}
?>