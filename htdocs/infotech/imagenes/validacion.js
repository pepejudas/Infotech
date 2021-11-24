// ----------------------------------------------------------------------
//           FormCheq.js (c) ChaTo [www.chato.cl] 1998
//           basado en FormChek.js (c) Eric Krock 1997 Netscape Corp.
// ----------------------------------------------------------------------
// Rutinas para verificacion de formularios, basado en FormChek.js
// Parte del curso "TEJEDORES DEL WEB" http://www.TejedoresDelWeb.com/
// ---------------------------------------------------------------------- 

var defaultEmptyOK = false;
var checkNiceness = true;
var digits = "0123456789";
var lowercaseLetters = "abcdefghijklmnopqrstuvwxyzáéíóúñü _";
var uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚÑ _";
var whitespace = " \t\n\r";
var phoneChars = "()-+ ";
var mMessage = "Error: no puede dejar este espacio vacio";
var pPrompt = "Error: ";
var pAlphanumeric = "ingrese un texto que contenga solo letras y/o numeros";
var pAlphabetic = "ingrese un texto que contenga solo letras";
var pAlphabetic2 = "";
var pInteger = "ingrese un numero entero";
var pNumber = "ingrese un numero";
var pFecha = "No ha seleccionado una fecha valida";
var pPhoneNumber = "ingrese un número de teléfono";
var pEmail = "ingrese una dirección de correo electrónico válida";
var pName = "ingrese un texto que contenga solo letras, numeros o espacios";
var pNice = "no puede utilizar comillas aqui";

function makeArray(n) {
	for ( var i = 1; i <= n; i++) {
		this[i] = 0;
	}
	return this;
}

function isEmpty(s) {
	return ((s == null) || (s.length == 0));
}

function isWhitespace(s) {
	var i;
	if (isEmpty(s))
		return true;
	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		// si el caracter en que estoy no aparece en whitespace,
		// entonces retornar falso
		if (whitespace.indexOf(c) == -1)
			return false;
	}
	return true;
}

function stripCharsInBag(s, bag) {
	var i;
	var returnString = "";

	// Buscar por el string, si el caracter no esta en "bag",
	// agregarlo a returnString

	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if (bag.indexOf(c) == -1)
			returnString += c;
	}

	return returnString;
}

function stripCharsNotInBag(s, bag) {
	var i;
	var returnString = "";
	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if (bag.indexOf(c) != -1)
			returnString += c;
	}

	return returnString;
}

function stripWhitespace(s) {
	return stripCharsInBag(s, whitespace);
}

function charInString(c, s) {
	for (i = 0; i < s.length; i++) {
		if (s.charAt(i) == c)
			return true;
	}
	return false;
}

function stripInitialWhitespace(s) {
	var i = 0;
	while ((i < s.length) && charInString(s.charAt(i), whitespace))
		i++;
	return s.substring(i, s.length);
}

function isLetter(c) {
	return ((uppercaseLetters.indexOf(c) != -1) || (lowercaseLetters.indexOf(c) != -1));
}

function isFecha(dateStr) {

	var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
	var matchArray = dateStr.match(datePat); // is the format ok?

	if (matchArray == null) {
		Sexy.alert("Por favor Diligencia la Fecha Correctamente formato aaaa-mm-dd");
		return false;
	}

	month = matchArray[1]; // p@rse date into variables
	day = matchArray[3];
	year = matchArray[5];

	if (month < 1 || month > 12) { // check month range
		Sexy.alert("el mes debe estar entre 1 y 12.");
		return false;
	}

	if (day < 1 || day > 31) {
		Sexy.alert("el dia debe estar entre 1 y 31.");
		return false;
	}

	if ((month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
		Sexy.alert("El Mes " + month + " no tiene 31 dias!");
		return false;
	}

	if (month == 2) { // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day > 29 || (day == 29 && !isleap)) {
			Sexy.alert("Febrero de " + year + " no tiene " + day + " dias!");
			return false;
		}
	}
	return true; // date is valid
}

function isDigit(c) {
	return ((c >= "0") && (c <= "9"));
}

function isLetterOrDigit(c) {
	return (isLetter(c) || isDigit(c));
}

