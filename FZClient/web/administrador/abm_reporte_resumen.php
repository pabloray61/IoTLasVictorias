<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

if($mes == "" && $ano == "") $ano = date("Y");
?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->

<!-- InstanceEndEditable -->

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
<? if($admin == 1){?>		
		<tr height="20">
			<td>
				<table id="MenuGral" width="680" cellSpacing="0" cellPadding="0" align="center" border="0">
					<tr>
						<td width="14%" class="menu" align="center">Agenda</td>
						<td width="14%" class="menu" align="center">Clientes</td>
						<td width="14%" class="menu" align="center">Vendedores</td>
						<td width="14%" class="menu" align="center">Productos</td>
						<td width="14%" class="menu" align="center">Insumos</td>
						<td width="14%" class="menu" align="center">Stock</td>
						<td width="14%" class="menu" align="center">Reportes</td>
						<td width="2%">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>

				<script type="text/javascript">
				<!--
				stm_bm(["menu56b9",820,"","",0,"","",1,0,250,0,200,1,0,0,"","100%",0,0,1,2,"default","hand",""],this);
				stm_bp("p0",[0,4,0,0,20,0,60,0,100,"",-2,"",-2,50,0,0,"#999999","transparent","",3,0,0,"#000000"]);
				stm_ai("p0i0",[2,"","","",-1,-1,0,"abm_agenda.php","_self","","","images/i_agenda.png","images/i_agenda.png",60,60,0,"","",0,0,0,0,2,"#FFFFF7",1,"#DCEDFF",1,"","",3,3,0,0,"#CCCCCC","#000000","#000000","#000000","8pt Verdana","8pt Verdana",0,0],75,0);
				stm_aix("p0i1","p0i0",[2,"","","",-1,-1,0,"abm_clientes.php","_self","","","images/i_clientes.png","images/i_clientes.png"],75,0);
				stm_bp("p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","#FFFFFF","",3,0,0,"#CCCCCC","images/toparrow.gif",9,126,0,"transparent","",3,"",0,0,0,"transparent","",3,"",3,126,0,"transparent","",3,"",0,0,0,"transparent","",3,"","","","",0,0,0,0,0,0,0,0]);
				
				stm_aix("p1i0","p0i0",[0,"ABM Clientes","","",-1,-1,0,"abm_clientes.php","_self","","","images/icono.gif","images/icono.gif",17,16,0,"","",0,0,0,0,1,"#FFFFFF",0,"#D7DCE2",0,"","",0,0],126,0);
				stm_aix("p1i1","p1i0",[0,"ABM Categoria","","",-1,-1,0,"abm_categoria_clientes.php"],126,0);
				stm_aix("p1i2","p1i0",[0,"ABM Tipos","","",-1,-1,0,"abm_tipos_clientes.php"],126,0);
				stm_aix("p1i3","p1i0",[0,"ABM Grupos","","",-1,-1,0,"abm_grupos.php"],126,0);
				stm_aix("p1i4","p1i0",[0,"Historial","","",-1,-1,0,"abm_ventas_cliente.php"],126,0);
				stm_ep();
				stm_aix("p0i2","p0i0",[2,"","","",-1,-1,0,"abm_vendedores.php","_self","","","images/i_vendedores.png","images/i_vendedores.png"],75,0);
				stm_bpx("p2","p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","transparent"]);
				stm_aix("p2i0","p1i0",[0,"ABM Vendedores","","",-1,-1,0,"abm_vendedores.php","_self","","","images/icono.gif","images/icono.gif",17,16,0,"","",0,0,0,0,1,"#FFFFFF",0,"#D7DCE2",0,"","",0,0],150,0);
				stm_aix("p2i1","p2i0",[0,"Agregar Pedido","","",-1,-1,0,"abm_ventas.php"],150,0);
				stm_aix("p2i2","p2i0",[0,"Agregar Visita","","",-1,-1,0,"abm_visita.php"],150,0);
				stm_aix("p2i3","p2i0",[0,"Agregar Llamado","","",-1,-1,0,"abm_llamado.php"],150,0);
				stm_aix("p2i4","p2i0",[0,"Listar Ventas","","",-1,-1,0,"listar_ventas.php"],150,0);
				stm_aix("p2i5","p2i0",[0,"Listar Seguimientos","","",-1,-1,0,"listar_seguimientos.php"],150,0);
				stm_aix("p2i6","p2i0",[0,"Cargar Pagos","","",-1,-1,0,"abm_pagos.php"],150,0);
				stm_ep();
				stm_aix("p0i3","p0i0",[2,"","","",-1,-1,0,"abm_productos.php","_self","","","images/i_productos.png","images/i_productos.png",60,60,0,"","",0,0,0,0,2,"#FFFFFF",0,"#DCEDFF",1,"","",0],75,0);
				stm_bpx("p3","p2",[]);
				stm_aix("p3i0","p1i0",[0,"ABM Categorias","","",-1,-1,0,"abm_p_categorias.php","_self","","","images/icono.gif","images/icono.gif",17,16,0,"","",0,0,0,0,1,"#FFFFFF",0,"#D7DCE2",0,"","",0,0],160,0);
				stm_aix("p3i1","p3i0",[0,"ABM Lineas","","",-1,-1,0,"abm_p_lineas.php"],160,0);
				stm_aix("p3i2","p3i0",[0,"ABM Variedades","","",-1,-1,0,"abm_p_variedades.php"],160,0);
				stm_aix("p3i3","p3i0",[0,"ABM Presentaciones","","",-1,-1,0,"abm_p_presentaciones.php"],160,0);
				stm_aix("p3i4","p3i0",[0,"ABM Productos","","",-1,-1,0,"abm_productos.php"],160,0);
				stm_aix("p3i5","p3i0",[0,"ABM Listas","","",-1,-1,0,"abm_listas.php"],160,0);
				stm_aix("p3i6","p3i0",[0,"Listas de Precios","","",-1,-1,0,"abm_precios.php"],160,0);
				stm_ep();
				stm_aix("p0i4","p0i0",[2,"","","",-1,-1,0,"abm_insumos.php","_self","","","images/i_insumos.png","images/i_insumos.png"],75,0);
				stm_bpx("p4","p2",[]);
				stm_aix("p4i0","p1i0",[0,"ABM Categorias","","",-1,-1,0,"abm_i_categorias.php"],126,0);
				stm_aix("p4i1","p1i0",[0,"ABM Proveedores","","",-1,-1,0,"abm_proveedores.php"],126,0);
				stm_aix("p4i2","p1i0",[0,"ABM Insumos","","",-1,-1,0,"abm_insumos.php"],126,0);
				stm_aix("p4i3","p1i0",[0,"ABM Cotizaciones","","",-1,-1,0,"abm_i_cotizaciones.php"],126,0);
				stm_ep();
				stm_aix("p0i5","p0i0",[2,"","","",-1,-1,0,"abm_stock.php","_self","","","images/i_stock.png","images/i_stock.png"],75,0);
				stm_bpx("p5","p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","transparent","",3,0,0,"#CCCCCC","images/toparrow.gif",9,126,0,"transparent","",2]);
				stm_aix("p5i0","p1i0",[0,"ABM Depositos","","",-1,-1,0,"abm_depositos.php"],126,0);
				stm_aix("p5i1","p1i0",[0,"ABM Produccion","","",-1,-1,0,"abm_produccion.php"],126,0);
				stm_aix("p5i2","p1i0",[0,"ABM Stock","","",-1,-1,0,"abm_stock.php"],126,0);
				stm_aix("p5i3","p1i0",[0,"Costo de Stock","","",-1,-1,0,"abm_costo_stock.php"],126,0);
				stm_aix("p5i4","p1i0",[0,"Transferencias","","",-1,-1,0,"abm_transferencias.php"],126,0);
				stm_aix("p5i5","p1i0",[0,"Abrir Cajas","","",-1,-1,0,"abm_abrir_cajas.php"],126,0);
				stm_ep();
				stm_aix("p0i6","p0i0",[2,"","","",-1,-1,0,"abm_reportes.php","_self","","","images/i_reportes.png","images/i_reportes.png"],75,0);
				stm_bpx("p6", "p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","transparent","",3,0,0,"#CCCCCC"]);
				stm_aix("p6i0","p1i0",[0,"Ventas x Productos","","",-1,-1,0,"abm_v_productos.php","_self","","","images/icono.gif","images/icono.gif",17,16,0,"","",0,0,0,0,1,"#FFFFFF",0,"#D7DCE2",0,"","",0,0],160,0);
				stm_aix("p6i1","p1i0",[0,"Ventas x Clientes","","",-1,-1,0,"abm_v_clientes.php"],160,0);
				stm_aix("p6i2","p1i0",[0,"Ventas x Vendedores","","",-1,-1,0,"abm_v_vendedor.php"],160,0);
				stm_aix("p6i3","p1i0",[0,"Deuda Pendiente","","",-1,-1,0,"abm_deudas.php"],160,0);
				stm_aix("p6i4","p1i0",[0,"Reporte de Actividad","","",-1,-1,0,"abm_reportes.php"],160,0);
				stm_aix("p6i5","p1i0",[0,"Reporte Resumen","","",-1,-1,0,"abm_reporte_resumen.php"],160,0);
				stm_ep();
				stm_ep();
				stm_em();
				//-->
				</script>

			</td>
		</tr>
