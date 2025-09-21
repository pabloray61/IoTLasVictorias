<?
include ("manager/conn.php");

$nombre = $_POST['nombre'] == "" ? "" : $_POST['nombre'];
$pais = $_POST['pais'] == "" ? "" : $_POST['pais'];
$telefono = $_POST['telefono'] == "" ? "" : $_POST['telefono'];
$email = $_POST['email'] == "" ? "bonadeo@fiberte.com.ar" : $_POST['email'];
$como = $_POST['como'] == "" ? "" : $_POST['como'];
$mensaje = $_POST['mensaje'] == "" ? "" : $_POST['mensaje'];
$precio_total = $_POST['precio_total'] == "" ? "" : $_POST['precio_total'];
$cant_items = $_POST['cant_items'];


$html = "<p><b>Datos del Cliente:</b></p>";
$html.= "<table width='500' border='0'>";
$html.= "	<tr>";
$html.= "		<td width='100'><b>Nombre:</b></td>";
$html.= "		<td width='250'> $nombre </td>";
$html.= "		<td width='50'><b>Pais:</b></td>";
$html.= "		<td width='100'> $pais </td>";
$html.= "	</tr>";
$html.= "	<tr>";
$html.= "		<td><b>Telefono:</b></td>";
$html.= "		<td> $telefono </td>";
$html.= "		<td>&nbsp;</td>";
$html.= "		<td>&nbsp;</td>";
$html.= "	</tr>";
$html.= "	<tr>";
$html.= "		<td><b>E-Mail</b></td>";
$html.= "		<td colspan='2'> $email </td>";
$html.= "		<td>&nbsp;</td>";
$html.= "	</tr>";
$html.= "	<tr>";
$html.= "		<td align='left' valign='top'><b>Comentario</b></td>";
$html.= "		<td colspan='3'> $mensaje </td>";
$html.= "	</tr>";
$html.= "</table>";
$html.= "<p><b>Datos de la compra:</b></p>";
$html.= "<table width='600' border='0'>";
$html.= "  <tr>";
$html.= "    <td width='70'><b>C&oacute;digo</b></td>";
$html.= "    <td width='340'><b>Descripci&oacute;n</b></td>";
$html.= "    <td width='60' align='center'><b>Cant.</b></td>";
$html.= "    <td width='60' align='center'><b>Precio</b></td>";
$html.= "    <td width='70' align='center'><b>Sub Total</b></td>";
$html.= "  </tr>";
  
for ( $i=0; $i<$cant_items; $i++){ 
	$html.= "  <tr>";
	$html.= "    <td width='70'><div align='left'>".$_POST['cod' . $i]."</div></td>";
	$html.= "    <td width='340'><div align='left'>". $_POST['desc' . $i]. "</div></td>";
	$html.= "    <td width='60'><div align='center'>".$_POST['cant' . $i] ."</div></td>";
	$html.= "    <td width='60'><div align='center'>". $_POST['precio' . $i] ."</div></td>";
	$html.= "    <td width='70'><div align='center'>". $_POST['subtotal' . $i]. "</div></td>";
	$html.= "  </tr>";
} 
  
$html.= "  <tr>";
$html.= "    <td colspan='4'><div align='right'><b>Total:</b> </div></td>";
$html.= "    <td><div align='center'>$precio_total</div></td>";
$html.= "  </tr>";
$html.= "</table>";

$dbHTML = str_replace ("'", "|", $html); 
//Saco el dia bara guardarlo en la db
$dia = getDate();
$dbDia = $dia['year'] . "-" . $dia['mon'] ."-" .$dia['mday'];


// *** Guarda el pedido en la base de datos:
//query("INSERT INTO pedidos (id_pedido, fecha, nombre, apellido, telefono, email, mensaje, html) VALUES (NULL, '$dbDia', '$nombre', '$apellido', '$telefono', '$email', '$mensaje', '$dbHTML')");
//closeConn();

// *** Manda un mail 
$to = "info@acordessa.com";
$subject = "|| ACORDESSA.COM => ORDEN DE COMPRA ||";
$sender = $_POST["email"];
$header = "From: $sender\nReply-To: $sender\nX-Mailer: PHP/".phpversion() ."\nContent-Type: text/html; charset=iso-8859-1\n";

//$r = mail ("fpaz@itcstudios.com", $subject, $html, $header);
$r = mail ($to, $subject, $html, $header);
$status = $r ? "si":"no";
echo "status=$status&";

// --------- DEBUG ----------------

$file = "tmp_html.html";
if ( file_exists ($file) ) unlink ($file);
$f = fopen ($file, 'a');
fwrite($f, $html); 
fclose($f);
?>
