function loadVinosData(){
	sub1.loading._visible = true;
	l = new XML();
	l.ignoreWhite = true;
	l.onLoad = parseVinos;
	l.load (path + "l_vinos_xml.php");
}

function parseVinos(){
	var b = this.firstChild.childNodes;
	shorts = [];

	for ( var i=0; i<b.length; i++){
		var r = b[i].childNodes;
		shorts[i] = {nombre:b[i].attributes.titulo, modelos:[]}
		shorts[i].modelos[0] = {};
		
		for ( var j=0; j<r.length; j++){
			var nodo = r[j].nodeName;
			
			if ( nodo == "id_prod" ){
				shorts[i].modelos[0].id_prod = r[j].firstChild.nodeValue;
			} else if ( nodo == "nombre" ){
				shorts[i].modelos[0].nombre = r[j].firstChild.nodeValue;
			} else if ( nodo == "material" ){
				shorts[i].modelos[0].material = r[j].firstChild.nodeValue;
			} else if ( nodo == "foto" ){
				shorts[i].modelos[0].foto = r[j].firstChild.nodeValue;
			} else {
				shorts[i].modelos[0].precio = r[j].firstChild.nodeValue;
			}
		}
	}
	
	sub1.loading._visible = false;
	sub1.s.alpha_d (0, 15);
	sub1.ce.alpha_d (0, 15);
	
	sub1.armarSelector ( shorts );
}