<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$id_cliente = $_REQUEST['id_cliente'];
if($_REQUEST['cancelar']=="Cancelar"){
	$id_cliente="";
}

// IMPRIMIR O INSERTAR LAS CONSULTAS -------------------

$insertar = "ok";		//	INSERT
//$imprimir = "ok";		//	PRINT

// ------------------------------------------------------

if($_REQUEST['grabar'] == "Aceptar"){

//-- 1ºelimina los pagos seleccionados

	for($k = 0; $k <= $_REQUEST['hastak']; $k++){
		if($_REQUEST['eliminar'. $k] > 0){
			$sql = "DELETE FROM pagos WHERE id_pago=" . $_REQUEST['eliminar' . $k];
			if($imprimir == "ok") echo("$sql<br>");
			if($insertar == "ok") query($sql);
			$id_cliente = $_REQUEST['id_cliente'];
		}
	}


//-- 2º carga los pagos
	//al monto ingresado se le suma el saldo a favor del cliente
	
	$monto = round($_REQUEST['monto'] * 100) / 100 + round($_REQUEST['saldo'] * 100) / 100;
	$id_vendedor = $_SESSION['id_vendedor'];
	$id_cliente=$_REQUEST['id_cliente'];
	$fecha = rotarFecha($_REQUEST['fecha']);
	
	for ($j = 0; $j <= $_REQUEST['hasta']; $j++){
		// echo($_REQUEST['ch'.$j]." = ".$monto."<br>");
		if($_REQUEST['ch'.$j] != "" && $monto > 0){
			$falta = round($_REQUEST['falta' . $j]*100)/100;
			if ($falta <= $monto){
				//si el monto excede lo que falta para cancelar, inputa lo que falta y se lo resta al monto anterior para cargarlo en las otras ventas.
				//Tambien se cambia el estado de la venta a 1 (pagada por el cliente)
//				echo $_REQUEST['id_venta' . $j];
					
				$sql="INSERT INTO pagos (id_pago, id_venta, id_vendedor, id_cliente, fecha, monto, id_modo_pago, concepto) VALUES
				(NULL, ". $_REQUEST['id_venta'. $j] ." , $id_vendedor, '$id_cliente' , '$fecha',
				 " . $falta .", ". $_REQUEST['id_modo_pago'] .", '". $_REQUEST['concepto'] . "')";

				if($imprimir == "ok") echo $sql . "<br>";
				if($insertar == "ok") query($sql);
				if($insertar == "ok") query("UPDATE ventas SET estado=1 WHERE id_venta= ".$_REQUEST['id_venta'.$j]);
			
				$monto = $monto - $falta;
			}else{
				//carga el monto y el monto queda en 0 => sale del loop
				$sql="INSERT INTO pagos (id_pago, id_venta, id_vendedor, id_cliente, fecha, monto, id_modo_pago, concepto) VALUES
				(NULL, ". $_REQUEST['id_venta'. $j] ." , 'id_vendedor', '$id_cliente' , '$fecha',
				 " . $monto .", ". $_REQUEST['id_modo_pago'] . ", '". $_REQUEST['concepto'] ."')";

				if($imprimir == "ok") echo $sql . "<br>";
				if($insertar == "ok") query($sql);
				//carga el pago y termina el loop
				$monto=0;
			}
		}
	}
	
	//despues del for el monto que queda va al saldo a favor del cliente.
	
	if($insertar == "ok") query("UPDATE clientes SET saldo= $monto WHERE id_cliente= $id_cliente");

}
?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected BrANDs .::.</title>


<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet" type="text/css" href="includes/tcal.css" />
<script type="text/javascript" src="includes/tcal.js"></script> 
<!-- InstanceEndEditable -->

<link rel="stylesheet" href="includes/menu.css" type="text/css">
<script type="text/javascript" src="includes/jquery143.js"></script>
<script type='text/javascript' src='includes/menu.js'></script>

<script type="text/javascript" src="js/stmenu.js"></script>
<script type="text/javascript">
<!--
window.onerror=function(m,u,l)
{
	window.status = "Java Script Error: "+m;
	return true;
}
//-->
</script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>


