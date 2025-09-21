// ---- 

/*
Events:
--> on_fake_preload(): es como un on_preload_done para el caso de q  ya está cargada. Podés diferenciar q hace cuando 
						termino de cargar si ya estaba actualizada y si no estaba actualizada.
--> on_preload_start(): si la definis, tenes q escribirle el método start_preloading() cuando termina de hacer las sentencias: 
						Sirve para acomodar cosas antes de empezar a cargar y chequear, como hacerlo ir a un fotograma
						especial donde está la barrita de carga
--> on_preload_done(): el último evento, cuando terminó de cargar

Métodos:
start_preloading(): lo definis si usaste on_preload_start() para q empiece a cargar y checkear

*/
dynamic class Preload {
	function Preload (target, url ){
		this.target = target;
		this.url = url;
		var ar = url.split ("?"); //en ar[0] busco la url sin fecha de modificacion, x ej: home.swf

		this.so = SharedObject.getLocal("soulmax");
		
		//t+= "ar[0] = " + this.so.data[ar[0]] + ", url=" + this.url + "\n";

		if (this.so.data[ar[0]] == this.url) {
			//trace("No necesita actualizarse");
			this.actualizar = false;
		} else {
			//trace("Necesita actualizarse");
			this.actualizar = true;
			//guarda el nuevo last_modified
			this.so.data[ar[0]] = this.url;
			this.so.flush();
		}
		if (_level0._url.substring(0,7) != "http://") this.url = ar[0];
	}

	function load (){
		if ( this.on_preload_start != undefined) this.on_preload_start();		
		else this.start_preloading();
	}

	function start_preloading (){
		
		if( typeof this.target == "string" ) { //Si es un nivel, carga con loadMovieNum
			loadMovieNum(this.url, this.target.substring(6, this.target.length));
		} else this.target.loadMovie( this.url ); //Si es movieclip, con loadMovie
		
		this.id = setInterval(this, "$preload_check", 10);
	}

	function $preload_check (){
		//trace("$preload_check()");
		
		if (typeof this.target == "string" and eval(this.target).getBytesLoaded() > 1) this.target = eval(this.target); 
		
		this.loaded = this.target.getBytesLoaded();
		this.total = this.target.getBytesTotal();
		this.porc = (this.porc == undefined) ? "0":(Math.round(this.loaded*100/this.total));
		
		if (this.actualizar) this.on_preload_update();
		
		if (this.porc == 100 and this.loaded > 1) {
			clearInterval( this.id );
			
			if ( !this.actualizar and this.on_fake_preload != undefined ){//esta cacheado
				this.on_fake_preload();
			} else this.on_preload_done();	
		}
	}


}
