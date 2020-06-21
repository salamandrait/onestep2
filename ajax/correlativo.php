<?php
require_once "../database/Correlativo.php";
$correlativo=new Correlativo();

$idcorrelativo=isset($_POST["idcorrelativo"])? limpiarCadena($_POST["idcorrelativo"]):"";
$cod_correlativo=isset($_POST["cod_correlativo"])? limpiarCadena($_POST["cod_correlativo"]):"";
$desc_correlativo=isset($_POST["desc_correlativo"])? limpiarCadena($_POST["desc_correlativo"]):"";
$grupo=isset($_POST["grupo"])? limpiarCadena($_POST["grupo"]):"";
$tabla=isset($_POST["tabla"])? limpiarCadena($_POST["tabla"]):"";
$cadena=isset($_POST["cadena"])? limpiarCadena($_POST["cadena"]):"";
$precadena=isset($_POST["precadena"])? limpiarCadena($_POST["precadena"]):"";
$cod_num=isset($_POST["cod_num"])? limpiarCadena($_POST["cod_num"]):"";
$largo=isset($_POST["largo"])? limpiarCadena($_POST["largo"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idcorrelativo)){
       $rspta=$correlativo->Insertar($cod_correlativo,$desc_correlativo,$grupo,$tabla,$cadena,$precadena,$cod_num,$largo);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$correlativo->Editar($idcorrelativo,$cod_correlativo,$desc_correlativo,$grupo,$tabla,$cadena,$precadena,$cod_num,$largo);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$correlativo->Desactivar($idcorrelativo);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$correlativo->Eliminar($idcorrelativo);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$correlativo->Activar($idcorrelativo);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$correlativo->Mostrar($idcorrelativo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$correlativo->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcorrelativo.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idcorrelativo.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcorrelativo.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcorrelativo.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idcorrelativo.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcorrelativo.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_correlativo.'</h5>',
            "2"=>'<h5>'.$reg->desc_correlativo.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'100px;">'.$reg->tabla.'</h5>',          
				"4"=>'<h5 '.$al.'center'.$w.'70px;">'.$reg->precadena.'</h5>',
				"5"=>'<h5 '.$al.'center'.$w.'70px;">'.$reg->cadena.'</h5>',
				"6"=>'<h5 '.$al.'center'.$w.'80px;">'.$reg->cod_num.'</h5>',
				"7"=>'<h5 '.$al.'center'.$w.'50px;">'.$reg->largo.'</h5>',      
				"8"=>($reg->estatus)?
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

   case 'generarCod':
		$rspta=$correlativo->GenerarCod($_POST['tabla']);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
}
?>