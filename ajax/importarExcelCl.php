<?php

      $tipo='';
      require_once '../Config/Conexion.php';     // Importante - conexión con la base de datos 
      //$cn = mysqli_connect ("localhost","root","","admindb") or die ("ERROR EN LA CONEXION CON LA BD");

      /** Llamamos las clases necesarias PHPExcel */
      require_once('../public/PHPExcel/Classes/PHPExcel.php');
      require_once('../public/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');   

      $allowedFileType = 'xlsx';

      //cargamos el fichero
      $archivo = $_FILES['formato']['name'];
      $tipo = $_FILES['formato']['type'];
      $ruta = "../formatos/".$archivo;
      copy($_FILES['formato']['tmp_name'],$ruta);
   
      #Validamos la Existencia del Archivo y Verificamos el Tipo de Archivo
      if (file_exists ($ruta) &&  ($tipo=='text/xlsx'||$tipo=='text/xls'
         ||$tipo=='application/vnd.ms-excel'||$tipo=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')){ 

         // Cargando la hoja de excel
         $objReader = new PHPExcel_Reader_Excel2007();
         $objPHPExcel = $objReader->load($ruta);
         $objFecha = new PHPExcel_Shared_Date();       
         // Asignamos la hoja de excel activa
         $objPHPExcel->setActiveSheetIndex(0);

         // Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido
         $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
         $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

         //Creamos un array con todos los datos del Excel importado
         for ($indiceFila=2;$indiceFila<=$filas;$indiceFila++){

            $_DATOS_EXCEL[$indiceFila]['idtipocliente'] = $objPHPExcel->getActiveSheet()->getCell('A'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['idoperacion'] = $objPHPExcel->getActiveSheet()->getCell('B'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['idcondpago'] = $objPHPExcel->getActiveSheet()->getCell('C'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['idzona'] = $objPHPExcel->getActiveSheet()->getCell('D'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['idvendedor'] = $objPHPExcel->getActiveSheet()->getCell('E'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['idimpuestoi'] = $objPHPExcel->getActiveSheet()->getCell('F'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['cod_cliente'] = $objPHPExcel->getActiveSheet()->getCell('G'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['desc_cliente'] = $objPHPExcel->getActiveSheet()->getCell('H'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['rif'] = $objPHPExcel->getActiveSheet()->getCell('I'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['direccion'] = $objPHPExcel->getActiveSheet()->getCell('J'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['ciudad'] = $objPHPExcel->getActiveSheet()->getCell('K'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['codpostal'] = $objPHPExcel->getActiveSheet()->getCell('L'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['contacto'] = $objPHPExcel->getActiveSheet()->getCell('M'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['telefono'] = $objPHPExcel->getActiveSheet()->getCell('N'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['movil'] = $objPHPExcel->getActiveSheet()->getCell('O'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['email'] = $objPHPExcel->getActiveSheet()->getCell('P'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['web'] = $objPHPExcel->getActiveSheet()->getCell('Q'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['limite'] = $objPHPExcel->getActiveSheet()->getCell('R'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['montofiscal'] = $objPHPExcel->getActiveSheet()->getCell('S'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['fechareg'] = $objPHPExcel->getActiveSheet()->getCell('T'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['aplicareten'] = $objPHPExcel->getActiveSheet()->getCell('U'.$indiceFila)->getCalculatedValue();
            $_DATOS_EXCEL[$indiceFila]['estatus'] = 1;
         } 

         $errores=0;

         foreach($_DATOS_EXCEL as $campo => $valor){
            $sql = "INSERT INTO tbcliente(idtipocliente,idoperacion,idcondpago,idzona,idvendedor,idimpuestoi,
            cod_cliente,desc_cliente,rif,direccion,ciudad,codpostal,contacto,telefono,movil,email,web,limite,
            montofiscal,fechareg,aplicareten,estatus) VALUES ('";foreach ($valor as $campo2 => $valor2)
            {$campo2 == "estatus"? $sql.= $valor2."');" : $sql.= $valor2."','";}

            $result=ejecutarConsulta($sql);

            if ($result==1) {
               echo 'Total <b>'.$campo.' Registros</b> Ingresados Correctamente!<br>';
            }
            if($result==1062) {

                echo 'Total <b>'.(($result+1)-1062).' Duplicados</b>, Error al Ingresar<br>!';
            }
            
         }
    
      unlink($ruta);
            
   }else {
      echo "<label>Primero debes cargar el archivo con Extencion .XLSX</label>";
      unlink($ruta);
   }
      
?>
