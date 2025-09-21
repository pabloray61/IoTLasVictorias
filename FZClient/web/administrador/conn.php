<?php

$conn_id = openConn();

function openConn (){
	$local = $_SERVER['SERVER_NAME'] == "localhost" ? true:false;
	//echo "Server: " . $_SERVER['SERVER_NAME'];
	
	if ($local) {
		$id = mysql_connect("localhost", "root") or die("error");
		mysql_select_db("acordes", $id) or die(mysql_error());

	} else {
		//server config
		$id = mysql_connect("localhost", "acordes_user", "Acordes12") or die(mysql_error());
		mysql_select_db("acordes_bd", $id);// Server config 
		//$id = mysql_connect("localhost", "uv0664", "genta022queda") or die(mysql_error());
		//mysql_select_db("uv0664_acordes", $id);// Server config 
	}
	mysql_query("SET character SET utf8");
	return $id;

}

function query ($str){ //Para hacer la consulta de una, sin usar el conn_id
	global $conn_id;
	$q = mysql_query ($str, $conn_id) or die (mysql_error());
	return $q; 
}

function size($q) { /* Returns the number of rows selected  // @return int */
	return mysql_num_rows($q);
}
function closeConn (){
	global $conn_id;
	mysql_close($conn_id);
}

function check ($valor){
	if ( $valor == "1" ) echo "checked";
}

function ahora(){
	$a = getDate();
	return $a["year"]."-".$a["mon"]."-".$a["wday"]."|".$a["hours"].":".$a["minutes"].":".$a["seconds"];
}

function getPicUrl ($cod){
	$tmpUrl = "productos_img/" . $cod . ".jpg";
	if ( is_file($tmpUrl) ) return $tmpUrl;
	else return "productos_img/no_disponible.jpg";
}


?>