<? 
	if($_SESSION['admin'] == "ok") $admin = 1;
	
	$vendedor = $_SESSION['nombre_vend'];
	$exp = explode(",", $vendedor);
	if($exp[1] == ""){
		$n = $exp[0];
	}else{
		$n = $exp[1];
	}
	
	include("_menu.php");
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="121" valign="top">
				<table width="100%" height="121" border="0" cellpadding="0" cellspacing="0" id="HEADER">
					<tr>
						<td width="343" valign="top" class="header-left3">
						  <img src="images/headers/mm-ap.jpg" width="341" height="80">
						  <p class="textToolBar">&nbsp;&nbsp;&nbsp;&nbsp;Bienvenido <?= $n?></p>
						</td>
						<td class="expand3">&nbsp;</td>
						<td width="358" valign="top" class="header-right3">
							<p>&nbsp;<br><br><br></p><p>&nbsp;</p>
					    	<p align="right"><a href="logout.php" class="textToolBarLink">Log out</a>&nbsp;&nbsp;&nbsp;</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		  <td height="15"><div align="right"></div></td>
		</tr>	
		<tr valign="top">
			<td height="5">
			  <!-- InstanceBeginEditable name="SubMenu" -->
			
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td height="30">&nbsp;</td></tr>
		<tr>
			<td valign="top" height="30">
			  <!-- InstanceBeginEditable name="body" -->

