MovieClip.prototype.blink = function (nTimes){
	this.$nTimes = nTimes;
	if ( !this._visible ) {
		this._visible = true;	
		this.$nTimes -= 1;
	}
	this.$blink_c = 0;
	delete this.onEnterFrame;
	this.onEnterFrame = function (){
		if ( this.$blink_c < this.$nTimes) {
			this._visible = !this._visible;
			this.$blink_c++;
		} else {
			this._visible = true;
			delete this.onEnterFrame;
			this.onBlinkDone();
		}
	}
}

//--------------------------------------------------------------
Array.prototype.shuffle=function(){
   for(i=0;i<this.length;i++){
      var tmp=this[i];
      var randomNum=random(this.length);
      this[i]=this[randomNum];
      this[randomNum]=tmp;
   }
}

//----------------------------------------------------------------
MovieClip.prototype.doAfter = function (millis, meth, obj, args){//espera un tiempo antes de ejecutar una fc
	this.millis = millis; 
	this.meth = meth; 
	this.obj = (obj == null) ? this:(obj); 
	this.args = args;
	
	if ( typeof this.meth == "function" ) {//si como arg usas una funcion
		this.$_f = function( ref ){
			ref.meth();
			clearInterval(ref.da_id);
		};
		this.da_id = setInterval(this.$_f, this.millis, this);
		
	} else {
		this.$_f = function (){//si como arg usas un método
			this[this.meth].apply(this.obj, this.args);
			clearInterval(this.da_id);
		};
		this.da_id = setInterval(this, "$_f", this.millis);
	}
}

MovieClip.prototype.wait = function (millis, nFrame){//Espera cierta cantidad de tiempo, y dp sigue la animacion
	this.stop();
	this.$nFrame = (this._currentframe+1) || nFrame;
	this.doAfter(millis, "gotoAndPlay", this, [this.$nFrame]);
}


//-----------------------------------------------
MovieClip.prototype.alpha = function(alphaF,vel){
this.alphaF=alphaF; this.alphaVel=vel;
        with(this){
		var alphaAc = _alpha; var newAlpha;
			  if(alphaAc < alphaF){
				 if(alphaF > alphaAc + alphaVel){newAlpha = alphaAc + alphaVel} else {newAlpha = alphaF; var done = true;}
			  }else{
				 if(alphaF < alphaAc - alphaVel){newAlpha = alphaAc - alphaVel} else {newAlpha = alphaF; var done = true;}
			  }
	     if (done) this.alpha_onDone();
          _alpha = newAlpha;
        }
}

MovieClip.prototype.alpha_d = function(alphaF, vel){
	this.onEnterFrame = function(){
		this.alpha(alphaF, vel);
	}
	this.alpha_onDone = function(){delete this.onEnterFrame;}
}

//------------------------------------------------------------
// Para animar botones
MovieClip.prototype.timelineTo = function(fFrame, vel){
	var dir, vel
	vel = (vel == undefined) ? 1:(vel);
	dir = (this._currentframe < fFrame) ? vel:-vel;
	
	this.timelineToObj = {fFrame:fFrame, dir:dir};
	this.onTimelineStart();
	
	this.onEnterFrame = function(){
		var fFrame = this.timelineToObj.fFrame, dir = this.timelineToObj.dir;
			if(this._currentframe != fFrame){
				this.gotoAndStop(this._currentframe + dir);	
			} else {
				delete this.timelineToObj;
				delete this.onEnterFrame;
				this.onTimelineEnd();
			}
	}
}

// ---
_global.getRandomNum = function ( n, base ){
	var b = base == undefined ? 0:(base);
	var r = b + Math.floor(Math.random()*n);
	return r;
}

//--
MovieClip.prototype.moverA = function(x,y,vel){
this.x=x;this.y=y;this.vel=vel
with(this){
	     var xA, yA, xS, yS; 	
 	     xA = _x; yA = _y;
 	     if(Math.abs(x - xA) > 1){ xS = (x - xA)/vel} else {xS = 0; var doneX = true;};
             if(Math.abs(y - yA)>1){ yS = (y - yA)/vel} else {yS = 0; var doneY = true;};
	     if (doneX and doneY ){this.moverA_onDone();};
	     _x += xS;
	     _y += yS;
        }
}
MovieClip.prototype.moverA_d = function (x, y, vel){
	this.onEnterFrame = function () {
		this.moverA (x, y, vel);
	}
	this.moverA_onDone = function () { delete this.onEnterFrame };
}
//----
MovieClip.prototype.escalarA=function(sx,sy,velx,vely){
this.sx=sx; this.sy=sy; this.escVelx=velx; this.escVely=vely;
        with(this){
		var escXA = _xscale; var escYA = _yscale; var escXN, escYN; VA = Math.abs;
		if (VA(escXA - sx) < 1 and VA(escYA - sy) < 1 ){_xscale = sx; _yscale = sy; this.escalarA_onDone();}
		_xscale = (escXN = escXA + (sx - escXA)/escVelx);
        _yscale = (escYN = escYA + (sy- escYA)/escVely);
		
        }
}
MovieClip.prototype.escalarA_d = function (sx, sy, velx, vely){
	this.onEnterFrame = function () {
		this.escalarA (sx, sy, velx, vely);
	}
	this.escalarA_onDone = function () { delete this.onEnterFrame };
}

//-- DO TYPE y ON LOAD
MovieClip.prototype.doType = function (texto, tf, vel){
	this.stopType();
	
	this.typeC = 0;
	this.typeText = texto;
	this.typeTf= tf;
	this.typeVel = vel == (undefined) ? 30:(vel);
	this.$type = function (){
		if ( this.typeC <= this.typeText.length ){
			this.typeC++;
			var str = this.typeText.substring(0, this.typeC);
			this.typeTf.text = str;
		} else clearInterval(this.typeInt);
	}
	this.typeInt = setInterval(this,"$type", 30, texto);	
}
MovieClip.prototype.stopType = function (){ clearInterval(this.typeInt) };
//---
MovieClip.prototype.addProperty("onLoad",
    function () {
        return _global.__onLoadList__[this];
	    
    },
    function (func) {
        if (_global.__onLoadList__ == undefined) _global.__onLoadList__ = {};
        _global.__onLoadList__[this] = func;
    }
);
ASSetPropFlags(MovieClip.prototype, "onLoad", 1);

