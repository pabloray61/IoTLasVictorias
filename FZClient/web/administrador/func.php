<?
/// imprime la fecha de hoy
function hoy(){
return date("Y") ."-".date("m") . "-".date("d");
}

//------------------------------------------------

//convierte la fecha de yyyy-mm-dd a dd-mm-yyyy
function formatoFecha($str_fecha){
	$arr = preg_split("[-]", $str_fecha);
	$a = trim($arr[0]);
	$m = trim($arr[1]);
	$d = trim($arr[2]);
	echo $d . "-" . $m . "-" . $a; 

}
//convierte la fecha de yyyy-mm-dd a dd-mm-yy
function formatoFecha2($str_fecha){
	$arr = preg_split("[-]", $str_fecha);
	$a = substr(trim($arr[0]),2,2);
	$m = trim($arr[1]);
	$d = trim($arr[2]);
	echo $d . "-" . $m . "-" . $a; 

}

//Devuelve las carpetas dentro del archivo path.
function listar_dir($path){
$carpetas=array();
$dir=opendir($path);

while ( $a = readdir( $dir ) ){

	if(is_dir($path . $a) and $a!='.' and $a!='..'){
		array_push($carpetas,$a);

	}
}

return $carpetas;
}

function getMes ($indx){
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	return $meses[$indx];
}


function membrete($titulo, $foto, $w1 = ''){
		if($w1 == "") $w1 = 10;
		$w2 = 100 - $w1;
		echo "<tr height='11'>
				<td width='11' background='images/border_izq_up.png'></td>
				<td background='images/border_h_up.png'></td>
				<td width='11' background='images/border_der_up.png'></td>
			</tr>
			<tr>
				<td background='images/border_v_izq.png'>&nbsp;</td>
				<td>
					<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						<tr>
							<td width='80%'>
								<table width='100%' border='0' cellpadding='0' cellspacing='0'>
									<tr height='40'>
										<td width='".$w1."%' abbr='center'><img src='images/".$foto."'></td>
										<td width='".$w2."%' class='titulo_login'>".$titulo."</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td background='images/border_v_der.png'>&nbsp;</td>
			</tr>
			<tr height='11'>
				<td background='images/border_izq_dw.png'></td>
				<td background='images/border_h_dw.png'></td>
				<td background='images/border_der_dw.png'></td>
			</tr>
			<tr height='10'><td colspan='3'></td></tr>";
}
function getLastM ($url){
	$r = filemtime ($url);
	return $url . "?" . date("Y-m-d-G:i:s", $r);
}
function rotarFecha($fecha, $d='-'){
	if(!empty($fecha) AND $fecha != '--' AND $fecha != '0000-00-00'){
		list($d1, $d2, $d3) = explode("$d",$fecha);
		$fecha = $d3."".$d."".$d2."".$d."".$d1;
	}else{
		$fecha = '';
	}
	return $fecha;
}
function separarFechaHora($dato, $d='-'){
	$datos = array();
	if(!empty($dato)){
		list($d1, $d2, $d3, $h, $m, $s) = split('[ -/:]', $dato);
		//echo($d1."-".$d2."-".$d3." | ".$h.":".$m.":".$s);
		$datos[0] = $d1."".$d."".$d2."".$d."".$d3;
		$datos[1] = $h.":".$m;
	}else{
		$datos[0] = "";
		$datos[1] = "";
	}
	return $datos;
}

// Devuelve un array con los archivos que hay dentro de la que le pasaste ($carpeta_base)
function listarArchivos($carpeta_base, $ext=""){
	$carpetas = array();
	if ($dir = opendir($carpeta_base)){
		while ( $file = readdir( $dir )){
			if ( $file != '.' and $file != '..' and $file != 'Thumbs.db'){
				array_push($carpetas, $file);
			}
		}
	} else echo "<b>listarArchivos()</b> => no hay nada en esta carpeta <BR>";
	
	if ($ext != ""){ //si tiene argumente $ext, busca solo archivos con esa extensión
		$archivos = array();
		for ($i=0; $i<count($carpetas); $i++){
			if( getExtension($carpetas[$i]) == $ext ) array_push ($archivos, $carpetas[$i]);
		}
		sort($archivos); 
		return $archivos;
	} else {
		sort($carpetas); //devuelve el arreglo con la data
		return $carpetas;
	}
}

