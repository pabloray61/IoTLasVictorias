<div style="position:absolute; left:250px; top:59px; color:#FFF">
	<? if($admin == 1){ // COMPLETO ?>
        <ul id="nav">
            <li><a href="abm_agenda.php">Agenda</a></li>
            <li><a href="abm_clientes.php">Clientes</a>
                <ul class="submenu">
                    <li><a href="abm_clientes.php">ABM Clientes</a></li>
                    <li><a href="abm_categoria_clientes.php">ABM Categorias</a></li>
                    <li><a href="abm_tipos_clientes.php">ABM Tipos</a></li>
                    <li><a href="abm_grupos.php">ABM Grupos</a></li>
                    <li><a href="abm_ventas_cliente.php">Historial</a></li>
                </ul>
            </li>
            <li><a href="abm_vendedores.php">Vendedores</a>
                <ul class="submenu">
                    <li><a href="abm_vendedores.php">ABM Vendedores</a></li>
                    <li><a href="abm_ventas.php">Agregar Pedido</a></li>
                    <li><a href="abm_visita.php">Agregar Visita</a></li>
                    <li><a href="abm_llamado.php">Agregar Llamado</a></li>
                    <li><a href="listar_ventas.php">Listar Ventas</a></li>
                    <li><a href="listar_seguimientos.php">Listar Seguimientos</a></li>
                    <li><a href="abm_pagos.php">Cargar Pagos</a></li>
                    <li><a href="abm_pago_comisiones.php">Pagar Comisiones</a></li>
                </ul>
            </li>
            <li><a href="abm_productos.php">Productos</a>
                <ul class="submenu">
                    <li><a href="abm_p_categorias.php">ABM Categorias</a></li>
                    <li><a href="abm_p_lineas.php">ABM Lineas</a></li>
                    <li><a href="abm_p_variedades.php">ABM Variedades</a></li>
                    <li><a href="abm_p_presentaciones.php">ABM Presentaciones</a></li>
                    <li><a href="abm_productos.php">ABM Productos</a></li>
                    <li><a href="abm_listas.php">ABM Listas</a></li>
                    <li><a href="abm_precios.php">Listas de Precios</a></li>
                </ul>
            </li>
            <li><a href="abm_insumos.php">Insumos</a>
                <ul class="submenu">
                    <li><a href="abm_i_categorias.php">ABM Categorias</a></li>
                    <li><a href="abm_proveedores.php">ABM Proveedores</a></li>
                    <li><a href="abm_insumos.php">ABM Insumos</a></li>
                    <li><a href="abm_i_cotizaciones.php">ABM Cotizaciones</a></li>
                    <li><a href="abm_i_producto.php">Insumos - Producto</a></li>
                </ul>
            </li>
            <li><a href="abm_stock.php">Stock</a>
                <ul class="submenu">
                    <li><a href="abm_depositos.php">ABM Depositos</a></li>
                    <li><a href="abm_produccion.php">ABM Produccion</a></li>
                    <li><a href="abm_stock.php">ABM Stock</a></li>
                    <li><a href="abm_costo_stock.php">Costo de Stock</a></li>
                    <li><a href="abm_transferencias.php">Transferencias</a></li>
                    <li><a href="abm_abrir_cajas.php">Abrir Cajas</a></li>
                </ul>
            </li>
            <li><a href="abm_reportes.php">Reportes</a>
                <ul class="submenu">
                    <li><a href="abm_v_productos.php">Ventas x Productos</a></li>
                    <li><a href="abm_v_clientes.php">Ventas x Clientes</a></li>
                    <li><a href="abm_v_clientes_anos.php">Cajas x Clientes</a></li>
                    <li><a href="abm_v_vendedor.php">Ventas x Vendedores</a></li>
                    <li><a href="abm_deudas.php">Deuda Pendiente</a></li>
                    <li><a href="abm_reportes.php">Reporte de Actividad</a></li>
                    <li><a href="abm_rr_meses.php">Resumen Años-Meses</a></li>
                    <li><a href="abm_rr_clientes.php">Resumen Años-Clientes</a></li>
                </ul>
            </li>                            
        </ul>
    <? }else{?>
		<ul id="nav">
            <li><a href="abm_agenda.php">Agenda</a></li>
            <li><a href="abm_clientes.php">Mis Clientes</a></li>
            <li><a href="abm_clientes.php">Mi Cuenta</a>
                <ul class="submenu">
                    <li><a href="abm_clave.php">Cambiar mi clave</a></li>
                    <li><a href="abm_ventas.php">Agregar Pedido</a></li>
                    <li><a href="abm_visita.php">Agregar Visita</a></li>
                    <li><a href="abm_llamado.php">Agregar Llamado</a></li>
                    <li><a href="listar_ventas.php">Lista Ventas</a></li>
                    <li><a href="listar_seguimientos.php">Listar Seguimientos</a></li>
                    <li><a href="abm_pagos.php">Cargar Pagos</a></li>
                    <li><a href="abm_pago_comisiones.php">Pagar Comisiones</a></li>
                </ul>
            </li>
            <li><a href="abm_reportes.php">Reportes</a>
                <ul class="submenu">
                    <li><a href="abm_v_productos.php">Ventas x Productos</a></li>
                    <li><a href="abm_v_clientes.php">Ventas x Clientes</a></li>
                    <li><a href="abm_v_clientes_anos.php">Cajas x Clientes</a></li>
                    <li><a href="abm_v_vendedor.php">Ventas x Vendedores</a></li>
                    <li><a href="abm_deudas.php">Deuda Pendiente</a></li>
                    <li><a href="abm_reportes.php">Reporte de Actividad</a></li>
                    <li><a href="abm_rr_meses.php">Resumen Años-Meses</a></li>
                    <li><a href="abm_rr_clientes.php">Resumen Años-Clientes</a></li>
                </ul>
            </li>  
		</ul>
    <? }?>
</div>