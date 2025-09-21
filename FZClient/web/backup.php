<? 
require("administrador/conn.php");
require("administrador/func.php");

// Nombre del archivo de con el cual queremos que se guarde la base de datos 
$hoy = date("d-m-Y");
$filename = "BD-Acordes-(".$hoy.").sql.gz";  

//$opcion1 = true;
$opcion2 = true;

if($opcion1){
	// Cabeceras para forzar al navegador a guardar el archivo 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	header("Content-Transfer-Encoding: binary"); 
	header("Content-type: application/force-download"); 
	header("Content-Disposition: attachment; filename=$filename"); 
	 
	$usuario="uv0664";  // Usuario de la base de datos, un ejemplo podria ser 'root' 
	$passwd="genta022queda";  // Contraseña asignada al usuario 
	$bd="uv0664_acordes";  // Nombre de la Base de Datos a exportar 
	$host="localhost";
	 
	// Funciones para exportar la base de datos 
	//$executa = "c:\\mysql\\bin\\mysqldump.exe -u $usuario --password=$passwd --opt $bd";  // WINDOWS
	//$executa = "/mysql/bin/mysqldump -u $usuario --password=$passwd --opt $bd"; //LINUX
	$executa = "mysqldump --opt -h $host -u $usuario -p $passwd $bd | gzip > $filename";
	
	system($executa, $resultado); 
	 
	// Comprobar si se ha realizado bien, si no es así, mostrará un mensaje de error 
	if ($resultado) { echo "<H1>Error ejecutando comando: $executa</H1>\n"; } 
}
if($opcion2){
	$tableName  = 'mypet';   
	$backupFile = 'backup/mypet.sql';   
	$query      = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";   
	$result = mysql_query($query);   
}
?>  
