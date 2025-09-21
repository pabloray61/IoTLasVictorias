<?php  

class Border {
/*
 *   Esta clase define un borde en una celda de Excel, tiene 4 atributos y un 
 *   método que devuelve el tag Border del archivo XML.
 *   El constructor recibe como parametro la posición del borde.
*/
 var $Position;
 var $LinesStyle;
 var $Weight;
 var $Color;
 
 function Border($position,
                 $style = 'Continuous',
                 $weight = 1,
                 $color = '#666666')
 {
     $this->Position = $position;
     $this->LinesStyle = $style;
     $this->Weight = $weight;
     $this->Color = $color;
 }
 
 function getTag()
 {
     $cadena = array('<Border ss:Position="', $this->Position,
                           '" ss:LineStyle="', $this->LinesStyle,
                           '" ss:Weight="', $this->Weight,
                           '" ss:Color="', $this->Color , '"/>"');
		 
     return implode('', $cadena);
 }
} //    fin de Border

class Alignment {
/*
 *   Esta clase define la alineación de una celda de Excel, tiene 2 atributos y 
 *   un método que devuelve el tag Alignment del archivo XML.
*/
 var $Horizontal = 'Left';
 var $Vertical = 'Center';
 
 function getTag()
 {
     $cadena = array('<Alignment ss:Horizontal="', $this->Horizontal,
                     '" ss:Vertical="', $this->Vertical, '"/>');
     return implode('', $cadena);
 }
} //    fin de Alingment

class Font {
/*
 *   Esta clase define la fuente de una celda de Excel, tiene 6 atributos y un
 *   método que devuelve el tag Font del archivo XML.
*/
 var $FontName = 'Arial';
 var $FontFamily = 'Swiss';
 var $FontSize = 8;
 var $Color = '#666666';
 Var $UnderLine;
 var $Bold;
 var $Italic;
 
 function getTag()
 {

     $cadena  = array('<', 'Font ss:FontName="', $this->FontName,
                          '" x:Family="', $this->FontFamily,
                          '" ss:Size="', $this->FontSize,
                          '" ss:Color="', $this->Color, '"');
     if (is_numeric($this->UnderLine))
         array_push($cadena, ' ss:Underline="', $this->UnderLine, '"');
     if (is_numeric($this->Bold))
         array_push($cadena, ' ss:Bold="', $this->Bold, '"');
     if (is_numeric($this->Italic))
         array_push($cadena, ' ss:Italic="', $this->Italic . '"');
     $cadena[] = '/>';

     return implode('', $cadena);
 }  
} //    fin de Font

class Interior {
/*
 *   Esta clase define el relleno de una celda de Excel, tiene 2 atributos y un
 *   método que devuelve el tag Interior del archivo XML.
*/
 var $Color = '#FFCC00';
 var $Pattern = 'Solid';
 
 function getTag()
 {
     $cadena  = array('<Interior ss:Color="', $this->Color, '" ',
                                'ss:Pattern="', $this->Pattern, '" />');
		 
	 return implode('', $cadena);
 }
} //    fin de Interior

class NumberFormat {
/*
 *   Esta clase define el formato numérico de una celda de Excel, tiene
 *   un atributo y un método que devuelve el tag NumberFormat del archivo XML.
*/
 var $Format;
  
 function getTag()
 {
   $cadena = array('<NumberFormat ss:Format="', $this->Format, '"/>');
   return implode('', $cadena);
 }
} //    fin de NumberFormat

class Style {
/*
 *   Esta clase define el estilo de una celda de Excel. El estilo es la fuente,
 *   la alineación, los bordes, el relleno y el formato numérico de la celda.
 *   La clase tiene 7 propiedades y dos métodos.
 *   El primer método pone un borde y el otro devuelve el tag NumberFormat
 *   del archivo XML.
 *   El constructor recibe como parámetro una cadena que será el id del estilo.
*/
 var $ID;
 var $Font;
 var $Alignment;
 var $Borders;
 var $Interior;
 var $NumberFormat;
 var $Has_Borders = 0;
 
 function Style($ID)
 {
 	$this->ID = $ID;
 }
 
 function setBorder($position,
                    $style = 'Continuous',
                    $weight = 1,
                    $color = '#666666')
 {
     if (!($position=='Top'|
           $position=='Right'|
           $position=='Bottom'|
           $position=='Left')) return;
		 $border = new Border($position, $style, $weight, $color);
		 if (is_array($this->Borders)) $this->Borders = array() ;
		 $this->Borders[$position] = &$border;
 }
 
