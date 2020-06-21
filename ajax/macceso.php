<?php
require_once "../database/MAcceso.php";
$macceso=new MAcceso();

$idmacceso=isset($_POST["idmacceso"])? limpiarCadena($_POST["idmacceso"]):"";
$cod_macceso=isset($_POST["cod_macceso"])? limpiarCadena($_POST["cod_macceso"]):"";
$desc_macceso=isset($_POST["desc_macceso"])? limpiarCadena($_POST["desc_macceso"]):"";
$departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
   if (empty($idmacceso)){
      $rspta=$macceso->Insertar($cod_macceso,$desc_macceso,$_POST['accesos']);
      echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
      $rspta=$macceso->Editar($idmacceso,$cod_macceso,$desc_macceso,$_POST['accesos']);
      echo $rspta=='1'?"Registro Actualizado Correctamente! <span class='label btn-success'><i class='fa fa-check'></i></span>":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$macceso->Desactivar($idmacceso);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$macceso->Eliminar($idmacceso);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$macceso->Activar($idmacceso);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$macceso->Mostrar($idmacceso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$macceso->Listar();
      //Vamos a declarar un array
      $data= Array();

         while ($reg=$rspta->fetch_object()){

            $al='style="text-align:';
            $w='; width:';
            $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmacceso.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idmacceso.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmacceso.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmacceso.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idmacceso.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmacceso.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_macceso.'</h5>',
				"2"=>'<h5>'.$reg->desc_macceso.'</h5>',  
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

	case 'accesoscf':
		$rspta = $macceso->listarModulo('config');
		//Obtener los accesos asignados al usuario
		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Tablas</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkconfig">
					<i class="chkconfig text-'.$swi.'"></i></h5></td>
				</tr>';
			}
   break;

   case 'accesosi':	
		$rspta = $macceso->listarModulo('inventario');
		//Obtener los accesos asignados al usuario
		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Tablas</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkinv" > 
					<i class="chkinv text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosopi':
		$rspta = $macceso->listarModulo('opinventario');

		//Obtener los accesos asignados al usuario
		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Operaciones</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkinv" > 
					<i class="chkinv text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosc':
		$rspta = $macceso->listarModulo('compras');

		//Obtener los accesos asignados al usuario
		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Tablas</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkcompra" > 
					<i class="chkcompra text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosopc':
		$rspta = $macceso->listarModulo('opcompras');

		//Obtener los accesos asignados al usuario
		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Operaciones</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkcompra" > 
					<i class="chkcompra text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosv':
		$rspta = $macceso->listarModulo('ventas');

		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Tablas</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkventa"> 
					<i class="chkventa text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosopv':
		//Obtenemos todos los accesos de la tabla accesos	
		$rspta = $macceso->listarModulo('opventas');
		//Obtener los accesos asignados al usuario

		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Operaciones</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkventa"> 
					<i class="chkventa text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosb':
		//Obtenemos todos los accesos de la tabla accesos	
		$rspta = $macceso->listarModulo('bancos');
		//Obtener los accesos asignados al usuario

		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Tablas</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkbanco" > 
					<i class="chkbanco text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

	case 'accesosopb':
		//Obtenemos todos los accesos de la tabla accesos
		$rspta = $macceso->listarModulo('opbancos');
		//Obtener los accesos asignados al usuario
		$marcados = $macceso->listarmarcados($idmacceso);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
		{
			array_push($valores, $per->idacceso);
		}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		echo '<thead class="bg-gray-active">
					<th>Operaciones</th>
					<th style="width:150px">Estado</th>                                
				</thead>';
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				$swi=in_array($reg->idacceso,$valores)?'green glyphicon glyphicon-ok-circle':'red glyphicon glyphicon-remove-circle';

				echo $fila=
				'<tr class="filas">
					<td><label>'.$reg->desc_acceso.'</label></td>
					<td><h5><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'" class="chkbanco" > 
					<i class="chkbanco text-'.$swi.'"></i></h5></td>
				</tr>';
			}
	break;

}
?>