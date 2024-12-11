//NOTE:....
//	yy = year
//	mm = month
//	wk = week 
//	dd = day
function getAge(yy, mm, wk, dd){
	var age = "";
	 if (yy == 0 && mm == 0 && wk == 0) {

	  	if (dd == 1) {
	  		age = dd + "dy";
	  	}else if(dd > 1){
	  		age = dd + "dys";
	  	}
	 }

	if (yy == 0 && mm == 0 && wk > 0) {

	  	if (wk == 1 && dd == 0) {
	  		age = wk + "wk";
	  	}
	  	else if (wk == 1 && dd <= 1) {
	  		age = wk + "wk "+ dd+"dy";
	  	}
	  	else if (wk == 1 && dd > 1) {
	  		age = wk + "wk "+ dd+"dys";
	  	}
	  	else if (wk > 1 && dd == 0) {
	  		age = wk + "wks";
	  	}
	  	else if (wk > 1 && dd <= 1) {
	  		age = wk + "wks "+ dd+"dy";
	  	}
	  	else if (wk > 1 && dd > 1) {
	  		age = wk + "wks "+ dd+"dys";
	  	}
	}

	if (yy == 0 && mm > 0) {

	  	if (mm == 1 && wk == 0 && dd == 0) {
	  		age = mm +"mo ";
	  	}
	  	else if (mm == 1 && wk == 0 && dd <= 1) {
	  		age = mm+"mo " +dd+ "dy";
	  	}
	  	else if (mm == 1 && wk == 0 && dd > 1) {
	  		age = mm+"mo "+dd+ "dys";
	  	}
	  	else if (mm == 1 && wk == 1 && dd == 0) {
	  		age = mm+"mo "+wk + "wk";
	  	}
	  	else if (mm == 1 && wk == 1 && dd <= 1) {
	  		age = mm+"mo "+wk + "wk "+ dd+"dy";
	  	}
	  	else if (mm == 1 && wk == 1 && dd > 1) {
	  		age = mm+"mo "+wk + "wk "+ dd+"dys";
	  	}
	  	else if (mm == 1 && wk > 1 && dd == 0) {
	  		age = mm+"mo "+wk + "wks";
	  	}
	  	else if (mm == 1 && wk > 1 && dd <= 1) {
	  		age = mm+"mo "+wk + "wks "+ dd+"dy";
	  	}
	  	else if (mm == 1 && wk > 1 && dd > 1) {
	  		age = mm+"mo "+wk + "wks "+ dd+"dys";
	  	}
	  	else if (mm  > 1 && wk == 0 && dd == 0) {
	  		age = mm+"mos ";
	  	}
	  	else if (mm  > 1 && wk == 0 && dd <= 1) {
	  		age = mm+"mos " +dd+ "dy";
	  	}
	  	else if (mm  > 1 && wk == 0 && dd > 1) {
	  		age = mm+"mos "+dd+ "dys";
	  	}
	  	else if (mm  > 1 && wk == 1 && dd == 0) {
	  		age = mm+"mos "+wk + "wk ";
	  	}
	  	else if (mm > 1 && wk == 1 && dd <= 1) {
	  		age = mm+"mos "+wk + "wk "+ dd+"dy";
	  	}
	  	else if (mm  > 1 && wk == 1 && dd > 1) {
	  		age = mm+"mos "+wk + "wk "+ dd+"dys";
	  	}
	  	else if (mm  > 1 && wk > 1 && dd == 0) {
	  		age = mm+"mos "+wk + "wks";
	  	}
	  	else if (mm  > 1 && wk > 1 && dd <= 1) {
	  		age = mm+"mos "+wk + "wks "+ dd+"dy";
	  	}
	  	else if (mm  > 1 && wk > 1 && dd > 1) {
	  		age = mm+"mos "+wk + "wks "+ dd+"dys";
	  	}
	}
	if (yy > 0) {

	  	if (yy == 1 && mm == 0 && wk == 0 && dd == 0) {
	  		age = yy +"yr ";
	  	}
	  	else if (yy == 1 && mm == 0 && wk == 0 && dd == 1) {
	  		age = yy +"yr "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm == 0 && wk == 0 && dd > 1) {
	  		age = yy +"yr "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm == 0 && wk == 1 && dd == 0) {
	  		age = yy +"yr "+wk+"wk";
	  	}
	  	else if (yy == 1 && mm == 0 && wk == 1 && dd == 1) {
	  		age = yy +"yr "+wk+"wk "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm == 0 && wk == 1 && dd > 1) {
	  		age = yy +"yr "+wk+"wk "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm == 0 && wk > 1 && dd == 0) {
	  		age = yy +"yr "+wk+"wks ";
	  	}
	  	else if (yy == 1 && mm == 0 && wk > 1 && dd == 1) {
	  		age = yy +"yr "+wk+"wks "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm == 0 && wk > 1 && dd > 1) {
	  		age = yy +"yr "+wk+"wks "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm == 1 && wk == 0 && dd == 0) {
	  		age = yy +"yr "+mm+" mo";
	  	}
	  	else if (yy == 1 && mm == 1 && wk == 0 && dd == 1) {
	  		age = yy +"yr "+mm+" mo "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm == 1 && wk == 0 && dd > 1) {
	  		age = yy +"yr "+mm+" mo "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm == 1 && wk == 1 && dd == 0) {
	  		age = yy +"yr "+mm+" mo "+wk+"wk";
	  	}
	  	else if (yy == 1 && mm == 1 && wk == 1 && dd == 1) {
	  		age = yy +"yr "+mm+" mo "+wk+"wk "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm == 1 && wk == 1 && dd > 1) {
	  		age = yy +"yr "+mm+" mo "+wk+"wk "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm == 1 && wk > 1 && dd == 0) {
	  		age = yy +"yr "+mm+" mo "+wk+"wks ";
	  	}
	  	else if (yy == 1 && mm == 1 && wk > 1 && dd == 1) {
	  		age = yy +"yr "+mm+" mo "+wk+"wks "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm == 1 && wk > 1 && dd > 1) {
	  		age = yy +"yr "+mm+" mo "+wk+"wks "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm > 1 && wk == 0 && dd == 0) {
	  		age = yy +"yr "+mm+"mos";
	  	}
	  	else if (yy == 1 && mm > 1 && wk == 0 && dd == 1) {
	  		age = yy +"yr "+mm+"mos "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm > 1 && wk == 0 && dd > 1) {
	  		age = yy +"yr "+mm+"mos "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm > 1 && wk == 1 && dd == 0) {
	  		age = yy +"yr "+mm+"mos "+wk+"wk";
	  	}
	  	else if (yy == 1 && mm > 1 && wk == 1 && dd == 1) {
	  		age = yy +"yr "+mm+"mos "+wk+"wk "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm > 1 && wk == 1 && dd > 1) {
	  		age = yy +"yr "+mm+"mos "+wk+"wk "+dd+"dys";
	  	}
	  	else if (yy == 1 && mm > 1 && wk > 1 && dd == 0) {
	  		age = yy +"yr "+mm+"mos "+wk+"wks ";
	  	}
	  	else if (yy == 1 && mm > 1 && wk > 1 && dd == 1) {
	  		age = yy +"yr "+mm+"mos "+wk+"wks "+dd+"dy";
	  	}
	  	else if (yy == 1 && mm > 1 && wk > 1 && dd > 1) {
	  		age = yy +"yr "+mm+"mos "+wk+"wks "+dd+"dys";
	  	}
	  	else if (yy >1 && mm == 0 && wk == 0 && dd == 0) {
	  		age = yy +"yrs ";
	  	}
	  	else if (yy >1 && mm == 0 && wk == 0 && dd == 1) {
	  		age = yy +"yrs "+dd+"dy";
	  	}
	  	else if (yy >1 && mm == 0 && wk == 0 && dd > 1) {
	  		age = yy +"yrs "+dd+"dys";
	  	}
	  	else if (yy >1 && mm == 0 && wk == 1 && dd == 0) {
	  		age = yy +"yrs "+wk+"wk";
	  	}
	  	else if (yy >1 && mm == 0 && wk == 1 && dd == 1) {
	  		age = yy +"yrs "+wk+"wk "+dd+"dy";
	  	}
	  	else if (yy >1 && mm == 0 && wk == 1 && dd > 1) {
	  		age = yy +"yrs "+wk+"wk "+dd+"dys";
	  	}
	  	else if (yy >1 && mm == 0 && wk > 1 && dd == 0) {
	  		age = yy +"yrs "+wk+"wks ";
	  	}
	  	else if (yy >1 && mm == 0 && wk > 1 && dd == 1) {
	  		age = yy +"yrs "+wk+"wks "+dd+"dy";
	  	}
	  	else if (yy >1 && mm == 0 && wk > 1 && dd > 1) {
	  		age = yy +"yrs "+wk+"wks "+dd+"dys";
	  	}
		else if (yy >1 && mm == 1 && wk == 0 && dd == 0) {
	  		age = yy +"yrs "+mm+" mo";
	  	}
	  	else if (yy >1 && mm == 1 && wk == 0 && dd == 1) {
	  		age = yy +"yrs "+mm+" mo "+dd+"dy";
	  	}
	  	else if (yy >1 && mm == 1 && wk == 0 && dd > 1) {
	  		age = yy +"yrs "+mm+" mo "+dd+"dys";
	  	}
	  	else if (yy >1 && mm == 1 && wk == 1 && dd == 0) {
	  		age = yy +"yrs "+mm+" mo "+wk+"wk";
	  	}
	  	else if (yy >1 && mm == 1 && wk == 1 && dd == 1) {
	  		age = yy +"yrs "+mm+" mo "+wk+"wk "+dd+"dy";
	  	}
	  	else if (yy >1 && mm == 1 && wk == 1 && dd > 1) {
	  		age = yy +"yrs "+mm+" mo "+wk+"wk "+dd+"dys";
	  	}
	  	else if (yy >1 && mm == 1 && wk > 1 && dd == 0) {
	  		age = yy +"yrs "+mm+" mo "+wk+"wks ";
	  	}
	  	else if (yy >1 && mm == 1 && wk > 1 && dd == 1) {
	  		age = yy +"yrs "+mm+" mo "+wk+"wks "+dd+"dy";
	  	}
	  	else if (yy >1 && mm == 1 && wk > 1 && dd > 1) {
	  		age = yy +"yrs "+mm+" mo "+wk+"wks "+dd+"dys";
	  	}
	  	else if (yy >1 && mm > 1 && wk == 0 && dd == 0) {
	  		age = yy +"yrs "+mm+"mos";
	  	}
	  	else if (yy >1 && mm > 1 && wk == 0 && dd == 1) {
	  		age = yy +"yrs "+mm+"mos "+dd+"dy";
	  	}
	  	else if (yy >1 && mm > 1 && wk == 0 && dd > 1) {
	  		age = yy +"yrs "+mm+"mos "+dd+"dys";
	  	}
	  	else if (yy >1 && mm > 1 && wk == 1 && dd == 0) {
	  		age = yy +"yrs "+mm+"mos "+wk+"wk";
	  	}
	  	else if (yy >1 && mm > 1 && wk == 1 && dd == 1) {
	  		age = yy +"yrs "+mm+"mos "+wk+"wk "+dd+"dy";
	  	}
	  	else if (yy >1 && mm > 1 && wk == 1 && dd > 1) {
	  		age = yy +"yrs "+mm+"mos "+wk+"wk "+dd+"dys";
	  	}
	  	else if (yy >1 && mm > 1 && wk > 1 && dd == 0) {
	  		age = yy +"yrs "+mm+"mos "+wk+"wks ";
	  	}
	  	else if (yy >1 && mm > 1 && wk > 1 && dd == 1) {
	  		age = yy +"yrs "+mm+"mos "+wk+"wks "+dd+"dy";
	  	}
	  	else if (yy >1 && mm > 1 && wk > 1 && dd > 1) {
	  		age = yy +"yrs "+mm+"mos "+wk+"wks "+dd+"dys";
	  	}
 	}
 	return age;
}