 function getTag()
 {
     
    // Abre el estilo
    $cadena = array('<Style ss:ID="', $this->ID, '">');
    // Alineación
    if (get_class($this->Alignment) == 'alignment')
        $cadena[] = $this->Alignment->getTag();
    // Bordes
    if (count($this->Borders)) {
        foreach ($this->Borders as $border) {
            $cadena[] = $border->getTag();
        }
		 
	} else if ($Has_Borders) {
        $border = new Border('Top');
        $cadena[] = $border->getTag();
        $border->Position = 'Right';
        $cadena[] = $border->getTag();
        $border->Position = 'Bottom';
        $cadena[] = $border->getTag();
        $border->Postiion = 'Left';
        $cadena[] = $border->getTag();
	}
	// Fuente
    if (get_class($this->Font) == 'font')
        $cadena[] = $this->Font->getTag();

    // Interior
	if (get_class($this->Interior) == 'interior')
        $cadena[] = $this->Interior->getTag();
	
	// Formato
	if (get_class($this->NumberFormat) == 'numberformat')
        $cadena[] = $this->NumberFormat->getTag();
	
	// Cierra el estilo
	$cadena[] = '</Style>';
	
    return implode('', $cadena);
 }
} //    fin de Style


class Data {
/*
 *   Esta clase contiene el dato de la celda y la información sobre su tipo.
 *   Tiene dos propiedades y un método que devuelve el Tag Data de XML.
 *   El constructor puede recibir como parámetros es tipo de datos y el valor.
*/
 var $Type;
 var $Value = '';

 function Data ($value='', $type='String')
 {
     $this->Value = $value;
     $this->Type = $type;
 }
 
function getTag()
 {
     $cadena = array('<Data ss:Type="',
                     $this->Type, '">',
                     $this->Value, '</Data>');
     return implode('', $cadena);
 }
}

class Cell {
/*
 *   Esta clase que define la celda de Excel, tiene seis propiedades y un método
 *   que devielve el tag Cell de XML.
 *   El constructor puede recibir como parámetros tres cadenas conteniendo
 *   el dato, es nombre del estilo y una fórmula.
*/
 var $Index;
 var $StyleId;
 var $Formula;
 var $HRef;
 var $HRefScreenTip;
 var $Data;
 
 function Cell($data='',$style='Default',$formula='')
 {
     if (is_numeric($data)) $this->Data = new Data($data, 'Number');
     else $this->Data = new Data($data);
     $this->Data = new Data($data);
     $this->StyleId = $style;
     if ($formula) $This->Formula = $formula;
 }
 
 function getTag()
 {
     $cadena = array('<', 'Cell ss:StyleID="', $this->StyleId, '" ');
     if ($this->Formula) {
         array_push($cadena, 'ss:Formula="', $this->Formula, '" ');
     }
     if ($this->HRef) {
         array_push($cadena, 'ss:HRef="', $this->Href, '" ');
         if ($this->HRefScreenTip)
             array_push($cadena,
                        'x:HRefScreenTip="',
                        $this->HRefScreenTip, '" ');
     }
     if ($this->Index) array_push($cadena, 'ss:Index="', $this->Index, '"');
     $cadena[] = '>';
     $cadena[] = $this->Data->getTag() . '</Cell>';
     
     return implode('', $cadena);
 }

}

class Row {
/*
 *   Esta clase es una fila del la planilla.
 *   Tiene cinco propiedades y dos métodos
*/
 var $Cells = array();
 var $AutoFitHeight;
 var $Height;
 var $Hidden;
 var $Index;
 var $StyleID;

 function addCell($cell)
 {
     if (get_class($cell) == 'cell') {
       if (!is_array($this->Cells)) $this->Cells = array($cell);
       else $this->Cells[] = $cell;
     }
 }
 
 function getTag()
 {
     $cadena = array('<', 'Row ');
     if ($this->AutoFitHeight)
         array_push($cadena, 'ss:AutoFitHeight="', $this->AutoFitHeight, '" ');
     if ($this->Height)
         array_push($cadena, 'ss:Height="', $this->Height, '" ');
     if ($this->Hidden)
         array_push($cadena, 'ssHidden="', $this->Hidden, '" ');
     if ($this->Index)
         array_push($cadena, 'ss:Index="', $this->Index, '" ');
     if ($this->StileId)
         array_push($cadena, 'ss:StyleID="', $this->StyleID, '" ');
     array_push($cadena, '>');
     foreach ($this->Cells as $cell) {
         array_push($cadena, $cell->getTag());
     }
     array_push($cadena, '</Row>');
     
     return implode('', $cadena);
 }
 
}

class Column {
/*
 *   Esta clase crea la etiqueta Column, que especifica definiciones para una
 *   columna. Tiene Cuatro propiedades y un método.
*/
 var $AutoFitWidth;
 var $Index;
 var $Span;
 var $StyleID;
 var $Width;
 
