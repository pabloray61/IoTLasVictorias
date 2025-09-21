<script language="javascript" type="text/javascript">
<!--
//Constantes
	c_Combo_Otros=0;
	var enProceso = false; // lo usamos para ver si hay un proceso activo
	var http = getHTTPObject(); // Creamos el objeto XMLHttpRequest

	function validaLetra(e){
/*	
	Valida Letras: a-z A-Z  backspace,ctrl,shift, delete
	Se llama desde el evento onkeyPress() del textbox
*/
		var tecla = (document.all) ? e.keyCode : e.which;
		if (tecla == 0 || tecla == 8 || tecla == 32) return true; //delete,shift,ctrl, backspace,etc 
		if ((tecla >= 65 && tecla<=90) || (tecla >= 97 && tecla<=122))  //A-Z a-z
			return true;
		else
			return false;
	}
	
	function validaNumero(e){
		var tecla = (document.all) ? e.keyCode : e.which;
		if (tecla == 0 || tecla == 8) return true; //delete,shift,ctrl, spacebar,etc 
		if (tecla >= 48 && tecla <= 57) 
			return true; //backspace,delete,shift,ctrl, etc 
		else 
			return false;
	}

	function validaDNI(e){
		var valida = false;
		if (validaNumero(e)) 
			valida = true;
		return valida;
	}
	function validaPass(e){
		var valida = false;
		if (validaNumero(e) || validaLetra(e)) 
			valida = true;
		return valida;
	}

	

	function FcheckEmail(NombreText){
		var campo = document.getElementById(NombreText);
		var s = campo.value;
		var allValid = true;
		var filter=/^[A-Za-z][A-Za-z0-9_.-]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.-]+[A-za-z]$/;

		if (s.length == 0 ) return true;

		if (!filter.test(s))
		{
			allValid=false;
			campo.focus();
			MostrarDivMensaje ("Ingrese una direccion de email valida.");
		}
		return allValid;
	}

	function FcheckDNI(NombreText){
/*	
	Valida Letras y Numeros
	Se llama desde el evento onchange() del textbox
*/
		var campo = document.getElementById(NombreText);
		var v = campo.value;
		var allValid = true;
		MostrarDivMensaje ("");
		var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú " + "1234567890";
		var checkStr = campo.value;

		for (i = 0; i < checkStr.length; i++) 
		{
			ch = checkStr.charAt(i);
			for (j = 0; j < checkOK.length; j++)
				if (ch == checkOK.charAt(j))
				break;//Todo ok
				if (j == checkOK.length) 
				{
					allValid = false;
					break; 
				}
		}
		if (!allValid){
			campo.focus();
			MostrarDivMensaje ("Sólo LETRAS y NUMEROS para " + NombreText + ".");
			}

		return allValid;
	}
	
	function FcheckNumber(NombreText){
	//A esta altura se supone que ya valide vacio.
		var campo = document.getElementById(NombreText);
		var v = campo.value;
		MostrarDivMensaje ("");
		var allValid = true;

		if((isNaN(v)))
		{ 
			MostrarDivMensaje ("Sólo se admiten NUMEROS para " + NombreText + ".");
			campo.focus();
			allValid =  false;
		}
		return allValid;
	}

	function FcheckLetras (NombreText,Descrip){
		var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú ";
		var allValid = true;
		var campo = document.getElementById(NombreText);
		var checkStr = campo.value;
		if (!Descrip) Descrip = NombreText; //Si no envio descripcion, asigno el Nombre del campo
		
		for (i = 0; i < checkStr.length; i++) 
		{
			ch = checkStr.charAt(i);
			for (j = 0; j < checkOK.length; j++)
				if (ch == checkOK.charAt(j))
				break;//Todo ok
				if (j == checkOK.length) 
				{
					allValid = false;
					break; 
				}
		}	

		MostrarDivMensaje ("");
		if (!allValid){
			campo.focus();
			MostrarDivMensaje ("Sólo se admiten LETRAS para " + Descrip + ".");
			}
		return allValid;
	}

	//Función para crear un objeto XMLHttpRequest
	function crearAjax() {
	  var Ajax;
	  if (window.XMLHttpRequest) { // Intento de crear el objeto para Mozilla, Safari,...
		Ajax = new XMLHttpRequest();
		if (Ajax.overrideMimeType) {
		  //Se establece el tipo de contenido para el objeto
		  http.overrideMimeType('text/html');
		 }
	   } else if (window.ActiveXObject) { // IE
		try { //Primero se prueba con la mas reciente versión para IE
		  Ajax = new ActiveXObject("Msxml2.XMLHTTP");
		 } catch (e) {
		   try { //Si el explorer no esta actualizado se prueba con la versión anterior
			 Ajax = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		  }
	   }
	 
	  if (!Ajax) {alert('¡Por favor, actualice su navegador!');return false;}
	  else{
			return Ajax;
		  }
	 }



function ComboVacio(NombreCombo,Descrip)
{
	//Devuelve TRUE si el campo está vacio.  A.C.
	//Descrip , lo que sale en el mensaje de error como info a completar.
	var combo = document.getElementById(NombreCombo);
	var checkStr = combo.value;
	var valida = false;
	
	if (!Descrip) Descrip = NombreCombo; //Si no envio descripcion, asigno el Nombre del campo

	if (!checkStr || checkStr ==100){
		MostrarDivMensaje ("Debe seleccionar " + Descrip)
		valida = true;}
				
	return valida;
}
	
function CampoVacio(NombreText,Descrip)
{
	//Devuelve TRUE si el campo está vacio.  A.C.
	var campo = document.getElementById(NombreText);
	var checkStr = campo.value;
	var valida = false;

	if (!Descrip) Descrip = NombreText; //Si no envio descripcion, asigno el Nombre del campo
	
	if (!checkStr){
		MostrarDivMensaje ("El campo " + Descrip + " no puede estar vacío.")
		valida = true;}
				
	return valida;
	
}
	function Validar() {
			if (CampoVacio("Nombre") || !FcheckLetras ("Nombre")) return false;
			var Nombre = escape(document.getElementById("Nombre").value);
			
			if (CampoVacio("Apellido") || !FcheckLetras ("Apellido")) return false;			
			var Apellido = escape(document.getElementById("Apellido").value);
			
			if (CampoVacio("DNI") || !FcheckDNI ("DNI")) return false;
			var DNI = escape(document.getElementById("DNI").value);
			
			if (CampoVacio("Domicilio")) return false;
			var Domicilio = escape(document.getElementById("Domicilio").value);		   
		   
			if (ComboVacio("cboPais","Pais")) return false;
			var cboPais = escape(document.getElementById("cboPais").value);

			if (CampoVacio("Provincia") || !FcheckLetras ("Provincia")) return false;
			var Provincia = escape(document.getElementById("Provincia").value);

			if (CampoVacio("Localidad") || !FcheckLetras ("Localidad")) return false;	   
			var Localidad = escape(document.getElementById("Localidad").value);

			if (CampoVacio("CP","Codigo Postal")) return false;
			var CP = escape(document.getElementById("CP").value);

			if (ComboVacio("cboCable","TV por Cable")) return false;
		    var cboCable = document.getElementById("cboCable").value;
			if (cboCable == 0 && (CampoVacio("txtCable","TV por Cable") || !FcheckLetras ("txtCable","TV por Cable")) ) return false; 
			var txtCable = document.getElementById('txtCable').value;

			if (ComboVacio("cboCelular","Telefonia Movil")) return false;
		    var cboCelular = document.getElementById("cboCelular").value;
			if (cboCelular == 0 && (CampoVacio("txtCelular","Telefonia Movil") || !FcheckLetras ("txtCelular","Telefonia Movil")) ) return false; 
			var txtCelular = document.getElementById('txtCelular').value;
			
			if (ComboVacio("cboInternet","Proveedor de Internet")) return false;
		    var cboInternet = document.getElementById("cboInternet").value;
			if (cboInternet == 0 && (CampoVacio("txtInternet","Proveedor de Internet") || !FcheckLetras ("txtInternet","Proveedor de Internet")) ) return false; 
			var txtInternet = document.getElementById('txtInternet').value;
		   
			if (CampoVacio("Telefono") || !FcheckNumber ("Telefono")) return false;	   
		    var Telefono = document.getElementById('Telefono').value;
	   
			if (ComboVacio("Sexo")) return false;
			var Sexo = document.getElementById("Sexo").value;

			if (CampoVacio("Edad") || !FcheckNumber ("Edad")) return false;
			var Edad =document.getElementById("Edad").value;
		   
			if (CampoVacio("Email") || !FcheckEmail ("Email")) return false;
		    var Email = document.getElementById("Email").value;

		    var newsletter = document.getElementById('newsletter').value;

			if (!enProceso && http) 
			{
			    var url = "Formulario_Enviar.asp?Nombre="+ Nombre + "&Apellido="+ Apellido+ "&Domicilio="+ Domicilio+ "&DNI="+ DNI + "&cboPais="+ cboPais+ "&Provincia="+ Provincia+ "&Localidad="+ Localidad;
				url = url + "&CP="+ CP+ "&cboCable="+ cboCable+ "&txtCable="+ txtCable +"&cboCelular="+ cboCelular + "&txtCelular="+ txtCelular+ "&cboInternet="+ cboInternet+ "&txtInternet="+ txtInternet;
				url = url + "&Telefono="+ Telefono+ "&Sexo="+ Sexo + "&Edad="+ Edad + "&Email="+ Email;
				http.open("GET", url, true);
				http.onreadystatechange = handleHttpResponse;
				enProceso = true;
				http.send(null);
				setTimeout(showComments, 500); //Timeout y muestro el mensaje.
			}

	}

function getHTTPObject() {
    var xmlhttp;
    /*@cc_on
    @if (@_jscript_version >= 5)
       try {
          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (E) { xmlhttp = false; }
       }
    @else
    xmlhttp = false;
    @end @*/
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
       try {
          xmlhttp = new XMLHttpRequest();
       } catch (e) { xmlhttp = false; }
    }
    return xmlhttp;
}

//-->
</script>