//NOTE:....
//	inputDateId = is an ID of an input date field where Date is get
//	dispalyAgeID = is an ID of an input field where age will display
//	warning = is an ID of 'p' tag where warning message will display 
function setPetAge(inputDateId, dispalyAgeID, warning, mainInputDateId, ageThatTimeId){
		// GET INPUT DATE
		var date = $(inputDateId).val(),
			 	// REMOVING DASH SIGN BETWEEN DATE TO CONVERT INTO ARRAY
		 	  arr0 = date.split("-"),

		 	  //GETTING ARRAY VALUE AFTER REMOVING DASH SIGN
		 	  bDay = eval(arr0[2]),
		 	  bMonth = eval(arr0[1]),
		 	  bYear = eval(arr0[0]),

		 	  //CREATE DATE OBJECT TO GET THE TOTAL TIME OF INPUT DATE
		 	  newDate = new Date(date),
		 	  time = newDate.getTime();

		// GET INPUT DATE 2 TO GET THE DIFFFERENCE BETWEEN AGE AND VACCINATION OR DEWORMING DATE
		if (mainInputDateId != "") {
			var date2 = $(mainInputDateId).val(),
				 	// REMOVING DASH SIGN BETWEEN DATE TO CONVERT INTO ARRAY
			 	  arr2 = date2.split("-"),

			 	  //GETTING ARRAY VALUE AFTER REMOVING DASH SIGN
			 	  bDay2 = eval(arr2[2]),
			 	  bMonth2 = eval(arr2[1]),

			 	  bYear2 = eval(arr2[0]);

			 	  //CREATE DATE OBJECT TO GET THE TOTAL TIME OF INPUT DATE
			 	  newDate2 = new Date(date2),
			 	  time2 = newDate2.getTime();
		}

	 	 //CREATE DATE OBJECT TO GET THE DAY, MONTH AND YEAR OF THE CURRENT DATE
 	  var curDate = new Date(),
	  			curDay = curDate.getDate(),

 	  		//PLUS +1 TO .getMonth BECAUSE IT STATS WITH 0
 	  		curMonth = curDate.getMonth()+1,
 	  		curYear = curDate.getFullYear(),

 	  		//CREATE DATE OBJECT TO GET THE TOTAL TIME OF INPUT DATE
 	  		curTime = curDate.getTime();

 	  		//DISPLAY INPUT DATE AND CURRENT DATE
 	  		// console.log("-------------------------");
 	  		// console.log("Current Date: "+curMonth+" "+curDay+", "+curYear);
 	  		// console.log("Birth Date  : "+bMonth+" "+bDay+", "+bYear);
 	  		// console.log("-------------------------");

			  // SUBTRACT TOTAL TIME OF CURRENT DATE TO TOTAL TIME OF INPUT DATE
		  	value = curTime - time;

		  	if (mainInputDateId != "") {
		  		var res = 1000 * 60 * 60 * 24;
		  		console.log("---------------------------");
 				 			console.log("CurTime  : "+curTime);
 				 			console.log("Time     : "+(time + res));
 				 			console.log("Time2    : "+time2);
 				 			console.log("---------------------------");
		  		value2 = time - time2;//curTime - (time2+(time2 -time));
		  	}
		  	
		  	// console.log("---------------------------");
		  	// console.log("CurTime: "+curTime);
		  	// console.log("Time   : "+time);
		  	// console.log("---------------------------");
		  	// console.log("Time : "+time);
		  	// console.log("Time2: "+time2);
		  	// console.log("---------------------------");
		  	//GET AGE RESULTS 
		 	  var_day = Math.floor(value / (1000 * 60 * 60 * 24)),//TOTAL DAYS OF AGE
		 	  var_week = Math.floor(value / (1000 * 60 * 60 * 24 * 7)),//TOTAL WEEKS OF AGE
		 	  var_month = Math.floor(value / (1000 * 60 * 60 * 24 * 30.4375)),//TOTAL MONTHS OF AGE
		 	  var_year = Math.floor(value / (1000 * 60 * 60 * 24 * 365.25));//TOTAL YEARS OF AGE

		 	  if (mainInputDateId != "") {
		 	  	//GET AGE RESULTS TO GET THE DIFFFERENCE BETWEEN AGE AND VACCINATION OR DEWORMING DATE
		 	  	var_day2 = Math.floor(value2 / (1000 * 60 * 60 * 24)),//TOTAL DAYS OF AGE
		 	  	var_week2 = Math.floor(value2 / (1000 * 60 * 60 * 24 * 7)),//TOTAL WEEKS OF AGE
		 	  	var_month2 = Math.floor(value2 / (1000 * 60 * 60 * 24 * 30.4375)),//TOTAL MONTHS OF AGE
		 	  	var_year2 = Math.floor(value2 / (1000 * 60 * 60 * 24 * 365.25));//TOTAL YEARS OF AGE

		 	  }

		 	  // console.log(var_year+" Years");
		 	  // console.log(var_month+" Months");
		 	  // console.log(var_week+" Weeks");
		 	  // console.log(var_day+" Days");
		 	  // console.log(var_hour+" Hours");
		 	  // console.log(var_mins+" Mins");
		 	  
		 	  //INITIALIZE VARIABLES TO HOLD THE DATA OF YEAR, MONTH, WEEKS AND DAYS OF THE AGE
		 	  const MONTHS = 12;
		 	  const DAYS_OF_YEAR = 365.25;
		 	  const DAYS_OF_MONTH = 30.4375;
		 	  const DAYS_OF_WEEK = 7;
		 	  var dd = 0, mm = 0, wk = 0, yy = var_year;

		 	  if (var_year > 0) {
		 	  	if (var_month > MONTHS && var_month < (MONTHS * 2) ) {
		 	  		mm = var_month - MONTHS;
		 	  	} else if (var_month == 0){
		 	  		mm = var_month - MONTHS;
		 	  	}else{
		 	  		mm = var_month - (var_year * MONTHS) ;
		 	  	}
		 	  } else if ( var_year == 0) {
		 	  	mm = var_month;
		 	  }

		 	  if (mainInputDateId != "") {
		 	  	var dd2 = 0, mm2 = 0, wk2 = 0, yy2 = var_year2;
		 	  	//to get age from current date 
		 	  	if (var_year2 > 0) {
		 	  		if (var_month2 > MONTHS && var_month2 < (MONTHS * 2) ) {
		 	  			mm2 = var_month2 - MONTHS;
		 	  		} else if (var_month2 == 0){
		 	  			mm2 = var_month2 - MONTHS;
		 	  		}else{
		 	  			mm2 = var_month2 - (var_year2 * MONTHS) ;
		 	  		}
		 	  	} else if ( var_year2 == 0) {
		 	  		mm2 = var_month2;
		 	  	}
		 	  }


		 	  //GETTING TOTAL DAYS FROM AGE BASE ON YEAR AND MONTH 
		 	  var ttl_days =  (var_day - Math.floor((yy * DAYS_OF_YEAR) +(mm * DAYS_OF_MONTH)));
		 	  //GETTING NUMBER OF WEEKS AND DAYS FROM TOTAL DAYS(ttl_days)
		 	  if (ttl_days > 0 && ttl_days < DAYS_OF_WEEK) {
			 	  	dd = ttl_days;
		 	  }else if (ttl_days >= DAYS_OF_WEEK) {
			 	  	wk = Math.floor(ttl_days / DAYS_OF_WEEK);
			 	  	dd = ttl_days - (wk * DAYS_OF_WEEK);
		 	  }


		 	  if (mainInputDateId != "") {
		 	  	 	  //GETTING TOTAL DAYS FROM AGE BASE ON YEAR AND MONTH 2
		 	  	 	  var ttl_days2 =  (var_day2 - Math.floor((yy2 * DAYS_OF_YEAR) +(mm2 * DAYS_OF_MONTH)));
		 	  	 	  //GETTING NUMBER OF WEEKS AND DAYS FROM TOTAL DAYS(ttl_days)
		 	  	 	  if (ttl_days2 > 0 && ttl_days2 < DAYS_OF_WEEK) {
		 	  		 	  	dd2 = ttl_days2;
		 	  	 	  }else if (ttl_days2 >= DAYS_OF_WEEK) {
		 	  		 	  	wk2 = Math.floor(ttl_days2 / DAYS_OF_WEEK);
		 	  		 	  	dd2 = ttl_days2 - (wk2 * DAYS_OF_WEEK);
		 	  	 	  }
		 	  }

		 	  // console.log("-------------------------");
		 	  // console.log(yy+" Years Old");
		 	  // console.log(mm+" Months Old");
		 	  // console.log(wk+" Weeks Old");
		 	  // console.log(dd+" Days Old");
		 	  // console.log("-------------------------");
	
			 	// TO HOLD AGE RESULT LIKE " 2yrs. 1mos. 3wks. 2dys."
			 		var age = getAge(yy, mm, wk, dd);
			 		var ageThatTime = "";
			 		if (mainInputDateId != "") {
			 			 ageThatTime = getAge(yy2, mm2, wk2, dd2);
			 		}
			 		
			 		//console.log(age);

 				 		if (mainInputDateId != "") {
 				 			if (isNaN(time2)) {
 				 				$(inputDateId).val("");
 				 				warning.removeClass('d-none');
 				 				warning.html("<b>ERROR</b>: Please set <b>Date of Birth</b> first!");
 				 				$(mainInputDateId).addClass("border border-danger");
 				 			}else{
 				 				if (time >= time2 && time < curTime) {
	 				 				//console.log('youre in!');
									warning.addClass('d-none');
									warning.html(``);
									$(inputDateId).removeClass("border border-danger");
									dispalyAgeID.val(age);
									ageThatTimeId.val(ageThatTime);
		 				 		}else{
		 				 			//console.log('youre out!');
		 				 			warning.removeClass('d-none');
	 				 				warning.html(`<b>ERROR</b>: Invalid Date Input! `);
	 				 				$(inputDateId).addClass("border border-danger");
	 				 				$(inputDateId).val("");
	 				 				ageThatTimeId.val("");
	 				 				dispalyAgeID.val("");
		 				 		}
		 				 	}
 				 		}else{
 				 			if (time > curTime) {
 				 					warning.removeClass('d-none');
 				 					warning.html(`<b>ERROR</b>: Invalid Date Input! `);
 				 					$(inputDateId).addClass("border border-danger");
 				 					dispalyAgeID.val(age);
 				 					$(inputDateId).val("");
	 				 			}else{
	 				 			warning.addClass('d-none');
	 				 			$(inputDateId).removeClass("border border-danger");
	 				 			dispalyAgeID.val(age);	
	 				 		}
	 				 	}
				 	 
				 	  //SHOW AGE RESULT
				 	  //alert(age);
				 	  
				 	  // console.log("Age        : "+age);
				 	  // console.log("AgeThatTime: "+ageThatTime);
				 	  // console.log("DATE        : "+yy+"-"+mm+"-"+wk+"-"+dd);
				 	  // if (mainInputDateId != "") {
				 	  // 	console.log("DATE2       : "+yy2+"-"+mm2+"-"+wk2+"-"+dd2);
				 	  // }
}