<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr height="30">
		<td colspan="4">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="encabezado">DEUDA PENDIENTE / COBRANZAS</td>
					<td align="right"><a href="imp_deuda.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir Deuda</a></td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr height="40">
		<td class="t" width="3%">&nbsp;</td>
		<td class="t" width="94%" colspan="2">Vendedor <?=$_SESSION['nombre_vend'] ." (".date(d."-".m."-".y).")"?></td>
		<td class="t" width="3%">&nbsp;</td>
	</tr>
	<tr height="20"><td colspan="4" class="c1"></td></tr>
	<tr height="40" valign="middle">
		<td class="c1">&nbsp;</td>
		<td class="c1" colspan="2">
			<form name="formu" method="post" action="<?=$_SERVER['PHP_SELF']?>">
				Elegir un cliente &nbsp;&nbsp;
				<select name="id_cliente" onChange="formu.submit();">
				  <option>Seleccione un cliente</option>
				  <?
					  if($_SESSION['admin']!="ok") $sql="SELECT * FROM clientes WHERE id_vendedor = ".$_SESSION['id_vendedor'] ." ORDER BY apellido, nombre";
					  if($_SESSION['admin']=="ok") $sql="SELECT * FROM clientes ORDER BY apellido, nombre";//ahora trae todos los clientes
					  $q=query($sql);
					  while($rs=mysql_fetch_array($q)){
						  if($rs['nombre'] != "") $cliente = $rs['apellido'].", ".$rs['nombre'];
						  if($rs['nombre'] == "") $cliente = $rs['apellido'];
					  ?>
						<option value="<?=$rs['id_cliente']?>" <?  if($id_cliente == $rs['id_cliente']){ echo "SELECTED";} ?>><?= $cliente?></option>
					  <? }?>
				</select>
			</form>
		</td>
		<td class="c1">&nbsp;</td>
	</tr>	
	<tr height="20"><td colspan="4" class="c2"></td></tr>
	<tr height="40">
		<td class="c2">&nbsp;</td>
		<td class="c2" colspan="2">
			<?
			if(!$id_cliente > 0){
			?>
				<table align="center" width="98%"  cellspacing="2" cellpadding="2">
				  <tr height="30">
					<td width="30%" class="encabezado">Cliente</td>
					<td width="16%" class="encabezado" align="right">Deuda</td>
					<td width="15%" class="encabezado" align="right">&lt;30 d</td>
					<td width="13%" class="encabezado" align="right">30 - 60 d</td>
					<td width="15%" class="encabezado" align="right">&gt;60 d </td>
					<td width="11%" class="encabezado" align="right">&nbsp;</td>
				  </tr>
				<?
				//deuda vendedor
				$sql="SELECT c.id_cliente, c.nombre , c.apellido,
				(SELECT sum(vd.cant) FROM ventas_detalle vd inner join productos p on p.id_producto=vd.id_producto  where vd.id_venta=v.id_venta AND regalo != 1 AND 
				 case WHEN  (SELECT sum(monto) FROM pagos where id_venta=v.id_venta AND regalo != 1) > 0 then (SELECT sum(monto) FROM pagos where id_venta=v.id_venta) else 0 end < round(( (SELECT sum(cant*precio) FROM ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1)*(1-dto_porc/100) - dto_fijo)*100)/100) as cajas,
				
				SUM(- case WHEN  (SELECT sum(monto) FROM pagos where id_venta=v.id_venta)>0 THEN (SELECT sum(monto) FROM pagos where id_venta=v.id_venta) ELSE 0 end + round(((SELECT sum(cant*precio) FROM ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda ,
				SUM(- case WHEN  (SELECT sum(monto) FROM pagos where id_venta=v.id_venta)>0 THEN (SELECT sum(monto) FROM pagos where id_venta=v.id_venta) ELSE 0 end + round(((SELECT sum(cant*precio) FROM ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1 AND v.fecha >= curdate() - interval 30 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 30dias,
				SUM(- case WHEN  (SELECT sum(monto) FROM pagos where id_venta=v.id_venta)>0 THEN (SELECT sum(monto) FROM pagos where id_venta=v.id_venta) ELSE 0 end + round(((SELECT sum(cant*precio) FROM ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1 AND v.fecha < curdate() - interval 30 day AND v.fecha >= curdate()-interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 3060dias ,
				SUM(- case WHEN  (SELECT sum(monto) FROM pagos where id_venta=v.id_venta)>0 THEN (SELECT sum(monto) FROM pagos where id_venta=v.id_venta) ELSE 0 end + round(((SELECT sum(cant*precio) FROM ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1 AND v.fecha < curdate() -  interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 60dias 
				
				FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id_cliente
				WHERE - case WHEN  (SELECT sum(monto) FROM pagos where id_venta=v.id_venta)>0 THEN (SELECT sum(monto) FROM pagos where id_venta=v.id_venta) ELSE 0 end + round(((SELECT sum(cant*precio) FROM ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1)*(1-dto_porc/100) - dto_fijo)*100)/100 >0 AND v.id_vendedor=".$_SESSION['id_vendedor']." AND ISNULL(incobrable)
				GROUP BY c.id_cliente, c.nombre
				ORDER BY nombre asc";
				
				//echo($sql."<br>");
				$q = query($sql);
				
				$deuda_tot=0;
				$deuda30=0;
				$deuda3060=0;
				$deuda60=0;
				
				while($rs=mysql_fetch_array($q)){
					$deuda_tot += $rs['deuda'];
					$deuda30 += $rs['30dias'];
					$deuda3060 += $rs['3060dias'];
					$deuda60 += $rs['60dias'];
					
					$n = $rs['nombre'];
					$a = $rs['apellido'];
					if($n != "") $a = $a.", ".$n;
					?> 
						<form method="post" action="<?=$_SERVER['PHP_SELF']?>"> 
						  <tr class="data">
							<td><?=$a?></td>
							<td><div align="right">$<?=number_format($rs['deuda'],0,',','.')?></div></td>
							<td><div align="right">$<?=number_format($rs['30dias'],0,',','.')?></div></td>
							<td><div align="right">$<?=number_format($rs['3060dias'],0,',','.')?></div></td>
							<td><div align="right">$<?=number_format($rs['60dias'],0,',','.')?></div></td>
							<td align="right"><input type="submit" value="Ver"><input type="hidden" name="id_cliente" value="<?=$rs['id_cliente']?>">
							</td>
						  </tr>
						  </form>
				<? }?>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
			  <tr>
				<td class="encabezado">Total</td>
				<td align="right" class="encabezado">$<?=number_format($deuda_tot,0,',','.')?></td>
				<td align="right" class="encabezado">$<?=number_format($deuda30,0,',','.')?></td>
				<td align="right" class="encabezado">$<?=number_format($deuda3060,0,',','.')?></td>
				<td align="right" class="encabezado">$<?=number_format($deuda60,0,',','.')?></td>
				<td>&nbsp;</td>
			  </tr>
			</table>
			<p align="center" class="titulo">&nbsp; </p>
			<p align="center" class="titulo">&nbsp;</p>
		<? }?>
		
		
		<?
		if ($id_cliente > 0){
		
				$sql="SELECT saldo,
				SUM(- case WHEN  (SELECT sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (SELECT sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((SELECT sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda
				FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id_cliente
				where c.id_cliente=$id_cliente AND ISNULL(incobrable)
				 GROUP BY c.id_cliente";
				$q=query($sql);
				$rs=mysql_fetch_array($q);
				$saldo=$rs['saldo'];
				
				?>
				<p class="encabezado" align="center">Saldo a favor del cliente $<?= number_format($saldo, 2, ',', '.')?></p>
				<p class="encabezado" align="center">Saldo deudor del cliente $<?= number_format($rs['deuda'], 2, ',', '.')?></p>
				
				<br>
		</td>
		<td class="c2">&nbsp;</td>
	</tr>	
	<tr height="40"><td colspan="4" class="t" align="center"> Cargar pago - <?=$_SESSION['nombre_vend'];?> </td></tr>

<form name="formu2" action="<?=$_SERVER['PHP_SELF']?>" method="post"  onSubmit="return validar();"> 
	<tr height="40">
		<td class="c1">&nbsp;</td>
		<td class="c1" colspan="2">
            <table align="center" width="100%"  cellspacing="4" cellpadding="0" border="0">
                <tr height="10"><td colspan="4"></td></tr>
                <tr>
                    <td width="20%" class="data">Fecha</td>
                    <td width="25%" class="data">Modo de Pago</td>
                    <td width="10%" class="data">Monto</td>
                    <td width="45%" class="data">Comprobante / Nro Cheque:</td>
                </tr>
                <tr valign="bottom">
                    <td><? agregarFecha("fecha", rotarFecha(hoy()))?></td>
                    <td><select name="id_modo_pago">
                    <?
                    $sql3="SELECT * from modo_pago";
                    $q3=query($sql3);
                    while($rs3=mysql_fetch_array($q3)){
                        ?><option value="<?=$rs3['id_modo_pago']?>"><?=$rs3['modo']?></option><?
                    }?>
                    </select>
                    </td>
                    <td class="data"><input name="monto" type="text" size="5"></td>
                    <td><input name="concepto" type="text" size="60"></td>
                    <input type="hidden" name="id_cliente" value="<?=$id_cliente?>">
                </tr>
                <tr height="10"><td colspan="4"></td></tr>
            </table>
		</td>
		<td class="c1">&nbsp;</td>
	</tr>	
	<tr height="40"><td colspan="4" class="t" align="center">Listado de ventas sin rendir </td></tr>
	<tr height="40">
		<td class="c2">&nbsp;</td>
		<td class="c2" colspan="2">
				
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	            <tr height="10"><td colspan="6"></td></tr>
                <tr class="encabezado">
                    <td width="9%" align="center">Fecha</td>
                    <td width="12%" align="center"># Ref</td>
                    <td width="47%">Detalle</td>
                    <td width="12%">Monto</td>
                    <td width="12%">a cancelar </td>
                    <td width="8%" align="center">asignar</td>
                </tr>
				<tr height="1"><td bgcolor="#333333" colspan="6"></td></tr>
                <tr height="10"><td colspan="6"></td></tr>
				<?
				//  * (IF(v.factura = 1, 1.21, 1)) 
				$k=0; // k lo usopara contar cada pago
				$sql="SELECT id_venta, fecha, clientes.id_cliente, nombre, 
					round(((select sum(cant * precio) from ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1) * (1-dto_porc/100) - dto_fijo)*100)/100 as monto, 
					(select sum(cant) from ventas_detalle vd 
						inner join productos p ON p.id_producto=vd.id_producto 
						inner join p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
						where pp.presentacion = 'caja' AND vd.id_venta=v.id_venta) as cajas, 
					(round(((select sum(cant * precio) from ventas_detalle vd 
						where vd.id_venta=v.id_venta AND regalo != 1) * (1-dto_porc/100) - dto_fijo)*100)/100 - 
						(SELECT sum(monto) from pagos WHERE id_venta=v.id_venta)) as falta, 
					v.id_vendedor,
					(SELECT sum(monto) from pagos WHERE id_venta=v.id_venta) as pago
					FROM ventas v 
					inner join clientes on clientes.id_cliente=v.id_cliente
					WHERE clientes.id_cliente=$id_cliente AND v.estado<=2 AND ISNULL(incobrable)
					AND (select sum(cant * precio) from ventas_detalle vd 
					where vd.id_venta=v.id_venta AND regalo != 1) > 0  ORDER BY fecha DESC";
				
				//echo($sql."<br>");
				
				$q = query($sql);
				
				$i=0;
				while($rs=mysql_fetch_array($q)){
				//$falta=$rs['falta'];
					if(is_null($rs['falta'])){
						$falta = $rs['monto'];
					}else{
						$falta = $rs['falta'];
					}
					// Le agrego ceros al nro de NP
						$id_v = $rs['id_venta'];
						$largo = strlen($id_v);
						$ceros = 8 - $largo;
						$num = "";
						for($ic = 0; $ic < $ceros; $ic++){
							$num = $num."0"; 
						}
						$nro_NV = $num."".$id_v;
					// -----------------
					?>  
					 
					<tr height="25" class="data" bgcolor="#808080">
						<td align="center"><?= rotarFecha($rs['fecha'])?></td>
                        <td align="center"><?= $nro_NV?></td>
						<td><?=$rs['cajas']?> cajas</td>
						<td><strong>$ <?= number_format($rs['monto'], 2, ',','.')?></strong></td>
						<td><strong>$ <?= number_format($falta, 2, ',','.')?></strong></td>
						<td align="center"><? if($falta != 0){?><input type="checkbox" name="ch<?=$i?>" value="1"><? }?></td>
						<input type="hidden" name="id_venta<?=$i?>" value="<?=$rs['id_venta']?>">
						<input type="hidden" name="falta<?=$i?>" value="<?=$falta?>">
					</tr>
					<?
                    $sql2="SELECT * FROM pagos INNER JOIN modo_pago mp ON mp.id_modo_pago=pagos.id_modo_pago WHERE id_venta=" . $rs['id_venta'];
                    $q2=query($sql2);
                    
                    while($rs2 = mysql_fetch_array($q2)){
						$c = $rs2['concepto'];
						if($c != "") $c = "(".$c.")";
                    	$detalle = $rs2['modo']." ".$c;
						// Le agrego ceros al nro de NP
							$id_p = $rs2['id_pago'];
							$largo = strlen($id_p);
							$ceros = 8 - $largo;
							$num = "";
							for($ic = 0; $ic < $ceros; $ic++){
								$num = $num."0"; 
							}
							$nro_NP = $num."".$id_p;
						// -----------------
						?>
						<tr height="25" class="data">
                            <td align="center"><?= rotarFecha($rs2['fecha'])?></td>
                            <td align="center"><?= $nro_NP?></td>
                            <td><?= $detalle?></td>
                            <td>$ <?= number_format($rs2['monto'], 2, ',','.')?></td>
                            <td><input type="checkbox" name="eliminar<?=$k?>" value="<?=$rs2['id_pago']?>" onClick="return confirmar();">eliminar</td>
							<td>&nbsp;</td>
       						<input type="hidden" name="id_pago" value="<?=$rs2['id_pago']?>">
						</tr>
						<?
        	            $k++;
                    }
                    ?>
					<input type="hidden" name="saldo" value="<?=$saldo?>">
                    <input type="hidden" name="saldobtn" value="UsarSaldo">
					<tr height="10"><td colspan="6"></td></tr>
                    <tr height="1"><td bgcolor="#333333" colspan="6"></td></tr>
                    <tr height="10"><td colspan="6"></td></tr>
				    <?
					$i++;
				}
				?>
				</table>
				<p align="center">
				<input type="hidden" name="hasta" value="<?= $i-1?>">
				<input type="hidden" name="hastak" value="<?= $k-1?>">
				<input type="submit" name="cancelar" value="Cancelar">
				<input type="submit" name="grabar" value="Aceptar">
				</p>
                <br>
				<?
				} // end if id_cliente?>
		</td>
		<td class="c2">&nbsp;</td>
	</tr>	
</form>
	<tr height="20"><td class="t" colspan="4"></td></tr>
</table>
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td vAlign="bottom"></td>
		</tr>
		<tr><td vAlign="top" height="30"></td></tr>
		<tr>
			<td height="44" align="center" valign="bottom">
				<table class="pie" id="FOOTER" height="44" cellSpacing="0" cellPadding="0" width="100%" border="0">
					<tr>
						<td align="center">© 2009 ACORDES SA - Todos los derechos reservados</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>			


</body>
<!-- InstanceEnd --></html>
