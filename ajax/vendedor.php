<?php
require_once "../database/Vendedor.php";
$vendedor=new Vendedor();

$idvendedor=isset($_POST["idvendedor"])? limpiarCadena($_POST["idvendedor"]):"";
$cod_vendedor=isset($_POST["cod_vendedor"])? limpiarCadena($_POST["cod_vendedor"]):"";
$desc_vendedor=isset($_POST["desc_vendedor"])? limpiarCadena($_POST["desc_vendedor"]):"";
$rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$comisionv=isset($_POST["comisionv"])? limpiarCadena($_POST["comisionv"]):"";
$comisionc=isset($_POST["comisionc"])? limpiarCadena($_POST["comisionc"]):"";
$esvendedor=isset($_POST["esvendedor"])? limpiarCadena($_POST["esvendedor"]):"";
$escobrador=isset($_POST["escobrador"])? limpiarCadena($_POST["escobrador"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
   if (empty($idvendedor)){
      $rspta=$vendedor->Insertar($cod_vendedor,$desc_vendedor,$rif,$direccion,$telefono,$fechareg,$comisionv, 
   $comisionc,$esvendedor,$escobrador);
      echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
      $rspta=$vendedor->Editar($idvendedor,$cod_vendedor,$desc_vendedor,$rif,$direccion,$telefono,$fechareg,$comisionv, 
   $comisionc,$esvendedor,$escobrador);
      echo $rspta=='1'?"Registro Actualizado Correctamente! <span class='label btn-success'><i class='fa fa-check'></i></span>":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$vendedor->Desactivar($idvendedor);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$vendedor->Eliminar($idvendedor);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$vendedor->Activar($idvendedor);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$vendedor->Mostrar($idvendedor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$vendedor->Listar();
      //Vamos a declarar un array
      $data= Array();

         while ($reg=$rspta->fetch_object()){

            $al='style="text-align:';
            $w='; width:';
            $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idvendedor.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idvendedor.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idvendedor.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idvendedor.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idvendedor.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idvendedor.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_vendedor.'</h5>',
				"2"=>'<h5>'.$reg->desc_vendedor.'</h5>',
            "3"=>($reg->esvendedor)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o text-red"></span></h5>',
            "4"=>'<h5 style="text-align:center; width:80px;">'.$reg->comisionv.'</h5>',
            "5"=>($reg->escobrador)?
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':
            '<h5 '.$al.'center'.$w.'85px;"><span class="fa fa-circle-o  text-red"></span></h5>',
            "6"=>'<h5 style="text-align:center; width:80px;">'.$reg->comisionc.'</h5>',
				"7"=>($reg->estatus)?
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