function isInteger(s) {
	var i;
	if (isEmpty(s))
		if (isInteger.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isInteger.arguments[1] == true);

	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if (i != 0) {
			if (!isDigit(c))
				return false;
		} else {
			if (!isDigit(c) && (c != "-") || (c == "+"))
				return false;
		}
	}
	return true;
}

function isNumber(s) {
	var i;
	var dotAppeared;
	dotAppeared = false;
	if (isEmpty(s))
		if (isNumber.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isNumber.arguments[1] == true);

	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if (i != 0) {
			if (c == ".") {
				if (!dotAppeared)
					dotAppeared = true;
				else
					return false;
			} else if (!isDigit(c))
				return false;
		} else {
			if (c == ".") {
				if (!dotAppeared)
					dotAppeared = true;
				else
					return false;
			} else if (!isDigit(c) && (c != "-") || (c == "+"))
				return false;
		}
	}
	return true;
}

function isAlphabetic(s) {
	var i;

	if (isEmpty(s))
		if (isAlphabetic.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isAlphabetic.arguments[1] == true);
	for (i = 0; i < s.length; i++) {
		// Check that current character is letter.
		var c = s.charAt(i);
		var d = s.charCodeAt(i);

		if (!isLetter(c)) {
			if (d != 241 && d != 209 && d != 225 && d != 233 && d != 237
					&& d != 243 && d != 250 && d != 193 && d != 201 && d != 205
					&& d != 211 && d != 218) {// codigos de caracteres utf8
												// permitidos como texto normal
				return false;
			}
		}
	}
	return true;
}

function isAlphabetic2(s) {
	if (isEmpty(s))
		;
	return true;
}

function isAlphanumeric(s) {
	var i;

	if (isEmpty(s))
		if (isAlphanumeric.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isAlphanumeric.arguments[1] == true);

	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if (!(isAlphabetic(c) || isDigit(c)))
			return false;
	}

	return true;
}

function isAlphanumeric2(s) {
	var i;

	if (isEmpty(s))
		if (isAlphanumeric.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isAlphanumeric.arguments[1] == true);

	for (i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if (!(isAlphabetic2(c) || isDigit(c)))
			return false;
	}

	return true;
}


function isName(s) {
	if (isEmpty(s))
		if (isName.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isAlphanumeric.arguments[1] == true);

	return (isAlphanumeric(stripCharsInBag(s, whitespace)));
}

function isPhoneNumber(s) {
	var modString;
	if (isEmpty(s))
		if (isPhoneNumber.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isPhoneNumber.arguments[1] == true);
	modString = stripCharsInBag(s, phoneChars);
	return (isInteger(modString));
}

function isEmail(s) {
	if (isEmpty(s))
		if (isEmail.arguments.length == 1)
			return defaultEmptyOK;
		else
			return (isEmail.arguments[1] == true);
	if (isWhitespace(s))
		return false;
	var i = 1;
	var sLength = s.length;
	while ((i < sLength) && (s.charAt(i) != "@")) {
		i++;
	}

	if ((i >= sLength) || (s.charAt(i) != "@"))
		return false;
	else
		i += 2;

	while ((i < sLength) && (s.charAt(i) != ".")) {
		i++;
	}

	if ((i >= sLength - 1) || (s.charAt(i) != "."))
		return false;
	else
		return true;
}

function isNice(s){
	var i = 1;
	var sLength = s.length;
	var b = 1;
	while (i < sLength) {
		if ((s.charAt(i) == "\"") || (s.charAt(i) == "'"))
			b = 0;
		i++;
	}
	return b;
}

function statBar(s) {
	window.status = s;
}

function warnEmpty(theField) {
	theField.focus();
	Sexy.alert(mMessage);
	statBar(mMessage);
	cambiacolor(theField);
	return false;
}

