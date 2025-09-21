<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<!-- TemplateBeginEditable name="doctitle" -->

<!-- TemplateEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link href="../manager/estilo.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#DCD3C1">
<table height="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="162">&nbsp;</td>
    <td height="162"><img src="../manager/images/arriba_prod.jpg" width="748" height="162"></td>
    <td height="162">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF">

	<table  cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" width="148" >
	<table width="100%">
		<tr><td>&nbsp;</td></tr>
		<tr><td class="encabezado"><?=$_SESSION['nombre_vend']?></td></tr>
		<tr><td></td></tr>
		<tr><td></td></tr>
<?
if(!$_SESSION['admin']=="ok"){
?>
	<tr><td height="20" class="menu"><a href="index.php" class="menu">Agenda</a></td></tr>
	<tr><td height="20" class="menu"><a href="change_pass.php" class="menu">Cambiar clave </a></td></tr>
	<tr><td class="menu">&nbsp;</td></tr>

	<tr><td class="encabezado">Clientes</td></tr>
	<tr><td class="menu"><a href="bo_clientes.php" class="menu">ABM Clientes</a></td></tr>
	<tr><td class="menu">&nbsp;</td></tr>

	<tr><td class="encabezado">Actividad</td></tr>
	<tr><td height="20" class="menu"><a href="bo_venta.php" class="menu">Agregar venta/visita</a></td></tr>
	<tr><td height="20" class="menu"><a href="ver_ventas.php" class="menu">Cargar Pagos</a> </td></tr>
	<tr><td height="20" class="menu"><a href="bo_rendicion.php" class="menu">Rendir ventas</a> </td></tr>

	<tr><td height="20" class="menu">&nbsp;</td></tr>
	<tr><td class="encabezado">Reportes</td></tr>
	<tr><td height="20" class="menu"><a href="ventas_producto.php" class="menu">Ventas x producto</a> </td></tr>
	<tr><td height="20" class="menu"><a href="ventas_resumen.php" class="menu">Ventas x clientes</a> </td></tr>
	<tr><td height="20" class="menu"><a href="listar_rendiciones.php" class="menu">Ver rendiciones</a> </td></tr>
	<tr><td height="20" class="menu"><a href="listar_comisiones.php" class="menu">Ver pago comision</a></td></tr>
	<tr><td height="20" class="menu"><a href="bo_pagos.php" class="menu">Deuda Pendiente</a></td></tr>
	<tr><td height="20" class="menu"><a href="ver_resumen_ventas.php" class="menu">Reporte de Actividad</a> </td></tr>
	<tr><td height="20" class="menu">&nbsp;</td></tr>
	<tr><td height="20" class="menu"><a href="login.php" class="menu">Log out</a></td></tr>
	  
	  
	  
<?
}else{

?>	  
	<tr><td height="20" class="menu"><a href="index.php" class="menu">Agenda</a></td></tr>
	<tr><td class="menu">&nbsp;</td></tr>
	
	<tr><td class="encabezado">Clientes</td></tr>
	<tr><td class="menu"><a href="bo_clientes.php" class="menu">ABM Clientes</a></td></tr>
	<tr><td class="menu"><a href="bo_tipos.php" class="menu">ABM Tipos Clientes </a></td></tr>
	<tr><td class="menu"><a href="bo_grupos.php" class="menu">ABM Grupos</a></td></tr>
	<tr><td class="menu">&nbsp;</td></tr>
	
	<tr><td class="menu"><strong class="encabezado">Vendedores</strong></td></tr>
	<tr><td class="menu"><a href="bo_vendedores.php" class="menu">ABM Vendedores</a> </td></tr>
	<tr><td height="20" class="menu"><a href="change_pass.php" class="menu">Cambiar clave </a></td></tr>
	<tr><td height="20" class="menu"><a href="bo_venta.php" class="menu">Agregar venta </a></td></tr>
	<tr><td height="20" class="menu"><a href="ver_ventas.php" class="menu">Cargar Pagos</a> </td></tr>
	<tr><td height="20" class="menu"><a href="listar_rendiciones.php" class="menu">Ver rendiciones</a> </td></tr>	
	<tr><td height="20" class="menu"><a href="bo_comisiones.php" class="menu">Pagar comisiones </a></td></tr>
	<tr><td height="20" class="menu"><a href="listar_comisiones.php" class="menu">Ver comisiones</a></td></tr>
	<tr><td class="menu">&nbsp;</td></tr>
	
	<tr><td class="encabezado">Productos</td></tr>
	<tr><td class="menu"><a href="bo_tipo_linea.php" class="menu">ABM Tipo de Linea</a></td></tr>
	<tr><td class="menu"><a href="bo_lineas.php" class="menu">ABM Lineas</a></td></tr>
	<tr><td class="menu"><a href="bo_productos.php" class="menu">ABM Productos</a></td></tr>
	<tr><td class="menu"><a href="bo_listas.php" class="menu">Listas de Precios</a></td></tr>
	<tr><td class="menu">&nbsp;</td></tr>

	<tr><td class="encabezado">Reportes</td></tr>
	<tr><td height="20" class="menu"><a href="ventas_producto.php" class="menu">Ventas x producto</a> </td></tr>
	<tr><td height="20" class="menu"><a href="ventas_resumen.php" class="menu">Ventas x clientes</a> </td></tr>
	<tr><td height="20" class="menu"><a href="ventas_vendedor.php" class="menu">Ventas x vendedor</a> </td></tr>
	<tr><td height="20" class="menu"><a href="ver_pagos.php" class="menu">Deuda Pendiente</a></td></tr>
	<tr><td height="20" class="menu"><a href="ver_resumen_ventas.php" class="menu">Reporte de Actividad</a></td></tr>
	<tr><td height="20" class="menu"><a href="bo_modos.php" class="menu">Modos de pago</a> </td></tr>
    <tr><td height="20" class="menu">&nbsp;</td></tr>

	<tr><td class="encabezado">Stocks</td></tr>
	<tr><td height="20" class="menu"><a href="abm_depositos.php" class="menu">ABM Depositos</a></td></tr>
	<tr><td height="20" class="menu"><a href="abm_produccion.php" class="menu">ABM Produccion</a></td></tr>
	<tr><td height="20" class="menu"><a href="abm_stocks.php" class="menu">ABM Stocks</a></td></tr>
	<tr><td height="20" class="menu"><a href="costos_stocks.php" class="menu">Costos de Stock</a></td></tr>
	<tr><td height="20" class="menu"><a href="abm_transferencia.php" class="menu">Transferencia</a></td></tr>
	<tr><td height="20" class="menu"><a href="abm_abrir.php" class="menu">Abrir Cajas</a></td></tr>
    <tr><td height="20" class="menu">&nbsp;</td></tr>

	<tr><td height="20" class="menu">&nbsp;</td></tr>
	<tr><td height="20" class="menu"><p><a href="login.php" class="menu">Log out</a></p></td></tr>
	<tr><td height="20" class="menu">&nbsp;</td></tr>
	<tr><td height="20" class="menu">&nbsp;</td></tr>
	<tr><td height="20" class="menu">&nbsp;</td></tr>
<?}?>
	</table>
	
	</td>
	<td width="5" valign="top" background="../imagenes/line.jpg">&nbsp;</td>
	<td valign="top" width="590">  <!-- TemplateBeginEditable name="body" -->
	
	body<!-- TemplateEndEditable --><br></td>
	</tr>
	</table>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
