<?php
session_start(); 
require_once "../database/Usuario.php";
$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_usuario=isset($_POST["cod_usuario"])? limpiarCadena($_POST["cod_usuario"]):"";
$desc_usuario=isset($_POST["desc_usuario"])? limpiarCadena($_POST["desc_usuario"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$estatusc=isset($_POST["estatusc"])? limpiarCadena($_POST["estatusc"]):"";

switch ($_POST["opcion"]){

	case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
			$imagen=$_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["imagen"]["name"]);
			$_FILES['imagen']['tmp_name']=="../files/usuarios/".$cod_usuario.'.'.end($ext)?
			unlink("../files/usuarios/".$cod_usuario.'.'.end($ext)):'';
			if (
				$_FILES['imagen']['type'] == "image/jpg" || 
				$_FILES['imagen']['type'] == "image/jpeg" || 
				$_FILES['imagen']['type'] == "image/png"){
				$imagen = $cod_usuario.'.'.end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/".$imagen);
			}
		}
		if (empty($idusuario)){
         $rspta=$usuario->Insertar($cod_usuario,$desc_usuario,$direccion,$telefono,$email,$departamento,
         $clave,$imagen,$fechareg,$_POST['accesos']);
         echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;        
		}
		else {
         $rspta=$usuario->Editar($idusuario,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,$departamento,
         $clave,$imagen,$fechareg,$_POST['accesos']);
			echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
		}
	break;

	case 'desactivar':
		$rspta=$usuario->Desactivar($idusuario);
		echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
	break;

	case 'activar':
		$rspta=$usuario->Activar($idusuario);
		echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;
    
	case 'eliminar':
        $rspta=$usuario->Eliminaracceso($idusuario);
        $rspta=$usuario->Eliminar($idusuario);
        echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

	case 'mostrar':
		$rspta=$usuario->Mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->Listar();
 		//Vamos a declarar un array
		 $data= Array();
		 
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>($reg->estatus)?
				'<h5 small style="text-align:center; width:70px">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idusuario.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idusuario.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idusuario.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small style="text-align:center; width:70px">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idusuario.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idusuario.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idusuario.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
            "1"=>'<h5  style="width:100px">'.$reg->cod_usuario.'</h5>',
            "2"=>'<h5>'.$reg->desc_usuario.'</h5>',
            "3"=>'<h5 style="width:150px">'.$reg->departamento.'</h5>',             
				"4"=>($reg->estatus)?
				'<h5 style="text-align:center; width:80px"><span class="label bg-green">Activado</span></h5>':
				'<h5 style="text-align:center; width:80px"><span class="label bg-red">Desactivado</span></h5>'
 				);
		 }

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'verificar':
		$rspta=$usuario->Verificar($_POST['cod_usuario'], $_POST['clave']);

		$fetch=$rspta->fetch_object();

		if (isset($fetch)){

	    //Declaramos las variables de sesión
			$_SESSION['idusuario']=$fetch->idusuario;
			$_SESSION['cod_usuario']=$fetch->cod_usuario;
			$_SESSION['desc_usuario']=$fetch->desc_usuario;
			$_SESSION['departamento']=$fetch->departamento;
	    $_SESSION['imagenu']=$fetch->imagen;
			$_SESSION['email']=$fetch->email;
			$_SESSION['clave']=$fetch->clave;
			$_SESSION['estatus']=$fetch->estatus;
			$idacceso=$fetch->idacceso;

	    //Obtenemos los accesos del usuario
			$marcados = $usuario->listarMarcados($idacceso);

			//Declaramos el array para almacenar todos los accesos marcados
			$valores=array();
	
			//Almacenamos los accesos marcados en el array
			while ($per = $marcados->fetch_object()){
			//Determinamos los accesos del usuario
			$_SESSION[$per->acceso]=$per->permiso;
			// in_array(2,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
			// in_array(3,$valores)?$_SESSION['usuario']=1:$_SESSION['usuario']=0;
			// in_array(4,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
			// in_array(5,$valores)?$_SESSION['operacion']=1:$_SESSION['operacion']=0;
			// in_array(6,$valores)?$_SESSION['correlativo']=1:$_SESSION['correlativo']=0;
			// in_array(7,$valores)?$_SESSION['impuesto']=1:$_SESSION['impuesto']=0;
			// in_array(8,$valores)?$_SESSION['impuestoe']=1:$_SESSION['impuestoe']=0;
			// in_array(9,$valores)?$_SESSION['moneda']=1:$_SESSION['moneda']=0;
			// in_array(10,$valores)?$_SESSION['pais']=1:$_SESSION['pais']=0;	
			// in_array(20,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
		}
				
			// in_array(40,$valores)?$_SESSION['inventario']=1:$_SESSION['inventario']=0;
			// in_array(41,$valores)?$_SESSION['articulo']=1:$_SESSION['articulo']=0;
			// in_array(42,$valores)?$_SESSION['categoria']=1:$_SESSION['categoria']=0;
			// in_array(43,$valores)?$_SESSION['unidad']=1:$_SESSION['unidad']=0;
			// in_array(44,$valores)?$_SESSION['deposito']=1:$_SESSION['deposito']=0;
			// in_array(45,$valores)?$_SESSION['linea']=1:$_SESSION['linea']=0;
			// in_array(50,$valores)?$_SESSION['opinventario']=1:$_SESSION['opinventario']=0;
			// in_array(51,$valores)?$_SESSION['ajuste']=1:$_SESSION['ajuste']=0;
			// in_array(52,$valores)?$_SESSION['traslado']=1:$_SESSION['traslado']=0;
			// in_array(53,$valores)?$_SESSION['ajprecio']=1:$_SESSION['ajprecio']=0;
			// in_array(58,$valores)?$_SESSION['rinventario']=1:$_SESSION['rinventario']=0;
				
			// in_array(60,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			// in_array(61,$valores)?$_SESSION['proveedor']=1:$_SESSION['proveedor']=0;
			// in_array(62,$valores)?$_SESSION['tipoproveedor']=1:$_SESSION['tipoproveedor']=0;
			// in_array(64,$valores)?$_SESSION['condpago']=1:$_SESSION['condpago']=0;
			// in_array(66,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;
			// in_array(70,$valores)?$_SESSION['opcompras']=1:$_SESSION['opcompras']=0;
			// in_array(71,$valores)?$_SESSION['ccompra']=1:$_SESSION['ccompra']=0;
			// in_array(72,$valores)?$_SESSION['pcompra']=1:$_SESSION['pcompra']=0;
			// in_array(73,$valores)?$_SESSION['fcompra']=1:$_SESSION['fcompra']=0;
			// in_array(74,$valores)?$_SESSION['rcompra']=1:$_SESSION['rcompra']=0;
			// in_array(75,$valores)?$_SESSION['pago']=1:$_SESSION['pago']=0;
			// in_array(76,$valores)?$_SESSION['documentoc']=1:$_SESSION['documentoc']=0;
				
			// in_array(80,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
			// in_array(81,$valores)?$_SESSION['cliente']=1:$_SESSION['cliente']=0;
			// in_array(82,$valores)?$_SESSION['tipocliente']=1:$_SESSION['tipocliente']=0;
			// in_array(83,$valores)?$_SESSION['vendedor']=1:$_SESSION['vendedor']=0;
			// in_array(84,$valores)?$_SESSION['condpago']=1:$_SESSION['condpago']=0;	
			// in_array(86,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;	
			// in_array(90,$valores)?$_SESSION['opventas']=1:$_SESSION['opventas']=0;
			// in_array(91,$valores)?$_SESSION['cventa']=1:$_SESSION['cventa']=0;
			// in_array(92,$valores)?$_SESSION['pventa']=1:$_SESSION['pventa']=0;
			// in_array(93,$valores)?$_SESSION['fventa']=1:$_SESSION['fventa']=0;
			// in_array(94,$valores)?$_SESSION['rventa']=1:$_SESSION['rventa']=0;
			// in_array(95,$valores)?$_SESSION['cobro']=1:$_SESSION['cobro']=0;
			// in_array(96,$valores)?$_SESSION['documentov']=1:$_SESSION['documentov']=0;
				
			// in_array(100,$valores)?$_SESSION['bancos']=1:$_SESSION['bancos']=0;
			// in_array(101,$valores)?$_SESSION['banco']=1:$_SESSION['banco']=0;
			// in_array(102,$valores)?$_SESSION['caja']=1:$_SESSION['caja']=0;
			// in_array(103,$valores)?$_SESSION['cuenta']=1:$_SESSION['cuenta']=0;
			// in_array(104,$valores)?$_SESSION['ipago']=1:$_SESSION['ipago']=0;	
			// in_array(105,$valores)?$_SESSION['beneficiario']=1:$_SESSION['beneficiario']=0;		
			// in_array(110,$valores)?$_SESSION['opbancos']=1:$_SESSION['opbancos']=0;
			// in_array(111,$valores)?$_SESSION['movcaja']=1:$_SESSION['movcaja']=0;
			// in_array(112,$valores)?$_SESSION['movbanco']=1:$_SESSION['movbanco']=0;
			// in_array(113,$valores)?$_SESSION['depbanco']=1:$_SESSION['depbanco']=0;
			// in_array(114,$valores)?$_SESSION['odpago']=1:$_SESSION['odpago']=0;
			// in_array(117,$valores)?$_SESSION['conciliacion']=1:$_SESSION['conciliacion']=0;
			// in_array(119,$valores)?$_SESSION['rbanco']=1:$_SESSION['rbanco']=0;
			}
		echo json_encode($fetch); 
	break;

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al cod_usuario
        header("Location: ../index.php");
	break;
}
?>