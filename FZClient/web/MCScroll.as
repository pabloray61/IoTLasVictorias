/*
Federico Paz (federicopaz@fibertel.com.ar)

ARGUMENTOS:

holder:[MOVIECLIP] movieclip q se quiere scrollear.
mask:[MOVIECLIP] la máscara que usás como zona donde se va a ver el movieclip scrolleado
up:[MOVIECLIP] el movieclip que va a hacer de botón para scrollear para arriba
dw:[MOVIECLIP] el movieclip que va a hacer de botón para scrollear para abajo
vel:[INT] la velocidad de scrolleado. Por default es 7. 
horizontal:[BOOLEAN] si es horizontal o vertical

IMPORTANTE: el holder tiene que estar más arriba que la máscara cuando se arma una instancia de la clase
*/




dynamic class MCScroll{
	function MCScroll (holder, mask, up, dw, horizontal, vel){
		this.holder = holder;
		this.mask = mask;
		this.up = up;
		this.dw = dw;
		this.vel = vel != undefined ? vel:7;
		if ( horizontal ){
			this.prop = "_x";
			this.dim = "_width";
		} else {
			this.prop = "_y";
			this.dim = "_height";
		}
		this.holder.setMask (this.mask);
		
		//this.holder._y = this.mask._y; --> Inicialmente el holder tiene q estar mas arriba q la máscara para q ande

		this.up._ref = this.dw._ref = this;

		this.up.onPress = this.dw.onPress = function (){
			var dir = this == this._ref.up ? this._ref.vel:-this._ref.vel
			this._ref.interval = setInterval(this._ref, "_moveHolder", 30, dir);
		}
		this.up.onRelease = this.up.onReleaseOutside = this.dw.onRelease = this.dw.onReleaseOutside = function (){
			clearInterval (this._ref.interval);
		}

	}

	function _moveHolder( dir ){
		if (this.mask[this.prop] + 10 >= this.holder[this.prop] + dir and 
			this.mask[this.prop] + this.mask[this.dim]  <= this.holder[this.prop] + this.holder[this.dim] + dir){
			this.holder[this.prop] += dir;
		}
	}
}
