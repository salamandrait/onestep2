<?php
require_once '../database/Compra.php';
$compra=new Compra();

$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_compra=isset($_POST["cod_compra"])? limpiarCadena($_POST["cod_compra"]):"";
$desc_compra=isset($_POST["desc_compra"])? limpiarCadena($_POST["desc_compra"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$numerod=isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
$numeroc=isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
$origend=isset($_POST["origend"])? limpiarCadena($_POST["origend"]):"";
$origenc=isset($_POST["origenc"])? limpiarCadena($_POST["origenc"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$subtotalh=isset($_POST["subtotalh"])? limpiarCadena($_POST["subtotalh"]):"";
$impuestoh=isset($_POST["impuestoh"])? limpiarCadena($_POST["impuestoh"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$saldoh=isset($_POST["saldoh"])? limpiarCadena($_POST["saldoh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$fechaven=isset($_POST["fechaven"])? limpiarCadena($_POST["fechaven"]):"";

switch ($_POST['opcion']) {

   case 'guardaryeditar':
      if (empty($idcompra)) {

          $rspta=$compra->Insertar($idproveedor,$idcondpago,$idusuario,$cod_compra,$desc_compra,$numerod,$numeroc,$tipo,$origend,
          $origenc,$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,$_POST['idarticulo'],$_POST['iddeposito'],$_POST["idartunidad"],
          $_POST['cantidad'],$_POST['costo'],$_POST['tasa']);


          if($tipo!='Cotizacion'){

            $rspta=$compra->AddStockArt($_POST['idarticulo'],$_POST['disp'],$_POST['tipo'],
            $_POST['iddeposito'],$_POST['cantidad'],$_POST['valor']);

            $rspta=$compra->ActualizarCosto($_POST['idarticulo'],$_POST['costo'],$_POST['valor']);
          }
          if (!empty($_POST['idcompraop']) && ($tipo!='Cotizacion')) {

            $rspta=$compra->ActualizarDocImportar($_POST['idcompraop']);
            ($_POST['origend']!='Cotizacion')?$rspta=$compra->ActDetalleImp($_POST['idcompraop'],$origenc):$rspta;
          }
          $rspta=$compra->ActCod($tipo); 
          echo $rspta=='1'?'Registro Ingresado Correctamente!  <span class="label btn-success"> <i class="fa fa-check"></i></span>':$rspta;
      }
  break;

  case 'generarCod':
    $rspta=$compra->GenerarCod($tipo);
    echo json_encode($rspta);
  break;

  case 'mostrar':
    $rspta=$compra->Mostrar($idcompra);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
  break;

  case 'mostrarDetalle':
    $al='style="text-align:';
    $w='; width';
    $dtg='data-toggle="tooltip" data-placement="right" title=';
    $btn='button class="btn btn-xs btn-';

    $cont=0;
    $rspta=$compra->MostrarDetalle($idcompra);
    echo '<thead class="bg-blue-active">
            <th '.$al.'center'.$w.':30px;" class="nd">R</th>
            <th '.$al.'center'.$w.':120px;" class="nd">Código</th>
            <th '.$al.'center'.$w.':300px;" class="nd">Artículo</th>
            <th '.$al.'center'.$w.':80px;" class="nd">Unidad</th>
            <th '.$al.'right'.$w.':50px;" class="nd">Cant.</th>
            <th '.$al.'right'.$w.':110px;" class="nd">Costo Und</th>
            <th '.$al.'right'.$w.':120px;" class="nd">Sub Total</th>
            <th '.$al.'right'.$w.':28px;" class="nd">Imp.</th>
            <th '.$al.'right'.$w.':140px;" class="nd">Total Reng.</th>
          </thead>';
          while ($reg=$rspta->fetch_object()) {
            echo 
            $fila='<tr class="filas" id="fila'.($cont+1).'">
            <td><h5 '.$al.'center'.$w.':30px;"><'.$btn.'danger" type="button" onclick="eliminarDetalle('.($cont+1).');">
            <span class="fa fa-times-circle">'.($cont+1).'</span></button></td>
            <td class="hidden">
            <input name="idcomprad[]" id="idcomprad[]" value="'.$reg->idcomprad.'" type="text">
            <input name="idcomprag[]" id="idcomprag[]" value="'.$reg->idcompra.'" type="text">
            <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="text">
            <input name="idartunidad[]" id="idartunidad[]" value="'.$reg->idartunidad.'" type="text">
            <input name="iddeposito[]" id="iddeposito[]" value="'.$reg->iddeposito.'" type="text">
            <input name="tipoa[]" id="tipoa[]" value="'.$reg->tipoa.'" type="text">
            <input name="disp[]" id="disp[]" value="'.number_format($reg->disp,0).'" type="text">
            <input name="tasa[]" id="tasa[]" value="'.number_format($reg->tasa,0).'" type="text">
            <input name="valor[]" id="valor[]" value="'.number_format($reg->valor,0).'" type="text">
            <input onchange="modificarSubtotales();" name="cantidad[]" id="cantidad[]" value="'.number_format($reg->cantidad,0).'">
            <h5 id="subimp" name="subimp'.($cont+1).'">'.$reg->totald.'</h5>
            </td>
            <td '.$al.''.$w.':120px; text-size:12px"><h5>'.$reg->cod_articulo.'</h5></td>
            <td '.$al.''.$w.':300px; text-size:12px"><h5>'.$reg->desc_articulo.'</h5></td>
            <td '.$al.''.$w.':80px;"><h5>'.$reg->desc_unidad.'</h5></td>
            <td '.$al.'right'.$w.':50px;""><h5>'.$reg->cantidad.'</h5></td>
            <td><h5><input onchange="modificarSubtotales();" name="costo[]" id="costo[]" value="'.number_format($reg->costo,2,'.','').'" '.$al.'right'.$w.':110px;" type="text"></h5></td>
            <td '.$al.'right'.$w.':120px;""><h5 name="subtotal">'.number_format($reg->subtotald,2,'.',',').'</h5></td>
            <td '.$al.'right'.$w.':28px;""><h5">'.number_format($reg->tasa,0).'</h5></td>
            <td '.$al.'right'.$w.':140px;""><h5>'.number_format($reg->totald,2,'.',',').'</h5></td>
            </tr>';
            $cont++;
      }
  break;

  case 'listar':
    $rspta=$compra->Listar($tipo);
    //Vamos a declarar un array
    $data= array();

    $al='style="text-align:';
    $w='; width';
    $dtg='data-toggle="tooltip" data-placement="right" title=';
    $btn='button class="btn btn-xs btn-';

    while ($reg=$rspta->fetch_object()) {


      if ($reg->estatus=='Registrado') {
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-green">Registrado</span></h5>';         
      } else if ($reg->estatus=='Anulado'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-red-active">Anulado</span></h5>';         
      }else if ($reg->estatus=='Procesado'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado</span></h5>';         
      } else if ($reg->estatus=='Procesado Parc.'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado Parc.</span></h5>';         
      }else if ($reg->estatus=='Pagado'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label btn-success">Pagado</span></h5>';         
      } else if ($reg->estatus=='Pago Parc.'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label btn-success">Pago Parc.</span></h5>';         
      }

      $data[]=array(

        "0"=>($reg->estatus=='Registrado')?
        '<h5 small '.$al.'center'.$w.':120px" class="small">
        <'.$btn.'primary" onclick="mostrar('.$reg->idcompra.')" '.$dtg.'"Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
        '<'.$btn.'success" onclick="anular('.$reg->idcompra.',\''.$reg->tipo.'\')" '.$dtg.'"Anular"><i class="fa fa-check-square"></i></button>'.
        '<'.$btn.'danger" onclick="eliminar('.$reg->idcompra.',\''.$reg->tipo.'\')" '.$dtg.'"Eliminar"><i class="fa fa-remove"></i></button>'.
        '<a target="_blank" href="../reportes/rptCompra.php?id='.$reg->idcompra.'">
        <'.$btn.'info" '.$dtg.'"Imprimir"><i class="fa fa-file"></i></button></a>
        </h5>'
        :
        '<h5 small '.$al.'center'.$w.':120px" class="small">
        <'.$btn.'primary" onclick="mostrar('.$reg->idcompra.')" '.$dtg.'"Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
        '<'.$btn.'warning" disabled '.$dtg.'"Anulado"><i class="fa fa-trash"></i></button>'.
        '<'.$btn.'danger" disabled '.$dtg.'"Eliminar"><i class="fa fa-remove"></i></button>'.
        '<'.$btn.'info" onclick="formato('.$reg->idcompra.')" '.$dtg.'"Imprimir"><i class="fa fa-file"></i></button>
        </h5>'
        ,
        "1"=>'<h5 '.$al.'center'.$w.':90px;">'.$reg->fechareg.'</h5>',
        "2"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->cod_compra.'</h5>',
        "3"=>'<h5 '.$al.''.$w.':350px;">'.$reg->desc_proveedor.'</h5>',
        "4"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->rif.'</h5>',
        "5"=>'<h5 '.$al.''.$w.':100px;">'.$reg->numerod.'</h5>',
        "6"=>'<h5 '.$al.''.$w.':100px;">'.$reg->numeroc.'</h5>',
        "7"=>'<h5 '.$al.'right'.$w.':130px;" class="sum">'.number_format($reg->totalh, 2,",",".").'</h5>',
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

  case "listarProveedor":
    require_once "../database/Proveedor.php";
    $proveedor = new Proveedor();

    $rspta=$proveedor->Select();
    //Vamos a declarar un array
    $data= array();
    while ($reg=$rspta->fetch_object()) {
        $data[]=array(

          "0"=>'<h5><button class="btn btn-success btn-xs" onclick="agregarProveedor
        ('.$reg->idproveedor.',\''.$reg->cod_proveedor.'\',\''.$reg->desc_proveedor.'\',\''.$reg->rif.'\',
          \''.$reg->idcondpago.'\',\''.$reg->dias.'\',\''.$reg->limite.'\')">
          <span class="fa fa-check-square-o" style="text-align:center; width:15px;"></span></button></h5>',
          "1"=>'<h5 style="width:100px; text-align:center;">'.$reg->cod_proveedor.'</h5>',
          "2"=>'<h5 style="width:320px;">'.$reg->desc_proveedor.'</h5>',
          "3"=>'<h5 style="width:100px; text-align:center;">'.$reg->rif.'</h>',
          "4"=>'<h5 style="width:150px;">'.$reg->desc_condpago.'</h>'
          );
      }
      $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);
      echo json_encode($results);
  break;

  case "listarArtuculo":
    require_once "../database/Articulo.php";
    $articulo = new Articulo();

    $rspta=$articulo->SelectCompra($_POST['id']);
    //Vamos a declarar un array
    $data= array();

    while ($reg=$rspta->fetch_object()) {

      $data[]=array(

        "0"=>'<h5><button class="btn btn-success btn-xs" onclick="agregarDetalle('.$reg->idarticulo.',
        \''.$reg->iddeposito.'\',\''.$reg->cod_articulo.'\',\''.$reg->desc_articulo.'\',
        \''.$reg->tipoa.'\',\''.$reg->costo.'\',\''.number_format($reg->tasa,0).'\',\''.number_format($reg->disp,0).'\')">
        <span class="fa fa-check-square-o" style="text-align:center; width:15px;"></span></button></h5>',
        "1"=>'<h5 style="width:130px;">'.$reg->cod_articulo.'</h5>',
        "2"=>'<h5 style="width:400px;">'.$reg->desc_articulo.'</h5>',
        "3"=>'<h5 style="width:120px;">'.$reg->artref.'</h>',
        "4"=>'<h5 style="width:50px; text-align:right">'.number_format($reg->disp,0).'</h>',
        );
      }
      $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);
  break;

  case "Unidad":
    require_once "../database/Articulo.php";
    $articulo = new Articulo();

    $op=$_POST['op'];

    if ($op=='select') {

      $rspta = $articulo->ListarArtUnidad($_POST['id']);

      while ($reg = $rspta->fetch_object())
      {
        echo '<option value='.$reg->idartunidad.'>'.$reg->desc_unidad.'</option>';
      }
    } else if ($op=='data') {
      $rspta = $articulo->MostrarArtUnidadId($_POST['id']);
      echo json_encode($rspta);
    }
  break;

  case "selectDeposito":
    require_once "../database/Deposito.php";
    $deposito = new Deposito();
        
    $rspta = $deposito->Select();
        
    while ($reg = $rspta->fetch_object()) {
        echo '<option value='.$reg->iddeposito.'>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</option>';
    }
  break;

  case 'condpago':
    require_once '../database/CondPago.php';
    $condpago=new CondPago();
    $op=$_POST['op'];

    if ($op=='select') {
       $rspta=$condpago->Select();
 
        while ($reg=$rspta->fetch_object()) {
           echo '<option value="'.$reg->idcondpago.'">'.$reg->desc_condpago.'</option>';
        }
    } 
    elseif ($op=='data'){

    $rspta=$condpago->Mostrar($_POST['id']);         
    echo json_encode($rspta);
    }
  break;



  break;

}