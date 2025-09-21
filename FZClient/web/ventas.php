<?
require_once("administrador/conn.php");
require_once("administrador/func.php");
require "includes/class.phpmailer.php"; 

session_start();

require_once('function_cart.php');

$id_lista_precio = 9; // PRECIOS SUGERIDOS
?>
<html><!-- InstanceBegin template="/Templates/sub_web.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

<title>.: Acordes -:- Selected Brands :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Acordes nace en el año 2003 con el objetivo de elaborar y comercializar bebidas y productos alimenticios para su venta en el mercado local y de exportación.">
<meta name="Classification" content="Sitio realizado en php con agregados en flash">
<meta name="keywords" content="acordes, acordessa, acordes sa, bodega, vinos, wine, mendoza, sinfonia, SINFONIA, saxo, SAXO, VINEYARDS, VIÑEDOS, ARGENTINA, argentina, Argentina, mendoza">
<meta http-equiv="keywords" content="acordes, acordessa, acordes sa, bodega, vinos, wine, mendoza, sinfonia, SINFONIA, saxo, SAXO, VINEYARDS, VIÑEDOS, ARGENTINA, argentina, Argentina, mendoza">

<link href="estilos.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" -->
<?
$foto = "mantenimiento"; // nombre
$pag = "pag=ven"; //3 letras
?>
<!-- InstanceEndEditable -->
<?
if($foto == "novedades" OR $foto == "registrate" OR $foto == "eventos" OR $foto == "lifestyle" OR $foto == "lugares" OR $foto == "compras"){
	$foto = "mantenimiento";
}
?>
</head>

<body bgcolor="#OOOOOO" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="800" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr valign="middle">
		<td>
			<table width="800" height="600" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr valign="top">
					<td class="bg" width="800" height="528">
					  <!-- InstanceBeginEditable name="texto" -->