<? }else{?>
		<tr height="20">
			<td>
				<table id="MenuGral" width="390" cellSpacing="0" cellPadding="0" align="center" border="0">
					<tr>
						<td width="24%" class="menu" align="center">Mi Agenda</td>
						<td width="24%" class="menu" align="center">Mis Clientes</td>
						<td width="24%" class="menu" align="center">Mi Cuenta</td>
						<td width="24%" class="menu" align="center">Reportes</td>
						<td width="4">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>

				<script type="text/javascript">
				<!--
				stm_bm(["menu56b9",820,"","",0,"","",1,0,250,0,200,1,0,0,"","100%",0,0,1,2,"default","hand",""],this);
				stm_bp("p0",[0,4,0,0,20,0,60,0,100,"",-2,"",-2,50,0,0,"#999999","transparent","",3,0,0,"#000000"]);
				stm_ai("p0i0",[2,"","","",-1,-1,0,"abm_agenda.php","_self","","","images/i_agenda.png","images/i_agenda.png",60,60,0,"","",0,0,0,0,2,"#FFFFF7",1,"#DCEDFF",1,"","",3,3,0,0,"#CCCCCC","#000000","#000000","#000000","8pt Verdana","8pt Verdana",0,0],75,0);
				stm_aix("p0i1","p0i0",[2,"","","",-1,-1,0,"abm_clientes.php","_self","","","images/i_clientes.png","images/i_clientes.png"],75,0);
				stm_bp("p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","#FFFFFF","",3,0,0,"#CCCCCC","images/toparrow.gif",9,126,0,"transparent","",3,"",0,0,0,"transparent","",3,"images/line.gif",3,126,0,"transparent","",3,"",0,0,0,"transparent","",3,"","","","",0,0,0,0,0,0,0,0]);
			
				stm_ep();
				stm_aix("p0i2","p0i0",[2,"","","",-1,-1,0,"abm_vendedores.php","_self","","","images/i_vendedores.png","images/i_vendedores.png"],75,0);
				stm_bpx("p2","p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","transparent"]);
				stm_aix("p2i0","p0i2",[0,"Cambiar mi clave","","",-1,-1,0,"abm_clave.php","_self","","","images/icono.gif","images/icono.gif",17,16,0,"","",0,0,0,0,1,"#FFFFFF",0,"#D7DCE2",0,"","",0,0],126,0);
				stm_aix("p2i1","p2i0",[0,"Agregar Pedido","","",-1,-1,0,"abm_ventas.php"],126,0);
				stm_aix("p2i2","p2i0",[0,"Agregar Visita","","",-1,-1,0,"abm_visita.php"],126,0);
				stm_aix("p2i3","p2i0",[0,"Agregar Llamado","","",-1,-1,0,"abm_llamado.php"],126,0);
				stm_aix("p2i4","p2i0",[0,"Lista Ventas","","",-1,-1,0,"listar_ventas.php"],126,0);
				stm_aix("p2i5","p2i0",[0,"Cargar Pagos","","",-1,-1,0,"abm_pagos.php"],126,0);
				stm_ep();
				stm_aix("p0i6","p0i2",[2,"","","",-1,-1,0,"abm_reportes.php","_self","","","images/i_reportes.png","images/i_reportes.png"],75,0);
				stm_bpx("p6", "p1",[1,4,0,0,0,3,17,0,100,"",-2,"",-2,50,0,0,"#999999","transparent","",3,0,0,"#CCCCCC"]);
				stm_aix("p6i0","p2i0",[0,"Ventas x Productos","","",-1,-1,0,"abm_v_productos.php","_self","","","images/icono.gif","images/icono.gif",17,16,0,"","",0,0,0,0,1,"#FFFFFF",0,"#D7DCE2",0,"","",0,0],160,0);
				stm_aix("p6i1","p2i0",[0,"Ventas x Clientes","","",-1,-1,0,"abm_v_clientes.php"],160,0);
				stm_aix("p6i2","p2i0",[0,"Ventas x Vendedores","","",-1,-1,0,"abm_v_vendedor.php"],160,0);
				stm_aix("p6i3","p2i0",[0,"Deuda Pendiente","","",-1,-1,0,"abm_deudas.php"],160,0);
				stm_aix("p6i4","p2i0",[0,"Reporte de Actividad","","",-1,-1,0,"abm_reportes.php"],160,0);
				stm_ep();
				stm_ep();
				stm_em();
				//-->
				</script>

			</td>
		</tr>
