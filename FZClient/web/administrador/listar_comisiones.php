<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");


?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script language="javascript" src="calendar1.js"></script>
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
<script type="text/javascript" src="includes/jquery.dataTables.js" language="javascript"></script>
<style type="text/css" title="currentStyle">
	@import "includes/demo_page.css";
	@import "includes/demo_table_jui.css";
	@import "includes/jquery-ui-1.7.2.custom.css";
</style>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"iDisplayLength" : 100,
			"aaSorting": [[0, "desc"]]
		});
	} );
</script>
<p class="error" align="center"><?=$msg?></p><br>

<? 
if(!empty($_REQUEST['acc'])){
	$acc = $_REQUEST['acc'];
	$id_venta = $_REQUEST['id_venta'];
	$q = query("SELECT * FROM ventas WHERE id_venta = $id_venta");
	$rs = mysql_fetch_array($q);
	$n_remito = $rs['n_remito'];
	$f_remito = rotarFecha($rs['f_remito']);
	$n_factura = $rs['n_factura'];
	$f_factura = rotarFecha($rs['f_factura']);
?>
	<form name="formu" action="<?= $_SERVER['PHP_SELF']."?".ahora()?>" method="post">
        <table width="400" align="center" cellpadding="0" cellspacing="0" border="0">
        	<tr height="40"><td colspan="2" class="titulo">Numero de Remito</td></tr>
            <tr height="40">
                <td class="t" width="40%" align="center">Fecha</td>
                <td class="t" width="60%" align="center">Numero</td>
            </tr>
            <tr height="40">
                <td class="c1" align="center"><? agregarFecha("f_remito", $f_remito)?></td>
                <td class="c1" align="center"><input type="text" name="n_remito" value="<?= $n_remito?>" size="25" class="textToolBar"></td>
            </tr>
        	<tr height="40"><td colspan="2" class="titulo">Numero de Factura</td></tr>
            <tr height="40">
                <td class="t" width="40%" align="center">Fecha</td>
                <td class="t" width="60%" align="center">Numero</td>
            </tr>
            <tr height="40">
                <td class="c2" align="center"><? agregarFecha("f_factura", $f_factura)?></td>
                <td class="c2" align="center"><input type="text" name="n_factura" value="<?= $n_factura?>" size="25" class="textToolBar"></td>
            </tr>
            <tr height="20"><td colspan="2"></td></tr>
            <tr>
                <td align="center" colspan="2">
					<input type="hidden" name="agregar" value="agregar_numero">
                    <input type="hidden" name="id_venta" value="<?= $id_venta?>">
					<input type="image" name="enviar2" src="images/b_insert.png" alt="Guardar los datos" onClick="return confirm('Estás seguro que queres guardar los datos?');">&nbsp;&nbsp;
                    <a href="<?= $_SERVER['PHP_SELF']?>?acc="><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a>
                </td>
            </tr>
        </table>
    </form>
<? }else{?>

    <table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr height="30">
            <td width="5%">&nbsp;</td>
            <td width="90%" align="right"><a href="imp_ventas.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir Ventas</a></td>
            <td width="5%">&nbsp;</td>
        </tr>
        <tr height="30"><td class="t">&nbsp;</td><td class="t" align="left">Listado de Comisiones</td><td class="t">&nbsp;</td></tr>
        <tr height="20"><td colspan="3" class="c1"></td></tr>
        <tr height="30">
            <td class="c1">&nbsp;</td>
            <td class="c1">
                <form name="formu" action="<?= $_SERVER['PHP_SELF']."?".ahora()?>" method="post">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <?
                            $buscar = $_REQUEST['buscar'];
                            $fecha_desde = $_REQUEST['fecha_desde'];
                            $fecha_hasta = $_REQUEST['fecha_hasta'];
                            
                            if($fecha_desde == ''){
                                $mes = $_REQUEST['mes'];
                                $ano = $_REQUEST['ano'];
                            }
                            
                            if($buscar == "") $buscar = 1;
                            ?>
                            <td class="c1">&nbsp;</td>
                            <td class="c1" align="right">Filtro de ventas&nbsp;&nbsp;</td>
                            <td class="c1">&nbsp;
                                <select name="buscar" onChange="formu.submit();">
                                    <option value="1" <? if($buscar == 1){echo " SELECTED ";}?>>Mes en Curso</option>
                                    <option value="3" <? if($buscar == 3){echo " SELECTED ";}?>>Años / Meses</option>
                                    <option value="4" <? if($buscar == 4){echo " SELECTED ";}?>>Determinar Fecha</option>
                                </select>
                            </td>
                            <td class="c1">&nbsp;</td>
                            <?
                            if($buscar == 1){
                                $dias = date(d);
                                $resta = -($dias-1);
                            }
                            if($buscar == 3){
                                if($_REQUEST['ano'] == "") $ano = date(Y);
                                if($_REQUEST['mes'] == "") $mes = date(m);
                                ?>
                                <td class="c1" align="right">A&ntilde;o</td>
                                <td class="c1">&nbsp;
                                    <select name="ano" onChange="javascript:formu.submit();">
                                        <option value="0">Todos</option>
                                        <?
                                        $hoy=getdate();
                                        for($a = 2000; $a <= $hoy['year']+1; $a++){
                                        ?>
                                            <option <? if($ano == $a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
                                        <? }?>
                                    </select>
                                </td>
                                <td class="c1">&nbsp;</td>
                                <td class="c1" align="right">Mes</td>
                                <td class="c1">&nbsp;
                                    <select name="mes" onChange="javascript:formu.submit();">
                                        <option value="0">Todos</option>
                                        <option <? if($mes=="1") {echo " SELECTED";} ?> value="1">Enero</option>
                                        <option <? if($mes=="2") {echo " SELECTED";} ?> value="2">Febrero</option>
                                        <option <? if($mes=="3") {echo " SELECTED";} ?> value="3">Marzo</option>
                                        <option <? if($mes=="4") {echo " SELECTED";} ?> value="4">Abril</option>
                                        <option <? if($mes=="5") {echo " SELECTED";} ?> value="5">Mayo</option>
                                        <option <? if($mes=="6") {echo " SELECTED";} ?> value="6">Junio</option>
                                        <option <? if($mes=="7") {echo " SELECTED";} ?> value="7">Julio</option>
                                        <option <? if($mes=="8") {echo " SELECTED";} ?> value="8">Agosto</option>
                                        <option <? if($mes=="9") {echo " SELECTED";} ?> value="9">Septiembre</option>
                                        <option <? if($mes=="10") {echo " SELECTED";} ?> value="10">Octubre</option>
                                        <option <? if($mes=="11") {echo " SELECTED";} ?> value="11">Noviembre</option>
                                        <option <? if($mes=="12") {echo " SELECTED";} ?> value="12">Diciembre</option>
                                    </select>
                                </td>
                                <td class="c1">&nbsp;</td>
                            <?
                            }
                            if($buscar == 4){
                            ?>
                                <td class="c1" width="40">Desde</td>
                                <td class="c1" width="90"><? agregarFecha("fecha_desde", $fecha_desde)?></td>
                                <td class="c1" width="30">&nbsp;</td>
                                <td class="c1" width="40">Hasta</td>
                                <td class="c1" width="90"><? agregarFecha("fecha_hasta", $fecha_hasta)?></td>
                                <td class="c1" width="50">&nbsp;</td>
                                <td class="c1" width="20"><img src="images/b_search.png" onClick="formu.submit();"></td>
                                <td class="c1" width="10">&nbsp;</td>
                            <?
                                $fecha_desde = rotarFecha($fecha_desde);
                                $fecha_hasta = rotarFecha($fecha_hasta);
                            }
                            ?>
                        </tr>
                    </table>
                </form>
            </td>
            <td class="c1">&nbsp;</td>
        </tr>
    </table>
    
    <?
    // RESTO DIAS -----------------
        function restarDias($numdias, $date) {
            if (isset($date)) {
                $date = time();
            }
            list($hora, $min, $seg, $dia, $mes_r, $anno) = explode( " ", date( "H i s d m Y"));
            $d = $dia + $numdias;
            $fecha = date("d-m-Y", mktime($hora, $min, $seg, $mes_r, $d, $anno));
            return $fecha;
        } 
    // -----------------------------
    
    //echo("B: $buscar<br>");
    if($buscar == 1){
        $ano = date(Y);
        $mes = date(m);
    }
    
    if($mes > 0){ 
        $mes_s = " month(fecha)=" . $mes;
        $fecha_d = '';
        $fecha_h = '';
    }
    if($ano > 0){ 
        $ano_s = "year(fecha)=" . $ano;
        $fecha_d = '';
        $fecha_h = '';
        if($mes > 0) $mes_s = $mes_s . " && ";
        if($mes == 0) $ano_s = $ano_s;
    }
    if($fecha_d != "")	$f = " fecha >= '$fecha_d' && fecha <= '$fecha_h'";
    if($f == "--") $f = "";
    
    
    if($_SESSION['admin']!="ok"){
        $vend=" AND v.id_vendedor=". $_SESSION['id_vendedor'];
    }
    $a = date("Y");
    $m = date("m") - 1;
    if($m == 0) $m = 12;
    $d = date("d");
    $filtrar = $a."-".$m."-".$d;
    
    if($f != "" || $mes_s != "" || $ano_s != "" || $vend != "") $w = "WHERE";
    $where = $f." ".$mes_s." ".$ano_s." ".$vend ;
    
    if($buscar == "3") $w_send = "buscar=3&ano=$ano&mes=$mes";
    if($buscar == "4"){
        $w_send = "buscar=4&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta";	
        if(!empty($fecha_desde) AND !empty($fecha_hasta)){
            $where = "fecha BETWEEN '$fecha_desde' AND '$fecha_hasta'";
        }else{
            $where = "fecha = ".date("Y-m-d");
        }
    }
    
    $sql = "SELECT v.id_venta, v.fecha, v.factura, c.id_cliente, c.nombre, c.apellido, sigla, s.nombre AS vendedor, 
            v.id_vendedor, dto_porc, dto_fijo, com_porc, com_fijo, n_remito, f_remito, n_factura, f_factura FROM ventas v 
            INNER JOIN clientes c on c.id_cliente = v.id_cliente 
            INNER JOIN vendedores s on s.id_vendedor = v.id_vendedor 
            WHERE (v.com_porc > 0 || v.com_fijo > 0) AND $where
            ORDER BY fecha DESC, nombre";
    echo $sql."<br><br>";
    $q = query($sql);
	?>
    <table width="90%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td>
                <div id="container">
                    <div class="demo_jui">    
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                            <thead>
                                <tr>
                                    <th class="t" width="10%" align="center">Fecha</th>
                                    <? 	if($_SESSION['admin']=="ok"){?>
                                        <th class="t" width="26%">Cliente</th>
                                        <th class="t" width="7%" align="center">V</th>
                                    <? }else{?>
                                        <th class="t" width="33%" colspan="2">Cliente</th>
                                    <? }?>
                                    <th class="t" width="10%" align="center">Monto</th>
                                    <th class="t" width="7%" align="center">Com</th>
                                    <th class="t" width="10%" align="center">Remito</th>
                                    <th class="t" width="10%" align="center">Factura</th>
                                    <th class="t" width="20%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                
                                while($rs=mysql_fetch_array($q)){
                                    $id_venta = $rs['id_venta'];
                                    $factura = $rs['factura'];
                                    $dto_porc = $rs['dto_porc'];
                                    $dto_fijo = $rs['dto_fijo'];
									$com_porc = $rs['com_porc'];
									$com_fijo = $rs['com_fijo'];
                                    $iva = 1;
                                    //if($factura == 1) $iva = 1.21;
                                    $q2 = query("SELECT SUM(if(regalo = 0, (cant * precio), 0)) AS m_p FROM ventas_detalle WHERE id_venta = $id_venta");
                                    $rs2 = mysql_fetch_array($q2);
									
                                    $monto = (($rs2['m_p'] * (1-$dto_porc/100) - $dto_fijo)	*100)/100;
									$comision = (($monto * ($com_porc / 100) + $com_fijo) * 100) / 100;
                                            
                                    $n = $rs['nombre'];
                                    $a = $rs['apellido'];
                                    if($n != "") $a = $a.", ".$n;
									
                                    $monto_T += $monto;
									$comision_T += $comision;
                                    
									$c = "texto_ventas";
                                    
                                    $n_remito = $rs['n_remito'];
                                    $f_remito = rotarFecha($rs['f_remito']);
                                    $n_factura = $rs['n_factura'];
                                    $f_factura = rotarFecha($rs['f_factura']);
                                    ?>  
                                    <tr height="40">
                                        <td class="<?= $c?>" align="center"><? formatoFecha($rs['fecha'])?></td>
                                        <? 	if($_SESSION['admin']=="ok"){?>
                                            <td class="<?= $c?>" ><?= $a?></td>
                                            <td class="<?= $c?>" align="center"><?= $rs['sigla']?></td>
                                        <? }else{?>
                                            <td class="<?= $c?>" colspan="2"><?= $a?></td>
                                        <? }?>
                                        <td class="<?= $c?>" align="center">$<?= number_format($monto,2,'.',',')?></td>
                                        <td class="<?= $c?>" align="center"><?= $comision > 0 ? "$".number_format($comision,2,'.',',') : ""?></td>
                                        <td align="center" title="<?= !empty($n_remito) ? $f_remito : ""?>">
                                            <a href="<?= $_SERVER['PHP_SELF']?>?acc=a_factura&id_venta=<?=$rs['id_venta']?>" class="link_ventas">
                                            <? if(empty($n_remito)){?>
                                                <img src="images/add.png" border="0" title="Agregar numero de remito">
                                            <? }else{
                                                echo($n_remito);
                                            }?>
                                            </a>
                                        </td>
                                        <td class="<?= $c?>" align="center" title="<?= !empty($n_factura) ? $f_factura : ""?>">
                                            <a href="<?= $_SERVER['PHP_SELF']?>?acc=a_factura&id_venta=<?=$rs['id_venta']?>" class="link_ventas">
                                            <? if(empty($n_factura)){?>
                                                <img src="images/add.png" border="0" title="Agregar numero de factura">
                                            <? }else{
                                                echo($n_factura);
                                            }?>
                                            </a>
                                        </td>
                                        <td class="<?= $c?>" align="center">
                                            <a href="imp_nota.php?id_venta=<?=$rs['id_venta']?>&factura=<?= $factura?>" target="_blank"><img src="images/b_nota.png" border="0" title="Imprimir la nota de pedido de la venta"></a>&nbsp;&nbsp;
                                            <a href="imp_remito.php?id_venta=<?=$rs['id_venta']?>" target="_blank"><img src="images/b_remito.png" border="0" title="Imprimir el remito de la venta"></a>&nbsp;&nbsp;
                                            <a href="imp_factura.php?id_venta=<?=$rs['id_venta']?>&factura=<?= $factura?>" target="_blank"><img src="images/b_factura.png" border="0" title="Imprimir la factura de la venta"></a>&nbsp;&nbsp;
                                            <a href="ventas_detalle.php?id_venta=<?=$rs['id_venta']?>&id_cliente=<?=$rs['id_cliente']?>"><img src="images/b_ver.png" border="0" title="Ver detalle de la venta"></a>&nbsp;&nbsp;
                                            <a href="<?= $_SERVER['PHP_SELF']?>?eliminar=ok&id_venta=<?=$rs['id_venta']?>&<?= $w_send?>"><img src="images/b_borrar.png" border="0" title="Eliminar la venta"></a>
                                        </td>
                                    </tr>
                                <? }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
	<? if($OLD){?>		
		<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr height="40">
				<td class="t" width="10%" align="center">Fecha</td>
				<? 	if($_SESSION['admin']=="ok"){?>
					<td class="t" width="25%">Cliente</td>
					<td class="t" width="5%" align="center">Vendedor</td>
				<? }else{?>
					<td class="t" width="30%" colspan="2">Cliente</td>
				<? }?>
				<td class="t" width="10%" align="center">Monto</td>
				<td class="t" width="10%" align="center">Remito</td>
				<td class="t" width="10%" align="center">Factura</td>
				<td class="t" width="20%">&nbsp;</td>
			</tr>
			<?
			
			while($rs=mysql_fetch_array($q)){
				$id_venta = $rs['id_venta'];
				$factura = $rs['factura'];
				$dto_porc = $rs['dto_porc'];
				$dto_fijo = $rs['dto_fijo'];
				$iva = 1;
				//if($factura == 1) $iva = 1.21;
				$q2 = query("SELECT SUM(if(regalo = 0, (cant * precio), 0)) AS m_p FROM ventas_detalle WHERE id_venta = $id_venta");
				$rs2 = mysql_fetch_array($q2);
				
				$monto = (($rs2['m_p'] * (1 - $dto_porc / 100) - $dto_fijo)	* 100) / 100;
				
				$n = $rs['nombre'];
				$a = $rs['apellido'];
				if($n != "") $a = $a.", ".$n;
				$monto_T += $monto;
				
				$c = $flag ? "c1":"c2";
				$flag = !$flag;
				
				$n_remito = $rs['n_remito'];
				$f_remito = rotarFecha($rs['f_remito']);
				$n_factura = $rs['n_factura'];
				$f_factura = rotarFecha($rs['f_factura']);
				?>  
				<tr height="40">
					<td class="<?= $c?>" align="center"><? formatoFecha($rs['fecha'])?></td>
					<? 	if($_SESSION['admin']=="ok"){?>
						<td class="<?= $c?>" ><?= $a?></td>
						<td class="<?= $c?>" align="center"><?= $rs['sigla']?></td>
					<? }else{?>
						<td class="<?= $c?>" colspan="2"><?= $a?></td>
					<? }?>
					<td class="<?= $c?>" align="center">$<?= number_format($monto,2,'.',',')?></td>
					<td class="<?= $c?>" align="center" title="<?= !empty($n_remito) ? $f_remito : ""?>">
						<a href="<?= $_SERVER['PHP_SELF']?>?acc=a_factura&id_venta=<?=$rs['id_venta']?>" class="numero">
						<? if(empty($n_remito)){?>
							<img src="images/b_a_remito.png" border="0" title="Agregar numero de remito">
						<? }else{
							echo($n_remito);
						}?>
						</a>
					</td>
					<td class="<?= $c?>" align="center" title="<?= !empty($n_factura) ? $f_factura : ""?>">
						<a href="<?= $_SERVER['PHP_SELF']?>?acc=a_factura&id_venta=<?=$rs['id_venta']?>" class="numero">
						<? if(empty($n_factura)){?>
							<img src="images/b_a_factura.png" border="0" title="Agregar numero de factura">
						<? }else{
							echo($n_factura);
						}?>
						</a>
					</td>
					<td class="<?= $c?>" align="center">
						<a href="imp_nota.php?id_venta=<?=$rs['id_venta']?>&factura=<?= $factura?>" target="_blank"><img src="images/b_nota.png" border="0" title="Imprimir la nota de pedido de la venta"></a>&nbsp;&nbsp;
						<a href="imp_remito.php?id_venta=<?=$rs['id_venta']?>" target="_blank"><img src="images/b_remito.png" border="0" title="Imprimir el remito de la venta"></a>&nbsp;&nbsp;
						<a href="imp_factura.php?id_venta=<?=$rs['id_venta']?>&factura=<?= $factura?>" target="_blank"><img src="images/b_factura.png" border="0" title="Imprimir la factura de la venta"></a>&nbsp;&nbsp;
						<a href="ventas_detalle.php?id_venta=<?=$rs['id_venta']?>&id_cliente=<?=$rs['id_cliente']?>"><img src="images/b_ver.png" border="0" title="Ver detalle de la venta"></a>&nbsp;&nbsp;
						<a href="<?= $_SERVER['PHP_SELF']?>?eliminar=ok&id_venta=<?=$rs['id_venta']?>&<?= $w_send?>"><img src="images/b_borrar.png" border="0" title="Eliminar la venta"></a>
					</td>
				</tr>
			<? }?>
			<tr height="30">
				<td class="t" colspan="<?= $_SESSION['admin']=="ok" ? 3 : 2?>">&nbsp;</td>
				<td class="t" align="center">$<?= number_format($monto_T,2,'.',',')?></td>
                <td class="t" align="center">$<?= number_format($comision_T,2,'.',',')?></td>
				<td class="t" colspan="3">&nbsp;</td>
			</tr>
		</table>
	<? } // CIERRO EL OLD?>
<? }?>
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