function warnInvalid(theField, s) {
	theField.focus();
	theField.select();
	Sexy.alert(s);
	statBar(pPrompt + s);
	return false;
}
function alertaerror(s){
	Sexy.alert(s);
}
function checkField(theField, theFunction, emptyOK, s) {
	var msg;
	if (checkField.arguments.length < 3)
		emptyOK = defaultEmptyOK;
	if (checkField.arguments.length == 4) {
		msg = s;
	} else {
		if (theFunction == isAlphabetic)
			msg = pAlphabetic;
		if (theFunction == isAlphabetic2)
			msg = pAlphabetic2;
		if (theFunction == isAlphanumeric)
			msg = pAlphanumeric;
		if (theFunction == isInteger)
			msg = pInteger;
		if (theFunction == isNumber)
			msg = pNumber;
		if (theFunction == isEmail)
			msg = pEmail;
		if (theFunction == isPhoneNumber)
			msg = pPhoneNumber;
		if (theFunction == isName)
			msg = pName;
		if (theFunction == isFecha)
			msg = pFecha;
	}

	if ((emptyOK == true) && (isEmpty(theField.value)))
		return true;

	if ((emptyOK == false) && (isEmpty(theField.value)))
		return warnEmpty(theField);

	if (checkNiceness && !isNice(theField.value))
		return warnInvalid(theField, pNice);

	if (theFunction(theField.value) == true) {
		restablececolor(theField);
		return true;
	} else {
		cambiacolor(theField);
		return warnInvalid(theField, msg);
	}
}
var boolvalidar=false;

function valida( boolValidar ) {

if(boolValidar){	
	
	var requiereced2;
	var fechanac = document.datos1.fecmes.value + "-"
			+ document.datos1.fecdia.value + "-" + document.datos1.fecano.value;

	if (checkField(document.datos1.s_tipodoc, isAlphabetic, false, "") == false) {
		return false;
	}
	
	if (document.datos1.s_tipodoc.value != "AS" && document.datos1.s_tipodoc.value != "MS") {
	
	if (checkField(document.datos1.i_documento, isInteger, false,
	"El campo debe ser numerico") == false) {
	return false;
	}

	if (checkField(document.datos1.s_nombre1, isAlphabetic, false,
			"El campo debe ser alfabetico") == false) {
		return false;
	}
	if (checkField(document.datos1.s_nombre2, isAlphabetic, true,
			"El campo debe ser alfabetico") == false) {
		return false;
	}
	if (checkField(document.datos1.s_apellido1, isAlphabetic, false,
			"El campo debe ser alfabetico") == false) {
		return false;
	}
	if (checkField(document.datos1.s_apellido2, isAlphabetic, true,
			"El campo debe ser alfabetico") == false) {
		return false;
	}
	if (checkField(document.datos1.i_regimen, isInteger, false, "") == false) {
		return false;
	}
	if (checkField(document.datos1.i_idparam, isInteger, false, "") == false) {
		return false;
	}
	if (checkField(document.datos1.i_plansalud, isInteger, false, "") == false) {
		return false;
	}
	if (checkField(document.datos1.s_coddepto, isInteger, false,"") == false) {
		return false;
	}
	if (checkField(document.datos1.s_codmunicipio, isInteger, false,"") == false) {
		return false;
	}
	if (checkField(document.datos1.s_zonaresidencia, isAlphabetic, false, "") == false) {
		return false;
	}
	// comprobacion de fecha
	if (isFecha(fechanac) == false) {
		cambiacolor(document.datos1.fecdia);
		return false;
	} else {
		restablececolor(document.datos1.fecdia);
	}
	// comprobacion de fecha

	if (checkField(document.datos1.s_direccion, isAlphanumeric, true,
			"El campo debe ser alfanumerico, numeros y letras unicamente") == false) {
		return false;
	}
	if (checkField(document.datos1.s_barrio, isAlphanumeric, true,
	"El campo debe ser alfanumerico, numeros y letras unicamente") == false) {
		return false;
	}
	if (checkField(document.datos1.i_edad, isInteger, true,
			"El campo debe ser Numerico") == false) {
		return false;
	}
	if (checkField(document.datos1.i_estrato, isInteger, true,
			"El campo debe ser Numerico") == false) {
		return false;
	}
	if (checkField(document.datos1.i_telefono, isInteger, true,
			"El campo debe ser Numerico") == false) {
		return false;
	}
	if (checkField(document.datos1.i_celular, isInteger, true,
			"El campo debe ser Numerico") == false) {
		return false;
	}
	if (checkField(document.datos1.i_rh, isInteger, true, "") == false) {
		return false;
	}
	if (checkField(document.datos1.s_sexo, isAlphabetic, false, "") == false) {
		return false;
	}
	if (checkField(document.datos1.i_estadocivil, isInteger, true, "") == false) {
		return false;
	}
	if (checkField(document.datos1.s_eps, isAlphabetic2, false, "") == false) {
		return false;
	}

	if (checkField(document.datos1.i_tipoafiliado, isInteger, false, "") == false) {
		return false;
	}
	// verificacion del tipo de afiliacion y si requiere cedula de titular
	if (document.datos1.i_tipoafiliado.value == 2) {
		requiereced2 = false;
	} else {
		requiereced2 = true;
	}
	if (checkField(document.datos1.i_cedulatitular, isInteger, requiereced2,
			"El campo debe ser numerico") == false) {
		return false;
	}
	if (checkField(document.datos1.s_observaciones, isAlphanumeric, true,
	"El campo debe ser alfanumerico, numeros y letras unicamente") == false) {
		return false;
	}

	return true;
 }else{
	 
	 if (checkField(document.datos1.s_nombre1, isAlphabetic, false,
			"El campo debe ser alfabetico") == false) {
	 return false;
	 }
	 if (checkField(document.datos1.s_nombre2, isAlphabetic, true,
			"El campo debe ser alfabetico") == false) {
	return false;
	}
	if (checkField(document.datos1.s_apellido1, isAlphabetic, false,
			"El campo debe ser alfabetico") == false) {
	return false;
	}
	if (checkField(document.datos1.s_apellido2, isAlphabetic, true,
		"El campo debe ser alfabetico") == false) {
	return false;
	}
	if (checkField(document.datos1.s_coddepto, isInteger, true,"") == false) {
			return false;
	}
	if (checkField(document.datos1.s_codmunicipio, isInteger, true,"") == false) {
			return false;
	}
	if (checkField(document.datos1.s_direccion, isAlphanumeric, true,
	"El campo debe ser alfanumerico, numeros y letras unicamente") == false) {
		return false;
	}
	
	return true;
 }
	
}return true;

}

