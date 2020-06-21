<?php
require_once "../database/Impuestoi.php";
$impuestoi=new Impuestoi();

$idimpuestoi=isset($_POST["idimpuestoi"])? limpiarCadena($_POST["idimpuestoi"]):"";
$idimpuestoid=isset($_POST["idimpuestoid"])? limpiarCadena($_POST["idimpuestoid"]):"";
$cod_impuestoi=isset($_POST["cod_impuestoi"])? limpiarCadena($_POST["cod_impuestoi"]):"";
$desc_impuestoi=isset($_POST["desc_impuestoi"])? limpiarCadena($_POST["desc_impuestoi"]):"";
$base=isset($_POST["base"])? limpiarCadena($_POST["base"]):"";
$retencion=isset($_POST["retencion"])? limpiarCadena($_POST["retencion"]):"";
$sustraendo=isset($_POST["sustraendo"])? limpiarCadena($_POST["sustraendo"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idimpuestoid)){
       $rspta=$impuestoi->Insertar($_POST['idimpuestoin'],$_POST['cod_concepto'],$_POST['desc_concepto'],$base,$retencion,$sustraendo);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$impuestoi->Editar($idimpuestoid,$base,$retencion,$sustraendo);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;  

   case 'eliminar':
      $rspta=$impuestoi->Eliminar($idimpuestoid);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$impuestoi->Mostrar($idimpuestoid);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$impuestoi->Listar($idimpuestoi);
      //Vamos a declarar un array
      $data= Array();
      $renglon=0;

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

				"0"=>'<h5 '.$al.'center'.$w.'60px;" class="small btn-group">
            <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idimpuestoid.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idimpuestoid.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button>
				</h5>'
				, 	 	
				"1"=>'<h5 '.$al.'center'.$w.'30px;"><label>'.($renglon+1).'</label></h5>',
				"2"=>'<h5 '.$al.'center'.$w.'50px;">'.$reg->cod_concepto.'</h5>',
				"3"=>'<h5 '.$al.''.$w.'400px;">'.$reg->desc_concepto.'</h5>',
				"4"=>'<h5 '.$al.'right'.$w.'90px;">'.number_format($reg->base,2,",",".").'</h5>',
				"5"=>'<h5 '.$al.'right'.$w.'90px;">'.number_format($reg->retencion,2,",",".").'</h5>',
            "6"=>'<h5 '.$al.'right'.$w.'90px;">'.number_format($reg->sustraendo,2,",",".").'</h5>',
            $renglon++
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case 'ListarTipoImp':
		$rspta=$impuestoi->ListarTipoImp();

		while ($reg=$rspta->fetch_object()) {

			echo'<option value='.$reg->idimpuestoi.'>'.$reg->desc_impuestoi.'</option>';
		}
	break;

   case 'SelectImpuestoi':
		$rspta=$impuestoi->Select();

		while ($reg=$rspta->fetch_object()) {

			echo'<option value='.$reg->idimpuestoi.'>'.$reg->desc_impuestoi.'</option>';
		}
	break;

	case 'Impuestoi':
		$rspta=$impuestoi->MostrarDt($_POST['id']);
			 //Codificar el resultado utilizando json
		 echo json_encode($rspta);
   break;
}
?>