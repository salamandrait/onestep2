<?php
require_once "../database/ReporteInv.php";

$reporteinv=new ReporteInv();

switch ($_GET["op"]) {
       
    case 'Articulo':
        require_once "../database/Articulo.php";
        $articulo= new Articulo();
            
        $tipo=$_GET['tipo'];
            
        $rspta = $articulo->Select();
            
        if ($tipo=='cod') {

        while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_articulo.'>'.$reg->cod_articulo.'</option>';			
            }
        } else if ($tipo=='desc'){
            
        while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_articulo.'>'.$reg->desc_articulo.'</option>';			
            }
        } else if ($tipo=='ref'){
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_articulo.'>'.$reg->artref.'</option>';			
            }
        }
        else if ($tipo==''){
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_articulo.'>'.$reg->cod_articulo.'-'.$reg->desc_articulo.'</option>';			
            }
        }
    break;
    
    case 'Categoria':
        require_once "../database/Categoria.php";
        $categoria= new Categoria();
            
        $tipo=$_GET['tipo'];
            
        $rspta = $categoria->Select();
            
        if ($tipo=='cod') {
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_categoria.'>'.$reg->cod_categoria.'</option>';			
            }
        } else if ($tipo=='desc'){
            while ($reg = $rspta->fetch_object())
            {
        echo '<option value='.$reg->cod_categoria.'>'.$reg->desc_categoria.'</option>';			
            }
        } else if ($tipo=='art'){
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_categoria.'>'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</option>';			
            }
        }
    break;
    
    case 'Linea':
        require_once "../database/Linea.php";
        $linea= new Linea();
            
        $tipo=$_GET['tipo'];
            
        $rspta = $linea->Select();
            
        if ($tipo=='cod') {
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_linea.'>'.$reg->cod_linea.'-'.$reg->desc_linea.'</option>';			
            }
        } else if ($tipo=='desc'){
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_linea.'>'.$reg->desc_linea.'</option>';			
            }
        } else if ($tipo=='art'){
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_linea.'>'.$reg->cod_linea.'-'.$reg->desc_linea.'</option>';			
            }
        }
    break;

    case 'Unidad':
        require_once "../database/Unidad.php";
        $unidad= new Unidad();
            
        $tipo=$_GET['tipo'];
            
        $rspta = $unidad->Select();
            
        if ($tipo=='cod') {
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_unidad.'>'.$reg->cod_unidad.'</option>';			
            }
        } else if ($tipo=='desc'){
            while ($reg = $rspta->fetch_object())
            {
        echo '<option value='.$reg->cod_unidad.'>'.$reg->desc_unidad.'</option>';			
            }
        } else if ($tipo=='art'){
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->cod_unidad.'>'.$reg->cod_unidad.'-'.$reg->desc_unidad.'</option>';			
            }
        }
    break;
      
    case 'Deposito':
        require_once "../database/Deposito.php";
        $deposito= new Deposito();
        
        $tipo=$_GET['tipo'];
        
        $rspta = $deposito->Select();
        
        if ($tipo=='cod') {
        while ($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->cod_deposito.'>'.$reg->cod_deposito.'</option>';			
        }
            } else if ($tipo=='desc'){
        while ($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->cod_deposito.'>'.$reg->desc_deposito.'</option>';			
        }
            } else if ($tipo=='art'){
        while ($reg = $rspta->fetch_object())
        {
            echo '<option value='.$reg->cod_deposito.'>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</option>';			
        }
            }
    break;

}