function ocultarnoreq(){
	if (document.datos1.s_tipodoc.value == "AS" || document.datos1.s_tipodoc.value == "MS") {
	
	ocultarFila("campos",1,false);// no documento
	ocultarFila("campos",6,false);// regimen
	ocultarFila("campos",7,false);// rango salarial
	ocultarFila("campos",8,false);// plan de salud
	ocultarFila("campos",13,false);// zona residencia
	ocultarFila("campos",14,false);// fecha nacimiento
	ocultarFila("campos",15,false);// fecha nacimiento
	ocultarFila("campos",16,false);// estrato
	ocultarFila("campos",21,false);// estado civil
	ocultarFila("campos",24,false);// tipo afiliado
	ocultarFila("campos",25,false);// cedula titular
	ocultarFila("campos2",0,false);
	ocultarFila("campos2",1,false);
	ocultarFila("campos2",2,false);

	}else{

		ocultarFila("campos",1,true);// no documento
		ocultarFila("campos",6,true);// regimen
		ocultarFila("campos",7,true);// rango salarial
		ocultarFila("campos",8,true);// plan de salud
		ocultarFila("campos",13,true);// zona residencia
		ocultarFila("campos",14,true);// fecha nacimiento
		ocultarFila("campos",15,true);// fecha nacimiento
		ocultarFila("campos",16,true);// estrato
		ocultarFila("campos",21,true);// estado civil
		ocultarFila("campos",24,true);// tipo afiliado
		ocultarFila("campos",25,true);// cedula titular
		ocultarFila("campos2",0,true);
		ocultarFila("campos2",1,true);
		ocultarFila("campos2",2,true);

	}
}

function ocultarFila(tabla,num,ver) {
	  dis= ver ? '' : 'none';
	  tab=document.getElementById(tabla);
	  tab.getElementsByTagName('tr')[num].style.display=dis;
	}

function validalog() {

	if (checkField(document.loginform.nombre, isAlphanumeric, false,
			"El campo debe ser alfanumerico") == false) {
		return false;
	}
	if (checkField(document.loginform.contra, isAlphanumeric, false,
			"El campo debe ser alfanumerico") == false) {
		return false;
	}
	if (checkField(document.loginform.nivel, isInteger, false,
		"") == false) {
		return false;
	}
	if (checkField(document.loginform.sucursal, isInteger, false,
		"") == false) {
		return false;
	}

	return true;
}

