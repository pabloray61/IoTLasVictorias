
dynamic class FlashCart{

	//inicializa la clase
	function FlashCart() {  this.items = []; } 

	function addItem (cod, desc, cant, precio)
	{
		var index = this.getIndex( cod );
		if ( index != undefined ){
			this.items[index].cant += cant;
			this.items[index].subtotal = precio * this.items[index].cant;
		} else {
			var obj = {cod: cod, desc:desc, cant:cant, precio:precio, subtotal:precio*cant};
			this.items.push (obj);
		}
	}

	function removeItem ( cod )
	{
		var index = this.getIndex (cod);
		if ( index != undefined ){
			this.items.splice(index, 1);
			return true;
		} else return false;
	}
	

	function update (cod, cantFinal)
	{
		var index = this.getIndex (cod);
		this.items[index].cant = cantFinal;
		this.items[index].subtotal = cantFinal * this.items[index].precio;
		
		return index;
	}

	function refresh(){//elimina los q estan con cantidad cero
		for ( var i=0; i<this.items.length; i++){
			var obj = this.items[i];
			if ( obj.cant == 0) this.removeItem (obj.cod);
		}
	}
	function removeItems(){
		this.items = [];
	}

	function getTotal ()
	{
		var total = 0;
		for ( var i=0; i<this.items.length; i++){
			total += this.items[i].subtotal; 
		}
		return total;
	}

	function listCart() //For debug
	{
		trace("FLASH CART LISTING: ")
		for ( var i=0; i<this.items.length; i++){
			trace("Código: " + this.items[i].cod );
			trace("Descripción: " + this.items[i].desc );
			trace("Cant: " + this.items[i].cant );
			trace("Precio: " + this.items[i].precio );
			trace("SubTotal: " + this.items[i].subtotal );
			trace("   ---    ");
		}
		trace("Total: " + this.getTotal())
		trace("******************************");
	}


	// Private functions
	private function getIndex ( cod ){ //Le pasas el codigo de prod y te devuelve el index del lugar del arreglo
		var index;
		for ( var i=0; i<this.items.length; i++) {
			if (this.items[i].cod == cod) {
				index = i;
				break;
			}
		}
		return index;
	}

}

