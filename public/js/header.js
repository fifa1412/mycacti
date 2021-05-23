var Header = {};

Header.getCookie = function(name){
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
}

Header.unsetCookie = function(){
	document.cookie.split(";").forEach(function(c) {
        //document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
		document.cookie = c + "= ; expires=Fri, 31 Dec 1999 23:59:59 GMT"; 
    });
} 

Header.formatDatetime = function(date){
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
		hour = '' + d.getHours();
		minute = '' + d.getMinutes();
		second = '' + d.getSeconds();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
	if (hour.length < 2) 
		hour = '0' + hour;
	if (minute.length < 2) 
		minute = '0' + minute;
	if (second.length < 2) 
		second = '0' + second;

    return [year, month, day].join('-')+" "+[hour, minute, second].join(':');
}

Header.removeNull = function(val){
	if(val!=null){
		return val;
	}else{
		return "";
	}
}

Header.isValidDate = function(value) {
    var dateWrapper = new Date(value);
    return !isNaN(dateWrapper.getDate());
}

Header.formatTime = function(date){
    let d = new Date(date),
		hour = '' + d.getHours();
		minute = '' + d.getMinutes();
		second = '' + d.getSeconds();

	if (hour.length < 2) 
		hour = '0' + hour;
	if (minute.length < 2) 
		minute = '0' + minute;
	if (second.length < 2) 
		second = '0' + second;

    return [hour, minute].join(':');
}

Header.formatDate = function(date){
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('/');
}

Header.commaNumber = function(x){
    //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	const fixedNumber = Number.parseFloat(x).toFixed(2);
    return String(fixedNumber).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

Header.showPopup = function(text){
	Swal.fire({
        html: text,
        width: '300px',
        showConfirmButton: false,
        allowOutsideClick: false
    });
	Swal.showLoading();
}

Header.showUpperRightPopup = function(text){
	Swal.fire({
		position: 'top-end',
		icon: 'success',
		html: text,
		width: '300px',
		showConfirmButton: false,
		timer: 3000
	  })
}

Header.closePopup = function(){
	Swal.close();
}

Header.showSuccessPopup = function(text){
	Swal.fire({
		html: text,
		icon: 'success',
		width: '550px',
		showConfirmButton: true,
	})
}

Header.showWarningPopup = function(text){
	Swal.fire({
		html: text,
		icon: 'warning',
		width: '550px',
		showConfirmButton: true,
	})
}

Header.showWarningWithRedirect = function(text, url){
	Swal.fire({
		html: text,
		icon: 'warning',
		width: '550px',
		showConfirmButton: true,
	}).then(function() {
		if(typeof url !== 'undefined'){
			if(url == 'goback'){
				window.history.back();
			}else{
				window.location = url;
			}
		}
	});
}

Header.showSuccessWithRedirect = function(text, url){
	Swal.fire({
		html: text,
		icon: 'success',
		width: '550px',
		showConfirmButton: true,
	}).then(function() {
		if(typeof url !== 'undefined'){
			window.location = url;
		}
	});
}

Header.getUrlSegment = function(segment){
	let url = window.location.pathname.split("/");
	return url[segment];
}