function validaperact(boolvalidar) {
if(boolvalidar){
	
	try{
	if (checkField(document.peract.codigo, isAlphanumeric, false,
			"El campo debe ser alfanumerico") == false) {
		return false;
	}
	if (checkField(document.peract.cedula, isInteger, false,
			"El campo debe ser numerico") == false) {
		
		return false;
	}
	 if (checkField(document.peract.nombre, isAlphabetic, false,
		"El campo debe ser alfabetico") == false) {
		 return false;
	 }
	 if (checkField(document.peract.apellidos, isAlphabetic, false,
		"El campo debe ser alfabetico") == false) {
	return false;
	}
	if (checkField(document.peract.pasadojudicial, isInteger, false,
		"El campo debe ser numerico") == false) {
	return false;
	}
	// comprobacion de fecha
	
		var vect=document.peract.fechaingreso.value.split('-');
		var fechanac=vect[1]+"-"+vect[2]+"-"+vect[0];
	
	if (isFecha(fechanac) == false) {
		cambiacolor(document.peract.fechaingreso);
		return false;
	} else {
		restablececolor(document.peract.fechaingreso);
	}

	if (checkField(document.peract.cargo, isInteger, false,
	"") == false) {
	return false;
	}
	
	}catch(Error){
	}

	return true;
  }
}

function validaperasp(boolvalidar) {
	if(boolvalidar){
		
		try{
		if (checkField(document.peract.cedula, isInteger, false,
				"El campo debe ser numerico") == false) {
			return false;
		}
		 if (checkField(document.peract.nombre, isAlphabetic, false,
			"El campo debe ser alfabetico") == false) {
			 return false;
		 }
		 if (checkField(document.peract.apellidos, isAlphabetic, false,
			"El campo debe ser alfabetico") == false) {
		return false;
		}
		if (checkField(document.peract.pasadojudicial, isInteger, false,
			"El campo debe ser numerico") == false) {
		return false;
		}
	
		// comprobacion de cargo
		
		if (checkField(document.peract.cargo, isInteger, false,
		"") == false) {
		return false;
		}
		}catch(Error){
		}

		return true;
	  }
	}

function validacliente(boolvalidar){
if(boolvalidar){	
	
	if (checkField(document.clientes.duenopuesto, isAlphanumeric, false,
	"El campo debe ser alfanumerico") == false) {
		return false;
	}
	if (checkField(document.clientes.codigo, isAlphanumeric, false,
	"El campo debe ser alfanumerico") == false) {
		return false;
	}
	if (checkField(document.clientes.nit, isInteger, false,
	"El campo debe ser numerico") == false) {
		return false;
	}
	if (checkField(document.clientes.nombrecliente, isAlphanumeric, false,
	"El campo debe ser alfanumerico") == false) {
		return false;
	}
}	
}