 function getTag()
 {
     $cadena = array('<', 'Column '); //2" ss:Width="97.5"/>)
     if ($this->AutoFitWidth)
         array_push($cadena, 'ss:AutoFitWidth="', $this->AutoFitWidth, '" ');
     if ($this->Index)
         array_push($cadena, 'ss:Index="', $this->Index, '" ');
     if ($this->StyleID)
         array_push($cadena, 'ss:StyleID="', $this->StyleID, '" ');
     if ($this->Width)
         array_push($cadena, 'ss:Width="', $this->Width, '" ');
     if ($this->Span)
         array_push($cadena, 'ss:Span="', $this->Span, '"');
     array_push($cadena, '/>');
     return implode('', $cadena);
 }
}

class Table {
/*
 *   Esta es la cuadrícula de datos de la hoja de Excel, que contiene todos los
 *   demás elementos visibles.
 *   Consta de cinco propiedades. Dos de ellas son array. Uno con las
 *   especificaciones para las columnas y el otro con las filas de la planilla.
 *   Tiene además trés métodos para agregar las especificaciones para las
 *   columnas, las filas de la tabla y devolver la etiqueta <Table>, con
 *   todos sus hijos.
*/
 var $Columns = array();
 var $Rows = array();
 var $DefaultColumnWidth;
 var $DefaultRowHeight;
 var $StyleID;
 
 function addColumn($column)
 {
     if (get_class($column) == 'column') {
         if (!is_array($this->Columns)) $this->Columns = Array($column);
         else $this->Columns[] = $column;
     }
 }
 
 function addRow($row)
 {
      if (get_class($row) == 'row') {
          if (!is_array($this->Rows)) $this->Rows = Array($row);
          else $this->Rows[] = $row;
      }
 }
 
 function getTag()
 {
     $cadena = array('<Table ');
     if ($this->DefaultColumnWidth)
         array_push($cadena,
                   'ss:DefaultColumnWidth="', $this->DefaultColumnWidth, '" ');
     if ($this->DefaultRowHeight)
         array_push($cadena,
                   'ss:DefaultRowHeight="', $this->DefaultRowHeight, '" ');
     if ($this->StyleID)
         array_push($cadena, 'ss:StyleID="', $this->StyleID, '" ');
     array_push($cadena, '>');
     foreach($this->Columns as $column) {
         array_push($cadena, $column->getTag());
     }
     foreach($this->Rows as $row) {
         array_push($cadena, $row->getTag());
     }
     array_push($cadena, '</Table>');
     return implode('', $cadena);
 }
}

class DocumentMargin {
 var $Location;
 var $Margin;
 var $Data;
 
 function DocumentMargin($location = 'Header', $margin=0, $data='')
 {
     $this->Location = $location;
     $this->Margin = $margin;
     $this->Data = $data;
 }
 
 function getTag()
 {
     $cadena = array('<', $this->Location, ' ');
     $cadena = array_push($cadena, 'x:Margin="', $this->Margin, '" ');
     $cadena = array_push($cadena, 'x:Data="', $this->Data, '"/>');
     return implode('', $cadena);
 }
}


class Layout {
 var $CenterHorizontal;
 var $centerVertical;
 var $Orientation;
 var $StartPageNumber;
 
 function getTag()
 {
     $cadena = array('<Layout ');
     if ($this->CenterHorizontal)
         array_push($cadena, 'x:CenterHorizontal="1" ');
     if ($this->CenterVertical)
         array_push($cadena, 'x:CenterVertical="1" ');
     if ($this->Orientation)
         array_push($cadena, 'x:Orientation="', $this->Orientation, '" ');
     if ($this->StartPageNumber)
         array_push($cadena, 'x:StartPageNumber="', $this->StartPageNumber, '"');
     array_push($cadena, '/>');
     return implode('', $cadena);
 }
}

class PageMargins {
 var $Bottom;
 var $Left;
 var $Right;
 var $Top;
 
 function getTag()
 {
     $cadena = array('<PageMargins ') ;
     if ($this->Bottom)
         array_push($cadena, 'x:Bottom="', $this->Bottom, '" ');
     if ($this->Left)
         array_push($cadena, 'x:Left="', $this->Left, '" ');
     if ($this->Right)
         array_push($cadena, 'x:Right="', $this->Right, '" ');
     if ($this->Top)
         array_push($cadena, 'x:Top="', $this->Top, '"');
     array_push($cadena, '/>');
     return implode('', $cadena);
 }
}

class PageSetup {
 var $Footer;
 var $Header;
 var $Layout;
 var $PageMargins;
 
