<?
require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="stylesheet" type="text/css">
</head>

<body>

<br>
<table align="center" cellpadding="0" cellspacing="0">
	<tr><td class="titulo" align="center">Cargar Pagos</td></tr>
	<tr><td class="data" align="center"><?= date(d."-".m."-".Y)?></td></tr>
</table>
<br>
<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
  <tr class="encabezado" bgcolor="#CCCCCC" height="25">
  	<td width="3%">&nbsp;</td>    
    <td width="14%">Fecha</td>
	<? if($_SESSION['admin']=="ok"){?>
		<td width="55%">Cliente</td>
		<td width="10%" align="center">Vend.</td>
	<? }else{?>
		<td width="65%">Cliente</td>
	<? }?>
    <td width="15%" align="right"><div align="right">Monto</div></td>
  	<td width="3%">&nbsp;</td>  
  </tr>
<?
if($_SESSION['admin']!="ok"){
	$vend=" WHERE v.id_vendedor=". $_SESSION['id_vendedor'];
}

$sql = "SELECT v.id_venta, v.fecha, c.id_cliente, c.nombre, c.apellido, sigla, v.id_vendedor, dto_porc, dto_fijo, if(p.monto > 0, 1, 0) as pagado FROM ventas v 
		INNER JOIN clientes c on c.id_cliente = v.id_cliente 
		INNER JOIN vendedores s on s.id_vendedor = v.id_vendedor 
		LEFT JOIN pagos p on p.id_venta = v.id_venta
		$vend 
		ORDER BY fecha DESC, nombre";
//echo($sql."<br>");
$q = query($sql);
$reg = 0;
while($rs=mysql_fetch_array($q)){
	$pagado = $rs['pagado'];
	if($pagado != 1){
		$id_venta = $rs['id_venta'];
		$dto_porc = $rs['dto_porc'];
		$dto_fijo = $rs['dto_fijo'];
		$q2 = query("SELECT sum(cant * precio) AS m_p FROM ventas_detalle WHERE id_venta = $id_venta");
		$rs2 = mysql_fetch_array($q2);
		$monto = (($rs2['m_p'] * (1-$dto_porc/100) - $dto_fijo)	*100)/100;
		
		$q5 =  query("SELECT sum(monto) AS monto2 FROM pagos WHERE pagos.id_venta = $id_venta");
		$rs5 = mysql_fetch_array($q5);
		$monto2 = $rs5['monto2'];

		$n = $rs['nombre'];
		$a = $rs['apellido'];
		if($n != "") $a = $a.", ".$n;

		if($monto > $monto2 OR $monto2 == NULL){
		
		  if($monto > 0){
		
			$monto_T += $monto;
			$bg = $flag ? "#EFEFEF":"#ffffff";
			$flag = !$flag;
			$reg ++;
			?>  
			  <form action="bo_venta.php" method="post">
			  <tr class="data" bgcolor="<?= $bg?>" height="20">
			  	<td>&nbsp;</td>
				<td><? formatoFecha($rs['fecha'])?></td>
				<td><?= substr($a, 0, 40)?></td>
				<? 	if($_SESSION['admin']=="ok") echo("<td align='center'>". $rs['sigla'] ."</td>");?>
				<td align="right"><div align="right">$<?= number_format($monto,2,'.',',')?></div></td>
			  	<td>&nbsp;</td>
			  </tr>
			  </form>
			  <?
			}
		  }
	}
}?>
  <tr class="encabezado" bgcolor="#CCCCCC" height="25">
    <td>&nbsp;</td>
  	<td colspan="2"><?= $reg?> Registros</td>
	<? 	if($_SESSION['admin']=="ok") echo("<td width='20' align='center'>&nbsp;</td>");?>
    <td align="right"><div align="right">$<?= number_format($monto_T,2,'.',',')?></div></td>
	<td>&nbsp;</td>
  </tr>
</table>




</body>
</html>
