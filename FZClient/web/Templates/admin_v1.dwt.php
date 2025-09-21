<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

?>

<html>
<head>
<!-- TemplateBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- TemplateEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->

<link href="../administrador/estilos.css" rel="stylesheet" type="text/css">
<link href="../administrador/menu.css" rel="stylesheet" type="text/css"/>
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
						  <img src="../administrador/images/headers/mm-ap.jpg" width="341" height="80">
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
				<table id="MenuGral" cellSpacing="0" cellPadding="1" align="center" border="0">
					<tr>
						<td>
							<div>
								<div>
									<div id="DLRnav">
										<div class="DLRmenu"><h3><span>Agenda</span></h3></div>
										<div class="DLRmenu"><h3><span>Clientes</span></h3></div>
										<div class="DLRmenu"><h3><span>Vendedores</span></h3></div>
										<div class="DLRmenu"><h3><span>Productos</span></h3></div>
										<div class="DLRmenu"><h3><span>Insumos</span></h3></div>
										<div class="DLRmenu"><h3><span>Stock</span></h3></div>
										<div class="DLRmenu"><h3><span>Reportes</span></h3></div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table id="MenuGral" cellSpacing="0" cellPadding="1" align="center" border="0">
					<tr>
						<td>				
<div>
	<div>
		<div id="DLRnav">
			<div id="id_agenda" class="DLRmenu">
				<h3><a href="abm_agenda.php" id="agenda" title="Agenda"><span><IMG src="../administrador/images/i_agenda.png" width="60" height="60" border="0"></span></a></h3>
				<ul></ul>
			</div>
			<div id="id_clientes" class="DLRmenu">
				<h3><a href="abm_clientes.php" id="clientes" title="Clientes"><span><IMG src="../administrador/images/i_clientes.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_clientes.php">ABM Clientes</a></li>
					<li><a id="" name="" href="abm_categoria_clientes.php">ABM Cat. de clientes</a></li>
					<li><a id="" name="" href="abm_tipos_clientes.php">ABM Tipos de clientes</a></li>
					<li><a id="" name="" href="abm_grupos.php">ABM Grupos</a></li>
					<li><a id="" name="" href="abm_ventas_cliente.php">ABM Historial</a></li>
				</ul>
			</div>
			<div id="id_vendedores" class="DLRmenu">
				<h3><a href="abm_vendedores.php" id="vendedores" title="Vendedores"><span><IMG src="../administrador/images/i_vendedores.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_vendedores.php">ABM Vendedores</a></li>						
					<li><a id="" name="" href="abm_ventas.php">Agregar un pedido</a></li>
					<li><a id="" name="" href="listar_ventas.php">Ver ventas</a></li>
					<li><a id="" name="" href="abm_visita.php">Agregar visita</a></li>
					<li><a id="" name="" href="abm_llamado.php">Agregar llamado</a></li>
					<li><a id="" name="" href="abm_pagos.php">Cargar Pagos</a></li>
					<li><a id="" name="" href="abm_rendiciones.php">Ver rendiciones</a></li>
					<li><a id="" name="" href="abm_p_comisiones.php">Pagar comiciones</a></li>
					<li><a id="" name="" href="abm_v_comisiones.php">Ver comisiones</a></li>
				</ul>
			</div>
			<div id="id_productos" class="DLRmenu">
				<h3><a href="abm_productos.php" id="productos" title="Productos"><span><IMG src="../administrador/images/i_productos.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_p_categorias.php">ABM Categorias</a></li>						
					<li><a id="" name="" href="abm_p_lineas.php">ABM Lineas</a></li>
					<li><a id="" name="" href="abm_p_variedades.php">ABM Variedades</a></li>
					<li><a id="" name="" href="abm_p_presentaciones.php">ABM Presentaciones</a></li>
					<li><a id="" name="" href="abm_productos.php">ABM Productos</a></li>
					<li><a id="" name="" href="abm_listas.php">ABM Listas</a></li>
					<li><a id="" name="" href="abm_precios.php">Lista de Precios</a></li>
				</ul>
			</div>
			<div id="id_insumos" class="DLRmenu">
				<h3><a href="abm_insumos.php" id="insumos" title="Insumos"><span><IMG src="../administrador/images/i_insumos.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_i_categorias.php">ABM Categorias</a></li>
					<li><a id="" name="" href="abm_proveedores.php">ABM Proveedores</a></li>
					<li><a id="" name="" href="abm_insumos.php">ABM Insumos</a></li>
				</ul>
			</div>
			<div id="id_stock" class="DLRmenu">
				<h3><a href="abm_stock.php" id="stock" title="Stock"><span><IMG src="../administrador/images/i_stock.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_depositos.php">ABM Depositos</a></li>						
					<li><a id="" name="" href="abm_produccion.php">ABM Produccion</a></li>
					<li><a id="" name="" href="abm_stock.php">ABM Stock</a></li>
					<li><a id="" name="" href="abm_costo_stock.php">Costo de Stock</a></li>
					<li><a id="" name="" href="abm_transferencias.php">Transferencia</a></li>
					<li><a id="" name="" href="abm_abrir_cajas.php">Abrir Cajas</a></li>
				</ul>
			</div>
			<div id="id_reportes" class="DLRmenu">
				<h3><a href="abm_reporte.php" id="reportes" title="Reportes"><span><IMG src="../administrador/images/i_reportes.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_v_productos.php">Ventas x producto</a></li>						
					<li><a id="" name="" href="abm_v_clientes.php">Ventas x cliente</a></li>
					<li><a id="" name="" href="abm_v_vendedor.php">Ventas x vendedor</a></li>
					<li><a id="" name="" href="abm_deudas.php">Deuda Pendiente</a></li>
					<li><a id="" name="" href="abm_reporte.php">Reporte de Actividad</a></li>
					<li><a id="" name="" href="abm_modos_pago.php">Modos de Pago</a></li>
				</ul>
			</div>
		</div>
	</div>
	<script src="navegador.js" type="text/javascript"></script>
