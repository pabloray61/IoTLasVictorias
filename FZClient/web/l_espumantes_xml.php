<?
include ("administrador/conn.php");

header('Cache-Control: no-cache');
header('Pragma: no-cache');
header ("content-type: text/xml");
echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
?>

<productos>
	<?
	$q = query ("SELECT p.id_producto, pc.id_categoria, pc.categoria, pl.linea, pv.variedad, pv.sigla, pp.presentacion, pp.unidades, pp.volumen, p.orden, pr.precio
				FROM productos p
				INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
				INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
				INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
				INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
				INNER JOIN precios pr ON pr.id_producto = p.id_producto
				WHERE p.id_categoria = 2 AND pr.id_lista = 9 ORDER BY orden");
	while ( $b = mysql_fetch_array ($q) ){ 
		$categoria = $b['categoria'];
		$linea = $b['linea'];
		if($linea == "SINFONIA SV") $linea = "SV";
		if($linea == "SINFONIA ROBLE") $linea = "Roble";
		$variedad = " - ".$b['variedad'];
		$sigla = $b['sigla'];
		$presentacion = $b['presentacion']." (".$b['unidades']." x ". $b['volumen']." ml.)";
		
		if($variedad == " - Todas") $variedad = "";
		
		$producto = $linea." - ".$sigla." - ". $presentacion;
	?>
		<producto titulo='<?= $producto?>'>
			<id_prod><?= "A".$b['id_producto'] ?></id_prod>
			<nombre><?= $b['linea']?></nombre>
			<material><?= $producto?></material>
			<foto><?= getPicUrl("A".$b['id_producto'])?></foto>
			<precio><?= $b['precio']?></precio>
		</producto>
	<? }?> 	
</productos>