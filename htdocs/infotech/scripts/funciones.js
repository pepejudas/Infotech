var mes;
var diaIni;
var diaFin;

function verificarseleccion(){
try{
var opcion=document.getElementsByName("opcionturnos")[0].value;
docehoras(opcion);
}catch(error){
    mensajeini(error);
}
}

function docehoras(opcion){
if(opcion=="1"){
	a=1;b=0;
}else if(opcion=="2"){
	a=0;b=1;
}else if(opcion=="3"){
	a=1;b=1;
}else{
	a=0;b=0;
}	

try{
        for(i=1;i<31;i++){
		Ext.get("d"+i).dom[0].selected='selected';
	}
	for(i=1;i<31;i++){
		Ext.get("n"+i).dom[0].selected='selected';
	}

	for(i=diaIni;i<diaFin;i++){
		Ext.get("d"+i).dom[a].selected='selected';
	}
	for(i=diaIni;i<diaFin;i++){
		Ext.get("n"+i).dom[b].selected='selected';
	}
}catch(err){
	mensajeini(err);
}
}

function conviertemes(mestexto){
var mesnumero="";
switch(mestexto){
case	"January": 	mesnumero=1;break;
case	"February": mesnumero=2;break;
case	"March": 	mesnumero=3;break;
case	"April": 	mesnumero=4;break;
case	"May": 		mesnumero=5;break;
case	"June": 	mesnumero=6;break;
case	"July": 	mesnumero=7;break;
case	"August": 	mesnumero=8;break;
case	"September":mesnumero=9;break;
case	"October": 	mesnumero=10;break;
case	"November": mesnumero=11;break;
case	"December": mesnumero=12;break;
}
return mesnumero; 	
}

function numdias(humanMonth, year) {
return new Date(year || new Date().getFullYear(), humanMonth, 0).getDate();
}

Ext.onReady(function(){

mes=conviertemes(document.getElementById("mesbusca").value);
diaIni=Ext.get('tdesde').dom.value;
diaFin=numdias(mes, document.getElementById("anobusca").value);
Ext.get('thasta').dom.value=diaFin;
Ext.get('botonver').on('click', function(){
    diaIni = Ext.get('tdesde').dom.value;
    diaFin = Ext.get('thasta').dom.value;
    diaFin++;
    verificarseleccion();
});
});