 function getTag()
 {
     $cadena = array('<PageSetup>');
     if (get_class($this->Footer) == 'documentmargin')
         array_push($cadena, $this->Footer->getTag());
     if (get_class($this->Header) == 'documentmargin')
         array_push($cadena, $this->Header->getTag());
     if (get_class($this->Layout) == 'layout')
         array_push($cadena, $this->Layout->getTag());
     if (get_class($this->PageMargins) == 'pagemargins')
         array_push($cadena, $this->getTag());
     array_push($cadena, '</PageSetup>');
     return implode('', $cadena);
 }

}

class WorkSheet {
 var $Name;
 var $Table;
 var $WorksheetOptions;
 
 function WorkSheet($name='Hoja')
 {
     $this->Name = $name;
     $this->Table = new Table();
 }

 function getTag()
 {
     if (get_class($this->Table!='table')) $this->Table = new Table();

     $cadena = array('<Worksheet ss:Name="', $this->Name, '">');
     array_push($cadena, $this->Table->getTag());
     if (get_class($this->WorksheetOptions=='worksheetoptions'))
         array_push($cadena, $this->WorksheetOptions->getTag());
     array_push($cadena, '</Worksheet>');
     return implode('', $cadena);
 }
}

class Workbook {
/*
 *   Esta clase crea un archivo XML-XLS, que puede ser abierto por MS Excel,
 *   a partir de la version 10(XP).
 *   La jerarquía de objetos es la siguiente:
 *   Workbook
 *      |->Styles
 *      |     |->Style
 *	    |     |->Alignment
 *      |     |->Font
 *		|     |->Borders (Array)
 *		|     |     |->Border
 *		|     |->Interior
 *		|     -->NumberFormat
 *		|
 *		|->Worksheet
 *		      |->Table
 *            |     |->Column
 *            |     |->Rows (Array)
 *            |           |->Row
 *            |                  |->Cells (Array)
 *            |                        |->Cell
 * 		      |                              |->Data
 *            |
 *            |->WorksheetOptions
 *                  |->PageSetup
 *                        |->Header
 *                        |->Footer
 *                        |->Layout
 *                        |->PageMargins
*/
 var $DefaultStyle;
 var $Styles = array();
 var $WorkSheets = array();
 
 function Workbook()
 {
     //Agrega un estilo de celda por defecto
     $default = new Style('Default');
     $default->Font = new Font();
     $this->DefaultStyle = $default;
     
     //Agrega una hoja
     $sheet = new WorkSheet('Hoja1');
     array_push($this->WorkSheets, $sheet);
 }
 
 function addStyle($style)
 {
     if (get_class($style!='style')) return;
     if (!is_array($this->Styles)) $this->Styles = array();
     array_push($this->Styles, $style);
 }
 
 function addWorkSheet($worksheet)
 {
     if (get_class($worksheet!='worksheets')) return;
     if (!is_array($this->WorkSheets)) $this->WorkSheets = array();
     array_push($this->WorkSheets, $worksheet);
 }
 
 function getXML()
 {
     //Inicia el documento XML
     $cadena = array('<?xml version="1.0" encoding="ISO-8859-1"?>',
                     '<?mso-application progid="Excel.Sheet"?>',
                     '<Workbook xmlns="urn:schemas-microsoft-com:',
                     'office:spreadsheet" ',
                     'xmlns:o="urn:schemas-microsoft-com:office:office" ',
                     'xmlns:x="urn:schemas-microsoft-com:office:excel" ',
                     'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" ',
                     'xmlns:html="http://www.w3.org/TR/REC-html40">');

      //Agrega los estilos
      array_push($cadena, '<Styles>');
      array_push($cadena, $this->DefaultStyle->getTag());
      foreach ($this->Styles as $style)
          array_push($cadena, $style->getTag());
      array_push($cadena, '</Styles>');

      //Agrega las páginas
      foreach ($this->WorkSheets as $sheet)
          array_push($cadena, $sheet->getTag());
      
      //Cierra el libro
      array_push($cadena, '</Workbook>');
      return implode('', $cadena);
 }

 function OutPut($disposition='attachment', $filename='Libro1.xml')
 {
     if (!headers_sent()) {
         $buffer = $this->getXML();
         $header = implode('', array('Content-disposition: ', $disposition,
                               '; filename="', $filename, '"'));
         header('Content-Type: application/vnd.ms-excel');
         header('Content-Length: '.strlen($buffer));
         header($header);
         echo $buffer;
      } else {
         echo 'Ya se enviaron algunos datos al explorador. El Libro no se puede mostrar';
      }
 }
 
 
}	// fin de Workbook

?>
