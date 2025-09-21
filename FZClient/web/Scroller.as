/*
holder: mc que se va a scrollear
mask: máscara usada
knob = nombre del mc que hace de cosito para scrollear, y d es el ancho o la altura según corresponda a desplazamiento 		vertical y horizontal.
largo_barra: cuanto querés que se desplace el knob (tenes q tener en cuenta la altura o ancho del mismo)
horizontal: Boolean. Si no escribís nada es vertical
*/

dynamic class Scroller{
	function Scroller (holder, mask, knob, largo_barra, btn_up, btn_dw, horizontal){
		this.holder = holder;
		this.mask = mask;
		this.knob = knob;
		this.largo_barra = largo_barra;
		this.btn_up = btn_up;
		this.btn_dw = btn_dw;
		this.horizontal = horizontal;
		this.step = 15;//velocidad del paso de los botones up, dw
			
		if ( this.horizontal ){
			this.prop = "_x";
			this.dim = "_width";
			this.koeficient = this.largo_barra/(this.holder._width - this.largo_barra - 1.5 * this.knob._width);
			this.holderI = this.holder._x; //posición inicial del holder
			this.knobI = this.knob._x;

			this.top = this.knob._y;
			this.left = this.knob._x;
			this.right = this.knob._x + this.largo_barra;
			this.bottom = this.knob._y;

		} else { // vertical
			this.prop = "_y";
			this.dim = "_height";
			this.koeficient = this.largo_barra/(this.holder._height - this.largo_barra - 1.5 * this.knob._height);
			this.holderI = this.holder._y; //posición inicial del holder
			this.knobI = this.knob._y;

			this.top = this.knob._y;
			this.left = this.knob._x;
			this.right = this.knob._x;
			this.bottom = this.knob._y + this.largo_barra;
		}
		
		this.knob._ref = this.btn_up._ref = this.btn_dw._ref = this; //Le paso la referencia de la clase al knob
		this.$init();
	}


	//Private functions ------------
	function $init(){
		this.holder.setMask (this.mask);
		
		// knob ------ 
		this.knob.onPress = function (){
			this.startDrag (false, this._ref.left, this._ref.top, this._ref.right, this._ref.bottom);
			this._ref.dragInt = setInterval(this._ref, "$onMove", 30);

		}	
		this.knob.onRelease = this.knob.onReleaseOutside = function (){
			this.stopDrag();
			clearInterval (this._ref.dragInt);
		}

		// btns up y dw ------
		this.btn_up.onPress = this.btn_dw.onPress = function (){
			clearInterval (this._ref.pressInt);
			this._ref.pressInt = setInterval (this._ref, "$moveKnob", 30, this);
		}
		this.btn_up.onRelease = this.btn_up.onReleaseOutside =  this.btn_dw.onRelease = this.btn_dw.onReleaseOutside = function (){
			clearInterval (this._ref.pressInt);
		}

	}

	function $onMove (){
		//this.holder[this.prop] = this.holderI - (this.knob[this.prop] - this.knobI)/this.koeficient;
		this.holder[this.prop] = this.holderI - ( this.holder[this.dim] - this.mask[this.dim]) * (this.knob[this.prop] - this.knobI)/(this.largo_barra);
	}
	
	function $moveKnob (btn){
		var limite_sup, limite_inf
		
		if ( this.horizontal ){
			limite_sup = this.left;
			limite_inf = this.right;
		} else {
			limite_sup = this.top;
			limite_inf = this.bottom;			
		}

		if ( btn == this.btn_dw) {
			if (this.knob[this.prop] + this.step * this.koeficient < limite_inf) {
				this.knob[this.prop] += this.step * this.koeficient;
			} else this.knob[this.prop] = limite_inf;	
		} else {
			if (this.knob[this.prop] - this.step * this.koeficient > limite_sup) {
				this.knob[this.prop] -= this.step * this.koeficient;
			} else this.knob[this.prop] = limite_sup;
		}
		this.$onMove();//acamodo el holder dependiendo de donde está el knob
	}

}