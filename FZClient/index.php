<!DOCTYPE html>
<?
$_SESSION['mensaje'] = '';

$accion = $_REQUEST['accion'];
$direccion = '';

if($accion == 'newsletter' AND $_REQUEST['boton'] == 'ENVIAR'){
	$reg_name = $_REQUEST['reg_nombreyapellido'];
	$reg_mail = $_REQUEST['reg_mail'];
	$reg_mail2 = $_REQUEST['reg_mailconfirmacion'];
	
	$content = "Nombre y Apellido: ".$reg_name."<br>Mail: ".$reg_mail;
	
	$subject = 'Suscripcion al Newsletter';
	$mensaje_ok = 'Muchas gracias, la solicitud fue enviada.';
	
	if(!empty($reg_mail) AND $reg_mail == $reg_mail2){
		$direccion = 'ok';
	}
		
}
if($accion == 'contacto' AND $_REQUEST['boton'] == 'ENVIAR'){
	$reg_name = $_REQUEST['contacto_nombreyapellido'];
	$reg_mail = $_REQUEST['contacto_mail'];
	$reg_mail2 = $_REQUEST['contacto_mail2'];
	$reg_consulta = $_REQUEST['contacto_consulta'];
	
	$content = "Nombre y Apellido: ".$reg_name."<br>
				Mail: ".$reg_mail."<br><br><br>
				<strong>Comentario:</strong><br>".$reg_consulta;
	
	$subject = 'Consulta desde la Web';
	$mensaje_ok = 'Su consulta ha sido enviada correctamente.';
	
	if(!empty($reg_mail) AND $reg_mail == $reg_mail2){
		$direccion = 'ok';
	}
}

