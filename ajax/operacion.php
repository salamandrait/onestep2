<?php
require_once "../database/Operacion.php";
$operacion=new Operacion();

$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$cod_operacion=isset($_POST["cod_operacion"])? limpiarCadena($_POST["cod_operacion"]):"";
$desc_operacion=isset($_POST["desc_operacion"])? limpiarCadena($_POST["desc_operacion"]):"";
$escompra=isset($_POST["escompra"])? limpiarCadena($_POST["escompra"]):"";
$esventa=isset($_POST["esventa"])? limpiarCadena($_POST["esventa"]):"";
$esinventario=isset($_POST["esinventario"])? limpiarCadena($_POST["esinventario"]):"";
$esconfig=isset($_POST["esconfig"])? limpiarCadena($_POST["esconfig"]):"";
$esbanco=isset($_POST["esbanco"])? limpiarCadena($_POST["esbanco"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idoperacion)){
       $rspta=$operacion->Insertar($cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$operacion->Editar($idoperacion,$cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$operacion->Desactivar($idoperacion);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$operacion->Eliminar($idoperacion);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$operacion->Activar($idoperacion);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$operacion->Mostrar($idoperacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$operacion->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idoperacion.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idoperacion.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idoperacion.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idoperacion.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idoperacion.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idoperacion.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_operacion.'</h5>',
            "2"=>'<h5 '.$al.''.$w.'250px;">'.$reg->desc_operacion.'</h5>',
            "3"=>($reg->esinventario)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o text-red"></span></h5>',
            "4"=>($reg->escompra)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o  text-red"></span></h5>', 
            "5"=>($reg->esventa)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o text-red"></span></h5>',
            "6"=>($reg->esbanco)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o  text-red"></span></h5>',              
            "7"=>($reg->esconfig)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o text-red"></span></h5>',                                
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

}
?>