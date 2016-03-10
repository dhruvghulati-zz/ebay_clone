function getTimeRemaining(endtime){
	var t = Date.parse(endtime)-Date.parse(new Date());
	var seconds = Math.floor((t/1000)%60);
	var minutes = Math.floor((t/1000/60)%60);
	var hours = Math.floor((t/(1000*60*60))%24);
	var days = Math.floor(t/(1000*60*60*24));
	return {
		'total':t,
		'days': days,
		'hours': hours,
		'minutes' : minutes,
		'seconds' : seconds
			};
}

function setClock(endtime,destination,id){
	var clock = document.getElementById(id);
	var inter = setInterval(function(){
        var timeLeft = getTimeRemaining(endtime);
        clock.innerHTML = 'days: ' + timeLeft.days + '<br>' +
                      	'hours: '+ timeLeft.hours + '<br>' +
                      	'minutes: ' + timeLeft.minutes + '<br>' +
                      	'seconds: ' + timeLeft.seconds;
		if(timeLeft.total<= 900000){
			clock.style.color = '#7f0000';
            
		}
		if(timeLeft.total<=0){
			clearInterval(inter);
            window.location = destination;
		}
	},1000);
}

setClock('2016-03-10T21:39:30','index.php','clo');