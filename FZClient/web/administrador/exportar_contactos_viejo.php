<?
require("conn.php");
require("func.php");
require("xml_xls_book.php");			//Agregamos la librería

session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

$filtro_v = $_REQUEST['filtro_v'];
$filtro_c = $_REQUEST['filtro_c'];
$filtro_t = $_REQUEST['filtro_t'];

$vend = "";
if($_SESSION['admin'] != "ok"){
	$vend= " id_vendedor=" . $_SESSION['id_vendedor'];
}else{
	if($filtro_vendedor != "" AND $filtro_vendedor != "all"){ 
		$vend = " id_vendedor = " . $filtro_v;
	}
}			
if($filtro_t != "" and $filtro_t != "all") $tipo = " t.id_tipo = ".$filtro_t;
if($filtro_c != "" and $filtro_c != "all") $categoria = " c.id_categoria = ".$filtro_c;

if($vend != "" || $tipo != "" || $categoria != "") $w = " WHERE";
if($vend != "" && ($tipo != "" || $categoria != "")) $w2 = " and";
if($tipo != "" && $categoria != "") $w3 = " and";

$where = $w ." ". $vend ." ". $w2 ." ". $tipo ." ". $w3 ." ". $categoria ." ". $sq2 ." ". $orden;
//echo $where."<br>";

$title = "Listado de clientes";



//Creamos un nuevo libro Excel
$libro = new WorkBook();

//El libro que se acaba de crear tiene una hoja predeterminada en el array
//WorkSheets, que contine las hojas del libro. El índice de esta hoja es cero y
//ya contiene una tabla. Definimos un alias a esa tabla.
$tabla = &$libro->WorkSheets[0]->Table;

$fuente_t = new Font();                         //Creamos un objeto Font
$fuente_t->FontSize = 11;                       //Ponemos el tamaño de la fuente
$fuente_t->Color = '#000000';
$fuente_t->Bold = 1;                            //Ponemos en negrita

$estilo_t = new Style('estilo_t');                 
$estilo_t->Font= $fuente_t;        
$estilo_t->Interior = new Interior();
$estilo_t->Interior->Color = '#FFFFFF';

//Definimos los estilos
$fuente = new Font();                         //Creamos un objeto Font
$fuente->FontSize = 10;                       //Ponemos el tamaño de la fuente
$fuente->Color = '#000000';                   //Ponemos el color del texto(verde)
//$fuente->Bold = 1;                            //Ponemos en negrita

$estilo = new Style('estilo');                 //Creamos un Style llamado 'verde',
$estilo->Font= $fuente;                       //que tendrá la fuente que creamos.
$estilo->Interior = new Interior();           //Creamos un Instancia del objeto Interior y la asignamos a la propiedad Interior del estilo.
$estilo->Interior->Color = '#FFFFFF';         //Definimos el color de relleno.

$libro->addStyle($estilo);                    //Agregamos el estilo al libro.
$libro->addStyle($estilo_t);                    //Agregamos el estilo al libro.

//Definiciones de columnas
$col = new Column();                          //Creo la columna
$col->Index = 1;                              //columna
$col->Width = 180;                            //ancho de la columna
$tabla->addColumn($col);
$col2 = new Column();						  // creo la columna 2
$col2->Index = 2;    
$col2->Width = 80;  
$tabla->addColumn($col2);
$col3 = new Column();						  // creo la columna 3
$col3->Index = 3;        
$col3->Width = 80;      
$tabla->addColumn($col3);
$col4 = new Column();						  // creo la columna 4
$col4->Index = 4; 
$col4->Width = 180;
$tabla->addColumn($col4);
$col5 = new Column();						  // creo la columna 5
$col5->Index = 5; 
$col5->Width = 100;
$tabla->addColumn($col5);
$col6 = new Column();						  // creo la columna 6
$col6->Index = 6; 
$col6->Width = 100;
$tabla->addColumn($col6);
$col7 = new Column();						  // creo la columna 7
$col7->Index = 7; 
$col7->Width = 90;
$tabla->addColumn($col7);
$col8 = new Column();						  // creo la columna 8
$col8->Index = 8; 
$col8->Width = 90;
$tabla->addColumn($col8);
$col9 = new Column();						  // creo la columna 9
$col9->Index = 9; 
$col9->Width = 200;
$tabla->addColumn($col9);
$col10 = new Column();						  // creo la columna 10
$col10->Index = 10; 
$col10->Width = 50;
$tabla->addColumn($col10);
$col11 = new Column();						  // creo la columna 11
$col11->Index = 11; 
$col11->Width = 150;
$tabla->addColumn($col11);
$col12 = new Column();						  // creo la columna 12
$col12->Index = 12; 
$col12->Width = 100;
$tabla->addColumn($col12);