// Devuelve un array con las carpetas que hay ($carpeta_base)
function listarCarpetas($carpeta_base, $ext=""){
	$carpetas = array();
	if ($dir = opendir($carpeta_base)){
		while ( $file = readdir( $dir )){
			if ( $file != '.' and $file != '..' ){
				array_push($carpetas, $file);
			}
		}
	} else echo "<b>listarArchivos()</b> => no hay ninguna carpeta <BR>";
	
	if ($ext != ""){ //si tiene argumente $ext, busca solo archivos con esa extensión
		$archivos = array();
		for ($i=0; $i<count($carpetas); $i++){
			if( getExtension($carpetas[$i]) == $ext ) array_push ($archivos, $carpetas[$i]);
		}
		sort($archivos); 
		return $archivos;
	} else {
		sort($carpetas); //devuelve el arreglo con la data
		return $carpetas;
	}
}
function armarSelect($variable, $valor, $dato1, $dato2, $tabla, $txt, $class, $submit="", $n=""){
	//echo("SELECT * FROM $tabla order by $dato1");
	$fs = !empty($submit) ? "onChange='document.$submit.submit();'" : "";
	echo "<select name='$variable$n' class='$class' $fs>\n";
	echo "<option value=''>$txt</option>\n";
		$q_t = query("SELECT * FROM $tabla order by $dato1");
			while($rs_t = mysql_fetch_array($q_t)){ 
				$id_dato = $rs_t[$variable];
				if($dato1 != "") $d1 = $rs_t[$dato1];
				if($dato2 != "") $d2 = $rs_t[$dato2];
				echo "<option value='$id_dato'";
				if($id_dato == $valor) echo "SELECTED";
				echo ">$d1 $d2</option>\n";
		 	}
	echo "</select>\n";
}
function armarSelectD($variable, $valor, $txt, $class, $value, $name){
	$value = preg_split("[,]", $value);
	$name = preg_split("[,]", $name);
	echo "<select name='$variable' class='$class'>\n";
	echo "<option value=''>$txt</option>\n";
		for($i = 0; $i< sizeof($value); $i++){ 
			$dato = $value[$i];
			$nombre = $name[$i];
			echo "<option value='$dato'";
			if($dato == $valor) echo "SELECTED";
			echo ">$nombre</option>\n";
		}
	echo "</select>\n";
}
function getFoto ($path){
	if(file_exists($path)){
		$tmp = getimagesize($path);
		$ancho = $tmp[0];
		$alto = $tmp[1];
		echo "<img src='images/b_ver_foto.png' border='0' style='border-color: 777777' onmouseover=showtrail('$path','',$ancho,$alto)  onmouseout='hidetrail();'>";
		echo "<div style='display: none; position: absolute;z-index:110; ' id='preview_div'></div>";
	}
}


function getExtension ($file){
	$tmp = preg_split("[\.]", $file);
	if ( count($tmp) > 1 ) return strtolower($tmp[count($tmp)-1]);
	else return "";
}

// Armo un SELECT
function selectCarpeta($carpeta, $img_def, $variable, $valor, $txt, $class){
	if($variable == "") $variable = $img_def;
	$tmp = listarArchivos($carpeta);
	echo "<Select name='".$variable."' class='".$class."' onChange='javascript:cargar_imagen('$carpeta', this.value, '$variable')'>\n";
	echo "<option value='".$img_def."'>".$txt."</option>";
	echo "<option value='".$img_def."'>-----------------------------------</option>";
	for ($j=0; $j < count($tmp); $j++){
		$nombre = explode("-", $tmp[$j]);
		if ($tmp[$j] != "Thumbs.db" && substr(strrchr($tmp[$j], '.'), 1) != "LCK"){
			$selected = $tmp[$j] == $valor ? "SELECTED":"";
			$n = $nombre[1];
			if($n == "") $n = $nombre[0];
			echo "<option value='". $tmp[$j] ."' $selected >". $n ."</option>\n";
		}
	}
	echo "</select>";
}

//Esta funcion sirve para armar el combo de las fechas
//Esta funcion sirve para armar el combo de las fechas
function comboFecha ($str_fecha = "", $counter = ""){


	$arr = preg_split("-", $str_fecha);
	$a = trim($arr[0]); $m = trim($arr[1]); $d = trim($arr[2]);
	
	
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$hoy=getdate();
	for ($h = 1950; $h <= $hoy['year']+1; $h++){
		$ano[]=$h;
	}
	//Armo el select del dia
	echo "<SELECT name='dia".$counter."'>";
	echo "<option value='0'>dd</option>";
	for ( $i=1; $i<=31; $i++) {
		$c = $i < 10 ? "0".$i:$i;
		echo "<option value='$c' ".(($c == $d) ? "SELECTED":"").">$c</option> ";
	}
	echo "</SELECT>";
	
	//armo el select del mes
	echo "<SELECT name='mes".$counter."'>";
	echo "<option value='0'>mm</option>";
	for ( $i=1; $i<= count($meses); $i++) {
		$c = $i < 10 ? "0".$i:$i;
		echo "<option value='$c' ". (($c == $m) ? "SELECTED":""). ">".$meses[$i-1]."</option>/r";
	}
	echo "</SELECT>";
	
	//armo el select del año
	echo "<SELECT name='ano".$counter."'>";
	echo "<option value='0001'>aa</option>";
	for ( $i=0; $i< count($ano); $i++) {
		echo "<option value='".$ano[$i]."' ".($ano[$i] == $a ? "SELECTED":"").">".$ano[$i]."</option> ";
	}
	echo "</SELECT>";
}

