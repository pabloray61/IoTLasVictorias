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
	var reportes = document.getElementById("id_reportes");
	
	// get all drop down lists
	var DLRclientes = clientes.getElementsByTagName("ul")[0];
	var DLRagenda = agenda.getElementsByTagName("ul")[0];
	var DLRvendedores = vendedores.getElementsByTagName("ul")[0];
	var DLRreportes = reportes.getElementsByTagName("ul")[0];

	// hides all drop down menus
	var DLRhideMenuLists = function() {
		DLRclientes.style.display = 'none';
		DLRagenda.style.display = 'none';
		DLRvendedores.style.display = 'none';
		DLRreportes.style.display = 'none';
		
		DLRremoveClass(clientes,'DLRactive');
		DLRremoveClass(agenda,'DLRactive');
		DLRremoveClass(vendedores,'DLRactive');
		DLRremoveClass(reportes,'DLRactive');
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
	arrOthersclientess = new Array(agenda,vendedores,reportes);
	arrOthersagendas = new Array(clientes,vendedores,reportes);
	arrOthersvendedoress = new Array(clientes,agenda,reportes);
	arrOthersreportess = new Array(clientes,agenda,vendedores);
	
	DLRaddMenuListeners(clientes, DLRclientes, arrOthersclientess);
	DLRaddMenuListeners(agenda, DLRagenda,arrOthersagendas);
	DLRaddMenuListeners(vendedores, DLRvendedores,arrOthersvendedoress);
	DLRaddMenuListeners(reportes,DLRreportes, arrOthersreportess);
	
	// make sure all drop downs are hidden on start
	DLRhideMenuLists();
	
	
	// add listeners for onfocus to open up menus (for tab access)	
	document.getElementById("agenda").onfocus = agenda.onmouseover;
	document.getElementById("clientes").onfocus = clientes.onmouseover;
	document.getElementById("vendedores").onfocus = vendedores.onmouseover;
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
	
	/**** TOOLBAR LINKS ****/
	var DLRmyDisneylandDiv = document.getElementById("DLRmyDisneyland");
	var DLRmyDisneylandTooltip = document.getElementById("DLRmyDisneylandTooltip");
	var DLRannualPassholdersDiv = document.getElementById("DLRannualPassholders");
	var DLRannualPassholdersTooltip = document.getElementById("DLRannualPassholdersTooltip");
	var DLRloginDiv = document.getElementById("DLRlogIn");
	//var DLRloginTooltip = document.getElementById("DLRloginTooltip");
	
	DLRmyDisneylandDiv.onmouseover = function() {
		DLRmyDisneylandTooltip.style.display = 'block';
		DLRmyDisneylandDiv.className = DLRmyDisneylandDiv.className + ' DLRtoolbarActive';
			
		// position and turn on shim for IE6
		if (document.all) {
			// add shim after objMenuList
			DLRmyDisneylandDiv.appendChild(DLRshim);
			DLRshim.style.height = DLRmyDisneylandTooltip.offsetHeight + "px";
			DLRshim.style.width = DLRmyDisneylandTooltip.offsetWidth + "px";
			DLRshim.style.display = 'block';
			DLRshim.style.top = DLRmyDisneylandTooltip.offsetTop + "px";
			DLRshim.style.left = DLRmyDisneylandTooltip.offsetLeft + "px";
		}
	};
	DLRmyDisneylandDiv.onmouseout = function() {
		DLRmyDisneylandTooltip.style.display = 'none';
		DLRremoveClass(DLRmyDisneylandDiv, 'DLRtoolbarActive');
		DLRshim.style.display = 'none';
	};
	DLRannualPassholdersDiv.onmouseover = function() {
		DLRannualPassholdersTooltip.style.display = 'block';
		DLRannualPassholdersDiv.className = DLRannualPassholdersDiv.className + ' DLRtoolbarActive';
			
		// position and turn on shim for IE6
		if (document.all) {
			// add shim after objMenuList
			DLRannualPassholdersDiv.appendChild(DLRshim);
			DLRshim.style.height = DLRannualPassholdersTooltip.offsetHeight + "px";
			DLRshim.style.width = DLRannualPassholdersTooltip.offsetWidth + "px";
			DLRshim.style.display = 'block';
			DLRshim.style.top = DLRannualPassholdersTooltip.offsetTop + "px";
			DLRshim.style.left = DLRannualPassholdersTooltip.offsetLeft + "px";
		}
	};
	DLRannualPassholdersDiv.onmouseout = function() {
		DLRannualPassholdersTooltip.style.display = 'none';
		DLRremoveClass(DLRannualPassholdersDiv, 'DLRtoolbarActive');
		DLRshim.style.display = 'none';
	};
	
	document.getElementById("DLRmyDisneylandMedia").onfocus=DLRmyDisneylandDiv.onmouseover;
	document.getElementById("DLRannualPassholdersMedia").onfocus=DLRannualPassholdersDiv.onmouseover;
	document.getElementById("DLRmyDisneylandTooltip").onblur = DLRmyDisneylandDiv.onmouseout;
	document.getElementById("DLRannualPassholdersTooltip").onblur = DLRannualPassholdersDiv.onmouseout;
	
	// if user is not logged in, show login form "tooltip"
	if (DLRloginDiv != null) {
		DLRloginDiv.onmouseover = function() {
			DLRloginDiv.className = DLRloginDiv.className + ' DLRtoolbarActive';
		};
		DLRloginDiv.onmouseout = function() {
			DLRremoveClass(DLRloginDiv, 'DLRtoolbarActive');
		};
	}
	
})();
 	