//Definición de las filas
$fila = new Row();                            //Creamos un nueva fila

//Definición de la celda
$celda = new Cell('Listado de Clientes '.$title.' ('. date(d.'/'.m.'/'.Y) .')');   //Creamos una celda con un texto.
$celda->StyleId = 'estilo_t'; 

$fila->addCell($celda);                       //Agregamos la celda a la fila y
$tabla->addRow($fila);                        //la fila a la tabla.

// TITULOS

//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Nombre';                //A nuestra celda le cambiamos el
	$celda->StyleId = 'estilo_t';                   //Le asignamos el estilo que habiámos definido antes
	//$celda->Data->Type ='Number';               //valor y el tipo de datos.
	$celda->Index = 1;                            //la ubicamos en la cuarta columna

	$fila->Cells = array();                       //Limpiamos el array de celdas,
	$fila->Cells[] = $celda;                      //agregamos la celda a la fila,

//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Telefono';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 2;

	$fila->Cells[] = $celda;

//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Celular';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 3;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'E-mail';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 4;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Cuit - DNI';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 5;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Contacto';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 6;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Fecha de alta';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 7;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Cumpleaños';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 8;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Dirección';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 9;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'CP';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 10;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Localidad';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 11;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = 'Tipo de Cliente';
	$celda->StyleId = 'estilo_t'; 
	$celda->Index = 12;

	$fila->Cells[] = $celda;

	$tabla->Rows[] = $fila; 					  //agregamos la fila a la tabla.

// FIN TITULOS


$i = 0;
$q = query("SELECT * FROM clientes c 
			LEFT JOIN categoria_clientes cc on c.id_categoria = cc.id_categoria 
			LEFT JOIN tipo_clientes t on c.id_tipo = t.id_tipo 
			LEFT JOIN listas l on c.id_lista = l.id_lista 
			$where");
			
	while($rs = mysql_fetch_array($q)){
	$apellido = $rs['apellido'];
	$nombre = $rs['nombre'];
	if($nombre != "") $apellido = $apellido.", ".$nombre; 
	$telefono = $rs['telefono'];
	$cell = $rs['celular'];
	$mail = $rs['mail'];
	$cuit = $rs['cuit'];
	$contacto = $rs['contacto'];
	$fecha_alta = $rs['fecha_alta'];
	$fecha_cumple = $rs['fecha_cumple'];
	$direccion = $rs['direccion'];
	$cp = $rs['cp'];
	$localidad = $rs['localidad'];
	$tipo = $rs['tipo'];
	
	$id_vendedor = $rs['id_vendedor'];
	$categoria = $rs['categoria'];
	$id_lista = $rs['id_lista'];
	$lista = $rs['lista'];

//------------------------------------------
	//Otra celda
	$celda->Data->Value = $nombre;                //A nuestra celda le cambiamos el
	$celda->StyleId = 'estilo';                   //Le asignamos el estilo que habiámos definido antes
	//$celda->Data->Type ='Number';               //valor y el tipo de datos.
	$celda->Index = 1;                            //la ubicamos en la cuarta columna

	$fila->Cells = array();                       //Limpiamos el array de celdas,
	$fila->Cells[] = $celda;                      //agregamos la celda a la fila,

//------------------------------------------
	//Otra celda
	$celda->Data->Value = $telefono;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 2;

	$fila->Cells[] = $celda;

//------------------------------------------
	//Otra celda
	$celda->Data->Value = $cell;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 3;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $mail;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 4;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $cuit;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 5;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $contacto;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 6;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $fecha_alta;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 7;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $fecha_cumple;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 8;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $direccion;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 9;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $cp;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 10;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $localidad;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 11;

	$fila->Cells[] = $celda;
//------------------------------------------
	//Otra celda
	$celda->Data->Value = $tipo;
	$celda->StyleId = 'estilo'; 
	$celda->Index = 12;

	$fila->Cells[] = $celda;

	$tabla->Rows[] = $fila; 					  //agregamos la fila a la tabla.


}
$hoy = date(d."-".m."-".Y);
//Al explorador
$libro->OutPut('attachment', 'Contactos '.$title.' '.$hoy.'.xls');  //Enviamos nuestro libro al explorador

?>