<?
if(!$_REQUEST['enviar']){
?>					  
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td width="230" align="center">
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="20"><td></td></tr>
    
                    <?
                    $q2 = query("SELECT p.id_categoria, c.categoria FROM p_categorias c
                                INNER JOIN productos p ON c.id_categoria = p.id_categoria
                                WHERE p.venta=1 GROUP BY id_categoria ORDER BY c.orden");
                    while($rs2 = mysql_fetch_array($q2)){
                        $id_categoria = $rs2['id_categoria'];
                        $categoria = $rs2['categoria'];
                        ?>
                        <tr>
                            <td align="center">
                                <table width="190" cellpadding="0" cellspacing="0" border="0">
                                    <tr><td colspan="3"><img src="images/cart_up.png" width="190"></td></tr>
                                    <tr height="30">
                                        <td background="images/cart_left.png" width="2"></td>
                                        <td bgcolor="#FFFFFF" width="172">&nbsp;&nbsp;&nbsp;<img src="images/ico_1.jpg">&nbsp;&nbsp;<a href="<?= $_SERVER['PHP_SELF']?>?id_categoria=<?= $id_categoria?>" class="menu"><?= $categoria?></a></td>
                                        <td background="images/cart_right.png" width="2"></td>
                                    </tr>
                                    <tr><td colspan="3"><img src="images/cart_dw.png" width="190"></td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr height="10"><td></td></tr>
                    <? }?>

    
                    <!--  CARRITO DE COMPRAS -->
                    <? if (!$cart){?>
                        <tr height="60"><td class="cart_resultado" align="center">No hay ningun producto<br> en su carrito.</td></tr>
                    <? }else{?>
                        <tr>
                            <td align="center">
                                <table width="190" cellpadding="0" cellspacing="0" border="0">
                                    <tr><td colspan="3"><img src="images/cart_up.png" width="190"></td></tr>
                                    <tr height="30">
                                        <td background="images/cart_left.png" width="2"></td>
                                        <td bgcolor="#FFFFFF" width="186" align="center">
                                            <table width="96%" cellpadding="0" cellspacing="0" border="0">
                                                <tr height="40">
                                                    <td>
                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                            <tr>
                                                                <td width="60%" align="left" class="cart_t">&nbsp;Mi pedido:</td>
                                                                <td width="40%" align="right">
                                                                    <a href="<?= $_SERVER['PHP_SELF']?>?enviar=ok" title="Enviar mi pedido"><img src="images/enviar_pedido.png" border="0"></a>
                                                                    <a href="<?= $_SERVER['PHP_SELF']?>?vaciar=ok" title="Vaciar el carrito" onClick="javascript: return confirm('Estas seguro que queres vaciar el carrito');"><img src="images/vaciar.png" border="0"></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr height="1"><td bgcolor="#b2ad91"></td></tr>
                                                <?
                                                if($cart){	
                                                    $items = explode(',',$cart);
                                                    $contents = array();
                                                    foreach ($items as $item) {
                                                        $contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
                                                    }
                                                    $cant = sizeof($contents);
                                                    $i = 0;
                                                    foreach ($contents as $id_producto=>$qty) {
                                                            $qp = query("SELECT c.categoria, l.linea, v.variedad, pr.unidades,
                                                                        (SELECT precio FROM precios pr WHERE pr.id_producto = $id_producto AND pr.id_lista = $id_lista_precio ORDER BY pr.fecha DESC LIMIT 1) AS precio 
                                                                        FROM productos p
                                                                        INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
                                                                        INNER JOIN p_lineas l ON l.id_linea = p.id_linea
                                                                        INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
                                                                        INNER JOIN p_presentacion pr ON pr.id_presentacion = p.id_presentacion
                                                                        WHERE p.id_producto = ".$id_producto);
                                                            $rs = mysql_fetch_array($qp);
                                                            $i++;
                                                            $precio = $rs['precio'];
                                                            $unidades = $rs['unidades'];
                                                            $u = $qty / $unidades;
                                                            $total += $precio * $u;
                                                            $total_qty += $qty;
                                                        ?>
                                                        <tr height="5"><td></td></tr>
                                                        <tr height="20" onClick="javascript: if(confirm('Estas seguro que queres eliminar este preducto del carrito?') == true) { document.location.href='<?= $_SERVER['PHP_SELF']?>?id_producto=<?= $id_producto?>&action=delete';}" onMouseOver="javascript:pintar(this);" onMouseOut="javascript:despintar(this);" style="cursor:pointer" title="Eliminar este producto del carrito">
                                                            <td>
                                                                <table width="174" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td class="cart_st"><?= $rs['linea']?></td>
                                                                        <td class="cart_t" align="right"><?= $qty?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="70%" class="cart_t"><?= $rs['variedad']?></td>
                                                                        <td width="20%" class="cart_t" align="right">$&nbsp;<?= number_format($precio, 0, ",", ".")?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr height="5"><td></td></tr>
                                                        <? if($i != $cant) echo("<tr><td><img src='images/cart_separador.png'></td></tr>")?>
                                                    <? }?>
                                                <? }?>
                                                <tr height="1"><td bgcolor="#b2ad91"></td></tr>
                                                <tr height="5"><td></td></tr>
                                                <tr>
                                                    <td>
                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                            <tr>
                                                                <td width="20%" class="cart_r">Total:</td>
                                                                <td width="50%" class="cart_r"><?= $total_qty?> producto<?= $total_qty > 1 ? "s" : ""?></td>
                                                                <td width="30%" class="cart_r" align="right">$&nbsp;<?= number_format($total, 0, ",", ".")?>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr height="5"><td></td></tr>
                                            </table>
                                        </td>
                                        <td background="images/cart_right.png" width="2"></td>
                                    </tr>
                                    <tr><td colspan="3"><img src="images/cart_dw.png" width="190"></td></tr>
                                </table>
                            </td>
                        </tr>
                    <? }?>	
                    <!--  END CARRITO DE COMPRAS -->
                </table>
            </td>
            <td width="500">
                <?
                $id_cat = $_REQUEST['id_categoria'];
                $id_cat = !empty($id_cat) ? $id_cat : 1;
                $sql_where = "WHERE venta = 1 AND p.id_categoria = $id_cat";
                $sql_order = "";
            
                $q = query("SELECT p.id_producto, p.foto, pc.id_categoria, pc.categoria, pl.linea, pv.variedad, pv.sigla, 
                            pp.presentacion, pp.unidades, pp.volumen, p.orden, p.venta, p.codigo FROM productos p
                            INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
                            INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
                            INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
                            INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
                            $sql_where $sql_order");
            
                $reg_x_pagina = $_REQUEST['reg_x_pagina'] == "" ? 12:$_REQUEST['reg_x_pagina'];
                $pagina_actual = $_REQUEST['pagina_actual'] == "" ? 1:$_REQUEST['pagina_actual'];
            
                $reg_inicial = ($pagina_actual - 1) * $reg_x_pagina;
                $reg_final = $reg_inicial + $reg_x_pagina;
            
                $nro_reg = size($q);
                $nro_paginas = floor (( $nro_reg / $reg_x_pagina)) + 1 ;
                if(($nro_paginas - 1) * $reg_x_pagina == $nro_reg) $nro_paginas = $nro_paginas - 1;
                //echo($nro_paginas." : ".$nro_reg." / ".$reg_x_pagina);
                ?>									
                <table width="100%" cellpadding="0" cellspacing="0" border="0" align="right">
                    <?
                    if(size($q) > 0){
                    ?>
                        <tr height="20"><td></td></tr>
                        <tr>
                            <td align="center">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <?	
                                        $i = 0;
                                        $t = 1;
                                        $ta = 100;
                                        for ($i = $reg_inicial; $i < $reg_final && $i < $nro_reg; $i++)  {
                                            $id_producto = mysql_result($q, $i, 'id_producto');
                                            $foto = mysql_result($q, $i, 'foto');
                                            if(!empty($foto)){
                                                $dir = "productos/".$foto;
                                                list($width, $height) = getimagesize($dir);
												if($height > $width && $height > $ta){
													$width = $width / ($height / $ta);
													$height = $ta;
												}
												if($width > $height && $width > $ta){
													$height = $height / ($width / $ta);
													$width = $ta;
												}
                                            }else{
                                                $dir = "images/foto_no_disponible.jpg";
                                                $width = $ta;
                                                $height = $ta;
                                            }
                                            $categoria = mysql_result($q, $i, 'categoria');
                                            if(strlen($categoria) > 20) $categoria = substr($categoria, 0, 20)."...";
                                            $linea = mysql_result($q, $i, 'linea');
                                            if(strlen($linea) > 20) $linea = substr($linea, 0, 20)."...";
                                            $variedad = mysql_result($q, $i, 'variedad');
                                            if(strlen($variedad) > 20) $variedad = substr($variedad, 0, 20)."...";
                                            $presentacion = mysql_result($q, $i, 'presentacion');
                                            if(strlen($presentacion) > 20) $presentacion = substr($presentacion, 0, 20)."...";
                                            $unidades = mysql_result($q, $i, 'unidades');
                                            $volumen = mysql_result($q, $i, 'volumen');
                                            $pres = $presentacion." ($unidades x $volumen)";
                                            $codigo = "Cod: ".mysql_result($q, $i, 'codigo');
                                            if(strlen($codigo) > 20) $codigo = substr($codigo, 0, 20)."...";
                
                                            $j += 1;
                                            
                                            $q2 = query("SELECT precio FROM precios WHERE id_producto = $id_producto AND id_lista = $id_lista_precio ORDER BY fecha DESC LIMIT 1");
    
                                        ?>
                                            <td width="110">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td colspan="3" align="center">
                                                            <table width="105" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td colspan="3"><img src="images/producto_up.png" width="104"></td></tr>
                                                                <tr height="100">
                                                                    <td background="images/producto_left.png" width="2"></td>
                                                                    <td align="center" bgcolor="#FFFFFF" width="100"><a href="<?= $dir?>" target="_blank" title="Agrandar la foto"><img src="<?= $dir?>" width="<?= $width?>" height="<?= $height?>" border="0"></a></td>
                                                                    <td background="images/producto_right.png" width="2"></td>										
                                                                </tr>
                                                                <tr><td colspan="3"><img src="images/producto_dw.png" width="104"></td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr height="10"><td colspan="3"></td></tr>
                                                    <tr height="20"><td colspan="3" class="cart_d">&nbsp;&nbsp;<?= $linea?></td></tr>
                                                    <tr><td colspan="3"><img src="images/producto_separador.png" width="100"></td></tr>
                                                    <tr height="20"><td colspan="3" class="cart_d">&nbsp;&nbsp;<?= $variedad?></td></tr>
                                                    <tr><td colspan="3"><img src="images/producto_separador.png" width="100"></td></tr>
                                                    <tr height="20"><td colspan="3" class="cart_d">&nbsp;&nbsp;<?= $pres?></td></tr>
                                                    <tr><td colspan="3"><img src="images/producto_separador.png" width="100"></td></tr>
                                                    <? if($cod){?>
                                                    <tr height="20"><td colspan="3" class="cart_d">&nbsp;&nbsp;<?= $codigo?></td></tr>
                                                    <tr><td colspan="3"><img src="images/producto_separador.png" width="100"></td></tr>
                                                    <? }?>
                                                    <tr height="30">
                                                        <td colspan="3">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="60%" class="cart_p">&nbsp;&nbsp;$&nbsp;<?= size($q2) > 0 ? number_format(mysql_result($q2, 0, 'precio'), 2, ',','.') : 0?></td>
                                                                    <td width="40%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?action=add&unidades=<?= $unidades?>&id_producto=<?= $id_producto?>&id_categoria=<?= $id_cat?>&pagina_actual=<?= $pagina_actual?>" title="Agregar un <?= $categoria." ".$linea." ".$variedad?> al carrito"><img src="images/comprar.png" border="0"></a></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr height="20"><td colspan="3"></td></tr>
                                                </table>
                                            </td>
                                            <? 
                                                if($t == ($j/4)){
                                                    echo("</tr><tr>");
                                                    $t += 1;
                                                }else{
                                                    echo("<td width='5'></td>");
                                                }
                                            ?>
                                        <? } // cierro el while?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <table align="center" border="0" cellpadding="0" cellspacing="0">
                                    <tr height="10"><td></td></tr>
                                    <tr valign="middle">									
                                        <?
                                        $pa = $pagina_actual - 1;
                                        $ps = $pagina_actual + 1;
                                        ?>
                                        <? if($pa != 0){?>
                                            <td width="25" align="center"><a href="<?=$_SERVER['PHP_SELF'] . "?reg_x_pagina=$reg_x_pagina&pagina_actual=$pa&id_categoria=$id_categoria&id_varietal=$id_varietal&ba=$ba&bb=$bb&lado_n=$l_na&lado_p=$l_pa"?>" class="link"><img src="images/b_anterior.png" border="0"></a></td>
                                        <? }?>
                                        <? 
                                        if($nro_paginas > 1){
                                            for ( $i = 1; $i <= $nro_paginas; $i++ ){ 
                                        ?>
                                            <td width="25" align="center"><a href="<?=$_SERVER['PHP_SELF'] . "?reg_x_pagina=$reg_x_pagina&pagina_actual=$i&id_categoria=$id_categoria&id_varietal=$id_varietal&ba=$ba&bb=$bb&lado_n=$l_na&lado_p=$l_pa"?>" class="<?= $i == $pagina_actual ? "numeroON":"numeroOFF"?>"><?= $i == $pagina_actual ? "&nbsp;$i&nbsp;":"&nbsp;$i&nbsp;"?></a></td>
                                        <? 
                                            }
                                        }
                                        ?>
                                        <? if($pagina_actual != $nro_paginas){?>
                                            <td width="25" align="center"><a href="<?=$_SERVER['PHP_SELF'] . "?reg_x_pagina=$reg_x_pagina&pagina_actual=$ps&id_categoria=$id_categoria&id_varietal=$id_varietal&ba=$ba&bb=$bb&lado_n=$l_na&lado_p=$l_pa"?>" class="link"><img src="images/b_siguiente.png" border="0"></a></td>
                                        <? }?>
                                    </tr>
                                    <tr height="30"><td></td></tr>
                                </table>
                            </td>
                        </tr>
                    <? }else{ // si no hay productos?>
                        <tr height="20"><td></td></tr>
                        <tr height="30">
                            <td class="cart_t">No hay ningun producto cargado.</td>
                        </tr>
                    <? } // cierro el if de si hay productos?>
                </table>	
            </td>
        </tr>
    </table>
<? }else{?>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
      	<tr height="20" bgcolor="#000000"><td></td></tr>
    </table>
    <table width="90%" cellpadding="0" cellspacing="0" border="0" align="center">
        <?
        $items = explode(',',$cart);
        $contents = array();
        foreach ($items as $item) {
            $contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
        }
        $i = 0;
        if($cart){
        ?>
            <tr height="20"><td></td></tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100" align="right"><img src="images/hojas.png"></td>
                            <td width="10">&nbsp;</td>
                            <td class="titulos">Productos seleccionados</td>
                            <td align="right" class="cart_t"><a href="<?= $_SERVER['PHP_SELF']?>?enviar=" title="Continuar comprando">Continuar comprando</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr height="20"><td></td></tr>
            <tr>
                <td align="left">
                    <table width="600" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">&nbsp;</td>
                            <td width="5%">&nbsp;</td>
                            <td width="75%">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td width="35%" class="cart_t">PRODUCTO</td>
                                        <td width="15%">&nbsp;</td>
                                        <td width="20%" class="cart_t" align="center">UNIDADES</td>
                                        <td width="20%" class="cart_t" align="right">SUBTOTAL</td>
                                        <td width="10%">&nbsp;</td>
                                    </tr>							
                                </table>
                            </td> 
                        </tr>
                        <tr height="2">
                            <td colspan="2"></td>
                            <td bgcolor="#5c1428"></td>
                        </tr>
                        <tr height="20"><td></td></tr>
                        <?
                        $prod_mail = "<table width='800' cellpadding='0' cellspacing='0' border='0'><tr height='30'><td><b>Producto</b></td><td><b>Botella</b></td><td><b>Codigo</b></td><td align='center'><b>Unidades</b></td><td align='center'><b>Precio</b></td><td align='center'><b>Subtotal</b></td></tr><tr height='1'><td colspan='7' bgcolor='#000000'></td></tr>";
    if($cart){
						$ta = 100;
                        foreach ($contents as $id_producto=>$qty) {
							$q = query("SELECT c.categoria, l.linea, v.variedad, pr.unidades, pr.volumen,
										(SELECT precio FROM precios pr WHERE pr.id_producto = $id_producto AND pr.id_lista = $id_lista_precio ORDER BY pr.fecha DESC LIMIT 1) AS precio 
										FROM productos p
										INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
										INNER JOIN p_lineas l ON l.id_linea = p.id_linea
										INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
										INNER JOIN p_presentacion pr ON pr.id_presentacion = p.id_presentacion
										WHERE p.id_producto = ".$id_producto);
                            $rs = mysql_fetch_array($q);
                            $i++;
							$unidades = $rs['unidades'];
							$volumen = $rs['volumen'];
							
                            $precio = $rs['precio'];
							
                            $total_envio += $precio * $qty / $unidades;
                            $total_qty_envio += $qty / $unidades;
                            
                            $foto = $rs['foto'];
                            if($foto != ""){
                                $dir = "productos/".$foto;
                                list($width, $height) = getimagesize($dir);
                                if($width > $ta) $width = $ta;
                                if($height > $ta) $height = $ta;
                            }else{
                                $dir = "images/foto_no_disponible.jpg";
                                $width = $ta;
                                $height = $ta;
                            }
							$categoria = $rs['categoria'];
							if(strlen($categoria) > 20) $categoria = substr($categoria, 0, 20)."...";
							$linea = $rs['linea'];
							if(strlen($linea) > 20) $linea = substr($linea, 0, 20)."...";
							$variedad = $rs['variedad'];
							if(strlen($variedad) > 20) $variedad = substr($variedad, 0, 20)."...";
							$presentacion = $rs['presentacion'];
							if(strlen($presentacion) > 20) $presentacion = substr($presentacion, 0, 20)."...";

							$pres = $presentacion." ($unidades x $volumen)";
							$codigo = "Cod: ".$rs['codigo'];
							if(strlen($codigo) > 20) $codigo = substr($codigo, 0, 20)."...";
                            $j += 1;
                            $prod_mail .= "<tr height='30'><td>".$categoria." - ".$linea."</td><td>".$variedad." ".$pres."</td><td>".$rs['codigo']."</td><td align='center'>".$qty/$unidades."</td><td align='center'>$&nbsp;".$precio."</td><td align='center'>$&nbsp;".$precio*$qty/$unidades."</td></tr>"
                        ?>
                            <tr>
                                <td>
                                    <table width="105" cellpadding="0" cellspacing="0" border="0">
                                        <tr><td colspan="3"><img src="images/producto_up.png" width="104"></td></tr>
                                        <tr height="100">
                                            <td background="images/producto_left.png" width="2"></td>
                                            <td align="center" bgcolor="#FFFFFF" width="100"><img src="<?= $dir?>" width="<?= $width?>" height="<?= $height?>"></td>
                                            <td background="images/producto_right.png" width="2"></td>										
                                        </tr>
                                        <tr><td colspan="3"><img src="images/producto_dw.png" width="104"></td></tr>
                                        <tr height="20"><td colspan="3"></td></tr>
                                    </table>
                                </td>
                                <td></td>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr height="25"><td class="cart_d">&nbsp;&nbsp;<?= $categoria." - ".$linea?></td><td colspan="4">&nbsp;</td></tr>
                                        <tr><td><img src="images/producto_separador.png"></td><td colspan="3"></td></tr>
                                        <tr height="25"><td class="cart_d">&nbsp;&nbsp;<?= $variedad." ".$pres?></td><td colspan="4">&nbsp;</td></tr>
                                        <tr><td><img src="images/producto_separador.png"></td><td colspan="3"></td></tr>
                                        <tr height="30">
                                            <td width="35%" class="cart_p">&nbsp;&nbsp;$&nbsp;<?= $rs['precio']?></td>
                                            <td width="15%">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr valign="top">
                                                        <td width="46%" align="right"><? if($qty/$unidades > 1){?><a href="<?= $_SERVER['PHP_SELF']?>?enviar=ok&id_producto=<?= $id_producto?>&unidades=<?= $rs['unidades']?>&action=disminuir" title="Sacar una unidades del carrito"><img src="images/send_no.png" border="0"></a><? }?></td>
                                                        <td width="8%"></td>
                                                        <td width="46%" align="left"><a href="<?= $_SERVER['PHP_SELF']?>?enviar=ok&id_producto=<?= $id_producto?>&unidades=<?= $rs['unidades']?>&action=add" title="Agregar una unidades al carrito"><img src="images/send_ok.png" border="0"></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="20%" class="cart_p" align="center"><?= $qty/$unidades?></td>
                                            <td width="20%" class="cart_p" align="right">$&nbsp;<?= number_format($rs['precio']*$qty/$unidades, 2, ",", ".")?></td>
                                            <td width="10%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?<?= (sizeof($contents) > 1) ? "enviar=ok" : "enviar=";?>&action=delete&id_producto=<?= $id_producto?>" title="Eliminar este preoducto del carrito" onClick="javascript: return confirm('Estas seguro que queres eliminar este preducto del carrito?')"><img src="images/cart_eliminar.png" border="0"></a></td>
                                        </tr>
                                        <tr height="1"><td colspan="5" background="images/cart_separador.png"></td></tr>
                                    </table>
                                </td>
                            </tr>
                        <? }?>
    <? }?>					
                        <tr height="10"><td></td></tr>
                        <tr height="2">
                            <td></td>
                            <td colspan="2" bgcolor="#5c1428"></td>
                        </tr>
                        <tr height="10"><td></td></tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr height="25">
                                        <td width="50%" class="cart_p" colspan="2">Total a pagar:</td>
                                        <td width="20%" class="cart_p" align="center"><?= $total_qty_envio?></td>
                                        <td width="20%" class="cart_p" align="right">$&nbsp;<?= number_format($total_envio, 2, ",", ".")?></td>
                                        <td width="10%"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr height="20"><td></td></tr>
    <? 
    $prod_mail .= "<tr height='1'><td colspan='6' bgcolor='#000000'></td></tr><tr height='30'><td colspan='3'><b>TOTAL</b></td><td align='center'><b>".number_format($total_qty_envio, 0, ',', '.')."</b></td><td align='center'>&nbsp;</td><td align='center'><b>$&nbsp;".number_format($total_envio, 2, ',', '.')."</b></td></tr><tr height='30'><td colspan='7'></td></tr></table>";
    $nro_pedido = date("dm-His");
    //echo("Nro: ".$nro_pedido);
    if($_REQUEST["boton"] == "Enviar"){
        $status="no";
        $status = $_POST["status"];
		$to_cart = "ventas@acordessa.com";
        //$to_cart = "bonadeo@fibertel.com.ar";
        
        $subject_cart = "|| ACORDES SA - PEDIDO ||";
        $name_cart = $_POST["name_cart"];
        $apellido_cart = $_POST["apellido_cart"];
        $cliente_cart = $name_cart." ".$apellido_cart;
        $telefono_cart = $_POST["telefono_cart"];
        $celular_cart = $_POST["celular_cart"];
        $direccion_cart = $_POST["direccion_cart"];
        $mail_cart = $_POST["mail_cart"];
        $mensaje_cart = $_POST["mensaje_cart"];
        
        $message_cart = "<p>Cliente: $name_cart $apellido_cart
                        <br>Telefono: $telefono_cart
                        <br>Celular: $celular_cart
                        <br>Direccion: $direccion_cart
                        <br>E-Mail: $mail_cart</p>";
        $message_cart .="<br><b>Comentarios:</b>&nbsp;&nbsp;$mensaje_cart<br><br>";
        $message_cart .="<br><b>Numero de Pedido:</b>&nbsp;&nbsp;$nro_pedido<br><br>";
        $message_cart .= $prod_mail;
    
        // FUNCION MAILER
        $mail = new phpmailer(); 
        $mail->PluginDir = "includes/"; 
        $mail->Mailer = "smtp"; 
        $mail->Host = "127.0.0.1"; 
			
		$mail->SMTPAuth = true;
        $mail->Username = "ventas@acordessa.com"; 
        $mail->Password = "vale11"; 
        
        $mail->From = $mail_cart; 
        $mail->FromName = $cliente_cart." - PEDIDO";
        $mail->AddReplyTo($mail_cart, $cliente_cart);
        $mail->Timeout = 80; 
        
        $mail->Subject = $subject_cart; 
        $mail->Body = $message_cart; 
        $mail->IsHTML(True); 
    
        $mail->AddAddress($to_cart); 
    
        if($status == "ok" && $_POST["boton"] == "Enviar"){
            if ($mail_cart != ""){ 
                $send = "ok";
            }else{ 
                $send = "no";
                $envio_pedido = "no";
            }
        }
        if($send == "ok"){	
            $exito = $mail->Send(); 
           
           if(!$exito){ 
                echo "<br/>".$mail->ErrorInfo; 
           }
        }	 
         $mail->ClearAddresses();  // Eliminas los e-mails que tengas acomulados. 
    
        if($envio_pedido == "ok"){
            $subject_cart_reply = "Confirmacion del Pedido";
            $message_cart_reply = "<b>Hemos recibido su pedido correctamente.</b>
                                    <br>Nos contactaremos con usted a la brevedad.
                                    <br><br><b>Datos personales:</b><br>
                                    <br><b>Cliente:</b> $name_cart $apellido_cart
                                    <br><b>Telefono:</b> $telefono_cart
                                    <br><b>Celular:</b> $celular_cart
                                    <br><b>Direccion:</b> $direccion_cart
                                    <br><b>E-Mail:</b> $mail_cart";
            $message_cart_reply .="<br><b>Comentarios:</b>&nbsp;&nbsp;$mensaje_cart<br><br>";
            $message_cart_reply .="<br><b>Numero de Pedido:</b>&nbsp;&nbsp;$nro_pedido<br><br>";
            $message_cart_reply .= "<br><b>Datos de su pedido:</b><br><br>";
            $message_cart_reply .= $prod_mail;
            $message_cart_reply .= "<br><br><br>Verifique sus datos y la informacion del pedido. De haber algun error comuniquese con nosotros via <a href='mailto:ventas@vinosacasa.com.ar'>mail</a> o por teléfono al 154-980-1397.";
    
            $mail = new phpmailer(); 
            $mail->PluginDir = "includes/"; 
            $mail->Mailer = "smtp"; 
			$mail->Host = "127.0.0.1"; 
				
			$mail->SMTPAuth = true;
			$mail->Username = "ventas@acordessa.com"; 
			$mail->Password = "vale11";  
            
            $mail->From = $to_cart; 
            $mail->FromName = "Acordes SA";
            $mail->AddReplyTo($to_cart, "Acordes SA");
            $mail->Timeout = 80; 
            
            $mail->Subject = $subject_cart_reply; 
            $mail->Body = $message_cart_reply; 
            $mail->IsHTML(True); 
        
            $mail->AddAddress($mail_cart);
            $exito = $mail->Send(); 
           
            if(!$exito){ 
                echo "<br/>".$mail->ErrorInfo; 
            }
             $mail->ClearAddresses();  // Eliminas los e-mails que tengas acomulados. 
        }
    }
    ?>
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <form action="<?= $_SERVER['PHP_SELF']?>?enviar=ok" name="form" method="post">
                                    <input type="hidden" name="boton" value="Enviar">
                                    <input type="hidden" name="status" value="ok">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr height="10"><td colspan="3"></td></tr>
                                        <tr height="40"><td>&nbsp;</td>
                                            <td colspan="3">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr valign="left">
                                                        <td width="45%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="100" align="right"><img src="images/hojas.png"></td>
                                                                    <td width="10">&nbsp;</td>
                                                                    <td class="titulos">Envianos tu pedido</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <? if($envio_pedido == "ok"){?>
                                                            <td width="5%"><img src='images/send_ok.png'></td>
                                                            <td width="50%" class="cart_t">El pedido se ha enviado correctamente.</td>
                                                        <? }?>												
                                                        <? if($envio_pedido == "no"){?>
                                                            <td width="5%"><img src='images/send_no.png'></td>
                                                            <td width="50%" class="cart_t">El pedido no pudo ser enviado.</td>
                                                        <? }?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr height="25">
                                            <td width="5%">&nbsp;</td>
                                            <td width="25%" class="cart_t" align="right" style="padding: 0 20 0 0;">Nombre</td>
                                            <td width="75%"><input type="text" name="name_cart" value="<?= $name_cart?>" size="50" class="cart_input"></td>
                                        </tr>
                                        <tr height="25">
                                            <td>&nbsp;</td>
                                            <td class="cart_t" align="right" style="padding: 0 20 0 0;">Apellido</td>
                                            <td><input type="text" name="apellido_cart" value="<?= $apellido_cart?>" size="50" class="cart_input"></td>
                                        </tr>
                                        <tr height="25">
                                            <td>&nbsp;</td>
                                            <td class="cart_t" align="right" style="padding: 0 20 0 0;">Telefono</td>
                                            <td><input type="text" name="telefono_cart" value="<?= $telefono_cart?>" size="50" class="cart_input"></td>
                                        </tr>
                                        <tr height="25">
                                            <td>&nbsp;</td>
                                            <td class="cart_t" align="right" style="padding: 0 20 0 0;">Celular</td>
                                            <td><input type="text" name="celular_cart" value="<?= $celular_cart?>" size="50" class="cart_input"></td>
                                        </tr>
                                        <tr height="25">
                                            <td>&nbsp;</td>
                                            <td class="cart_t" align="right" style="padding: 0 20 0 0;">Direccion</td>
                                            <td><input type="text" name="direccion_cart" value="<?= $direccion_cart?>" size="50" class="cart_input"></td>
                                        </tr>
                                        <tr height="25">
                                            <td>&nbsp;</td>
                                            <td class="cart_t" align="right" style="padding: 0 20 0 0;">E-mail</td>
                                            <td><input type="text" name="mail_cart" value="<?= $mail_cart?>" size="50" class="cart_input"></td>
                                        </tr>
                                        <tr height="15"><td colspan="3"></td></tr>
                                        <tr height="30" valign="top">
                                            <td>&nbsp;</td>
                                            <td class="cart_t" align="right" style="padding: 0 20 0 0;">Comentario</td>
                                            <td><textarea name="mensaje_cart" cols="52" rows="5" class="cart_input"><?= $mensaje_cart?></textarea></td>
                                        </tr>
                                        <tr height="20"><td colspan="3"></td></tr>
                                        <tr><td colspan="3" align="center"><input type="image" src="images/btn_send_pedido.png" title="Enviar el Mensaje"></td></tr>
                                        <tr height="15"><td colspan="3"></td></tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr height="20"><td></td></tr>
        <? }else{ // si no hay productos?>
            <tr height="20"><td></td></tr>
            <tr height="30">
                <td class="cart_t">No hay ningun producto en el carrito.</td>
            </tr>
        <? } // cierro el if de si hay productos?>
    </table>
	
<? }?>
					  <!-- InstanceEndEditable -->		
					</td>
				</tr>
				<tr>
					<td>
					<?
					$menu = filemtime("menu.swf");
					$url_menu = "menu.swf?last_modified=" . date("Y-m-d-G:i:s", $menu);
					?>
						<script src="writeObject.js" language="JavaScript"></script>
						<script language="JavaScript" type="text/JavaScript">
							var strAux = '';
							strAux += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="800" height="72" align="top">';
								  strAux += '<param name="movie" value="<?=$url_menu?>"?>';
								  strAux += '<param name=quality value=high>';
								  strAux += '<param name=FlashVars value="<?= $pag?>">'					  
								  strAux += '<param name="LOOP" value="false">';
								  strAux += '<param name="menu" value="false">';
								  strAux += '<param name="bgcolor" value="#E5E8DF"/>';
								  strAux += '<embed src="<?=$url_menu?>" FlashVars="<?= $pag?>" quality="high" bgcolor="#E5E8DF" width="800" height="72" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>';
							strAux += '</object>';
							writeObject(strAux);
						</script>		
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
<!-- InstanceEnd --></html>