function validacondiciones(boolvalidar){
	if(boolvalidar){	
		
		if (checkField(document.condiciones.nombrecliente, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.contacto, isAlphabetic, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.direccion, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.direccion2, isAlphanumeric, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.email, isEmail, true,
		"el formato del email no es correcto") == false) {
			return false;
		}
		if (checkField(document.condiciones.telefono, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.fax, isInteger, true,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.codigo, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.condiciones.nit, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
	}	
	}


function validaproveedor(boolvalidar){
	if(boolvalidar){	
		
		if (checkField(document.proveedores.nombreprov, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.proveedores.contacto, isAlphabetic, false,
		"El campo debe ser alfabetico") == false) {
			return false;
		}
		if (checkField(document.proveedores.telefono1, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.proveedores.telefono2, isInteger, true,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.proveedores.telefono3, isInteger, true,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.proveedores.direccion, isAlphanumeric2, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.proveedores.email, isEmail, true,
		"el formato del email no es correcto") == false) {
			return false;
		}
	}	
	}

function validaproductos(boolvalidar){
	if(boolvalidar){	
		if (checkField(document.productos.serial, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
                return false;
		}
		if (checkField(document.productos.nombreprod, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
                return false;
		}
		if (checkField(document.productos.precio, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.productos.proveedor, isInteger, false,
		"") == false) {
			return false;
		}
		if (checkField(document.productos.referencia, isAlphanumeric2, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.productos.modelo, isAlphanumeric2, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.productos.marca, isAlphanumeric2, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
	}	
	}

function validagregaserv(boolvalidar){

	if(boolvalidar){	
		if (checkField(document.agregaserv.cantidadservicios, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.agregaserv.personal, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.agregaserv.valorservicio, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.agregaserv.descripcion, isAlphanumeric, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
	}
}

function validagregarm(boolvalidar){
		if(boolvalidar){	
		
		if (checkField(document.agregarm.marca, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		if (checkField(document.agregarm.cantarma, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		if (checkField(document.agregarm.observacionarma, isAlphanumeric, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
	}
}

function validagregaseg(boolvalidar){

	if(boolvalidar){	
	
	var fechanac=document.agregaseg.mes.value+"-"+document.agregaseg.dia.value+"-"+document.agregaseg.ano.value;;
		
		if (isFecha(fechanac) == false) {
			cambiacolor(document.agregaseg.ano);
			return false;
		} else {
			restablececolor(document.agregaseg.ano);
		}
		
		if (checkField(document.agregaseg.comentarios, isAlphanumeric, true,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
	}
}
function validagregaorden(boolvalidar){

	if(boolvalidar){	
		if (checkField(document.ordenes.motivo, isAlphabetic, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
		if (checkField(document.ordenes.cedpersona1, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}

		if(document.ordenes.motivo.value!="Refuerzo"){
		if (checkField(document.ordenes.cedpersona2, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}}
		
		if (checkField(document.ordenes.cliepresenta, isAlphanumeric2, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
		
		var fechanac=document.ordenes.mespartir.value+"-"+document.ordenes.diapartir.value+"-"+document.ordenes.anopartir.value;;
		
		if (isFecha(fechanac) == false) {
			cambiacolor(document.ordenes.diapartir);
			return false;
		} else {
			restablececolor(document.ordenes.diapartir);
		}
		
		if (checkField(document.ordenes.diahasta, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
		if (checkField(document.ordenes.diaonoche, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
		if (checkField(document.ordenes.turnos, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
	
	}
}

function validaofertas(boolvalidar){
	if(boolvalidar){	
		
		if (checkField(document.ofertas.nit, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.empresa, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.contacto, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.direccion, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.estrato, isInteger, true,
		"El campo debe ser numerico") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.empresa, isAlphanumeric, false,
		"El campo debe ser alfanumerico") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.email, isEmail, true,
		"el formato del email no es correcto") == false) {
			return false;
		}
		
		if (checkField(document.ofertas.telefono, isInteger, false,
		"El campo debe ser numerico") == false) {
			return false;
		}

		
		if (checkField(document.ofertas.fax, isInteger, true,
		"El campo debe ser numerico") == false) {
			return false;
		}

		if (checkField(document.ofertas.tipocontacto, isInteger, false,
		"") == false) {
			return false;
		}
		
		var vect0=document.ofertas.fechaentrega.value.split('');
		var vect=document.ofertas.fechaentrega.value.split('-');
		var fechanac=vect[1]+"-"+vect[2]+"-"+vect[0];
	
	if (isFecha(fechanac) == false) {
		cambiacolor(document.ofertas.fechaentrega);
		return false;
	} else {
		restablececolor(document.ofertas.fechaentrega);
	}
		
	}	
	}
	
function cambiacolor(campo) {
	campo.style.backgroundColor = "#000";
	campo.style.color = "#FFF";
}
function restablececolor(campo) {
	campo.style.backgroundColor = "#CCC";
	campo.style.color = "#000";
}

// funcion para hacer peticion http al servidor sin recargar pagina

function ws_newXMLHttpRequest() {
	var req;
	try {
		req = new XMLHttpRequest();
	} catch (e) {
		try {
			req = new ActiveXObject("MSXML2.XmlHttp");
		} catch (e) {
			try {
				req = new ActiveXObject("Microsoft.XmlHttp");
			} catch (e) {
				try {
					req = new ActiveXObject("MSXML.XmlHttp");
				} catch (e) {
					req = new ActiveXObject("MSXML3.XmlHttp");
				}
			}
		}
	}
	return req;
}