<? }?>		
		<tr valign="top">
			<td height="30">
			  <!-- InstanceBeginEditable name="SubMenu" -->
			
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td height="30">&nbsp;</td></tr>
		<tr>
			<td valign="top" height="30">
			  <!-- InstanceBeginEditable name="body" -->

<p align="center" class="titulo">ACORDES - RESUMEN</p>

<br>
<table width="90%" cellpadding="0" cellspacing="0" border="0">
	<tr height="50">
		<td align="center" width="50%">&nbsp;</td>
		<td align="right" width="50%"><a href="imp_reporte_resumen.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir el reporte</a></td>
	</tr>
</table>
<?
$anos = array();
$i = 0;
$a = query("SELECT year(fecha) AS ano FROM ventas WHERE year(fecha) <> '' GROUP BY ano");
while($rs = mysql_fetch_array($a)){
	$anos[$i] = $rs['ano'];
	$i++;
}
$meses = array('ENE','FEB', 'MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT', 'NOV','DIC');

$datos = array();
array_push($datos,array());  // AGREGO UN ARREGLO DENTRO DE OTRO


$a = 0;
foreach($anos as $ano){ 
	for($m = 1; $m < 13; $m++){
		$sql = "SELECT month(fecha), year(fecha),
					SUM( CASE WHEN unidades = 1 THEN vd.cant ELSE 0 END ) AS botellas,
					SUM( CASE WHEN unidades > 1 THEN vd.cant ELSE 0 END ) AS cajas,
					ROUND((SUM(vd.precio * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_sd,
					ROUND(SUM(vd.precio_final * vd.cant)) AS monto
					FROM ventas v 
					INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta 
					INNER JOIN productos p ON p.id_producto = vd.id_producto 
					INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
					WHERE year(fecha) = '$ano' AND month(fecha) = '$m'
					GROUP BY month(fecha)";
		//echo ($sql."<br><br>");
		$q = query($sql);
		if(mysql_num_rows($q) > 0){
			$rs = mysql_fetch_array($q);
			$botellas = $rs['botellas'];
			$cajas = $rs['cajas'];
			$monto = $rs['monto'];
			if($monto == "") $monto = $rs['monto_sd'];
		}else{
			$botellas = 0;
			$cajas = 0;
			$monto = 0;
		}
		$datos[$a][$m][0] = $botellas;
		$datos[$a][$m][1] = $cajas;
		$datos[$a][$m][2] = $monto;
	}
	$a++;
}

?>
<!-- -------------- BOTELLAS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">BOTELLAS</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center"><?= number_format($datos[$a][$m][0], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][0];
				$mes_T[$m] += $datos[$a][$m][0];
				$total += $datos[$a][$m][0];
				?>
			<? }?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center"><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>
<!-- -------------- CAJAS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">CAJAS</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center"><?= number_format($datos[$a][$m][1], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][1];
				$mes_T[$m] += $datos[$a][$m][1];
				$total += $datos[$a][$m][1];
				?>
			<? }?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center"><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>
<!-- -------------- MONTOS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">MONTOS</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center">$&nbsp;<?= number_format($datos[$a][$m][2], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][2];
				$mes_T[$m] += $datos[$a][$m][2];
				$total += $datos[$a][$m][2];
				?>
			<? }?>
			<td class="t" align="center">$&nbsp;<?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center">$&nbsp;<?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center">$&nbsp;<?= number_format($total, 0, ',','.')?></td>
	</tr>
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
