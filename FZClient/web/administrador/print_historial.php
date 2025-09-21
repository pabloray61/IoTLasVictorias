<?
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

$id_cliente= $_REQUEST['id_cliente'];
require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}
	
	
if($_REQUEST['Filtrar'] == "Filtrar"){
	if($_REQUEST['d_mes'] != "" and $_REQUEST['d_ano'] != ""){
		$filtro=" AND fecha >= '"  . $_REQUEST['d_ano'] . "-". $_REQUEST['d_mes'] . "-01'    ";
	}
	if($_REQUEST['h_mes'] != "" and $_REQUEST['h_ano'] != ""){		
		$filtro.=" AND (fecha <= '"  . $_REQUEST['h_ano'] . "-". $_REQUEST['h_mes'] . "-01' OR (year(fecha) = " . $_REQUEST['h_ano'] . " AND month(fecha) = ". $_REQUEST['h_mes'] ." )) ";
	}
//echo $filtro;

}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 18px}
-->
</style>
</head>

<body >
<?
$sql="SELECT * from clientes c
	INNER JOIN vendedores v ON c.id_vendedor = v.id_vendedor
		where c.id_cliente=" . $_REQUEST['id_cliente'];
$q=query($sql);
$rs=mysql_fetch_array($q);

?>

<table width="800" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="200"><img src="images/logo.jpg" ></td>
		<td width="400">
			<table width="100%" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" class="data">Agente</td>
					<td width="70%" class="titulo"><?=$rs['nombre']?></td>
				</tr>
				<tr>
					<td class="data">Telefono</td>
					<td class="encabezado"><?=$rs['telefono']?></td>
				</tr>
				<tr>
					<td class="data">Celular</td>
					<td class="encabezado"><?=$rs['celular']?></td>
				</tr>
				<tr>
					<td class="data">Mail</td>
					<td class="encabezado"><?=$rs['mail']?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	    <td colspan="2" bgcolor="#FFFFFF">
			<table width="100%" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td valign="top" width="720">
						<?
						$sql="SELECT * FROM clientes WHERE id_cliente=$id_cliente";
						$q=query($sql);
						$rs=mysql_fetch_array($q);
						?>
						<table width="100%" cellspacing="2" cellpadding="2" align="center">
                        	<tr height="50" valign="middle"><td colspan="4" class="style1" align="left"><b>Historial Cliente</b></td></tr>
							<tr class="data">
								<td width="15%">Nombre</td>
								<td width="40%" class="encabezado"><?=$rs['nombre']." ".$rs['apellido']?></td>
								<td width="15%">CUIT/DNI</td>
								<td width="30"><?=$rs['dni']?></td>
							</tr>
							<tr class="data">
								<td>Direccion</td>
								<td><?=$rs['direccion']?></td>
								<td>Telefono</td>
								<td><?=$rs['telefono']?></td>
							</tr>
							<tr class="data">
								<td>Mail</td>
								<td><?=$rs['mail']?></td>
								<td>Celular</td>
								<td><?=$rs['celular']?></td>
							</tr>
							<tr class="data">
								<td>Localidad</td>
								<td><?=$rs['localidad']?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr class="data" height="10"><td colspan="4">&nbsp;</td></tr>
							<?
                            $sql2="SELECT saldo,
                            SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda
                            FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id_cliente
                            WHERE c.id_cliente= $id_cliente
                            GROUP BY c.id_cliente";
                            $q2 = query($sql2);
                            $rs2 = mysql_fetch_array($q2);
                            ?>
  							<tr height="30"><td colspan="4" class="encabezado"><b>Pendiente de pago: $ <?= number_format($rs2['deuda'], 2, ',','.')?></b></td></tr>
                            <tr class="data" height="10"><td colspan="4">&nbsp;</td></tr>
						</table>
						<table width="100%" align="center" cellpadding="2" cellspacing="2">
							<tr class="encabezado">
								<td width="25%"><strong>Fecha vta</strong></td>
								<td width="25%"><strong>Fecha pago</strong> </td>
								<td width="10%" align="right"><strong>Cajas</strong></td>
								<td width="10%" align="right"><strong>Bot</strong></td>
								<td width="10%" align="right"><strong>Bonif</strong></td>
								<td width="10%" align="right"><div align="right"><strong>Monto</strong></div></td>
								<td width="10%"></td>
							</tr>
							<?
							$sql="SELECT id_venta, fecha, clientes.id_cliente, 
								(select max(fecha) from pagos p where p.id_venta = v.id_venta) as fpago, 
								(select sum(monto) from pagos p where p.id_venta = v.id_venta) as pago, 
								round(((SELECT sum(cant*precio) from ventas_detalle vd where vd.id_venta = v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 as monto, 
								(SELECT sum(cant) FROM ventas_detalle vd 
									INNER JOIN productos p ON p.id_producto = vd.id_producto 
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE vd.id_venta = v.id_venta AND pp.presentacion = 'caja') as cajas, 
								(SELECT sum(cant) FROM ventas_detalle vd 
									INNER JOIN productos p ON p.id_producto=vd.id_producto
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
									WHERE vd.id_venta=v.id_venta AND pp.presentacion != 'caja' AND pp.presentacion != 'botella') as items, 
								(SELECT sum(cant) FROM ventas_detalle vd 
									INNER JOIN productos p ON p.id_producto=vd.id_producto 
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE vd.id_venta=v.id_venta AND pp.presentacion = 'botella') as botellas, v.id_vendedor 
								FROM ventas v 
								INNER JOIN clientes on clientes.id_cliente = v.id_cliente 
								WHERE v.id_cliente=". $id_cliente . " ". $filtro."  
								ORDER BY fecha DESC";

							$q = query($sql);
							
							$cajas=0;
							$bot=0;
							$bonif=0;
							$monto=0;
							while($rs=mysql_fetch_array($q)){
							$cajas+=$rs['cajas'];
							$bot+= $rs['botellas'];
							$bonif+=$rs['items'];
							$monto+=$rs['monto'];
							
							?>  
							<form action="bo_venta.php" method="post">
								<tr class="data">
									<td><? formatoFecha($rs['fecha'])?></td>
									<td>
										<? 
										if($rs['pago'] == $rs['monto']){
											echo formatoFecha($rs['fpago']);
										}elseif ($rs['monto']==0){
											echo $rs['visitas_tipo'];
										}else{
											echo "$ " . $rs['pago'];
										}?>
									</td>
									<td align="right"><?=$rs['cajas']?></td>
									<td align="right"><?=$rs['botellas']?></td>
									<td align="right"><?=$rs['items']?></td>
									<td align="right">$<?= number_format($rs['monto'], 2, ",", ".")?></td>
									<td>
										<input type="hidden" name="id_cliente" value="<?=$rs['id_cliente']?>">
										<input type="hidden" name="id_venta" value="<?=$rs['id_venta']?>">
									</td>
								</tr>
							</form>
							<? }?>
							<tr class="data">
								<td>&nbsp;</td>
								<td class="encabezado">Totales</td>
								<td align="right" class="encabezado"><?=$cajas?></td>
								<td align="right" class="encabezado"><?=$bot?></td>
								<td align="right" class="encabezado"><?=$bonif?></td>
								<td align="right" class="encabezado">$<?=number_format($monto,2,',','.')?></td>
								<td class="encabezado">&nbsp;</td>
							</tr>
						</table>
						<br>
						<table align="center" width="500" cellspacing="0" cellpadding="0">
						  <tr>
							<td>
							<form method="post" action="abm_ventas_cliente.php">
							  <div align="right">
								<input type="hidden" name="d_mes" value="<?=$_REQUEST['d_mes']?>">
								<input type="hidden" name="h_mes" value="<?=$_REQUEST['h_mes']?>">
								<input type="hidden" name="d_ano" value="<?=$_REQUEST['d_ano']?>">
								<input type="hidden" name="h_ano" value="<?=$_REQUEST['h_ano']?>">
								<input type="hidden" name="id_cliente" value="<?=$_REQUEST['id_cliente']?>">
						
								<input type="submit" value="Volver">
								</div>
							</form>
						  </tr>
						</table>
					<p>&nbsp;</p>
					<br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>

</body>
</html>
