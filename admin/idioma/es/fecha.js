var monthNames = new Array( "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
var dayNames = new Array( "Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var now = new Date();
thisYear = now.getYear();
if(thisYear < 1900) {thisYear += 1900}; // corrections if Y2K display problem
document.write(dayNames[now.getDay()] + " " + now.getDate() + " de " + monthNames[now.getMonth()] + " de " + thisYear + " ");