<?php
require_once '../database/Ajuste.php';
$ajuste=new Ajuste();

$idajuste=isset($_POST["idajuste"])? limpiarCadena($_POST["idajuste"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_ajuste=isset($_POST["cod_ajuste"])? limpiarCadena($_POST["cod_ajuste"]):"";
$desc_ajuste=isset($_POST["desc_ajuste"])? limpiarCadena($_POST["desc_ajuste"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$totalstock=isset($_POST["totalstock"])? limpiarCadena($_POST["totalstock"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

//Valores Arrays pasados por post
///name="idarticulo[]" 
//name="iddeposito[]"
//name="disp[]"
//name="tipoa[]" 
//name="valor[]"
//name="idartunidad[]
//name="cantidad[]
//name="costo[]

switch ($_POST["opcion"]) {

    case 'guardaryeditar':
            if (empty($idajuste)) {
                $rspta=$ajuste->Insertar($idusuario,$cod_ajuste,$desc_ajuste,$tipo,$totalstock,$totalh,$fechareg,
                $_POST["idarticulo"],$_POST["iddeposito"],$_POST['disp'],$_POST["cantidad"],$_POST["costo"],$_POST["idartunidad"]);
                $rspta=$ajuste->ActCod();
                $rspta=$ajuste->AddStockArt($_POST["idarticulo"], $_POST["iddeposito"], $_POST["cantidad"],
                $_POST["valor"],$tipo,$_POST["disp"],$_POST['tipoa']);
                echo $rspta=='1'?'Registro Ingresado Correctamente! <i class="fa bg-success fa-check-circle"></i>':$rspta;           
            }
    break;

    case 'anular':
            $rspta=$ajuste->Anular($idajuste);
            $rspta=$ajuste->AnularStock($idajuste,$tipo);
            echo $rspta=='1'?"Registro Anulado Correctamente!":$rspta;	 
    break;

    case 'eliminar':
        $rspta=$ajuste->AnularStock($idajuste,$tipo);
        $rspta=$ajuste->Eliminar($idajuste);
        echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;	 
    break;

    case 'mostrar':   
            $rspta=$ajuste->Mostrar($idajuste);
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
    break;

    case 'listar':
            $rspta=$ajuste->listar();
            //Vamos a declarar un array
            $data= Array();

            $al='style="text-align:';
            $w='; width';
            $dtg='data-toggle="tooltip" data-placement="right" title="';

            while ($reg=$rspta->fetch_object()){
                
                if ($reg->estatus=='Registrado') {
                    $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-green">Registrado</span></h5>';         
                } else if ($reg->estatus=='Anulado'){
                    $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-red-active">Anulado</span></h5>';         
                }else if ($reg->estatus=='Procesado'){
                    $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado</span></h5>';         
                }
                $url='../reportes/rptFormatoAjuste.php?id=';;
                $data[]=array(
                "0"=>($reg->estatus=='Registrado'||$reg->estatus=='Procesado')?
                '<h5 small '.$al.'center'.$w.':120px" class="small">
                <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idajuste.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
                '<button class="btn btn-success btn-xs" onclick="anular('.$reg->idajuste.',\''.$reg->tipo.'\')" '.$dtg.'Anular"><i class="glyphicon glyphicon-ban-circle"></i></button>'.
                '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idajuste.',\''.$reg->tipo.'\')" '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
                '<a target="_blank" href="'.$url.$reg->idajuste.'"><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button></a>
                </h5>'
                :
                '<h5 small '.$al.'center'.$w.':120px" class="small">
                <button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idajuste.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
                '<button class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="glyphicon glyphicon-exclamation-sign"></i></button>'.
                '<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
                '<a target="_blank" href="'.$url.$reg->idajuste.'" ><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i>
                </button></a>
                </h5>'
                ,
                "1"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->fechareg.'</h5>',
                "2"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->cod_ajuste.'</h5>',
                "3"=>'<h5>'.$reg->desc_ajuste.'</h5>',
                "4"=>'<h5 '.$w.':100px;">'.$reg->tipo.'</h5>',
                "5"=>'<h5 '.$al.'right'.$w.':150px;">'.number_format($reg->totalh,2,",",".").'</h5>',       
                "6"=>$estatus,
                );
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
    break;

    case 'listarDetalle':
		$rspta=$ajuste->ListarDetalle($idajuste);
        echo
            '<thead class="btn-primary">
                <th style="text-align:center; width:25px;" class="nd">E</th>
                <th style="text-align:center; width:150px;" class="nd">Codigo</th>
                <th style="text-align:center; width:350px;">Artículo</th>
                <th style="text-align:center; width:90px;" class="nd">Unidad</th>
                <th style="text-align:right; width:80px;" class="nd">Cantidad</th>
                <th style="text-align:right; width:140px;" class="nd">Costo</th>
                <th style="text-align:right; width:150px;" class="nd">Total Reng.</th>
            </thead>';
            while ($reg = $rspta->fetch_object())
                {
                echo
            $fila=
            '<tr class="filas">
                <td style="width:25px;"><span style="width:25px; "text-align:center;" class="label bg-red">'.($cont+1).'</span></td>
                <td style="width:150px;">'.$reg->cod_articulo.'</td>
                <td style="width:350px;"><span style="font-size:13px">'.$reg->desc_articulo.'</span></td>
                <td style="text-align:; width:90px;">'.$reg->desc_unidad.'</td>
                <td style="text-align:right; width:80px; padding-right:4px;">'.number_format($reg->cantidad,0).'</td>
                <td style="text-align:right; width:140px;"><span class="numberf">'.number_format($reg->costo,2,'.',',').'</span></td>
                <td style="text-align:right; width:150px;"><span class="numberf">'.number_format($reg->totald,2,'.',',').'</span></td>

            </tr>',
            $cont++,
            $totalf+=$reg->totald;
                }
                echo '<tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th></th>         
                <th></th>
                <th></th>
                <th><h4 style="text-align:right;"><B><input type="hidden" class="numberf" id="totalt" value="'.number_format($totalf,2,",",".").'"></span></B></h4></th>
            </tfoot>';
    break;

    case "selectUnidad":
        require_once "../database/Articulo.php";
        $articulo = new Articulo();

		$rspta = $articulo->ListarArtUnidad($_POST['idarticulo']);

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idartunidad.'>'.$reg->desc_unidad.'</option>';
		}
    break;
  
    case "Unidad":
        require_once "../database/Articulo.php";
        $articulo = new Articulo();

        $rspta = $articulo->MostrarArtUnidadId($_POST['id']);
        echo json_encode($rspta);
	break;

    case "listarArticulos":
            require_once "../database/Articulo.php";
            $articulo = new Articulo();

            $id=$_POST['id'];
            $tipo=$_POST['tipo'];
    
            $rspta=$articulo->SelectAjuste($id,$tipo);
            //Vamos a declarar un array
            $data= Array();
            while ($reg=$rspta->fetch_object()){

                $data[]=array(   

                    "0"=>'<button class="btn btn-warning btn-xs" onclick="agregarDetalle
                    ('.$reg->idarticulo.',\''.$reg->iddeposito.'\',\''.$reg->cod_articulo.'\',
                    \''.$reg->desc_articulo.'\',\''.$reg->tipo.'\',\''.$reg->costo.'\',\''.$reg->disp.'\',\''.$reg->stock.'\')"; 
                    style="text-align:center; width:20px;"><span class="fa fa-plus"></span></button>',
                    "1"=>'<h5 style="width:150px;">'.$reg->cod_articulo.'</h5>',
                    "2"=>'<h5 style="width:400px;">'.$reg->desc_articulo.'</h5>',
                    "3"=>'<h5 style="width:120px;">'.$reg->artref.'</h5>',
                    "4"=>'<h5 style="text-align:right; width:50px;">'.number_format($reg->stock,0).'</h5>',
                    "5"=>'<h5 style="text-align:right; width:120px;">'.number_format($reg->costo,2,".",",").'</h5>',
                    );
                    }
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
    break;
    
    case "selectDeposito":
        require_once "../database/Deposito.php";
        $deposito = new Deposito();

        $rspta = $deposito->select();

        while ($reg = $rspta->fetch_object())
        {
        echo '<option value='.$reg->iddeposito.'>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</option>';
        }
    break;
        
    case "Moneda":
        require_once "../database/Moneda.php";
        $moneda = new Moneda();

        $rspta = $moneda->SelectOp();

        while ($reg = $rspta->fetch_object())
        {
        echo $reg->cod_moneda;
        }
    break;
}
?>