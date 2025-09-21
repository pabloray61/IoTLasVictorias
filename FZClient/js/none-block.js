// Funcion contenidos generales
//-------------------------
function display () {
	document.getElementById('content-home').style.display='none';
	document.getElementById('content-nuestracava').style.display='none';
	document.getElementById('content-lifestyle').style.display='none';
	document.getElementById('content-ventas').style.display='none';
	document.getElementById('content-tupungato').style.display='none';
	document.getElementById('content-contacto').style.display='none';
	document.getElementById('content-reg').style.display='none';


	document.getElementById('n1').style.color='#7D7869';
	document.getElementById('n2').style.color='#7D7869';
	document.getElementById('n3').style.color='#7D7869';
	document.getElementById('n4').style.color='#7D7869';
	document.getElementById('n5').style.color='#7D7869';
	document.getElementById('n6').style.color='#7D7869';
	document.getElementById('n8').style.color='#7D7869';
}

function displaynav (id, id2) {
	display ();
	displayvinosespumantes ();
	displayvinos ();
	displayespumantes ();
	displaypuntoscatalogo ();
	document.getElementById(id).style.display='block';
	document.getElementById(id2).style.color='#5F0F05';
}

function displaynavreg (id) {
	display ();
	displayvinosespumantes ();
	displayvinos ();
	displayespumantes ();
	displaypuntoscatalogo ();
	document.getElementById(id).style.display='block';
}

// Funcion contenidos Vinos, Espumantes
//-------------------------
function displayvinosespumantes () {
	document.getElementById('content-nuestracava-home').style.display='none';
	document.getElementById('content-nuestracava-vinos').style.display='none';
	document.getElementById('content-nuestracava-espumantes').style.display='none';
}

function displayvinos () {
	document.getElementById('content-nuestracava-vinos-selectedvineyards').style.display='none';
	document.getElementById('content-nuestracava-vinos-roble').style.display='none';
	document.getElementById('content-nuestracava-vinos-reserva').style.display='none';
}

function displayespumantes () {
	document.getElementById('content-nuestracava-espumantes-extraburt').style.display='none';
	document.getElementById('content-nuestracava-espumantes-brutnature').style.display='none';
}

function colorvinosespumantes () {
	document.getElementById('N01').style.color='#320F28';
	document.getElementById('N02').style.color='#320F28';
	document.getElementById('N03').style.color='#320F28';
	document.getElementById('N04').style.color='#320F28';
	document.getElementById('N05').style.color='#320F28';
	document.getElementById('N06').style.color='#320F28';
	document.getElementById('N07').style.color='#320F28';
	document.getElementById('N08').style.color='#320F28';
	document.getElementById('N09').style.color='#320F28';
	document.getElementById('N10').style.color='#320F28';
	document.getElementById('N11').style.color='#320F28';
	document.getElementById('N12').style.color='#320F28';
	document.getElementById('N13').style.color='#320F28';
	document.getElementById('N14').style.color='#320F28';
	document.getElementById('N15').style.color='#320F28';
}

function colorvinosespumantes2 () {
	document.getElementById('A01').style.color='gray';
	document.getElementById('A02').style.color='gray';
	document.getElementById('A03').style.color='gray';
	document.getElementById('A04').style.color='gray';
}

function vinos (id) {
	colorvinosespumantes ();
	displayvinosespumantes ();
	displayvinos ();
	displayespumantes ();
	document.getElementById(id).style.display='block';
	document.getElementById('content-nuestracava-vinos-selectedvineyards').style.display='block';
}

function espumantes (id) {
	colorvinosespumantes ();
	displayvinosespumantes ();
	displayvinos ();
	displayespumantes ();
	document.getElementById(id).style.display='block';
	document.getElementById('content-nuestracava-espumantes-extraburt').style.display='block';
}

function vinosvinos (id) {
	colorvinosespumantes ();
	displayvinosespumantes ();
	displayvinos ();
	displayespumantes ();
	document.getElementById('content-nuestracava-vinos').style.display='block';
	document.getElementById(id).style.display='block';
}

function espumantesespumantes (id) {
	colorvinosespumantes ();
	displayvinosespumantes ();
	displayvinos ();
	displayespumantes ();
	document.getElementById('content-nuestracava-espumantes').style.display='block';
	document.getElementById(id).style.display='block';
}

function activevinosespumantes (id) {
	colorvinosespumantes ();
	document.getElementById(id).style.color='#AEA83B';
}

function activevinosespumantes2 (id) {
	colorvinosespumantes2 ();
	document.getElementById(id).style.color='#320F28';
}

// Funcion contenidos Puntos, Catalogo
//-------------------------
function displaypuntoscatalogo () {
	document.getElementById('content-ventas-home').style.display='none';
	document.getElementById('content-ventas-puntos').style.display='none';
	document.getElementById('content-ventas-catalogo').style.display='none';

	document.getElementById('content-ventas-puntos-restaurants').style.display='none';
	document.getElementById('content-ventas-puntos-supermercados').style.display='none';
	document.getElementById('content-ventas-puntos-empresas').style.display='none';

	document.getElementById('content-ventas-catalogo-vino').style.display='none';
	document.getElementById('content-ventas-catalogo-champagne').style.display='none';
	document.getElementById('content-ventas-catalogo-estuches').style.display='none';

	document.getElementById('pn1').style.color='#320F28';
	document.getElementById('pn2').style.color='#320F28';
	document.getElementById('pn3').style.color='#320F28';
	document.getElementById('pn4').style.color='#320F28';
	document.getElementById('pn5').style.color='#320F28';
	document.getElementById('pn6').style.color='#320F28';
	document.getElementById('pn7').style.color='#320F28';
	document.getElementById('pn8').style.color='#320F28';
	document.getElementById('pn9').style.color='#320F28';

	document.getElementById('cn1').style.color='#320F28';
	document.getElementById('cn2').style.color='#320F28';
	document.getElementById('cn3').style.color='#320F28';
	document.getElementById('cn4').style.color='#320F28';
	document.getElementById('cn5').style.color='#320F28';
	document.getElementById('cn6').style.color='#320F28';
	document.getElementById('cn7').style.color='#320F28';
	document.getElementById('cn8').style.color='#320F28';
	document.getElementById('cn9').style.color='#320F28';
}

function puntoscatalogos (id, id2, id3, id4) {
	displaypuntoscatalogo ();
	document.getElementById(id).style.display='block';
	document.getElementById(id2).style.display='block';
	document.getElementById(id3).style.color='#AFA53C';
	document.getElementById(id4).style.color='#320F28';
}