//NOTE:....
//	birthdate = date value 
function setAge(birthdate){
	arr0 = birthdate.split("-"),

	//GETTING ARRAY VALUE AFTER REMOVING DASH SIGN
	bDay = eval(arr0[2]),
	bMonth = eval(arr0[1]),
	bYear = eval(arr0[0]),

	//CREATE DATE OBJECT TO GET THE TOTAL TIME OF INPUT DATE
	newDate = new Date(birthdate),
	time = newDate.getTime();

	//CREATE DATE OBJECT TO GET THE DAY, MONTH AND YEAR OF THE CURRENT DATE
    var curDate = new Date(),
		curDay = curDate.getDate(),

		//PLUS +1 TO .getMonth BECAUSE IT STARTS WITH 0
		curMonth = curDate.getMonth()+1,
		curYear = curDate.getFullYear(),

		//CREATE DATE OBJECT TO GET THE TOTAL TIME OF INPUT DATE
		curTime = curDate.getTime();

	 	// SUBTRACT TOTAL TIME OF CURRENT DATE TO TOTAL TIME OF INPUT DATE
		value = curTime - time;

		//GET AGE RESULTS 
		var_day = Math.floor(value / (1000 * 60 * 60 * 24)),//TOTAL DAYS OF AGE
		var_week = Math.floor(value / (1000 * 60 * 60 * 24 * 7)),//TOTAL WEEKS OF AGE
		var_month = Math.floor(value / (1000 * 60 * 60 * 24 * 30.4375)),//TOTAL MONTHS OF AGE
		var_year = Math.floor(value / (1000 * 60 * 60 * 24 * 365.25));//TOTAL YEARS OF AGE

		//INITIALIZE VARIABLES TO HOLD THE DATA OF YEAR, MONTH, WEEKS AND DAYS OF THE AGE
		const MONTHS = 12;
		const DAYS_OF_YEAR = 365.25;
		const DAYS_OF_MONTH = 30.4375;
		const DAYS_OF_WEEK = 7;
		var dd = 0, mm = 0, wk = 0, yy = var_year;

		if (var_year > 0) {
			if (var_month > MONTHS && var_month < (MONTHS * 2) ) {
				mm = var_month - MONTHS;
			} else if (var_month == 0){
				mm = var_month - MONTHS;
			}else{
				mm = var_month - (var_year * MONTHS) ;
			}
		} else if ( var_year == 0) {
			mm = var_month;
		}

		//GETTING TOTAL DAYS FROM AGE BASE ON YEAR AND MONTH 
		var ttl_days =  (var_day - Math.floor((yy * DAYS_OF_YEAR) +(mm * DAYS_OF_MONTH)));
		//GETTING NUMBER OF WEEKS AND DAYS FROM TOTAL DAYS(ttl_days)
		if (ttl_days > 0 && ttl_days < DAYS_OF_WEEK) {
		  	dd = ttl_days;
		}else if (ttl_days >= DAYS_OF_WEEK) {
		  	wk = Math.floor(ttl_days / DAYS_OF_WEEK);
		  	dd = ttl_days - (wk * DAYS_OF_WEEK);
		}

		  // TO HOLD AGE RESULT LIKE " 2yrs. 1mos. 3wks. 2dys."
		return age = getAge(yy, mm, wk, dd);
}

	window.addEventListener("load", function(){
		$.ajax({
			url:"administrator/update_schedule_status.php",
			success: function(res){
			},
			error: function(err){
				// alert(err.responseText);
			}
		})
	});

	window.addEventListener("load", function(){
		$.ajax({
			url:"administrator/send_notifications.php",
			success: function(res){
				console.log(res);
			},
			error: function(err){
				// alert(err.responseText);
			}
		})
	});