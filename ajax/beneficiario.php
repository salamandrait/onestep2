<?php
require_once "../database/Beneficiario.php";
$beneficiario=new Beneficiario();

$idbeneficiario=isset($_POST["idbeneficiario"])? limpiarCadena($_POST["idbeneficiario"]):"";
$idimpuestoi=isset($_POST["idimpuestoi"])? limpiarCadena($_POST["idimpuestoi"]):"";
$cod_beneficiario=isset($_POST["cod_beneficiario"])? limpiarCadena($_POST["cod_beneficiario"]):"";
$desc_beneficiario=isset($_POST["desc_beneficiario"])? limpiarCadena($_POST["desc_beneficiario"]):"";
$rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idbeneficiario)){
       $rspta=$beneficiario->Insertar($idimpuestoi,$cod_beneficiario,$desc_beneficiario,$rif,$direccion,$telefono,$fechareg);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$beneficiario->Editar($idimpuestoi,$idbeneficiario,$cod_beneficiario,$desc_beneficiario,$rif,$direccion,$telefono,$fechareg);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$beneficiario->Desactivar($idbeneficiario);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$beneficiario->Eliminar($idbeneficiario);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$beneficiario->Activar($idbeneficiario);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$beneficiario->Mostrar($idbeneficiario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$beneficiario->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idbeneficiario.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idbeneficiario.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idbeneficiario.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idbeneficiario.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idbeneficiario.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idbeneficiario.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_beneficiario.'</h5>',
            "2"=>'<h5>'.$reg->desc_beneficiario.'</h5>',  
            "3"=>'<h5 '.$al.''.$w.'100px;">'.$reg->rif.'</h5>',
				"4"=>'<h5 '.$al.''.$w.'150px;">'.$reg->telefono.'</h5>',             
				"5"=>($reg->estatus)?
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

   case 'SelectImpuestoi':
      require_once "../database/Impuestoi.php";
      $impuestoi = new Impuestoi();

      $rspta=$impuestoi->ListarTipoImp();

      while ($reg=$rspta->fetch_object()) {

         echo'<option value='.$reg->idimpuestoi.'>'.$reg->desc_impuestoi.'</option>';
      }
   break;
}
?>