function agregarFecha($nombre, $fecha){
	echo "<div><input type='text' name='$nombre' class='tcal' value='$fecha' size='12' /></div>";
}
function comboHora($var1, $hora_in, $txt_in, $var2, $hora_out, $txt_out, $class="imput_form"){
	echo"<script type='text/javascript' src='includes/timepicker.js'></script>";
	echo"<table><tr>";
	echo"<td><input id='".$var1."' name='".$var1."' type='text' value='".$hora_in."' size='4' maxlength='8' class='".$class."' style='text-align:center;'>&nbsp;</td>\n";
	echo"<td><img src='images/timepicker.gif' border='0' alt='".$txt_in."' onClick='selectTime(this,".$var1.")' style='cursor:hand'>&nbsp;</td>\n";
	if($var2 != "no"){
		echo"<td><input id='".$var2."' name='".$var2."' type='text' value='".$hora_out."' size='4' maxlength='8' class='".$class."' style='text-align:center;'>&nbsp;</td>\n";
		echo"<td><img src='images/timepicker.gif' border='0' alt='".$txt_out."' onClick='selectTime(this,".$var2.")' style='cursor:hand'>&nbsp;</td>\n";
	}
	echo"</tr></table>";
}

function getPais($variable = 'pais', $pais, $class){
	echo("<select name='$variable' class='".$class."'>"); 
		echo("<option value=''>Elegir el Pais</option>");
		echo("<option value=''>-------------------</option>\n");
		echo("<option value='Argentina'"); if($pais == "Argentina") echo("SELECTED"); echo(">Argentina</option>\n");
		echo("<option value='Brasil'"); if($pais == "Brasil") echo("SELECTED"); echo(">Brasil</option>\n");
		echo("<option value='Chile'"); if($pais == "Chile") echo("SELECTED"); echo(">Chile</option>\n");
		echo("<option value='Estados Unidos'"); if($pais == "Estados Unidos") echo("SELECTED"); echo(">Estados Unidos</option>\n");
		echo("<option value='Paraguay'"); if($pais == "Paraguay") echo("SELECTED"); echo(">Paraguay</option>\n");
		echo("<option value='Uruguay'"); if($pais == "Uruguay") echo("SELECTED"); echo(">Uruguay</option>\n");
		echo("<option value=''>-------------------</option>\n");
		echo("<option value='Afganistan'"); if($pais == "Afganistan") echo("SELECTED"); echo(">Afganistan</option>\n");
		echo("<option value='Africa del Sur'"); if($pais == "Africa del Sur") echo("SELECTED"); echo(">Africa del Sur</option>\n");
		echo("<option value='Albania'"); if($pais == "Albania") echo("SELECTED"); echo(">Albania</option>\n");
		echo("<option value='Alemania'"); if($pais == "Alemania") echo("SELECTED"); echo(">Alemania</option>\n");
		echo("<option value='Andorra'"); if($pais == "Andorra") echo("SELECTED"); echo(">Andorra</option>\n");
		echo("<option value='Angola'"); if($pais == "Angola") echo("SELECTED"); echo(">Angola</option>\n");
		echo("<option value='Antigua y Barbuda'"); if($pais == "Antigua y Barbuda") echo("SELECTED"); echo(">Antigua y Barbuda</option>\n");
		echo("<option value='Antillas Holandesas'"); if($pais == "Antillas Holandesas") echo("SELECTED"); echo(">Antillas Holandesas</option>\n");
		echo("<option value='Arabia Saudita'"); if($pais == "Arabia Saudita") echo("SELECTED"); echo(">Arabia Saudita</option>\n");
		echo("<option value='Argelia'"); if($pais == "Argelia") echo("SELECTED"); echo(">Argelia</option>\n");
		echo("<option value='Armenia'"); if($pais == "Armenia") echo("SELECTED"); echo(">Armenia</option>\n");
		echo("<option value='Aruba'"); if($pais == "Aruba") echo("SELECTED"); echo(">Aruba</option>\n");
		echo("<option value='Australia'"); if($pais == "Australia") echo("SELECTED"); echo(">Australia</option>\n");
		echo("<option value='Austria'"); if($pais == "Austria") echo("SELECTED"); echo(">Austria</option>\n");
		echo("<option value='Azerbaijan'"); if($pais == "Azerbaijan") echo("SELECTED"); echo(">Azerbaijan</option>\n");
		echo("<option value='Bahamas'"); if($pais == "Bahamas") echo("SELECTED"); echo(">Bahamas</option>\n");
		echo("<option value='Bahrain'"); if($pais == "Bahrain") echo("SELECTED"); echo(">Bahrain</option>\n");
		echo("<option value='Bangladesh'"); if($pais == "Bangladesh") echo("SELECTED"); echo(">Bangladesh</option>\n");
		echo("<option value='Barbados'"); if($pais == "Barbados") echo("SELECTED"); echo(">Barbados</option>\n");
		echo("<option value='Belarusia'"); if($pais == "Belarusia") echo("SELECTED"); echo(">Belarusia</option>\n");
		echo("<option value='Belgica'"); if($pais == "Belgica") echo("SELECTED"); echo(">Belgica</option>\n");
		echo("<option value='Belice'"); if($pais == "Belice") echo("SELECTED"); echo(">Belice</option>\n");
		echo("<option value='Benin'"); if($pais == "Benin") echo("SELECTED"); echo(">Benin</option>\n");
		echo("<option value='Bermudas'"); if($pais == "Bermudas") echo("SELECTED"); echo(">Bermudas</option>\n");
		echo("<option value='Bolivia'"); if($pais == "Bolivia") echo("SELECTED"); echo(">Bolivia</option>\n");
		echo("<option value='Bosnia'"); if($pais == "Bosnia") echo("SELECTED"); echo(">Bosnia</option>\n");
		echo("<option value='Botswana'"); if($pais == "Botswana") echo("SELECTED"); echo(">Botswana</option>\n");
		echo("<option value='Brunei Darussulam'"); if($pais == "Brunei Darussulam") echo("SELECTED"); echo(">Brunei Darussulam</option>\n");
		echo("<option value='Bulgaria'"); if($pais == "Bulgaria") echo("SELECTED"); echo(">Bulgaria</option>\n");
		echo("<option value='Burkina Faso'"); if($pais == "Burkina Faso") echo("SELECTED"); echo(">Burkina Faso</option>\n");
		echo("<option value='Burundi'"); if($pais == "Burundi") echo("SELECTED"); echo(">Burundi</option>\n");
		echo("<option value='Butan'"); if($pais == "Butan") echo("SELECTED"); echo(">Butan</option>\n");
		echo("<option value='Camboya'"); if($pais == "Camboya") echo("SELECTED"); echo(">Camboya</option>\n");
		echo("<option value='Camerun'"); if($pais == "Camerun") echo("SELECTED"); echo(">Camerun</option>\n");
		echo("<option value='Canada'"); if($pais == "Canada") echo("SELECTED"); echo(">Canada</option>\n");
		echo("<option value='Cape Verde'"); if($pais == "Cape Verde") echo("SELECTED"); echo(">Cape Verde</option>\n");
		echo("<option value='Chad'"); if($pais == "Chad") echo("SELECTED"); echo(">Chad</option>\n");
		echo("<option value='China'"); if($pais == "China") echo("SELECTED"); echo(">China</option>\n");
		echo("<option value='Chipre'"); if($pais == "Chipre") echo("SELECTED"); echo(">Chipre</option>\n");
		echo("<option value='Colombia'"); if($pais == "Colombia") echo("SELECTED"); echo(">Colombia</option>\n");
		echo("<option value='Comoros'"); if($pais == "Comoros") echo("SELECTED"); echo(">Comoros</option>\n");
		echo("<option value='Congo'"); if($pais == "Congo") echo("SELECTED"); echo(">Congo</option>\n");
		echo("<option value='Corea del Norte'"); if($pais == "Corea del Norte") echo("SELECTED"); echo(">Corea del Norte</option>\n");
		echo("<option value='Corea del Sur'"); if($pais == "Corea del Sur") echo("SELECTED"); echo(">Corea del Sur</option>\n");
		echo("<option value='Costa de Marfíl'"); if($pais == "Costa de Marfíl") echo("SELECTED"); echo(">Costa de Marfíl</option>\n");
		echo("<option value='Costa Rica'"); if($pais == "Costa Rica") echo("SELECTED"); echo(">Costa Rica</option>\n");
		echo("<option value='Croasia'"); if($pais == "Croasia") echo("SELECTED"); echo(">Croasia</option>\n");
		echo("<option value='Cuba'"); if($pais == "Cuba") echo("SELECTED"); echo(">Cuba</option>\n");
		echo("<option value='Dinamarca'"); if($pais == "Dinamarca") echo("SELECTED"); echo(">Dinamarca</option>\n");
		echo("<option value='Djibouti'"); if($pais == "Djibouti") echo("SELECTED"); echo(">Djibouti</option>\n");
		echo("<option value='Dominica'"); if($pais == "Dominica") echo("SELECTED"); echo(">Dominica</option>\n");
		echo("<option value='Ecuador'"); if($pais == "Ecuador") echo("SELECTED"); echo(">Ecuador</option>\n");
		echo("<option value='Egipto'"); if($pais == "Egipto") echo("SELECTED"); echo(">Egipto</option>\n");
		echo("<option value='El Salvador'"); if($pais == "El Salvador") echo("SELECTED"); echo(">El Salvador</option>\n");
		echo("<option value='Emiratos Arabes Unidos'"); if($pais == "Emiratos Arabes Unidos") echo("SELECTED"); echo(">Emiratos Arabes Unidos</option>\n");
		echo("<option value='Eritrea'"); if($pais == "Eritrea") echo("SELECTED"); echo(">Eritrea</option>\n");
		echo("<option value='Eslovenia'"); if($pais == "Eslovenia") echo("SELECTED"); echo(">Eslovenia</option>\n");
		echo("<option value='España'"); if($pais == "España") echo("SELECTED"); echo(">España</option>\n");
		echo("<option value='Estonia'"); if($pais == "Estonia") echo("SELECTED"); echo(">Estonia</option>\n");
		echo("<option value='Etiopia'"); if($pais == "Etiopia") echo("SELECTED"); echo(">Etiopia</option>\n");
		echo("<option value='Fiji'"); if($pais == "Fiji") echo("SELECTED"); echo(">Fiji</option>\n");
		echo("<option value='Filipinas'"); if($pais == "Filipinas") echo("SELECTED"); echo(">Filipinas</option>\n");
		echo("<option value='Finlandia'"); if($pais == "Finlandia") echo("SELECTED"); echo(">Finlandia</option>\n");
		echo("<option value='Francia'"); if($pais == "Francia") echo("SELECTED"); echo(">Francia</option>\n");
		echo("<option value='Gabon'"); if($pais == "Gabon") echo("SELECTED"); echo(">Gabon</option>\n");
		echo("<option value='Gambia'"); if($pais == "Gambia") echo("SELECTED"); echo(">Gambia</option>\n");
		echo("<option value='Georgia'"); if($pais == "Georgia") echo("SELECTED"); echo(">Georgia</option>\n");
		echo("<option value='Ghana'"); if($pais == "Ghana") echo("SELECTED"); echo(">Ghana</option>\n");
		echo("<option value='Granada'"); if($pais == "Granada") echo("SELECTED"); echo(">Granada</option>\n");
		echo("<option value='Grecia'"); if($pais == "Grecia") echo("SELECTED"); echo(">Grecia</option>\n");
		echo("<option value='Groenlandia'"); if($pais == "Groenlandia") echo("SELECTED"); echo(">Groenlandia</option>\n");
		echo("<option value='Guadalupe'"); if($pais == "Guadalupe") echo("SELECTED"); echo(">Guadalupe</option>\n");
		echo("<option value='Guam'"); if($pais == "Guam") echo("SELECTED"); echo(">Guam</option>\n");
		echo("<option value='Guatemala'"); if($pais == "Guatemala") echo("SELECTED"); echo(">Guatemala</option>\n");
		echo("<option value='Guayana Francesa'"); if($pais == "Guayana Francesa") echo("SELECTED"); echo(">Guayana Francesa</option>\n");
		echo("<option value='Guerney'"); if($pais == "Guerney") echo("SELECTED"); echo(">Guerney</option>\n");
		echo("<option value='Guinea'"); if($pais == "Guinea") echo("SELECTED"); echo(">Guinea</option>\n");
		echo("<option value='Guinea-Bissau'"); if($pais == "Guinea-Bissau") echo("SELECTED"); echo(">Guinea-Bissau</option>\n");
		echo("<option value='Guinea Equatorial'"); if($pais == "Guinea Equatorial") echo("SELECTED"); echo(">Guinea Equatorial</option>\n");
		echo("<option value='Guyana'"); if($pais == "Guyana") echo("SELECTED"); echo(">Guyana</option>\n");
		echo("<option value='Haiti'"); if($pais == "Haiti") echo("SELECTED"); echo(">Haiti</option>\n");
		echo("<option value='Holanda'"); if($pais == "Holanda") echo("SELECTED"); echo(">Holanda</option>\n");
		echo("<option value='Honduras'"); if($pais == "Honduras") echo("SELECTED"); echo(">Honduras</option>\n");
		echo("<option value='Hong Kong'"); if($pais == "Hong Kong") echo("SELECTED"); echo(">Hong Kong</option>\n");
		echo("<option value='Hungria'"); if($pais == "Hungria") echo("SELECTED"); echo(">Hungria</option>\n");
		echo("<option value='India'"); if($pais == "India") echo("SELECTED"); echo(">India</option>\n");
		echo("<option value='Indonesia'"); if($pais == "Indonesia") echo("SELECTED"); echo(">Indonesia</option>\n");
		echo("<option value='Irak'"); if($pais == "Irak") echo("SELECTED"); echo(">Irak</option>\n");
		echo("<option value='Iran'"); if($pais == "Iran") echo("SELECTED"); echo(">Iran</option>\n");
		echo("<option value='Irlanda'"); if($pais == "Irlanda") echo("SELECTED"); echo(">Irlanda</option>\n");
		echo("<option value='Islandia'"); if($pais == "Islandia") echo("SELECTED"); echo(">Islandia</option>\n");
		echo("<option value='Islas Caiman'"); if($pais == "Islas Caiman") echo("SELECTED"); echo(">Islas Caiman</option>\n");
		echo("<option value='Islas Faroe'"); if($pais == "Islas Faroe") echo("SELECTED"); echo(">Islas Faroe</option>\n");
		echo("<option value='Islas Malvinas'"); if($pais == "Islas Malvinas") echo("SELECTED"); echo(">Islas Malvinas</option>\n");
		echo("<option value='Islas Marshall'"); if($pais == "Islas Marshall") echo("SELECTED"); echo(">Islas Marshall</option>\n");
		echo("<option value='Islas Solomon'"); if($pais == "Islas Solomon") echo("SELECTED"); echo(">Islas Solomon</option>\n");
		echo("<option value='Islas Virgenes Britanicas'"); if($pais == "Islas Virgenes Britanicas") echo("SELECTED"); echo(">Islas Virgenes Britanicas</option>\n");
		echo("<option value='Islas Virgenes (U.S.)'"); if($pais == "Islas Virgenes (U.S.)") echo("SELECTED"); echo(">Islas Virgenes (U.S.)</option>\n");
		echo("<option value='Israel'"); if($pais == "Israel") echo("SELECTED"); echo(">Israel</option>\n");
		echo("<option value='Italia'"); if($pais == "Italia") echo("SELECTED"); echo(">Italia</option>\n");
		echo("<option value='Jamaica'"); if($pais == "Jamaica") echo("SELECTED"); echo(">Jamaica</option>\n");
		echo("<option value='Japon'"); if($pais == "Japon") echo("SELECTED"); echo(">Japon</option>\n");
		echo("<option value='Jersey'"); if($pais == "Jersey") echo("SELECTED"); echo(">Jersey</option>\n");
		echo("<option value='JJordania'"); if($pais == "JJordania") echo("SELECTED"); echo(">JJordania</option>\n");
		echo("<option value='Kazakhstan'"); if($pais == "Kazakhstan") echo("SELECTED"); echo(">Kazakhstan</option>\n");
		echo("<option value='Kenia'"); if($pais == "Kenia") echo("SELECTED"); echo(">Kenia</option>\n");
		echo("<option value='Kiribati'"); if($pais == "Kiribati") echo("SELECTED"); echo(">Kiribati</option>\n");
		echo("<option value='Kuwait'"); if($pais == "Kuwait") echo("SELECTED"); echo(">Kuwait</option>\n");
		echo("<option value='Kyrgyzstan'"); if($pais == "Kyrgyzstan") echo("SELECTED"); echo(">Kyrgyzstan</option>\n");
		echo("<option value='Laos'"); if($pais == "Laos") echo("SELECTED"); echo(">Laos</option>\n");
		echo("<option value='Latvia'"); if($pais == "Latvia") echo("SELECTED"); echo(">Latvia</option>\n");
		echo("<option value='Lesotho'"); if($pais == "Lesotho") echo("SELECTED"); echo(">Lesotho</option>\n");
		echo("<option value='Libano'"); if($pais == "Libano") echo("SELECTED"); echo(">Libano</option>\n");
		echo("<option value='Liberia'"); if($pais == "Liberia") echo("SELECTED"); echo(">Liberia</option>\n");
		echo("<option value='Libia'"); if($pais == "Libia") echo("SELECTED"); echo(">Libia</option>\n");
		echo("<option value='Liechtenstein'"); if($pais == "Liechtenstein") echo("SELECTED"); echo(">Liechtenstein</option>\n");
		echo("<option value='Lituania'"); if($pais == "Lituania") echo("SELECTED"); echo(">Lituania</option>\n");
		echo("<option value='Luxemburgo'"); if($pais == "Luxemburgo") echo("SELECTED"); echo(">Luxemburgo</option>\n");
		echo("<option value='Macao'"); if($pais == "Macao") echo("SELECTED"); echo(">Macao</option>\n");
		echo("<option value='Macedonia'"); if($pais == "Macedonia") echo("SELECTED"); echo(">Macedonia</option>\n");
		echo("<option value='Madagascar'"); if($pais == "Madagascar") echo("SELECTED"); echo(">Madagascar</option>\n");
		echo("<option value='Malasia'"); if($pais == "Malasia") echo("SELECTED"); echo(">Malasia</option>\n");
		echo("<option value='Malawi'"); if($pais == "Malawi") echo("SELECTED"); echo(">Malawi</option>\n");
		echo("<option value='Maldivas'"); if($pais == "Maldivas") echo("SELECTED"); echo(">Maldivas</option>\n");
		echo("<option value='Mali'"); if($pais == "Mali") echo("SELECTED"); echo(">Mali</option>\n");
		echo("<option value='Malta'"); if($pais == "Malta") echo("SELECTED"); echo(">Malta</option>\n");
		echo("<option value='Marruecos'"); if($pais == "Marruecos") echo("SELECTED"); echo(">Marruecos</option>\n");
		echo("<option value='Martinica'"); if($pais == "Martinica") echo("SELECTED"); echo(">Martinica</option>\n");
		echo("<option value='Mauricio'"); if($pais == "Mauricio") echo("SELECTED"); echo(">Mauricio</option>\n");
		echo("<option value='Mauritania'"); if($pais == "Mauritania") echo("SELECTED"); echo(">Mauritania</option>\n");
		echo("<option value='Mexico'"); if($pais == "Mexico") echo("SELECTED"); echo(">Mexico</option>\n");
		echo("<option value='Micronesia'"); if($pais == "Micronesia") echo("SELECTED"); echo(">Micronesia</option>\n");
		echo("<option value='Moldova'"); if($pais == "Moldova") echo("SELECTED"); echo(">Moldova</option>\n");
		echo("<option value='Monaco'"); if($pais == "Monaco") echo("SELECTED"); echo(">Monaco</option>\n");
		echo("<option value='Mongolia'"); if($pais == "Mongolia") echo("SELECTED"); echo(">Mongolia</option>\n");
		echo("<option value='Mozambique'"); if($pais == "Mozambique") echo("SELECTED"); echo(">Mozambique</option>\n");
		echo("<option value='Myanmar (Burma)'"); if($pais == "Myanmar (Burma)") echo("SELECTED"); echo(">Myanmar (Burma)</option>\n");
		echo("<option value='Namibia'"); if($pais == "Namibia") echo("SELECTED"); echo(">Namibia</option>\n");
		echo("<option value='Nepal'"); if($pais == "Nepal") echo("SELECTED"); echo(">Nepal</option>\n");
		echo("<option value='Nicaragua'"); if($pais == "Nicaragua") echo("SELECTED"); echo(">Nicaragua</option>\n");
		echo("<option value='Niger'"); if($pais == "Niger") echo("SELECTED"); echo(">Niger</option>\n");
		echo("<option value='Nigeria'"); if($pais == "Nigeria") echo("SELECTED"); echo(">Nigeria</option>\n");
		echo("<option value='Noruega'"); if($pais == "Noruega") echo("SELECTED"); echo(">Noruega</option>\n");
		echo("<option value='Nueva Caledonia'"); if($pais == "Nueva Caledonia") echo("SELECTED"); echo(">Nueva Caledonia</option>\n");
		echo("<option value='Nueva Zealandia'"); if($pais == "Nueva Zealandia") echo("SELECTED"); echo(">Nueva Zealandia</option>\n");
		echo("<option value='Oman'"); if($pais == "Oman") echo("SELECTED"); echo(">Oman</option>\n");
		echo("<option value='Pakistan'"); if($pais == "Pakistan") echo("SELECTED"); echo(">Pakistan</option>\n");
		echo("<option value='Palestina'"); if($pais == "Palestina") echo("SELECTED"); echo(">Palestina</option>\n");
		echo("<option value='Panama'"); if($pais == "Panama") echo("SELECTED"); echo(">Panama</option>\n");
		echo("<option value='Papua Nueva Guinea'"); if($pais == "Papua Nueva Guinea") echo("SELECTED"); echo(">Papua Nueva Guinea</option>\n");
		echo("<option value='Peru'"); if($pais == "Peru") echo("SELECTED"); echo(">Peru</option>\n");
		echo("<option value='Polinesia Francesa'"); if($pais == "Polinesia Francesa") echo("SELECTED"); echo(">Polinesia Francesa</option>\n");
		echo("<option value='Polonia'"); if($pais == "Polonia") echo("SELECTED"); echo(">Polonia</option>\n");
		echo("<option value='Portugal'"); if($pais == "Portugal") echo("SELECTED"); echo(">Portugal</option>\n");
		echo("<option value='Puerto Rico'"); if($pais == "Puerto Rico") echo("SELECTED"); echo(">Puerto Rico</option>\n");
		echo("<option value='Qatar'"); if($pais == "Qatar") echo("SELECTED"); echo(">Qatar</option>\n");
		echo("<option value='Reino Unido'"); if($pais == "Reino Unido") echo("SELECTED"); echo(">Reino Unido</option>\n");
		echo("<option value='Republica Centroafricana'"); if($pais == "Republica Centroafricana") echo("SELECTED"); echo(">Republica Centroafricana</option>\n");
		echo("<option value='Republica Checa'"); if($pais == "Republica Checa") echo("SELECTED"); echo(">Republica Checa</option>\n");
		echo("<option value='Republica Democratica del Congo'"); if($pais == "Republica Democratica del Congo") echo("SELECTED"); echo(">Republica Democratica del Congo</option>\n");
		echo("<option value='Republica Dominicana'"); if($pais == "Republica Dominicana") echo("SELECTED"); echo(">Republica Dominicana</option>\n");
		echo("<option value='Republica Eslovaca'"); if($pais == "Republica Eslovaca") echo("SELECTED"); echo(">Republica Eslovaca</option>\n");
		echo("<option value='Reunion'"); if($pais == "Reunion") echo("SELECTED"); echo(">Reunion</option>\n");
		echo("<option value='Ruanda'"); if($pais == "Ruanda") echo("SELECTED"); echo(">Ruanda</option>\n");
		echo("<option value='Rumania'"); if($pais == "Rumania") echo("SELECTED"); echo(">Rumania</option>\n");
		echo("<option value='Rusia'"); if($pais == "Rusia") echo("SELECTED"); echo(">Rusia</option>\n");
		echo("<option value='Sahara'"); if($pais == "Sahara") echo("SELECTED"); echo(">Sahara</option>\n");
		echo("<option value='Samoa'"); if($pais == "Samoa") echo("SELECTED"); echo(">Samoa</option>\n");
		echo("<option value='San Cristobal-Nevis (St. Kitts)'"); if($pais == "San Cristobal-Nevis (St. Kitts)") echo("SELECTED"); echo(">San Cristobal-Nevis (St. Kitts)</option>\n");
		echo("<option value='San Marino'"); if($pais == "San Marino") echo("SELECTED"); echo(">San Marino</option>\n");
		echo("<option value='San Vincente y las Granadinas'"); if($pais == "San Vincente y las Granadinas") echo("SELECTED"); echo(">San Vincente y las Granadinas</option>\n");
		echo("<option value='Santa Helena'"); if($pais == "Santa Helena") echo("SELECTED"); echo(">Santa Helena</option>\n");
		echo("<option value='Santa Lucia'"); if($pais == "Santa Lucia") echo("SELECTED"); echo(">Santa Lucia</option>\n");
		echo("<option value='Santa Sede (Vaticano)'"); if($pais == "Santa Sede (Vaticano)") echo("SELECTED"); echo(">Santa Sede (Vaticano)</option>\n");
		echo("<option value='Sao Tome & Principe'"); if($pais == "Sao Tome & Principe") echo("SELECTED"); echo(">Sao Tome & Principe</option>\n");
		echo("<option value='Senegal'"); if($pais == "Senegal") echo("SELECTED"); echo(">Senegal</option>\n");
		echo("<option value='Seychelles'"); if($pais == "Seychelles") echo("SELECTED"); echo(">Seychelles</option>\n");
		echo("<option value='Sierra Leona'"); if($pais == "Sierra Leona") echo("SELECTED"); echo(">Sierra Leona</option>\n");
		echo("<option value='Singapur'"); if($pais == "Singapur") echo("SELECTED"); echo(">Singapur</option>\n");
		echo("<option value='Siria'"); if($pais == "Siria") echo("SELECTED"); echo(">Siria</option>\n");
		echo("<option value='Somalia'"); if($pais == "Somalia") echo("SELECTED"); echo(">Somalia</option>\n");
		echo("<option value='Sri Lanka (Ceilan)'"); if($pais == "Sri Lanka (Ceilan)") echo("SELECTED"); echo(">Sri Lanka (Ceilan)</option>\n");
		echo("<option value='Sudan'"); if($pais == "Sudan") echo("SELECTED"); echo(">Sudan</option>\n");
		echo("<option value='Suecia'"); if($pais == "Suecia") echo("SELECTED"); echo(">Suecia</option>\n");
		echo("<option value='Suiza'"); if($pais == "Suiza") echo("SELECTED"); echo(">Suiza</option>\n");
		echo("<option value='Sur Africa'"); if($pais == "Sur Africa") echo("SELECTED"); echo(">Sur Africa</option>\n");
		echo("<option value='Surinam'"); if($pais == "Surinam") echo("SELECTED"); echo(">Surinam</option>\n");
		echo("<option value='Swaziland'"); if($pais == "Swaziland") echo("SELECTED"); echo(">Swaziland</option>\n");
		echo("<option value='Tailandia'"); if($pais == "Tailandia") echo("SELECTED"); echo(">Tailandia</option>\n");
		echo("<option value='Taiwan'"); if($pais == "Taiwan") echo("SELECTED"); echo(">Taiwan</option>\n");
		echo("<option value='Tajikistan'"); if($pais == "Tajikistan") echo("SELECTED"); echo(">Tajikistan</option>\n");
		echo("<option value='Tanzania'"); if($pais == "Tanzania") echo("SELECTED"); echo(">Tanzania</option>\n");
		echo("<option value='Timor Oriental'"); if($pais == "Timor Oriental") echo("SELECTED"); echo(">Timor Oriental</option>\n");
		echo("<option value='Togo'"); if($pais == "Togo") echo("SELECTED"); echo(">Togo</option>\n");
		echo("<option value='Tokelau'"); if($pais == "Tokelau") echo("SELECTED"); echo(">Tokelau</option>\n");
		echo("<option value='Tonga'"); if($pais == "Tonga") echo("SELECTED"); echo(">Tonga</option>\n");
		echo("<option value='Trinidad & Tobago'"); if($pais == "Trinidad & Tobago") echo("SELECTED"); echo(">Trinidad & Tobago</option>\n");
		echo("<option value='Tunisia'"); if($pais == "Tunisia") echo("SELECTED"); echo(">Tunisia</option>\n");
		echo("<option value='Turkmenistan'"); if($pais == "Turkmenistan") echo("SELECTED"); echo(">Turkmenistan</option>\n");
		echo("<option value='Turquia'"); if($pais == "Turquia") echo("SELECTED"); echo(">Turquia</option>\n");
		echo("<option value='Ucrania'"); if($pais == "Ucrania") echo("SELECTED"); echo(">Ucrania</option>\n");
		echo("<option value='Uganda'"); if($pais == "Uganda") echo("SELECTED"); echo(">Uganda</option>\n");
		echo("<option value='Union Europea'"); if($pais == "Union Europea") echo("SELECTED"); echo(">Union Europea</option>\n");
		echo("<option value='Uzbekistan'"); if($pais == "Uzbekistan") echo("SELECTED"); echo(">Uzbekistan</option>\n");
		echo("<option value='Vanuatu'"); if($pais == "Vanuatu") echo("SELECTED"); echo(">Vanuatu</option>\n");
		echo("<option value='Venezuela'"); if($pais == "Venezuela") echo("SELECTED"); echo(">Venezuela</option>\n");
		echo("<option value='Vietnam'"); if($pais == "Vietnam") echo("SELECTED"); echo(">Vietnam</option>\n");
		echo("<option value='Yemen'"); if($pais == "Yemen") echo("SELECTED"); echo(">Yemen</option>\n");
		echo("<option value='Yugoslavia'"); if($pais == "Yugoslavia") echo("SELECTED"); echo(">Yugoslavia</option>\n");
		echo("<option value='Zambia'"); if($pais == "Zambia") echo("SELECTED"); echo(">Zambia</option>\n");
		echo("<option value='Zimbabwe'"); if($pais == "Zimbabwe") echo("SELECTED"); echo(">Zimbabwe</option>\n");
	echo("</select>");
}
?>