if($_REQUEST['boton'] == 'ENVIAR' AND $direccion == 'ok'){ // ENVIO EL MAIL
	
	require_once('includes/class.phpmailer.php');

	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->Host     = 'acordeswines.com';
	$mail->SMTPAuth = 'info@acordeswines.com';
	$mail->Username = 'info@acordeswines.com';
	$mail->Password = 'Info2012';
	$mail->CharSet = "UTF-8";

	$mail->From     = $reg_mail;
	$mail->FromName = $reg_name;
	
	$to = 'info@acordeswines.com';
	$mail->AddAddress($to);
	
	$mail->WordWrap = 0;
	$mail->IsHTML(true);
	$mail->Subject 	= $subject;
	$mail->Body    	= "<div>" . $content . "</div>";
	$mail->AltBody 	= $content;

	if ($mail->Send()) {
		$_SESSION['mensaje'] = $mensaje_ok;
	} else {
		$_SESSION['mensaje'] = 'El mensaje no pudo ser enviado.';
	}
}
?>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Acordes</title>
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/none-block.js"></script>
	</head>
	<body>
    	
		<? 
		if(!empty($_SESSION['mensaje'])){
			echo("<script>alert('" . $_SESSION['mensaje'] . "')</script>");
			$_SESSION['mensaje'] = '';
			header('Location: http://www.acordeswines.com/');
		}
		?>
        <? if(empty($_REQUEST['mayores'])){?>
            <div id="content-inicio">
                <div>
                    <h6>Para ingresar debes ser mayor de 18 años</h6>
                    <a href="#" onclick="$('#content-inicio').fadeOut();">INGRESAR</a>
                    <img src="img/inicio-logo.png">
                    <p>Beber con moderación. Prohibida su venta a menores de 18 años</p>
                </div>
            </div>
		<? }?>
		<div id="wrapper">
			<div id="header">
				<div id="header-userpanel" onClick="displaynavreg ('content-reg');">   
                	Newsletter<br>
                    <a href="#" id="n8" onclick="displaynavreg ('content-reg');">Registrarse aqui</a>
				</div>
                <img id="header-acordes" src="img/header-acordes.png" onclick="displaynav ('content-home', 'n1');"></img>
				<a href="http://www.facebook.com/SinfoniaWines" target="_blank" style="cursor:pointer;"><img id="header-facebook" src="img/header-facebook.png" border="0" width="104" height="38"></img></a>
            </div>
			<div id="nav">
				<div id="nav-inner">
					<ul>
						<li><a id="n1" onclick="displaynav ('content-home', 'n1');">HOME</a></li>
						<li><a id="n2" onclick="displaynav ('content-nuestracava', 'n2'); document.getElementById('content-nuestracava-home').style.display='block';">NUESTRA CAVA</a></li>
						<li><a id="n5" onclick="displaynav ('content-tupungato', 'n5');">TUPUNGATO</a></li>
						<li><a id="n4" onclick="displaynav ('content-ventas', 'n4'); document.getElementById('content-ventas-home').style.display='block';">VENTAS</a></li>
						<li><a id="n3" onclick="displaynav ('content-lifestyle', 'n3');">LIFESTYLE</a></li>
						<li><a id="n6" onclick="displaynav ('content-contacto', 'n6');">CONTACTO</a></li>
					</ul>
				</div>
			</div>
			<div id="content">
				<!-- HOME -->
				<!--     -->
				<div id="content-home" style="display: block;">
					<div id="content-home-banner">
						<img src="img/home_foto.jpg">
						<div  id="content-home-banner-text">
							<p style="margin-top: 155px; font-size: 14px; font-family: 'DIN Engschrift Std'; color: #AEA83B;">MENDOZA · ARGENTINA</p>
							<p style="margin-top: 5px; font-size: 15px; font-family: 'FilosofiaOT-Regular'; color: #EEECD5; line-height:1.2;">Acordes nace en el año 2004 con el objetivo de elaborar y comercializar bebidas para su venta en el mercado local y de exportación. <br>
								Nuestra filosofía empresarial corresponde perfectamente al concepto de “ACORDES”, es decir dos o mas notas sonando al mismo tiempo.<br>
								Línea de vinos que reflejan identidad, carácter y expresión. El desafío y la búsqueda de calidad son una constante en nuestro proceso de creación.</p>
							<p style="margin-top: 5px; font-size: 18px; font-family: 'DIN Engschrift Std'; color: #EEECD5;">BIENVENIDOS A ACORDES</p>
							<p style="margin-top: 0px; font-size: 19px; font-family: 'FilosofiaOT-Italic'; color: #AEA83B;">· Gente sonando al unísono ·</p>
						</div>
					</div>
                    <img src="img/home_sinfonia.png" style="position: absolute; top: 82px; display: block; left: 30px;">
					<img src="img/ribbon-left.png" id="ribbon-left">
					<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
					<div id="content-home-smalls">
						<div class="content-home-smalls-img" style="left: -15px; cursor: pointer;"><img src="img/smalls-img1.png" onclick="displaynav ('content-lifestyle', 'n3');"></div>
						<div class="content-home-smalls-img" style="cursor: pointer;"><img src="img/smalls-img2.png" onclick="displaynav ('content-tupungato', 'n5');"></div>
						<div class="content-home-smalls-img">
							<p>A cierta altura de los Andes y de cara a los picos mas elevados de la cordillera, encontramos nuestro <em>terroir</em>. Sesenta hectáreas de privilegiado microclima e incomparables visuales hacen de Tupungato, Valle de Uco el sitio ideal para desarrollar nuestro proyecto. <br>
								Un lugar único y privilegiado para conjugar a los verdaderos protagonistas: los viñedos, la música y la cordillera.</p>
						</div>
					</div>
				</div>

				<!-- NUESTRA CAVA -->
				<!--     -->
				<div id="content-nuestracava" style="display: none;">
					<!-- HOME -->
					<div id="content-nuestracava-home" style="display: block">
						<div class="content-up-banner"><img src="img/nuestraCava_foto.jpg"></div>
						<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
						<div id="content-nuestracava-home-vinosespumantes">
							<div id="content-nuestracava-home-vinos">
								<div class="subtitle">VINOS</div>
								<div id="content-nuestracava-home-vinos-nav" style="top: 30px;">
									<ul>
										<li><a>· ·</a></li>
                                        <li><a onclick="vinosvinos ('content-nuestracava-vinos-selectedvineyards'); activevinosespumantes ('N01'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-sv.jpg';">SELECTED VINEYARDS</a></li>
										<li><a>·</a></li>
										<li><a onclick="vinosvinos ('content-nuestracava-vinos-roble'); activevinosespumantes ('N07'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-re.jpg';">ROBLE</a></li>
										<li><a>·</a></li>
										<li><a onclick="vinosvinos ('content-nuestracava-vinos-reserva'); activevinosespumantes ('N11'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-ro.jpg';">RESERVA</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<p></p>
							</div>
							<div id="content-nuestracava-home-espumantes">
								<div class="subtitle">CHAMPAÑA</div>
								<div id="content-nuestracava-home-espumantes-nav" style="top: 30px;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="N04" onclick="espumantesespumantes ('content-nuestracava-espumantes-extraburt'); activevinosespumantes ('N12'); activevinosespumantes2 ('A04');">METODO CHARMAT</a></li>
										<li><a>·</a></li>
										<li><a id="N05" onclick="espumantesespumantes ('content-nuestracava-espumantes-brutnature'); activevinosespumantes ('N15'); activevinosespumantes2 ('A04');">METODO CHAMPENOISE</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<p></p>
							</div>
						</div>
					</div>
					
                    <?
                    $fichaSVmalbec = '15SV-MALBEC.jpg';
					$fichaSVcab = '15SV-CAB.jpg';
					$fichaSVchar = '15SV-CHAR.jpg';
					
					$fichaRmalbec = '15R-MALBEC.jpg';
					$fichaRchar = '15R-CHAR.jpg';
					
					$fichaREmalbec = '15RE-MALBEC.jpg';
					
					$fichaEBesp = '15EB-ESP.jpg';
					
					$fichaBNesp = '15BN-ESP.jpg';
					?>
					<!-- VINOS -->
					<div id="content-nuestracava-vinos" >
						<div class="content-nuestracava-vinosespumantes-nav">
							<ul>
								<li><a id="A01" onclick="vinos ('content-nuestracava-vinos'); activevinosespumantes ('N01'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-sv.jpg';">VINOS</a></li>
								<li><a id="A02" onclick="espumantes ('content-nuestracava-espumantes'); activevinosespumantes ('N12'); activevinosespumantes2 ('A04');">CHAMPAÑA</a></li>
							</ul>
						</div>
						<div class="content-up-banner" style="margin-top: 0;"><img id="vinosbanner" src="img/vinos-banner-sv.jpg"></div>
						<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
						
						<div class="content-nuestracava-content">
							
							<!-- VINOS-SELECTEDVINEYARDS -->
							<div id="content-nuestracava-vinos-selectedvineyards">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>VINOS · </h6><p>SELECTED VINEYARDS</p></div></div>
								<div class="content-nuestracava-nav" style="margin: 0;">
									<ul>
	                                    <li><a>· ·</a></li>
										<li><a id="N01" onclick="vinosvinos ('content-nuestracava-vinos-selectedvineyards'); activevinosespumantes ('N01'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-sv.jpg';">SELECTED VINEYARDS</a></li>
										<li><a>·</a></li>
										<li><a id="N02" onclick="vinosvinos ('content-nuestracava-vinos-roble'); activevinosespumantes ('N07'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-re.jpg';">ROBLE</a></li>
										<li><a>·</a></li>
										<li><a id="N03" onclick="vinosvinos ('content-nuestracava-vinos-reserva'); activevinosespumantes ('N11'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-ro.jpg';">RESERVA</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<div class="content-nuestracava-text">
									<p style="margin-bottom:30px;">Una línea de vinos varietales jóvenes con personalidad proveniente de añejos viñedos situados al pie de la Cordillera de los Andes y de un moderno proceso de elaboración.  Se caracterizan por un suave paso por madera y se presentan en tres variedades:</p>
								</div>
								<div class="content-nuestracava-vinos-tipos" style="margin-left:10px;">
									<div class="borde">
										<p class="sinfonia">SINFONIA SV</p>
										<p class="titulo">MALBEC</p>
										<p class="parrafo">De intenso color rojo rubí donde se destacan las notas de ciruela y frambuesa. Ideal para acompañar carnes rojas y pasta.</p>
										<a href="img/fichas/<?=$fichaSVmalbec?>" target="_blank">Ver ficha técnica</a>	
									</div>
									<div class="borde" style="width:300px">
										<p class="sinfonia">SINFONIA SV</p>
										<p class="titulo">CABERNET SAUVIGNON</p>
										<p class="parrafo">De intenso color rojo violáceo donde se destacan las notas de pimienta negra y chocolate. Ideal para acompañar carnes rojas y platos sazonados. </p>
										<a href="img/fichas/<?=$fichaSVcab?>" target="_blank">Ver ficha técnica</a>	
									</div>
									<div class="borde">
										<p class="sinfonia">SINFONIA SV</p>
										<p class="titulo">CHARDONNAY</p>
										<p class="parrafo">De color amarillo con reflejos verdes donde se destacan las notas de ananá, manzana verde y frutos tropicales. Ideal para acompañar carnes blancas, risotos y mariscos.</p>
										<a href="img/fichas/<?=$fichaSVchar?>" target="_blank">Ver ficha técnica</a>	
									</div>
								</div>	
							</div>

							<!-- VINOS-ROBLE -->

							<div id="content-nuestracava-vinos-roble">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>VINOS · </h6><p>ROBLE</p></div></div>
								<div class="content-nuestracava-nav" style="margin: 0;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="N06" onclick="vinosvinos ('content-nuestracava-vinos-selectedvineyards'); activevinosespumantes ('N01'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-sv.jpg';">SELECTED VINEYARDS</a></li>
										<li><a>·</a></li>
										<li><a id="N07" onclick="vinosvinos ('content-nuestracava-vinos-roble'); activevinosespumantes ('N07'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-re.jpg';">ROBLE</a></li>
										<li><a>·</a></li>
										<li><a id="N08" onclick="vinosvinos ('content-nuestracava-vinos-reserva'); activevinosespumantes ('N11'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-ro.jpg';">RESERVA</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<div class="content-nuestracava-text">
									<p style="margin-bottom:30px;">Esta linea de vinos se caracteriza por tener un fuerte carácter.  Su paso por madera de roble francés (6 meses de contacto) permite tener un vino de cuerpo intenso y definido.</p>
								</div>
								<div class="content-nuestracava-vinos-tipos">
									<div class="borde" style="width:430px; height:206px;" >
										<p class="sinfonia">SINFONIA ROBLE</p>
										<p class="titulo">MALBEC</p>
										<p class="parrafo">De color rojo profundo con tintes violetas. En nariz se perciben aromas frutales como ciruela y guinda con suaves toques de vainilla aportados por su tiempo de crianza.	</p>
										<a href="img/fichas/<?=$fichaRmalbec?>" target="_blank">Ver ficha técnica</a>	
									</div>
									<div class="borde" style="width:430px; height:206px;" >
										<p class="sinfonia">SINFONIA ROBLE</p>
										<p class="titulo">CHARDONNAY</p>
										<p class="parrafo">Vino de coloración amarillo verdoso bien definido. Aromas a ananá y manzana verde con un toque de roble bien integrado. Boca untuosa de acidez fresca y final largo.</p>
										<a href="img/fichas/<?=$fichaRchar?>" target="_blank">Ver ficha técnica</a>	
									</div>
								</div>
								
							</div>
							<div id="content-nuestracava-vinos-reserva">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>VINOS · </h6><p>RESERVA</p></div></div>
								<div class="content-nuestracava-nav" style="margin: 0;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="N09" onclick="vinosvinos ('content-nuestracava-vinos-selectedvineyards'); activevinosespumantes ('N01'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-sv.jpg';">SELECTED VINEYARDS</a></li>
										<li><a>·</a></li>
										<li><a id="N10" onclick="vinosvinos ('content-nuestracava-vinos-roble'); activevinosespumantes ('N07'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-re.jpg';">ROBLE</a></li>
										<li><a>·</a></li>
										<li><a id="N11" onclick="vinosvinos ('content-nuestracava-vinos-reserva'); activevinosespumantes ('N11'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-ro.jpg';">RESERVA</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<div class="content-nuestracava-text">
									<p style="margin-bottom:30px;">Los vinos SINFONIA RESERVA se caracterizan por su elegancia y crianza en madera, que le transfieren un sabor especial que mejora con el paso de tiempo en estiba.</p>
								</div>
								<div class="content-nuestracava-vinos-tipos">
									<div class="borde" style="margin:0 200px; width:460px; height:203px; border-left-style:double; border-left-width:1px; border-right-width:1px;">
										<p class="sinfonia">SINFONIA RESERVA</p>
										<p class="titulo">MALBEC</p>
										<p class="parrafo">Vino concentrado de rojo intenso. A la nariz se perciben notas especiadas en combinación con frutos sobre maduros. En boca se encuentran taninos aterciopelados y persistentes en armonía con la acidez.</p>
										<a href="img/fichas/<?=$fichaREmalbec?>" target="_blank">Ver ficha técnica</a>
									</div>	
								</div>	
							</div>
						</div>
					</div>

					<!-- CHAMPAÑA -->
					<div id="content-nuestracava-espumantes" style="display: none">
						<div class="content-nuestracava-vinosespumantes-nav">
							<ul>
								<li><a id="A03" onclick="vinos ('content-nuestracava-vinos'); activevinosespumantes ('N01'); activevinosespumantes2 ('A01'); document.getElementById('vinosbanner').src='img/vinos-banner-sv.jpg';">VINOS</a></li>
								<li><a id="A04" onclick="espumantes ('content-nuestracava-espumantes'); activevinosespumantes ('N12'); activevinosespumantes2 ('A04');document.getElementById('espumantesbanner').src='img/es-banner-re.jpg';">ESPUMANTES</a></li>
							</ul>
						</div>
						<div class="content-up-banner" style="margin-top: 0;"><img id="espumantesbanner" src="img/espumantes-banner.jpg"></div>
						<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
						
						<div class="content-nuestracava-content" style="padding: 0; border: 0;">

							<div id="content-nuestracava-espumantes-extraburt">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>CHAMPAÑA · </h6><p>METODO CHARMAT</p></div></div>
								<div class="content-nuestracava-nav" style="margin-left: 0;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="N12" onclick="espumantesespumantes ('content-nuestracava-espumantes-extraburt'); activevinosespumantes ('N12'); activevinosespumantes2 ('A04'); document.getElementById('espumantesbanner').src='img/espumantes-banner.jpg';">METODO CHARMAT</a></li>
										<li><a>·</a></li>
										<li><a id="N13" onclick="espumantesespumantes ('content-nuestracava-espumantes-brutnature'); activevinosespumantes ('N15'); activevinosespumantes2 ('A04'); document.getElementById('espumantesbanner').src='img/espumantes-mc-banner.jpg';">METODO CHAMPENOISE</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<div class="content-nuestracava-text">
									<p style="margin-top: 10px; margin-bottom: 30px;">Partiendo de uvas Chardonnay de zonas privilegiadas de Mendoza, nuestros enólogos combinan sabiduría y tiempo para lograr una propuesta de sabor fresco y finas burbujas.
										Este champagne es elaborado mediante método charmat, con estrictos controles de calidad durante todo el proceso.</p>
								</div>
								<div class="content-nuestracava-vinos-tipos">
									<div class="borde" style="margin-left:200px; width:500px; height:206px;" >
										<p class="sinfonia">SINFONIA CHAMPAÑA</p>
										<p class="titulo">EXTRA BRUT</p>
										<p class="parrafo">De color amarillo pálido con finas y persistentes burbujas que resaltan su cuidadosa elaboración. Su aroma a frutas tropicales proviene de la predominancia de uvas Chardonnay. En boca se presenta fresco y con equilibrada acidez. </p>
										<a href="img/fichas/<?=$fichaEBesp?>" target="_blank">Ver ficha técnica</a>	
									</div>
								</div>
							</div>

							<!--BRUT NATURE-->
							<div id="content-nuestracava-espumantes-brutnature">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>CHAMPAÑA · </h6><p>METODO CHAMPENOISE</p></div></div>
								<div class="content-nuestracava-nav" style="margin-left: 0;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="N14" onclick="espumantesespumantes ('content-nuestracava-espumantes-extraburt'); activevinosespumantes ('N12'); activevinosespumantes2 ('A04'); document.getElementById('espumantesbanner').src='img/espumantes-banner.jpg';">METODO CHARMAT</a></li>
										<li><a>·</a></li>
										<li><a id="N15" onclick="espumantesespumantes ('content-nuestracava-espumantes-brutnature'); activevinosespumantes ('N15'); activevinosespumantes2 ('A04'); document.getElementById('espumantesbanner').src='img/espumantes-mc-banner.jpg';">METODO CHAMPENOISE</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<div class="content-nuestracava-text">
									<p style="margin-top: 10px; margin-bottom: 30px;">
                                    Este champagne es elaborado mediante el METODO CHAMPENOISE, con un tiempo de
									fermentación superior a los 9 meses,
									Durante todo el proceso se ha seguido estrictos controles de calidad, especialmente en el control de la segunda fermentación  la rotación en los pupitres y en el degollado final.</p>
								</div>
								<div class="content-nuestracava-vinos-tipos">
									<div class="borde" style="margin-left:130px; width:630px; height:206px;" >
										<p class="sinfonia">SINFONIA CHAMPAÑA</p>
										<p class="titulo">BRUT NATURE</p>
										<p class="parrafo" style="margin-left:15px; margin-right:15px;">De color amarillo pálido con reflejos dorados y burbujas finas, persistentes. A la nariz se perciben frutas como durazno, manzana y cítricos, con delicados toques de coco y almendra. A la boca es complejo con sabores a levadura y pan tostado, de buena persistencia y equilibrada acidez.</p>
										<a href="img/fichas/<?=$fichaBNesp?>" target="_blank">Ver ficha técnica</a>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				
				<!-- VENTAS -->
				<!--     -->
				<div id="content-ventas" style="display: none;">
					<div id="content-ventas-home">
						<div class="content-up-banner"><img src="img/foto18.jpg"></div>
						<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
						<div id="content-ventas-home-puntoscatalogo">
							<div id="content-ventas-home-puntos">
								<div id="content-ventas-home-puntoscatalogo-titles" class="subtitle">PUNTOS DE VENTA</div>
								<p>Nuestros productos pueden ser ubicados<br>en los siguientes lugares:</p>
								<div class="content-ventas-home-puntoscatalogo-nav">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-restaurants', 'pn1', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto10.jpg';">DISTRIBUIDORES</a></li>
										<li><a>·</a></li>
										<li><a onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-empresas', 'pn3', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto15.jpg';">SUPERMERCADOS</a></li>
                                        <li><a>·</a></li>
										<li><a onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-supermercados', 'pn2', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto1.jpg';">VENTA DIRECTA</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
							</div>
							<div id="content-ventas-home-catalogo">
								<div id="content-ventas-home-puntoscatalogo-titles" class="subtitle">CATALOGO ONLINE</div>
								<p>Nuestros productos pueden ser ubicados<br>en los siguientes lugares:</p>
								<div class="content-ventas-home-puntoscatalogo-nav">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto5.jpg';">VINOS</a></li>
										<li><a>·</a></li>
										<li><a onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-champagne', 'cn5', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto19.jpg';">CHAMPAÑA</a></li>
										<li><a>·</a></li>
										<li><a onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-estuches', 'cn9', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto17.jpg';">ESTUCHES</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
							</div>
						</div>
					</div>
				
					<!-- PUNTOS -->
					<div id="content-ventas-puntos" style="display: none;">
						<div class="content-ventas-puntoscatalogo-nav">
							<ul>
								<li><a id="pcn1a" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-restaurants', 'pn1', 'pcn1a');">PUNTOS DE VENTAS</a></li>
								<li><a id="pcn2a" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b');">CATALOGO ONLINE</a></li>
							</ul>
						</div>
						<div class="content-up-banner" style="margin-top: 0;"><img id="puntosbanner" src="img/foto10.jpg"></div>
						<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
						<div class="content-ventas-puntoscatalogo-content">
							<div id="content-ventas-puntos-restaurants">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>PUNTOS DE VENTA· </h6><p>DISTRIBUIDORES</p></div></div>
									<div class="content-ventas-puntoscatalogo-nav">
										<ul>
                                        	<li><a>· ·</a></li>
											<li><a id="pn1" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-restaurants', 'pn1', 'pcn1a'), activevinosespumantes ('pn1'); document.getElementById('puntosbanner').src='img/foto10.jpg';">DISTRIBUIDORES</a></li>
											<li><a>·</a></li>
											<li><a id="pn3" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-empresas', 'pn9', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto15.jpg';">SUPERMERCADOS</a></li>
											<li><a>·</a></li>
                                            <li><a id="pn2" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-supermercados', 'pn2', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto2.jpg';">VENTA DIRECTA</a></li>
											<li><a>· ·</a></li>
                                        </ul>
									</div>
                                
                                	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                        <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                        <tr>
                                            <td background="img/table-fdo.png">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr align="center">
                                                    	<td width="33%">
                                                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td align="center"><p class="nombre">PASCAL BLANCHOT</p></td></tr>
                                                                <tr><td align="center"><p class="parrafo">Rosario</p></td></tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td align="center"><p class="nombre">DANIEL ALONSO</p></td></tr>
                                                                <tr><td align="center"><p class="parrafo">Buenos Aires Centro</p></td></tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td align="center"><p class="nombre">EZEQUIEL FRAGA</p></td></tr>
                                                                <tr><td align="center"><p class="parrafo">GBA Norte</p></td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr height="30"><td colspan="3"></td></tr>
                                                    <tr align="center">
                                                    	<td width="33%">
                                                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td align="center"><p class="nombre">HUGO KANNEMANN</p></td></tr>
                                                                <tr><td align="center"><p class="parrafo">Comodoro Rivadavia</p></td></tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td align="center"><p class="nombre">CLAUDIO BINO</p></td></tr>
                                                                <tr><td align="center"><p class="parrafo">Córdoba Centro</p></td></tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr><td align="center"><p class="nombre">DANIEL BARROS</p></td></tr>
                                                                <tr><td align="center"><p class="parrafo">Córdoba Sur</p></td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                                    </table>
                               
							</div>
							<div id="content-ventas-puntos-supermercados">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>PUNTOS DE VENTA· </h6><p>VENTA DIRECTA</p></div></div>
                                <div class="content-ventas-puntoscatalogo-nav">
                                    <ul>
                                        <li><a>· ·</a></li>
                                        <li><a id="pn4" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-restaurants', 'pn4', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto10.jpg';">DISTRIBUIDORES</a></li>
                                        <li><a>·</a></li>
                                        <li><a id="pn6" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-empresas', 'pn6', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto15.jpg';">SUPERMERCADOS</a></li>
                                        <li><a>·</a></li>
                                        <li><a id="pn5" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-supermercados', 'pn5', 'pcn1a'), activevinosespumantes ('pn5'); document.getElementById('puntosbanner').src='img/foto7.jpg';">VENTA DIRECTA</a></li>
                                        <li><a>· ·</a></li>
                                    </ul>
                                </div>
                            
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                    <tr height="30"><td background="img/table-fdo.png"></td></tr>
                                    <tr>
                                        <td background="img/table-fdo.png">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr height="40">
                                                    <td align="center" class="p-presentacion">Podes realizar pedidos directamente a la bodega a <a href="mailto:info@acordeswines.com" class="link">info@acordeswines.com</a></td>
                                                </tr>
                                                <tr height="40">
                                                	<td align="center" class="p-presentacion">
                                                    	Fijate los medios de pago, formas de envio y precios de los productos en el 
                                                    	<a id="pcn2b" class="link" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b');">CATALOGO ONLINE</a> 
                                                        o en nuestra fanpage <a href="http://www.facebook.com/SinfoniaWines" target="_blank" class="link">www.facebook.com/SinfoniaWines</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                    <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                                </table>
							</div>
							<div id="content-ventas-puntos-empresas">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>PUNTOS DE VENTA· </h6><p>SUPERMERCADOS</p></div></div>
									<div class="content-ventas-puntoscatalogo-nav">
										<ul>
                                        	<li><a>· ·</a></li>
											<li><a id="pn7" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-restaurants', 'pn7', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto10.jpg';">DISTRIBUIDORES</a></li>
											<li><a>·</a></li>
											<li><a id="pn9" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-empresas', 'pn9', 'pcn1a'), activevinosespumantes ('pn9'); document.getElementById('puntosbanner').src='img/foto15.jpg';">SUPERMERCADOS</a></li>
											<li><a>·</a></li>
                                            <li><a id="pn8" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-supermercados', 'pn8', 'pcn1a'); document.getElementById('puntosbanner').src='img/foto11.jpg';">VENTA DIRECTA</a></li>
											<li><a>· ·</a></li>
                                        </ul>
									</div>
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                        <tr height="30"><td background="img/table-fdo.png"></td></tr>
                                        <tr>
                                            <td background="img/table-fdo.png">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr align="center">
                                                    	<td width="33%" align="center"><p class="nombre">· JUMBO ·</p></td>
                                                        <td width="33%" align="center"><p class="nombre">· DISCO ·</p></td>
                                                        <td width="33%" align="center"><p class="nombre">· WALMART ·</p></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                        <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                                    </table>
							</div>
						</div>
					</div>

					<!-- CATALOGO -->
					<div id="content-ventas-catalogo" style="display: none;">
						<div class="content-ventas-puntoscatalogo-nav">
							<ul>
								<li><a id="pcn1b" onclick="puntoscatalogos ('content-ventas-puntos', 'content-ventas-puntos-restaurants', 'pn1', 'pcn1a');">PUNTOS DE VENTAS</a></li>
								<li><a id="pcn2b" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b');">CATALOGO ONLINE</a></li>
							</ul>
						</div>
						<div class="content-up-banner" style="margin-top: 0;"><img id="catalogosbanner" src="img/foto5.jpg"></div>
						<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
						
						<div class="content-ventas-puntoscatalogo-content">
							<div id="content-ventas-catalogo-vino">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>CATALOGO ONLINE · </h6><p>VINOS</p></div></div>
								<div class="content-ventas-puntoscatalogo-nav" style="margin-left: 0;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="cn1" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto5.jpg';">VINOS</a></li>
										<li><a>·</a></li>
										<li><a id="cn2" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-champagne', 'cn5', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto19.jpg';">CHAMPAÑA</a></li>
										<li><a>·</a></li>
										<li><a id="cn3" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-estuches', 'cn9', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto17.jpg';">ESTUCHES</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                    <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                    <tr>
                                        <td background="img/table-fdo.png">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr><td colspan="4" class="p-titulo" style="text-align: center; height: 70px;">SINCOPA VINEYARDS BLEND</td></tr>
												<tr height="220" align="center" valign="middle">
                                                    <?
                                                    $si = array();
													$si[0] = array('MALBEC'				, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'sincopa-tinto.png');
													$si[1] = array('CABERNET SAUVIGNON'	, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'sincopa-tinto.png');
													$si[2] = array('TARDÍO'				, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'sincopa-tinto.png');
										   			$si[3] = array('DULCE'				, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'sincopa-tinto.png');
													foreach($si AS $producto){
													?>
                                                        <td width="20%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="65%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr height="40"><td align="right" class="p-variedad"><?= $producto[0]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[1]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[2]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[3]?></td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width="5%"></td>
                                                                    <td width="30%" align="left"><?= !empty($producto[4]) ? '<img src="img/'.$producto[4].'">' : ''?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <? }?>
                                                </tr>
                                                <tr height="4"><td colspan="4"><table width="100%"><tr><td width="15"></td><td background="img/p-dots.png"></td><td width="15"></td></tr></table></td></tr>
												<tr><td colspan="4" class="p-titulo" style="text-align: center; height: 70px;">SINFONIA VINEYARDS BLEND</td></tr>
												<tr height="220" align="center" valign="middle">
                                                    <?
                                                    $svb = array();
													$svb[0] = array('MALBEC'			, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'pvt-sinfonia.png');
													$svb[1] = array('CABERNET SAUVIGNON', '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'pvt-sinfonia.png');
													$svb[2] = array('TARDÍO'			, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'pvt-sinfonia.png');
										   			$svb[3] = array('DULCE'				, '1 x 750 ml - <b>usd 3,95</b>', '6 x 750 ml - <b>usd 23,68</b>', '12 x 750 ml - <b>usd 47,36</b>', 'pvt-sinfonia.png');
													foreach($svb AS $producto){
													?>
                                                        <td width="20%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="65%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr height="40"><td align="right" class="p-variedad"><?= $producto[0]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[1]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[2]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[3]?></td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width="5%"></td>
                                                                    <td width="30%" align="left"><?= !empty($producto[4]) ? '<img src="img/'.$producto[4].'">' : ''?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <? }?>
                                                </tr>
											</table>
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr height="4"><td colspan="3"><table width="100%"><tr><td width="15"></td><td background="img/p-dots.png"></td><td width="15"></td></tr></table></td></tr>
                                                <tr><td colspan="3" class="p-titulo" style="text-align: center; height: 70px;">SINFONÍA SELECTED VINEYARDS</td></tr>
												<tr height="220" align="center" valign="middle">
                                                    <?
                                                    $sv = array();
													$sv[0] = array('MALBEC'				, '1 x 750 ml - <b>usd 5,92</b>', '6 x 750 ml - <b>usd 35,52<b>', '12 x 750 ml - <b>usd 71,05</b>', 'pvt-sinfonia.png');
													$sv[1] = array('CABERNET SAUVIGNON'	, '1 x 750 ml - <b>usd 5,92</b>', '6 x 750 ml - <b>usd 35,52<b>', '12 x 750 ml - <b>usd 71,05</b>', 'pvt-sinfonia.png');
													$sv[2] = array('CHARDONNAY'			, '1 x 750 ml - <b>usd 5,42</b>', '6 x 750 ml - <b>usd 32,56<b>', '12 x 750 ml - <b>usd 65,13</b>', 'pvb-sinfonia.png');
													foreach($sv AS $producto){
													?>
                                                        <td width="33%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="65%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr height="40"><td align="right" class="p-variedad"><?= $producto[0]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[1]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[2]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[3]?></td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width="5%"></td>
                                                                    <td width="30%" align="left"><?= !empty($producto[4]) ? '<img src="img/'.$producto[4].'">' : ''?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <? }?>
                                                </tr>
                                                <tr height="4"><td colspan="3"><table width="100%"><tr><td width="15"></td><td background="img/p-dots.png"></td><td width="15"></td></tr></table></td></tr>
											</table>
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                	<td class="p-titulo" style="text-align: center; height: 70px;">SINFONIA ROBLE MALBEC</td>
                                                	<td class="p-titulo" style="text-align: center; height: 70px;">SINFONIA RESERVA MALBEC</td>
                                                </tr>
                                               	<tr height="220" align="center" valign="middle">
                                                    <?
                                                    $sv = array();
													$sv[0] = array('MALBEC', '1 x 750 ml - <b>usd 8,88</b>', '6 x 750 ml - <b>usd 53,28</b>', '12 x 750 ml - <b>usd 106,57</b>', 'pvt-roble.png');
													foreach($sv AS $producto){
													?>
                                                        <td width="50%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="65%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr height="40"><td align="right" class="p-variedad"><?= $producto[0]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[1]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[2]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[3]?></td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width="5%"></td>
                                                                    <td width="30%" align="left"><?= !empty($producto[4]) ? '<img src="img/'.$producto[4].'">' : ''?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <? }?>
                                                    <?
                                                    $sv = array();
													$sv[0] = array('MALBEC', '1 x 750 ml - <b>usd 11,51</b>', '6 x 750 ml - <b>usd 69,07</b>', '12 x 750 ml - <b>usd 138,16</b>', 'pvt-reserva.png');
													foreach($sv AS $producto){
													?>
                                                        <td width="50%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="65%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr height="40"><td align="right" class="p-variedad"><?= $producto[0]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[1]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[2]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[3]?></td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width="5%"></td>
                                                                    <td width="30%" align="left"><?= !empty($producto[4]) ? '<img src="img/'.$producto[4].'">' : ''?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <? }?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                                </table>
							</div>
							<div id="content-ventas-catalogo-champagne">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>CATALOGO ONLINE · </h6><p>CHAMPAÑA</p></div></div>
								<div class="content-ventas-puntoscatalogo-nav" style="margin-left: 0;">
									<ul>
	                                    <li><a>· ·</a></li>
										<li><a id="cn4" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto5.jpg';">VINOS</a></li>
										<li><a>·</a></li>
										<li><a id="cn5" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-champagne', 'cn5', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto19.jpg';">CHAMPAÑA</a></li>
										<li><a>·</a></li>
										<li><a id="cn6" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-estuches', 'cn9', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto17.jpg';">ESTUCHES</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
                                 <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                    <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                    <tr>
                                        <td background="img/table-fdo.png">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                               	<tr><td colspan="3" class="p-titulo" style="text-align: center; height: 70px;">CHAMPAÑA</td></tr>
                                                <tr height="220" align="center" valign="middle">
                                                    <?
                                                    $sv = array();
													$sv[0] = array('CHAMPAÑA SAXO'	 , '1 x 750 ml - <b>usd 6,41</b>', '6 x 750 ml - <b>usd 38,48</b>', '12 x 750 ml - <b>usd 76,97</b>', 'champagne-saxo.png');
													$sv[1] = array('EXTRA BRUT'		, '1 x 750 ml - <b>usd 8,22</b>', '6 x 750 ml - <b>usd 49,33</b>', '12 x 750 ml - <b>usd 98,68</b>', 'peb-sinfonia.png');
													$sv[2] = array('BRUT NATURE'	, '1 x 750 ml - <b>usd 11,51</b>', '6 x 750 ml - <b>usd 69,07</b>', '12 x 750 ml - <b>usd 138,16</b>', 'pbn-sinfonia.png');
													
													foreach($sv AS $producto){
													?>
                                                        <td width="33%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="65%">
                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                            <tr height="40"><td align="right" class="p-variedad"><?= $producto[0]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[1]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[2]?></td></tr>
                                                                            <tr height="30"><td align="right" class="p-presentacion"><?= $producto[3]?></td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td width="5%"></td>
                                                                    <td width="30%" align="left"><?= !empty($producto[4]) ? '<img src="img/'.$producto[4].'">' : ''?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <? }?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                                </table>
							</div>
							<div id="content-ventas-catalogo-estuches">
								<div class="subtitle2"><div class="subtitle2-centrado"> <h6>CATALOGO ONLINE · </h6><p>ESTUCHES</p></div></div>
								<div class="content-ventas-puntoscatalogo-nav" style="margin-left: 0;">
									<ul>
                                    	<li><a>· ·</a></li>
										<li><a id="cn7" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-vino', 'cn1', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto5.jpg';">VINOS</a></li>
										<li><a>·</a></li>
										<li><a id="cn8" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-champagne', 'cn5', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto19.jpg';">CHAMPAÑA</a></li>
										<li><a>·</a></li>
										<li><a id="cn9" onclick="puntoscatalogos ('content-ventas-catalogo', 'content-ventas-catalogo-estuches', 'cn9', 'pcn2b'); document.getElementById('catalogosbanner').src='img/foto17.jpg';">ESTUCHES</a></li>
										<li><a>· ·</a></li>
                                    </ul>
								</div>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                    <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                    <tr>
                                        <td background="img/table-fdo.png">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr height="220" align="center" valign="middle">
                                                    <?
                                                    $sv = array();
													$sv[0] = array('GIFT BOX ROBLE', '1 Sinfonía Roble Malbec x 750 ml <br>1 Copón de Cristal de 500 ml <br> Bolsa de tela fliselina de 80 gramos con logo Sinfonía', 'usd 22,46', 'pgb-roble.png');
													$sv[1] = array('GIFT BOX RESERVA', '1 Sinfonía Reserva Malbec x 750 ml <br>1 Copón de Cristal de 500 ml <br> Bolsa de tela fliselina de 80 gramos con logo Sinfonía', 'usd 27,96', 'pgb-reserva.png');
													$sv[2] = array('GIFT BOX EXTRA BRUT', '1 Champaña Extra Brut x 750 ml <br> 2 Copas de Cristal de 180 ml <br> Bolsa de tela fliselina de 80 gramos con logo Sinfonía', 'usd 31,25', 'pgb-extra-brut.png');
													$sv[3] = array('GIFT BOX CHAMPENOISE', '1 Champaña Brut Nature x 750 ml. Método Champenoise + 2 Copas de Cristal de 180 ml. + Bolsa de tela fliselina de 80 gramos con logo Sinfonía.', 'usd 32,96', 'pgb-extra-brut.png');
													//$sv[4] = array('MALBEC CATA VARIETAL', 'La Cata Varietal consiste en una degustación de diferentes vinos elaborados con la misma variedad de uva. <br>La caja contiene 6 botellas de Malbec de la familia Sinfonía.<br>2 Malbec Selected Vineyards<br>2 Malbec Roble<br>2 Malbec Reserva', '$ 1.500,00', 'pmc-sinfonia.png');
													$i = 0;
													foreach($sv AS $producto){
														$i++;
													?>
                                                        <td width="50%">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                            	<tr height="40"><td align="center" class="p-titulo"><?= $producto[0]?></td></tr>
                                                                <tr height="220"><td align="center"><?= !empty($producto[3]) ? '<img src="img/'.$producto[3].'">' : ''?></td></tr>
                                                                <tr height="30"><td align="center" class="p-presentacion" style="padding:0 20px 0 20px;"><?= $producto[1]?></td></tr>
                                                                <tr height="30"><td align="center" class="p-precio"><?= $producto[2]?></td></tr>
                                                            </table>
                                                        </td>
                                                        <?= ($i % 2 == 0) ? '</tr><tr height="60"><td colspan="2"><table width="100%"><tr><td width="15"></td><td background="img/p-dots.png"></td><td width="15"></td></tr></table></td></tr><tr height="220" align="center" valign="middle">' : ''?>
                                                    <? }?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                                </table>
							</div>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr height="20" valign="bottom"><td><img src="img/table-up.png" style="vertical-align: bottom;"></td></tr>
                                <tr height="20"><td background="img/table-fdo.png"></td></tr>
                                <tr>
                                    <td background="img/table-fdo.png">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr align="center" valign="top">
                                                <td class="p-presentacion">
                                                	LOS PEDIDOS SE RECIBEN A <br><br> 
                                                    <a href="mailto:info@acordeswines.com" class="link">info@acordeswines.com</a> <br><br>
                                                	ENVIOS A DOMICILIO EN CAPITAL Y GRAN BUENOS AIRES.
                                                </td>
                                                <td width="500" align="left">
                                                	<a href="https://www.mercadopago.com/mla/ayuda/medios-pago-cuotas" class="link" target="_blank">MEDIOS DE PAGO</a><br><br>
                                                    <img src="img/medios-de-pago.jpg" title="MercadoPago - Medios de pago" alt="MercadoPago - Medios de pago" width="468" height="60"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="20"><td><img src="img/table-dw.png"></td></tr>
                            </table>
						</div>
					</div>
				</div>

				<!-- TUPUNGATO -->
				<!--     -->
				<div id="content-tupungato" style="display: none;">
					<div class="content-up-banner"><img src="img/tupungato-banner.jpg"></div>
					<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
					<img id="content-tupungato-title" src="img/tupungato-title.png">
					<p id="content-tupungato-text" style="font-size:18px !important;">A cierta altura de los Andes y de cara a los picos mas elevados de la cordillera, encontramos nuestro terroir. Sesenta hectáreas de privilegiado microclima e incomparables visuales hacen de Tupungato, Valle de Uco el sitio ideal para desarrollar nuestro sueño/proyecto/emprendimiento. Un lugar único y privilegiado para conjugar a los verdaderos protagonistas: los viñedos, la música y la cordillera.</p>
					<div id="content-tupungato-bottom-left">
						<img id="content-tupungato-bottom-left-1a" src="img/tupungato-bottom-left-1a.jpg">
						<img id="content-tupungato-bottom-left-1b" src="img/tupungato-bottom-left-1b.jpg">
					</div>
					<div id="content-tupungato-bottom-right">
						<p>El proyecto contempla la construcción de un lodge de 16 habitaciones, sala de degustación, sala de barricas, spa y un auditorio para 200 personas con espectaculares vistas a la inmensidad de la cordillera.</p>
						<p>La premisa de diseño fue combinar el ambiente místico del vino con la armonía de la música.El proyecto se mimetiza con el paisaje, de modo que al recorrerlo se perciba a través de los 5 sentido, integrando la música, el vino y los Andes.</p>
						<p>Para la elaboración del master plan, se seleccionó al reconocido arquitecto Andrés Remy. Andrés cuenta con una destacada trayectoria de jerarquía intenacional y fue merecedor de numerosos premios y distinciones. </p>
						<a target="_blank" href="http://www.andresremy.com">www.andresremy.com</a>
					</div>
                    <div id="content-tupungato-bottom">
                    	<a href="img/tupungato-img1.pdf" target="_blank"><img id="content-tupungato-bottom-right-img" src="img/tupungato1.jpg" border="0"></a>
						<a href="img/tupungato-img2.pdf" target="_blank"><img id="content-tupungato-bottom-right-img" src="img/tupungato2.jpg" border="0"></a>
						<a href="img/tupungato-img3.pdf" target="_blank"><img id="content-tupungato-bottom-right-img" src="img/tupungato3.jpg" border="0"></a>
						<a href="img/tupungato-img4.pdf" target="_blank"><img id="content-tupungato-bottom-right-img" src="img/tupungato4.jpg" border="0"></a>
                    </div>
				</div>


				<!-- LIFESTYLE -->
				<!--     -->
				<div id="content-lifestyle" style="display: none;">
					<div class="content-up-banner"><img src="img/lifestyle-banner.jpg"></div>
					<div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
					<div class="subtitle2" style="margin-left:30px"><div class="subtitle2-centrado"> <h6>LIFESTYLE</h6></div></div>
					<div id="content-lifestyle-left">
                    	<p style="font-size:14px; text-align:center; margin-top:30px">NOTAS · ABRIL 2012</p>
                    	<div class="content-lifestyle-left-titulo">OTOÑO EN MENDOZA</div>
						<p>La belleza puede explicarse no sólo por la armonía que se puede encontrar en las cosas sino también por la pasión que le ponemos a nuestros sentidos cuando los aplicamos a esas cosas. Esa llama no se enciende sólo con los objetos artísticos: una comida, una bebida, una escena mínima o un paisaje son capaces de despertar ese impulso. ¿Qué sucede cuando todo eso se junta, cuando el arte, la gastronomía y el fervor se confunden y ya no es posible distinguir la forma y el fondo? Sucede un otoño en Mendoza.</p><p>El otoño allí te ofrece esa felicidad inalcanzable que sólo es posible encontrar en las cosas leves o profundas, pero siempre imperecederas: una sinfonía, una copa de vino, la transparencia del aire, un cuadro, la sencilla fragancia de un ramo de albahaca. Hay y habrá siempre allí un otoño como ningún otro que grita su color en las alamedas amarillas que rodean los verdes viñedos de la cosecha tardía. Hay y habrá siempre allí una excepcional claridad otoñal, una luz que penetra en el paisaje cercano y se extiende hacia la Cordillera de picos nevados. Hay y habrá siempre en Mendoza el vino que nadie niega, el líquido púrpura o ámbar que te instala en un eterno presente mientras el viajero camina hacia el futuro.</p><p>Ese otoño es apto para los materialistas profundos y también para los viajeros espirituales, porque un paseo por el Valle de Uco en otoño es una travesía por los sentidos, pero también una forma de conocimiento. A principios de abril, acontece allí un festival de música clásica que recorre los caminos del vino. El registro de todo eso es inolvidable. Puede suceder un concierto con temas de Maurice Ravel que una violinista y una cellista rusas interpretan en el subsuelo de una fantástica bodega. La visión de la Cordillera desde un restaurante junto a un bello museo de pinturas. Los langostinos crocantes con palta y gazpacho de tomates orgánicos acompañados por un Malbec Reserva. El tallo de una copa alzada que refleja los tonos y la leve espuma púrpura de un Cabernet Sauvignon. Los racimos de uva malbec iluminados por la luz del sol del mediodía en cualquier viñedo mendocino. </p><p>Cada una de estas cosas puede despertar al espíritu más dormido si se pone pasión en ello. Porque el otoño en Mendoza desnuda lo externo y lo íntimo de la naturaleza, pero a la vez revela algo esencial: nuestra propia naturaleza.</p><p style="margin-top:40px;">Por Juan Bedoian, Editor Suplemento Viajes, Clarín.</p>
                    </div>
					<div id="content-lifestyle-right">
						<div class="subtitle2" style="width:440px; height:28px; padding-top: 5px; margin-bottom:10px;">EVENTOS</div>
                        <div style="width: 440px; height: 1022px; overflow-y: scroll;">
                        	<?
                            $ls = array();
							$ls[0] = array('MARZO 2014', 'Auspiciamos la muestra Fotográfica de Josefina Oliver en el Palais de Glace', 'lifestyle-4.jpg');
							$ls[1] = array('NOVIEMBRE 2013', 'Premium Wines Experience 2013 se realizó los días 14 y 15 de Noviembre de 2013 en el Hotel Holiday Inn de Córdoba Capital. Contó con la presencia de más de 35 bodegas boutique y de autor de la Argentina y se pudo degustar de más de 150 vinos Premium. Algunas de las Bodegas que fueron parte del evento son Sinfonía (Acordes), Achaval Ferrer, Durigutti, Atamisque, Cruzat, Manos Negras, Urraca Wines, Las Perdices, Colomé , Sophenia, Casarena, Piedra Negra (Lurton) y Laborum.', 'life-cordoba1.jpg,life-cordoba2.jpg,life-cordoba3.jpg,life-cordoba4.jpg,life-cordoba5.jpg');
							$ls[2] = array('SEPTIEMBRE 2013', 'Expo DiVino Mar del Plata. La segunda expo DiVino de Mar del Plata se llevo a cabo los dias 17 y 18 de septiembre de 2013 en el salon de eventos del Hotel Sheraton de la ciudad de Mar del Plata', 'life-divino1.jpg,life-divino2.jpg,life-divino3.jpg,life-divino4.jpg');
							$ls[3] = array('SEPTIEMBRE 2012', 'Concurso fotográfico "Vino, Sudor y Lágrimas"', 'lifestyle-right-2.jpg');
							$ls[4] = array('AGOSTO 2012', 'Stand-Up comedy', 'lifestyle-right-3.jpg');
							
							foreach($ls AS $articulo){
							?>
                            	<p>&nbsp;</p>
                            	<p><?= $articulo[0]?></p><br>
                                <p><?= $articulo[1]?></p><br>
                                <div class="borde-abajo">
                                	<?
                                    $fotos = explode(',',$articulo[2]);
									foreach($fotos AS $foto){
									?>
                                    	<img src="img/<?= $foto?>"></img>
                                    <? }?>
                                    <p>&nbsp;</p>
                                </div>
                            <? }?>
						</div>
                        <div class="subtitle2" style="width:440px; height:5px; padding-top: 5px; margin-top: -6px;"></div>
					</div>
				</div>

				<!-- CONTACTO -->
				<!--     -->
				<div id="content-contacto" style="display: none;">
                    <form action="<?= $_SERVER['PHP_SELF']?>" name="formM" method="post">
                        <div class="content-up-banner"><img src="img/1.jpg"></div>
                        <div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
                        <div id="content-contacto-left">
                        
                            <input type="text" name="contacto_nombreyapellido">
                            <label for="contacto_nombreyapellido">NOMBRE Y APELLIDO</label>
                            <input type="text" name="contacto_mail">
                            <label for="contacto_mail">MAIL</label>
                            <input type="text" name="contacto_mail2">
                            <label for="contacto_mail2">CONFIRMACIÓN DE MAIL</label>
                            <textarea name="contacto_consulta" cols="52" rows="15"></textarea>
                            <label for="contacto_consulta">CONSULTA</label>
                        </div>
                        <div id="content-contacto-right"> <p>
                                <span class="content-contacto-right-bold">· Eduardo García Oliver<br>
                                </span> &nbsp;&nbsp;Gerente Comercial<br>  &nbsp;&nbsp;eduardo@acordeswines.com<br><br>
                                <span class="content-contacto-right-bold">· Valeria Ray<br>
                                </span> &nbsp;&nbsp;Gerente de Administración<br>   &nbsp;&nbsp;valeria@acordeswines.com<br><br>
                                <span class="content-contacto-right-bold">· Consultas Generales<br>
                                </span> &nbsp;&nbsp;info@acordeswines.com</p>
                            <input type="hidden" value="contacto" name="accion">
                            <input type="submit" value="ENVIAR" name="boton">
                        </div>
					</form>
                </div>

				<!-- REGISTRO -->
				<!--     -->
				<div id="content-reg" style="display: none;">
                    <form action="<?= $_SERVER['PHP_SELF']?>" name="formN" method="post">
                    	<input type="hidden" value="ok" name="mayores">
                        <div class="content-up-banner"><img src="img/contacto-banner.jpg"></div>
                        <div class="content-up-ribbon-right" onclick="displaynav ('content-home', 'n1');"></div>
                        <div id="content-reg-left">
                            <input type="text" name="reg_nombreyapellido">
                            <label for="reg_nombreyapellido">NOMBRE Y APELLIDO</label>
                            <input type="text" name="reg_mail">
                            <label for="reg_mail">MAIL</label>
                            <input type="text" name="reg_mailconfirmacion">
                            <label for="reg_mailconfirmacion">CONFIRMACIÓN DE MAIL</label>
                        </div>
                        <div id="content-reg-right">	
                        	<input type="hidden" value="newsletter" name="accion">
                            <input type="submit" value="ENVIAR" style="top:10px;" name="boton">
                            <input type="submit" value="CANCELAR" style="top: 60px;">
                        </div>
                    </form>
				</div>
			</div>
			<div id="footer">
				<p>Beber con moderación. Prohibida su venta a menores de 18 años. Copyright Acordes Srl 2012</p>
			</div>
		</div>
	<body>
</html>