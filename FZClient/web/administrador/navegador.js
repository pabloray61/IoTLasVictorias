(function () {
	/**** MAIN NAVIGATION ****/
	// helper function to remove class
	function DLRremoveClass(objElement, strClassName) {
		if (objElement.className) {
			var arrClasses = objElement.className.split(' ');

			for (var i=0;i<arrClasses.length;i++) {
				if (arrClasses[i].toUpperCase() == strClassName.toUpperCase()) {
					arrClasses.splice(i, 1);
					i--;
				}
			 }

			objElement.className = arrClasses.join(' ');
		}
	}
	
	// shim for IE6 to display drop downs above form elements
	var DLRshim = document.createElement("iframe");
	DLRshim.src = 'javascript:false;document.write("");';
	DLRshim.style.position = 'absolute';
	DLRshim.style.top = '0';
	DLRshim.style.left = '0';
	DLRshim.style.display = 'none';
	DLRshim.style.border = 'none';
	DLRshim.style.padding = '0';
	DLRshim.style.margin = '0';
	DLRshim.style.filter='progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';

	// get all main menu tabs
	var agenda = document.getElementById("id_agenda");
	var clientes = document.getElementById("id_clientes");
	var vendedores = document.getElementById("id_vendedores");
	var productos = document.getElementById("id_productos");
	var insumos = document.getElementById("id_insumos");
	var stock = document.getElementById("id_stock");
	var reportes = document.getElementById("id_reportes");
	
	// get all drop down lists
	var DLRclientes = clientes.getElementsByTagName("ul")[0];
	var DLRagenda = agenda.getElementsByTagName("ul")[0];
	var DLRvendedores = vendedores.getElementsByTagName("ul")[0];
	var DLRproductos = productos.getElementsByTagName("ul")[0];
	var DLRinsumos = insumos.getElementsByTagName("ul")[0];
	var DLRstock = stock.getElementsByTagName("ul")[0];
	var DLRreportes = reportes.getElementsByTagName("ul")[0];

	// hides all drop down menus
	var DLRhideMenuLists = function() {
		DLRclientes.style.display = 'none';
		DLRagenda.style.display = 'none';
		DLRvendedores.style.display = 'none';
		DLRproductos.style.display = 'none';
		DLRinsumos.style.display = 'none';
		DLRstock.style.display = 'none';
		DLRreportes.style.display = 'none';
			
		DLRremoveClass(clientes,'DLRactive');
		DLRremoveClass(agenda,'DLRactive');
		DLRremoveClass(vendedores,'DLRactive');
		DLRremoveClass(productos,'DLRactive');
		DLRremoveClass(insumos,'DLRactive');
		DLRremoveClass(stock,'DLRactive');
		DLRremoveClass(reportes,'DLRactive');
		DLRshim.style.display = 'none';
	}
	
	
	var DLRshowMenuLists = function(objMenuDiv, objMenuList, arrOtherMenuDivs) {
		objMenuList.style.display = 'block';	
		// removes "on" state of other tabs
		for (i=0;i<arrOtherMenuDivs.length;i++) {
			DLRremoveClass(arrOtherMenuDivs[i],'DLRactive');
		}
		// set "on" state of current tab
		objMenuDiv.className = objMenuDiv.className + ' DLRactive';
						
		// position and turn on shim for IE6
		if (document.all) {
			// add shim after objMenuList
			objMenuDiv.appendChild(DLRshim);
			DLRshim.style.height = objMenuList.offsetHeight + "px";
			DLRshim.style.width = objMenuList.offsetWidth + "px";
			DLRshim.style.display = 'block';
			DLRshim.style.top = objMenuList.offsetTop + "px";
			DLRshim.style.left = objMenuList.offsetLeft + "px";
		}
	}
	
	// makes passed in menu tab "active" and displays drop down menu
	function DLRaddMenuListeners(objMenuDiv, objMenuList, arrOtherMenuDivs) {
		objMenuDiv.onmouseover = function() {
			DLRhideMenuLists();
			DLRshowMenuLists(objMenuDiv, objMenuList, arrOtherMenuDivs);
		}
		objMenuDiv.onmouseout = DLRhideMenuLists;
	}
	
	// add listeners for each main menu tab
	
	// create arrays of other menu divs for each category 
	arrOthersclientess = new Array(agenda,vendedores,productos,insumos,stock,reportes);
	arrOthersagendas = new Array(clientes,vendedores,productos,insumos,stock,reportes);
	arrOthersvendedoress = new Array(clientes,agenda,productos,insumos,stock,reportes);
	arrOthersproductoss = new Array(clientes,agenda,vendedores,insumos,stock,reportes);
	arrOthersinsumoss = new Array(clientes,agenda,vendedores,productos,stock,reportes);
	arrOthersstocks = new Array(clientes,agenda,vendedores,productos,insumos,reportes);
	arrOthersreportess = new Array(clientes,agenda,vendedores,productos,insumos,stock);
	
	DLRaddMenuListeners(clientes, DLRclientes, arrOthersclientess);
	DLRaddMenuListeners(agenda, DLRagenda,arrOthersagendas);
	DLRaddMenuListeners(vendedores, DLRvendedores,arrOthersvendedoress);
	DLRaddMenuListeners(productos,DLRproductos, arrOthersproductoss);
	DLRaddMenuListeners(insumos,DLRinsumos, arrOthersinsumoss);
	DLRaddMenuListeners(stock,DLRstock, arrOthersstocks);
	DLRaddMenuListeners(reportes,DLRreportes, arrOthersreportess);
	
	// make sure all drop downs are hidden on start
	DLRhideMenuLists();
	
	
	// add listeners for onfocus to open up menus (for tab access)	
	document.getElementById("agenda").onfocus = agenda.onmouseover;
	document.getElementById("clientes").onfocus = clientes.onmouseover;
	document.getElementById("vendedores").onfocus = vendedores.onmouseover;
	document.getElementById("productos").onfocus = productos.onmouseover;
	document.getElementById("insumos").onfocus = insumos.onmouseover;
	document.getElementById("stock").onfocus = stock.onmouseover;
	document.getElementById("reportes").onfocus = reportes.onmouseover;
	
	
	/**** SEARCH INPUT ****/
	DLRobjSearchInput = document.getElementById("DLRsearchInput");
	DLRstrSearchDefaultText = DLRobjSearchInput.value
	DLRobjSearchInput.onclick = function() {
		if(DLRobjSearchInput.value == DLRstrSearchDefaultText) {
			DLRobjSearchInput.value = '';
		}
	};
	DLRobjSearchInput.onblur = function() {
		if(DLRobjSearchInput.value == '') {
			DLRobjSearchInput.value = DLRstrSearchDefaultText;
		}
	};
	
	
})();
 	
