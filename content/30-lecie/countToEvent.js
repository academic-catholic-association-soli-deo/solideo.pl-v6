var yellow = 255;
var blueHex = '00';
var direction = -1;
var step = 3;

var targetTime = 1551549600000;
var pause = 5000;

function start() {
	countDown();
	setInterval(function(){countDown();}, 1000);
	setTimeout(() => colorWatch(), pause);
}
window.onload = start;


function countDown() {
	var dzisiaj = new Date();
	
	if(dzisiaj.getTime() >= targetTime) {
		document.getElementById("timer").innerHTML = "UROCZYSTOŚĆ ROZPOCZĘTA !!!";
		if(dzisiaj.getTime() >= 1551585600000) {
			document.getElementById("timer").innerHTML = "BAL ZAKOŃCZONY! DZIĘKUJEMY WSZYSTKIM UCZESTNIKOM!";
		}
	}
	
	var secsToTarget = Math.round((targetTime - dzisiaj.getTime())/1000);
	
	var days = Math.floor(secsToTarget/86400);
	
	var hours = Math.floor((secsToTarget - days*86400)/3600);
	
	var minutes = Math.floor((secsToTarget - days*86400 - hours*3600)/60);
	
	var seconds = secsToTarget - days*86400 - hours*3600 - minutes*60;

	//if (days<10) days = "0"+days;
	if (hours<10) hours = "0"+hours;
	if (minutes<10) minutes = "0"+minutes;
	if (seconds<10) seconds = "0"+seconds;
	
	document.getElementById("timer").innerHTML =
		days+"<span>d</span> "+hours+"<span>h</span> "+minutes+"<span>m</span> "+seconds+"<span>s</span> ";
}


function colorWatch() {
	
	yellow += step*direction;
	
	if(yellow<16) yellowHex = '0' + yellow.toString(16);
	else yellowHex = yellow.toString(16);
	
	if(yellow>239) backHex = '0' + (255-yellow).toString(16);
	else backHex = (255-yellow).toString(16);
	
	yellowHex += yellowHex;
	backHex += backHex;
	
	if(yellow == 255) {
		direction = -1;
		setTimeout(() => colorWatch(), pause);
	}
	else if(yellow == 0) {
		direction = 1;
		setTimeout(() => colorWatch(), pause);
	}
	else
		setTimeout(() => colorWatch(), 50);
	
	document.getElementById("timer").style.color = "#" + yellowHex + blueHex;
	$('#timer').css("background-color", "#" + backHex + blueHex);
}
