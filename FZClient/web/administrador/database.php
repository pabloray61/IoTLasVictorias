<?php


// Common Database Methods
function find_all($tabla) {
	return find_by_sql("SELECT * FROM ".$tabla);
}

function find_by_id($tabla, $id=0) {
	$result_array = find_by_sql("SELECT * FROM ".$tabla." WHERE id={$id} LIMIT 1");
	return !empty($result_array) ? array_shift($result_array) : false;
}

function find_by_sql($sql="") {
	$result_set = query($sql);
	$object_array = array();
	while ($row = fetch_array($result_set)) {
		echo($row['nombre']);
		$object_array[] = instantiate($row);
	}
	return $object_array;
}

function count_all() {
	$sql = "SELECT COUNT(*) FROM ".$table_name;
	$result_set = query($sql);
	$row = fetch_array($result_set);
	return array_shift($row);
}


function insert($tabla, $accion) {
	$sql = "INSERT INTO $tabla (";
	$c = query("SELECT * FROM $tabla");
	$n = mysql_num_fields($c);
	for($i = 0; $i < $n; $i++){
		$sql .= mysql_field_name($c, $i).", ";
	}
	$sql = substr($sql, 0, (strlen($sql)-2));
	$sql .= ") VALUES (";
	for($i = 0; $i < mysql_num_fields($c); $i++){
		$field = mysql_field_name($c, $i);
		$type = mysql_field_type($c, $i);
		if(($type == "string" OR $type == "date" OR $type == "blob" OR $type == "real") AND !empty($_REQUEST[$field])) $sql .= "'";
		$valor = (empty($_REQUEST[$field])) ? 'NULL' : $_REQUEST[$field];
		$sql .= $valor;
		if(($type == "string" OR $type == "date" OR $type == "blob" OR $type == "real") AND !empty($_REQUEST[$field])) $sql .= "'";
		$sql .= ", ";
	}
	$sql = substr($sql, 0, (strlen($sql)-2));
	$sql .= ")";
	
	if($accion == 'insertar'){
		if(query($sql)) {
			return true;
		} else {
			return false;
		}
	}
	if($accion = 'imprimir') echo("SQL: ".$sql."<br>");
}

function update($tabla, $id, $accion) {
	$sql = "UPDATE ".$tabla." SET ";
	$c = query("SELECT * FROM $tabla");
	$n = mysql_num_fields($c);

	for($i = 0; $i < mysql_num_fields($c); $i++){
		$field = mysql_field_name($c, $i);
		$type = mysql_field_type($c, $i);
		$sql .= mysql_field_name($c, $i)."= ";
		if(isString($type)) $sql .= "'";
		$valor = (!isString($type) AND empty($_REQUEST[$field])) ? 'NULL' : $_REQUEST[$field];
		$sql .= $valor;
		if(isString($type)) $sql .= "'";
		$sql .= ", ";
	}
	$sql = substr($sql, 0, (strlen($sql)-2));
	$id = mysql_field_name($c, 0);
	$sql .= " WHERE ".$id."= ".$_REQUEST[$id];
	
	if($accion == 'insertar'){
		if(query($sql)) {
			return true;
		} else {
			return false;
		}
	}
	if($accion = 'imprimir') echo("SQL: ".$sql."<br>");
}

function delete($tabla, $accion) {
	$c = query("SELECT * FROM $tabla");
	$id = mysql_field_name($c, 0);
	$sql = "DELETE FROM ".$tabla;
	$sql .= " WHERE ".$id."= ".$_REQUEST[$id];
	$sql .= " LIMIT 1";
	
	if($accion == 'insertar'){
		if(query($sql)) {
			return true;
		} else {
			return false;
		}
	}
	if($accion = 'imprimir') echo("SQL: ".$sql."<br>");
}

function isString($type) {
	if($type == "string") return true;
	if($type == "date") return true;
	if($type == "blob") return true; 
	if($type == "real") return true;
	return false;
}

?>
