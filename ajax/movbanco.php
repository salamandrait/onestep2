<?php
require_once "../database/MovBanco.php";
$movbanco=new MovBanco();

$idmovbanco=isset($_POST["idmovbanco"])? limpiarCadena($_POST["idmovbanco"]):"";
$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_movbanco=isset($_POST["cod_movbanco"])? limpiarCadena($_POST["cod_movbanco"]):"";
$desc_movbanco=isset($_POST["desc_movbanco"])? limpiarCadena($_POST["desc_movbanco"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$numerod=isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
$numeroc=isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
$montod=isset($_POST["montod"])? limpiarCadena($_POST["montod"]):"";
$montoh=isset($_POST["montoh"])? limpiarCadena($_POST["montoh"]):"";
$saldoinicial=isset($_POST["saldoinicial"])? limpiarCadena($_POST["saldoinicial"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idmovbanco)){
       $rspta=$movbanco->Insertar($idcuenta,$idoperacion,$idusuario,$cod_movbanco,$desc_movbanco,$tipo,
       $origen,$numerod,$numeroc,$montod,$montoh,$saldoinicial,$fechareg);
       $rspta=$movbanco->ActCod();
       $rspta=$movbanco->ActSaldoCuenta($idcuenta);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$movbanco->Editar($idmovbanco,$idcuenta,$idoperacion,$idusuario,$cod_movbanco,$desc_movbanco,$tipo,
       $estatus,$origen,$numerod,$numeroc,$montod,$montoh,$saldoinicial,$fechareg);
       $rspta=$movbanco->ActSaldoCuenta($idcuenta);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'eliminar':
      $rspta=$movbanco->Eliminar($idmovbanco);
      $rspta=$movbanco->ActSaldoCuenta($idcuenta);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'anular':
      $rspta=$movbanco->Activar($idmovbanco);
      $rspta=$movbanco->ActSaldoCuenta($idcuenta);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$movbanco->Mostrar($idmovbanco);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $tipoorigen='';
      $rspta=$movbanco->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){
         
         $al='style="text-align:';
         $w='; width';
         $dtg='data-toggle="tooltip" data-placement="right" title="';

         $url='../reportes/rptMovBanco.php?id=';		
			if ($reg->estatus=='Registrado') {
                $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-green">Registrado</span></h5>';         
            } else if ($reg->estatus=='Anulado'){
                $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-red-active">Anulado</span></h5>';         
            }else if ($reg->estatus=='Procesado'){
                $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado</span></h5>'; 
            }        
			
            if($reg->estatus=='Registrado'&& $reg->origen=='Banco')
            {
               $tipoorigen='<h5 small '.$al.'center'.$w.':120px" class="small">
               <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovbanco.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
               '<button class="btn btn-success btn-xs" onclick="anular('.$reg->idmovbanco.',\''.$reg->idcuenta.'\')" '.$dtg.'Anular"><i class="fa fa-check-square"></i></button>'.
               '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmovbanco.',\''.$reg->idcuenta.'\')" '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
               '<a target="_blank" href="'.$url.$reg->idmovbanco.'"><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button></a>
               </h5>';
            }else if($reg->estatus=='Registrado'&& $reg->origen!='Banco')
            {
               $tipoorigen='<h5 small '.$al.'center'.$w.':120px" class="small">
               <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovbanco.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
               '<button class="btn btn-success btn-xs" disabled '.$dtg.'Anular"><i class="fa fa-check-square"></i></button>'.
               '<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
               '<a target="_blank" href="'.$url.$reg->idmovbanco.'"><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button></a>
               </h5>';
            }
            else if($reg->estatus=='Procesado')
            {
               $tipoorigen='<h5 small '.$al.'center'.$w.':120px" class="small">
               <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovbanco.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
               '<button class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="fa fa-trash"></i></button>'.
               '<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
               '<a target="_blank" href="'.$url.$reg->idmovbanco.'" ><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i>
               </button></a>
               </h5>';
            }   
            else 
            {
               $tipoorigen='<h5 small '.$al.'center'.$w.':120px" class="small">
               <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovbanco.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
               '<button class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="fa fa-trash"></i></button>'.
               '<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
               '<a target="_blank" href="'.$url.$reg->idmovbanco.'" ><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i>
               </button></a>
               </h5>';
            }
    
            $data[]=array(
            "0"=>$tipoorigen,
            "1"=>'<h5 '.$al.'center'.$w.':80px;">'.$reg->fechareg.'</h5>',
            "2"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->cod_movbanco.'</h5>',
            "3"=>'<h5 '.$al.''.$w.':100px;">'.$reg->cod_cuenta.'</h5>',
            "4"=>'<h5 '.$al.''.$w.':200px;">'.$reg->numcuenta.'</h5>',
            "5"=>'<h5 '.$al.''.$w.':140px;">'.$reg->tipo.'</h5>',
            "6"=>'<h5 '.$al.''.$w.':120px;">'.$reg->numerod.'</h5>',
            "7"=>($reg->montod==0)?
            '<h5 '.$al.'right'.$w.':140px;">'.number_format($reg->montoh,2,",",".").'</span>':
            '<h5 '.$al.'right'.$w.':140px;">'.number_format($reg->montod,2,",",".").'</span>',
            "8"=>$estatus,
			);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
   break;

   case 'selectOperacion':
      require_once '../database/Operacion.php';
      $operacion=new Operacion();
      $origen=$_POST['origen'];
      $rspta=$operacion->SelectOp($origen);
       
      while ($reg=$rspta->fetch_object()) {
         echo '<option value="'.$reg->idoperacion.'">'.$reg->cod_operacion.'-'.$reg->desc_operacion.'</option>';     
      }
   break;

   case 'cuenta':
      require_once '../database/Cuenta.php';
      $cuenta=new Cuenta();
      $op=$_POST['op'];

      if ($op=='select') {
         $rspta=$cuenta->Select();
   
          while ($reg=$rspta->fetch_object()) {
             echo '<option value="'.$reg->idcuenta.'">'.$reg->desc_cuenta.'</option>';
         }
      } 
      elseif ($op=='data'){

      $rspta=$cuenta->Mostrar($_POST['id']);         
      echo json_encode($rspta);
      }
   break;
}
?>