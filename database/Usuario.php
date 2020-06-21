<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	//Implementamos un método para insertar registros
	public function Insertar($idmacceso,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,$clave,$imagen,$fechareg){

		$sql="INSERT INTO tbusuario(idmacceso,cod_usuario,desc_usuario,direccion,telefono,email,clave,imagen,fechareg,estatus)
		VALUES ('$idmacceso','$cod_usuario','$desc_usuario','$direccion','$telefono','$email',
		ENCODE('$clave',CONCAT(3265888487/32555*25,'','g4n4d0r')),'$imagen',STR_TO_DATE('$fechareg','%d/%m/%Y'),'1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
  public function Editar($idusuario,$idmacceso,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,$clave,$imagen,$fechareg)
	{

		$sql="UPDATE 
		tbusuario 
		SET 
		idmacceso = '$idmacceso',
		cod_usuario = '$cod_usuario',
		desc_usuario = '$desc_usuario',
		direccion = '$direccion',
		telefono = '$telefono',
		email = '$email',
		clave = ENCODE('$clave',CONCAT(3265888487/32555*25,'','g4n4d0r')),
		imagen = '$imagen',
		fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y')
		WHERE idusuario = '$idusuario'";
		return ejecutarConsulta($sql);

	}

	//Implementamos un método para editar registros
  public function EditarClave($idusuario,$clave)
	{
		$sql="UPDATE 
		tbusuario 
		SET 
		clave = ENCODE('$clave',CONCAT(3265888487/32555*25,'','g4n4d0r'))
		WHERE idusuario = '$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function Eliminar($idusuario)
	{
		$sql="DELETE FROM tbusuario WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function Eliminaracceso($idmacceso)
	{
		$sql="DELETE FROM tbusuarioac WHERE idmacceso='$idmacceso'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function Desactivar($idusuario)
	{
		$sql="UPDATE tbusuario SET estatus='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function Activar($idusuario)
	{
		$sql="UPDATE tbusuario SET estatus='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function Mostrar($idusuario)
	{
		$sql="SELECT
		idusuario,
		cod_usuario,
		desc_usuario,
		direccion,
		telefono,
		email,
		DECODE(clave,CONCAT(3265888487/32555*25,'','g4n4d0r')) AS clave,
		imagen,
		DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
		idmacceso,
		estatus
		FROM tbusuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function Listar()
	{
		$sql="SELECT
		u.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		u.direccion,
		u.telefono,
		u.email,
		u.imagen,
		DATE_FORMAT(u.fechareg,'%d/%m/%Y') AS fechareg,
		u.estatus,
		u.idmacceso,
		ma.cod_macceso,
		ma.desc_macceso
		FROM tbusuario u
		INNER JOIN tbmacceso ma ON ma.idmacceso=u.idmacceso";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function Select()
	{
		$sql="SELECT
		u.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		u.direccion,
		u.telefono,
		u.email,
		u.imagen,
		DATE_FORMAT(u.fechareg,'%d/%m/%Y') AS fechareg,
		u.estatus,
		u.idmacceso,
		ma.cod_macceso,
		ma.desc_macceso
		FROM tbusuario u
		INNER JOIN tbmacceso ma ON ma.idmacceso=u.idmacceso
		WHERE u.estatus='1'";
		return ejecutarConsulta($sql);		
	}
	
	//Función para verificar el acceso al sistema
	public function Verificar($cod_usuario,$clave)
	{
		$sql="SELECT 
		u.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		DECODE(u.clave,CONCAT(3265888487/32555*25,'','g4n4d0r')) AS clave,
		u.direccion,
		u.telefono,
		u.email,
		u.imagen,
		u.idmacceso,
		ma.desc_macceso,
		u.estatus
		FROM tbusuario u 
		INNER JOIN tbmacceso  ma ON ma.idmacceso=u.idmacceso
		WHERE cod_usuario='$cod_usuario' AND clave=ENCODE('$clave',CONCAT(3265888487/32555*25,'','g4n4d0r'))"; 
		return ejecutarConsulta($sql);
	}

	public function rptListar()
	{
		$sql="SELECT 
		idusuario, 
		cod_usuario, 
		desc_usuario, 
		direccion,
		telefono,
		email,
		departamento,
		DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
		estatus
		FROM tbusuario
		ORDER BY cod_usuario ASC";
        return ejecutarConsulta($sql);
	}

	public function ListarModulo($modulo){
		$sql="SELECT * FROM tbacceso 
		WHERE modulo='$modulo'
		ORDER BY idacceso ASC"; 
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los permisos marcados
	public function Listarmarcados($idmacceso){
		$sql="SELECT * FROM tbusuarioac 
		WHERE idmacceso='$idmacceso'";
		return ejecutarConsulta($sql);
	}

}

?>