</div>

							</td>
						</tr>
			  		</table>
			</td>
		</tr>
<? }else{?>
		<tr>
			<td height="20">
				<table id="MenuGral" cellSpacing="0" cellPadding="1" align="center" border="0">
					<tr>
						<td>
<div>
	<div>
		<div id="DLRnav">
			<div class="DLRmenu"><h3><span>Mi Agenda</span></h3></div>
			<div class="DLRmenu"><h3><span>Mis Clientes</span></h3></div>
			<div class="DLRmenu"><h3><span>Mi Cuenta</span></h3></div>
			<div class="DLRmenu"><h3><span>Reportes</span></h3></div>
		</div>
	</div>
</div>
							</td>
						</tr>
			  		</table>
			</td>
		</tr>
		<tr>
			<td>
				<table id="MenuGral" cellSpacing="0" cellPadding="1" align="center" border="0">
					<tr>
						<td>
				
<div>
	<div>
		<div id="DLRnav">
			<div id="id_agenda" class="DLRmenu">
				<h3><a href="abm_agenda.php" id="agenda" title="Agenda"><span><IMG src="../administrador/images/i_agenda.png" width="60" height="60" border="0"></span></a></h3>
				<ul></ul>
			</div>
			<div id="id_clientes" class="DLRmenu">
				<h3><a href="abm_clientes.php" id="clientes" title="Clientes"><span><IMG src="../administrador/images/i_clientes.png" width="60" height="60" border="0"></span></a></h3>
				<ul></ul>
			</div>
			<div id="id_vendedores" class="DLRmenu">
				<h3><a href="abm_clave.php" id="vendedores" title="Vendedores"><span><IMG src="../administrador/images/i_vendedores.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_clave.php">Cambiar mi clave</a></li>
					<li><a id="" name="" href="abm_ventas.php">Agregar un pedido</a></li>
					<li><a id="" name="" href="listar_ventas.php">Ver ventas</a></li>
					<li><a id="" name="" href="abm_pagos.php">Cargar Pagos</a></li>
					<li><a id="" name="" href="abm_rendiciones.php">Ver rendiciones</a></li>
				</ul>
			</div>
			<div id="id_reportes" class="DLRmenu">
				<h3><a href="#" id="reportes" title="Reportes"><span><IMG src="../administrador/images/i_reportes.png" width="60" height="60" border="0"></span></a></h3>
				<ul>
					<li><a id="" name="" href="abm_v_productos.php">Ventas x producto</a></li>						
					<li><a id="" name="" href="abm_v_clientes.php">Ventas x cliente</a></li>
					<li><a id="" name="" href="abm_v_vendedor.php">Ventas x vendedor</a></li>
					<li><a id="" name="" href="abm_deudas.php">Deuda Pendiente</a></li>
					<li><a id="" name="" href="abm_reporte.php">Reporte de Actividad</a></li>
					<li><a id="" name="" href="abm_modos_pago.php">Modos de Pago</a></li>
				</ul>
			</div>
		</div>
	</div>
	<script src="../administrador/navegador_vendedores.js" type="text/javascript"></script>
</div>

							</td>
						</tr>
			  		</table>
			</td>
		</tr>

<? }?>		
		<tr valign="top">
			<td height="30">
			  <!-- TemplateBeginEditable name="SubMenu" -->
			
			  <!-- TemplateEndEditable -->
			</td>
		</tr>
		<tr><td height="30">&nbsp;</td></tr>
		<tr>
			<td valign="top" height="30">
			  <!-- TemplateBeginEditable name="body" -->
			
			  <!-- TemplateEndEditable -->
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
</html>
