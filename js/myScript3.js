//========================================================================================
//============= INSIDE $(document).ready(funtion(){ ... }) ==============================
//==============  to be able to execute the "funtion({})" ================================
//========================================================================================
$(document).ready(function(){

	//DATATABLES
	$("#clientPaymentsTbl, #categoryTBL, #unitProductsTBL").DataTable({
       "ordering":false
    });

	//PREVIEW IMAGE UPON MODAL POPUP
	function previewImage(image, modal, event){
		var reader = new FileReader();
		var files = event.target.files;

		var done = function(url){
			image.attr('src',url);
			modal.modal('show');
		}

		if (files && files.length > 0) {
			
			reader.onload = function(e){
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	}

	//sgl_Unit AND plr_Unit is from database pass from footer2 
	 function unitPlural(sgl_Unit, plr_Unit, unitSGLR){
	 	var units_sgl = sgl_Unit.split(" ");
	 	var units_plr = plr_Unit.split(" ");
	 	var index = 0;
	 	for (var i = 1; i < units_sgl.length; i++) {
	 		if (unitSGLR == units_sgl[i]) {//console.log(units_sgl[i]);
	 			index = i;
	 		break;
	 		}
	 		
	 	}
	 	if (index != 0) {
	 		return units_plr[index];
	 	}return 0;
	 }

	 function unitSingular(sgl_Unit, plr_Unit, unitPLR){
	 	var units_sgl = sgl_Unit.split(" ");
	 	var units_plr = plr_Unit.split(" ");
	 	var index = 0;
	 	for (var i = 1; i < units_plr.length; i++) {
	 		if (unitPLR == units_plr[i]) {//console.log(units_sgl[i]);
	 			index = i;
	 		break;
	 		}
	 		
	 	}
	 	if (index != 0) {
	 		return units_sgl[index];
	 	}return 0;
	 }

	//VALIDATE INPUT IF FLOAT OR WHOLE NUMBER
	function checkIfNumber(inputID, resMsgID){
		var input = inputID.val();
		var dataArr = input.split("");
		var fee = "";
		var periodCount = 0;
		if (dataArr[0] != "0") {
			for (var i = 0; i < input.length; i++) {
					var data = dataArr[input.length - (input.length - i)];

					if ( !isNaN(data) && data != " " || (data == "." && periodCount == 0)) {
						
						if (data == "." && periodCount == 0) {
							fee += data;
							periodCount = 1;
						}else{
							fee += data;
						}
						resMsgID.text("");
						inputID.val(fee);
						
					}else{
						resMsgID.text('Invalid input "'+data+'"').fadeTo(2000,500).slideUp(500);
						inputID.val("");
						inputID.val(fee);
						return false;
					}
			}
		}else{
			//resMsgID.text('Invalid input "'+data+'"').fadeTo(2000,500).slideUp(500);
			inputID.val("");
			return false;
		}    	
	}

	//VALIDATE INPUT IF WHOLE NUMBER
	function checkIfWholeNumber(inputID, resMsgID){
		
		var input = inputID.val();
		var dataArr = input.split("");
		var fee = "";
			for (var i = 0; i < input.length; i++) {
				var data = dataArr[input.length - (input.length - i)];
				
				if (!isNaN(data) && data != " " && dataArr[0] != "0") {
					fee += data;
					
					if (resMsgID != ""){
						resMsgID.text("");
					}
					
					inputID.val(fee);
				}else{
					if (resMsgID != ""){
						resMsgID.text('Invalid input "'+data+'"').fadeTo(2000,500).slideUp(500);
					}
					
					inputID.val("");
					inputID.val(fee);
					return false;
					
				}
			}
	}

		// $('#initQty').on('keyup', function(){
		// 	var onHand = $('#onHand');
		// 	var initQty = $(this).val();
		// 	var origUnit = $('#origUnit').val();
		// 	var initPrice = $('#initPrice').val();
		// 	var incRate = $('#incRate').val();

		// 	if (checkIfWholeNumber($(this), $('#initQtyRes')) != false) {
		// 		var init_price = initPrice / initQty;
		// 		if (origUnit != "" && initQty != "") {
		// 			onHand.val(initQty+" "+unitPlural(sgl_Unit, plr_Unit, origUnit));

		// 			if (initQty == 1 ) {
		// 				onHand.val(initQty+" "+origUnit);
		// 			}

		// 			var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
		// 			var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);
				
		// 			if (incRate != "") {
		// 				$('#ratePeso').val((rate_peso).toFixed(2));
		// 				$('#pricePeso').val((price_peso).toFixed(2));

		// 			}else{
		// 				$('#ratePeso').val("");
		// 				$('#pricePeso').val("");
		// 			}
		// 		}else{
		// 			onHand.val("");
		// 		}
		// 	}
		// });

		// $('#origUnit').on('change', function(){
		// 	var unit = $(this).val();
		// 	$('#initPricelb').html('Init. Price per '+unit+' (<span>&#8369;</span>)');
		// 	$('#costratelb').html('Cost Rate per '+unit+' (<span>&#8369;</span>)');
		// 	$('#pricelb').html('Price per '+unit+' (<span>&#8369;</span>)');

		// 	if ($('#initQty').val() != "" && $(this).val() != "") {
		// 		$('#onHand').val($('#initQty').val()+" "+unitPlural(sgl_Unit, plr_Unit, unit));

		// 		if ($('#initQty').val() == 1) {
		// 			$('#onHand').val($('#initQty').val()+" "+unit);
		// 		} 
		// 	}else{
		// 		$('#onHand').val("");
		// 	}
		// });

		// $('#initPrice').on('keyup', function(){
		// 	var initQty = $('#initQty').val();
		// 	var origUnit = $('#origUnit').val();
		// 	var initPrice = $(this).val();
		// 	var incRate = $('#incRate').val();

		// 	if (initQty == "") {
		// 		$(this).val("");
		// 		$('#initQty').addClass("border border-danger");
		// 		$('#initQty').attr('placeholder', 'Please fill!	');
		// 		$('#initQtyRes').html("<i> Please fill this field!</i>");
		// 		setTimeout(function(){
		// 			$('#initQty').removeClass("border border-danger");
		// 			$('#initQtyRes').text("");
		// 		},3000);
		// 	}else{
		// 		var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
		// 		var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

		// 		if (checkIfNumber($(this), $('#initPriceRes')) != false ) {
		// 			if (initPrice != "") {
		// 				if (incRate == "") {
		// 					$('#ratePeso').val("");
		// 					$('#pricePeso').val("");
		// 				}else{
		// 					$('#ratePeso').val((rate_peso).toFixed(2));
		// 					$('#pricePeso').val((price_peso).toFixed(2));
		// 				}
		// 			}else{
		// 				$('#ratePeso').val("");
		// 				$('#pricePeso').val("");
		// 			}
					
		// 		}else{
		// 			$('#ratePeso').val("");
		// 			$('#pricePeso').val("");
		// 		}

		// 	}
			
		// });

		// $('#incRate').on('keyup', function(){
		// 	var incRate = $(this).val();
		// 	var initPrice = $('#initPrice').val();
		// 	var initQty = $('#initQty').val();
		// 	var origUnit = $('#origUnit').val();

		// 	if (initQty == "") {
		// 		$(this).val("");
		// 		$('#initQty').addClass("border border-danger");
		// 		$('#initQty').attr('placeholder', 'Please fill!	');
		// 		$('#initQtyRes').html("<i> Please fill this field!</i>");
		// 		setTimeout(function(){
		// 			$('#initQty').removeClass("border border-danger");
		// 			$('#initQtyRes').text("");
		// 		},3000);
		// 	}else {
		// 		if (initPrice == "") {
		// 			$(this).val("");
		// 			$('#initPrice').addClass("border border-danger");
		// 			$('#initPrice').attr('placeholder', 'Please fill!	');
		// 			$('#initPriceRes').html("<i> Please fill this field!</i>");
		// 			setTimeout(function(){
		// 				$('#initPrice').removeClass("border border-danger");
		// 				$('#initPriceRes').text("");
		// 			},3000);
		// 		}else{
		// 			if (origUnit == "") {
		// 				$(this).val("");
		// 				$('#origUnit').addClass("border border-danger");
		// 				$('#origUnit').attr('placeholder', 'Please fill!');
		// 				setTimeout(function(){
		// 					$('#origUnit').removeClass("border border-danger");
		// 					$('#origUnitRes').text("");
		// 				},3000);
		// 			}else{
		// 				var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
		// 				var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

		// 				if (incRate != "") {
		// 					if(checkIfNumber($(this), $('#incRateRes')) != false) {
		// 						// ttlQty.val(initQty);
		// 						$('#ratePeso').val((rate_peso).toFixed(2));
		// 						$('#pricePeso').val((price_peso).toFixed(2));
		// 						// $('#ratePeso2').val((rate_peso).toFixed(2));
		// 						// $('#pricePeso2').val((price_peso).toFixed(2));
		// 						// initPrice.,'#initPrice2'val(initprice);
		// 					}else{
		// 						// ttlQty.val("");
		// 						$('#ratePeso').val("");
		// 						$('#pricePeso').val("");
		// 						// $('#ratePeso2').val("");
		// 						// $('#pricePeso2').val("");
		// 						// initPrice.val("");
		// 					}
		// 				}else{
		// 					$('#ratePeso').val("");
		// 					$('#pricePeso').val("");
		// 					// $('#ratePeso2').val("");
		// 					// $('#pricePeso2').val("");
		// 				}
		// 			}
					
		// 		}
		// 	}
				
		// });

		// $('#inventoryTBL tbody').on('click','.addProductQty', function(e){
		// 	e.preventDefault();
		// 	$('#addProductQtyModal').modal('show');

		// 	$tr = $(this).closest('tr');

		// 	var data = $tr.children('td').map(function(){
		// 		return $(this).text();
		// 	}).get();
		// 	var onhand = data[9].split(" ");
		// 	var id = data[0];
		// 	var product = data[1];
		// 	var ctg = data[2];
		// 	var desc = data[3];
		// 	var onhandP = data[9];
		// 	var stat = $.trim(data[10]); 
		// 	var price = data[8];
		// 	$('input[name = "prodID"]').val(id);
		// 	$('#pname').text(product);
		// 	$('#ctgname').text(ctg);
		// 	$('#pdesc').text(desc);
		// 	$('#ponhand').text(onhandP);
		// 	$('#pprice').text(price);
		// 	if (stat == "FULL") {
		// 		$('#pstat').html(`<span class="bg-success p-2" >FULL</span>`);
		// 	}
		// 	if (stat == "LOW") {
		// 		$('#pstat').html(`<span class="bg-warning p-2" >LOW</span>`);
		// 	}
		// 	if (stat == "CRITICAL") {
		// 		$('#pstat').html(`<span class="bg-danger p-2" >CRITICAL</span>`);
		// 	}
	 //    if (stat == "NORMAL") {
	 //      $('#pstat').html(`<span class="bg-olive p-2" >NORMAL</span>`);
	 //    }
	 //    if (stat == "OUT OF STOCK") {
	 //      $('#pstat').html(`<span class="bg-gray-dark p-2" >OUT OF STOCK</span>`);
	 //    }
		// 	$('#ttlQTYRes').text(onhandP);
		// 	$('#ttlQTYRes2').text(onhandP);
		// 	$('input[name = "onhandProd"]').val(onhand[0]);
		// 	$('input[name = "unitProd"]').val(onhand[1]);
		// 	$('input[name = "ctgProd"]').val(ctg);
	 //    $('#addedQtyUnit').text(onhand[1]);
		// 	$('input[name = "descProd"]').val(desc);
		// 	$('input[name = "priceProd"]').val(price);
		// 	//console.log(data);

		// });

	 //  $('#inventoryTBL tbody').on('click','.editProductBTN', function(e){
		// 	e.preventDefault();
		// 	$('#editProductModal').modal('show');

		// 	$tr = $(this).closest('tr');

		// 	var data = $tr.children('td').map(function(){
		// 		return $(this).text();
		// 	}).get();
		// 	var onhand = data[9].split(" ");
		// 	var id = data[0];
		// 	var product = data[1];
		// 	var ctg = data[2];
		// 	var desc = data[3];
		// 	var ttlq = data[4].split(" ");
		// 	var orgP = data[5];
		// 	var ratePerc = data[6];
		// 	var rateP = data[7];
		// 	var price = data[8];
		// 	var onhandP = data[9];
		// 	var stat = data[10];
		// 	var ctgID = data[11];
		// 	//alert(stat);
		// 	$('input[name = "hdProdID"]').val(id);
		// 	$('input[name = "product2"]').val(product);
		// 	$('input[name = "ctgProd"]').val(ctg);
		// 	$('#prodDesc2').text(desc);
		// 	$('input[name = "qty2"]').val(ttlq[0]);
		// 	$('input[name = "price2"]').val(orgP);
		// 	$('input[name = "qtyOnhand2"]').val(onhandP);
		// 	$('input[name = "incrate2"]').val(ratePerc);
		// 	$('input[name = "pesoRate2"]').val(rateP);
		// 	$('input[name = "pesoPrice2"]').val(price);
		// 	$('input[name = "hdStat3"]').val(stat);

		// 	$('#initPricelb2').html('Init. Price per '+unitSingular(sgl_Unit, plr_Unit, onhand[1])+' (<span>&#8369;</span>)');
		// 	$('#costratelb2').html('Cost Rate per '+unitSingular(sgl_Unit, plr_Unit, onhand[1])+' (<span>&#8369;</span>)');
		// 	$('#pricelb2').html('Price per '+unitSingular(sgl_Unit, plr_Unit, onhand[1])+' (<span>&#8369;</span>)');

		// 	$('#loadcategories').load('inventory/load-categories.php', {
		// 	   ctg : ctg
		// 	}, function(restxt, statstxt, jqXHR){
		// 	 if (restxt == 'success') {
		// 	   console.log('New Content Load');
		// 	 }
		// 	 if (restxt == 'error') {
		// 	    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		// 	 }
		// 	});

		// 	//$('#origUnit2').val(unitSingular(sgl_Unit, plr_Unit, onhand[1]));
		// 	$('#origUnit2').load('inventory/load-units.php', {
		// 	   unit : onhand[1]
		// 	}, function(restxt, statstxt, jqXHR){
		// 	 if (restxt == 'success') {
		// 	   console.log('New Content Load');
		// 	 }
		// 	 if (restxt == 'error') {
		// 	    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		// 	 }
		// 	});
		// });

		// $('#addedQty').on('keyup', function(){
		// 	var onhand = $('input[name = "onhandProd"]').val();
		// 	var unit = $('input[name = "unitProd"]').val();
		// 	var addQty = $(this).val();
		// 	var newqty = parseInt(onhand) + parseInt(addQty);
		// 	if (addQty != "") {
		// 		if (checkIfWholeNumber($(this), $('#addedQtyRes')) != false) {
		// 			$('#ttlQTYRes').text(newqty+" "+unit );
		// 			if (true) {}
		// 			$('input[name = "totalProdQty"]').val(newqty);
		// 		}
		// 	}else{
		// 		$('#ttlQTYRes').text(onhand+" "+unit );
		// 		$('input[name = "totalProdQty"]').val(newqty);
		// 	}
		// });


		// $('#initQty2').on('keyup', function(){
		// 	var onHand = $('#onHand2');
		// 	var initQty = $(this).val();
		// 	var origUnit = $('#origUnit2').val();
		// 	var initPrice = $('#initPrice2').val();
		// 	var incRate = $('#incRate2').val();

		// 	if (checkIfWholeNumber($(this), $('#initQtyRes2')) != false) {

		// 		if (origUnit != "" && initQty != "") {
		// 			onHand.val(initQty+" "+unitPlural(sgl_Unit, plr_Unit, origUnit));
		// 			if (initQty == 1 ) {
		// 				onHand.val(initQty+" "+origUnit);
		// 			}
		// 			// $('#lbPrice2').text("Price per "+units[unit]+" (Peso)");

		// 			var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
		// 			var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);
				
		// 			if (incRate != "") {
		// 				$('#ratePeso2').val((rate_peso).toFixed(2));
		// 				$('#pricePeso2').val((price_peso).toFixed(2));

		// 			}else{
		// 				$('#ratePeso2').val("");
		// 				$('#pricePeso2').val("");
		// 			}
		// 		}else{
		// 			onHand.val("");
		// 			// $('#lbPrice2').text('Price (Peso)');
		// 		}
		// 	}
		// });

		// $('#origUnit2').on('change', function(){
			
		// 	var unit = $(this).val();

		// 	$('#initPricelb2').html('Init. Price per '+unit+' (<span>&#8369;</span>)');
		// 	$('#costratelb2').html('Cost Rate per '+unit+' (<span>&#8369;</span>)');
		// 	$('#pricelb2').html('Price per '+unit+' (<span>&#8369;</span>)');

		// 	if ($('#initQty2').val() != "" && $(this).val() != "") {
		// 		$('#onHand2').val($('#initQty2').val()+" "+unitPlural(sgl_Unit, plr_Unit, unit));
		// 		// $('#lbPrice').text("Price per "+units[unit]+" (Peso)");2
		// 		if ($('#initQty2').val() == 1) {
		// 			$('#onHand2').val($('#initQty2').val()+" "+unit);
		// 		} 
		// 	}else{
		// 		$('#onHand2').val("");
		// 	}
		// });

		// $('#initPrice2').on('keyup', function(){
		// 	var initQty = $('#initQty2').val();
		// 	var origUnit = $('#origUnit2').val();
		// 	var initPrice = $(this).val();
		// 	var incRate = $('#incRate2').val();

		// 	if (initQty == "") {
		// 		$(this).val("");
		// 		$('#initQty2').addClass("border border-danger");
		// 		$('#initQty2').attr('placeholder', 'Please fill!	');
		// 		$('#initQtyRes2').html("<i> Please fill this field!</i>");
		// 		setTimeout(function(){
		// 			$('#initQty2').removeClass("border border-danger");
		// 			$('#initQtyRes2').text("");
		// 		},3000);
		// 	}else{
		// 		var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
		// 		var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

		// 		if (checkIfNumber($(this), $('#initPriceRes2')) != false ) {
		// 			if (initPrice != "") {
		// 				if (incRate == "") {
		// 					$('#ratePeso2').val("");
		// 					$('#pricePeso2').val("");
		// 				}else{
		// 					$('#ratePeso2').val((rate_peso).toFixed(2));
		// 					$('#pricePeso2').val((price_peso).toFixed(2));
		// 				}
		// 			}else{
		// 				$('#ratePeso2').val("");
		// 				$('#pricePeso2').val("");
		// 			}
					
		// 		}else{
		// 			$('#ratePeso2').val("");
		// 			$('#pricePeso2').val("");
		// 		}

		// 	}
			
		// });

		// $('#incRate2').on('keyup', function(){
		// 	var incRate = $(this).val();
		// 	var initPrice = $('#initPrice2').val();
		// 	var initQty = $('#initQty2').val();
		// 	var origUnit = $('#origUnit2').val();

		// 	if (initQty == "") {
		// 		$(this).val("");
		// 		$('#initQty2').addClass("border border-danger");
		// 		$('#initQty2').attr('placeholder', 'Please fill!	');
		// 		$('#initQtyRes2').html("<i> Please fill this field!</i>");
		// 		setTimeout(function(){
		// 			$('#initQty2').removeClass("border border-danger");
		// 			$('#initQtyRes2').text("");
		// 		},3000);
		// 	}else {
		// 		if (initPrice == "") {
		// 			$(this).val("");
		// 			$('#initPrice2').addClass("border border-danger");
		// 			$('#initPrice2').attr('placeholder', 'Please fill!	');
		// 			$('#initPriceRes2').html("<i> Please fill this field!</i>");
		// 			setTimeout(function(){
		// 				$('#initPrice2').removeClass("border border-danger");
		// 				$('#initPriceRes2').text("");
		// 			},3000);
		// 		}else{
		// 			if (origUnit == "") {
		// 				$(this).val("");
		// 				$('#origUnit2').addClass("border border-danger");
		// 				$('#origUnit2').attr('placeholder', 'Please fill!');
		// 				setTimeout(function(){
		// 					$('#origUnit2').removeClass("border border-danger");
		// 					$('#origUnitRes2').text("");
		// 				},3000);
		// 			}else{
		// 				var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
		// 				var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

		// 				if (incRate != "") {
		// 					if(checkIfNumber($(this), $('#incRateRes2')) != false) {
		// 						// ttlQty.val(initQty);
		// 						$('#ratePeso2').val((rate_peso).toFixed(2));
		// 						$('#pricePeso2').val((price_peso).toFixed(2));
		// 					}else{
		// 						$('#ratePeso2').val("");
		// 						$('#pricePeso2').val("");
		// 					}
		// 				}else{
		// 					$('#ratePeso2').val("");
		// 					$('#pricePeso2').val("");
		// 				}
		// 			}
					
		// 		}
		// 	}
				
		// });
	$('#clientPaymentsTbl tbody').on('click','button',function(){
		var tr = $(this).closest('tr');
		var data = tr.children('td').map(function(){
							return $(this).text();
					}).get();
		$('#servicesAndFeeTbody').load("receptionist/load-servicesAndFee.php",{
			cin_no:data[0]
		}, function(restxt, statstxt, jqXHR){
		   if (statstxt == "success") {
		   	$('#cdate').text(data[8]);
		   	$('#cinvoice').text(data[0]);
		   	$('#cname').text(data[1]);
		   	$('#cpet').text(data[2]);
		   	$('#crecept').text(data[9]);
		   	$('#csubtotal').text(data[3]);
		   	$('#cdisrate').text(data[4]);
		   	$('#cdiscost').text(data[5]);
		   	$('#ctotal').html(data[6]);
		   	$('#cstatus').text(data[7]);
		   	window.location.href = 'index3.php?page=paymentRecords';
		   }else{
		   		Swal.fire({
		   	        icon:'error',
		   	        title: "Failed! Please check internet connection!",
		   	        showConfirmButton: 'true',
		   	        timer: 2500
		   		});
		   }
	   });
	});

	//FOR VIEW ACCOUNT PASSWORD
	$('#viewUserPassword').on('click', function(){
	   if($('#userPassword').attr('type') == "password"){
	   	 $(this).removeClass('fas fa-eye-slash');
	   	 $(this).addClass('fas fa-eye');
	      $('#userPassword').prop('type','text');
	   }else{
	     $(this).addClass('fas fa-eye-slash');
	      $('#userPassword').prop('type','password');
	   }
	});

	//FOR VIEW ACCOUNT PASSWORD EDIT
	$('#viewUserPassword2').on('click', function(){
	   if($('#userPassword2').attr('type') == "password"){
	   	 $(this).removeClass('fas fa-eye-slash');
	   	 $(this).addClass('fas fa-eye');
	      $('#userPassword2').prop('type','text');
	   }else{
	     $(this).addClass('fas fa-eye-slash');
	      $('#userPassword2').prop('type','password');
	   }
	});

	// EDIT ACCOUNT INFO
	$('#edit_user_btn2').click(function(){
		$('#editAccountModal2').modal('show');

		$('#account_ID2').val($('#account_id2').val());
		$('#fNAME2').val($('#Fname2').val());
		$('#lNAME2').val($('#Lname2').val());
		$('#contaCT2').val($('#Contact2').val());
		$('#uNAME2').val($('#Uname2').val());
		$('#baseusername').val($('#Uname2').val());
		$('#userPassword2').val($('#userPassword').val());
		if (parseInt($('#Uname2').val().trim().length) < 8) {
			$('#usernameCheck').addClass("text-danger");
			$('#usernameCheck').text("Must consist of 8 characters ("+(8 - parseInt($('#Uname2').val().trim().length))+" left)");
			$('#saveEditedAccount').attr("disabled", true);
		}else{
			$('#usernameCheck').removeClass('text-danger');
			$('#usernameCheck').addClass("text-success");
			$('#usernameCheck').text("Valid Username");
			$('#saveEditedAccount').attr("disabled", false);
		}

		if (parseInt($('#userPassword').val().trim().length) < 8) {
			$('#passwordCheck').addClass('text-danger');
			$('#passwordCheck').text("Must consist of 8 characters ("+(8 - parseInt($('#userPassword2').val().trim().length))+" left)");
			$('#saveEditedAccount').attr("disabled", true);
		}else{
			$('#passwordCheck').removeClass('text-danger');
			$('#passwordCheck').addClass("text-success");
			$('#passwordCheck').text("Valid Password");
			$('#saveEditedAccount').attr("disabled", false);
		}
		
	});
	$('#userPassword2').keyup(function(e){
		$('#passwordCheck').removeClass('text-danger');
		$('#passwordCheck').removeClass('text-success');
		var passwordLength = $('#userPassword2').val().trim().length;
		if (passwordLength < 8) {
			$('#passwordCheck').addClass("text-danger");
			$('#passwordCheck').text("Must consist of 8 characters ("+(8 - parseInt(passwordLength))+" left)");
			$('#saveEditedAccount').attr("disabled", true);
		}else{
			$('#passwordCheck').addClass("text-success");
			$('#passwordCheck').text("Valid Password");
			$('#saveEditedAccount').attr("disabled", false);
		}
	});
	// CHECKING FOR USERNAME VALIDITY
	$('#uNAME2').keyup(function(e){
		e.preventDefault();
		$('#usernameCheck').removeClass('text-danger');
		$('#usernameCheck').removeClass('text-success');
		var usernameLength = $('#uNAME2').val().trim().length;
		if (usernameLength < 8) {
			$('#usernameCheck').addClass("text-danger");
			$('#usernameCheck').text("Must consist of 8 characters ("+(8 - parseInt(usernameLength))+" left)");
			$('#saveEditedAccount').attr("disabled", true);
		}else{
			if ($('#baseusername').val() == $('#uNAME2').val()) {
				$('#usernameCheck').addClass("text-success");
				$('#usernameCheck').text("Valid Username");
				$('#saveEditedAccount').attr("disabled", false);
			}else{
				$.ajax({
					method:'post',
					url:'administrator/checkUsername.php',
					data:{username:$(this).val()},
					success: function(res){
						if (res.status == "existing") {
							$('#usernameCheck').addClass("text-danger");
							$('#usernameCheck').text("Existing! Please use different username!");
							$('#saveEditedAccount').attr("disabled", true);
						}else{
							$('#usernameCheck').addClass("text-success");
							$('#usernameCheck').text("Valid Username");
							$('#saveEditedAccount').attr("disabled", false);
						}
					},
					error: function(err){
						console.log(err.responseText);
					}
				});
			}
			
		}
	});
	// GETTING ADMIN ID AND ADMIN RECENT PHOTO
	let ACCOUNT_ID = "";
	let ACCOUNT_PHOTO = "";
	$('#edit_userPhoto').click(function(){
		ACCOUNT_ID = $('#account_id2').val();
		ACCOUNT_PHOTO = $('#accnt_photo2').text();
		 // console.log(ACCOUNT_ID);
		 // console.log(ACCOUNT_PHOTO);
		 $('#upload_adminPhoto2').click();
	});

	//NOTE...
	//image = AN IMG ELEMENT WHERE THE CROPPED IMAGE WILL BE DISPLAY
	//cropper = INITIALIZE FOR cropper.js VARIABLE
	// var modal3 = $('#croppedPetImageModal3');
	var image3 = document.querySelector('#sample_img4');
	var cropper3;

	//GET AND DISPLAY SELECTED PHOTO/IMAGE
	$('#upload_adminPhoto2').on('change', function (event){
		var file = event.target.files;
		var file_ext = file[0].type;

		var extensions = ['image/jpeg', 'image/jpg', 'image/png'];

		var extensions2 = extensions.values();//ITERATOR

		var isValidImage = false;
		for(let value of extensions2){
			// console.log(value);
			if (file_ext == value) {
				isValidImage = true;
				break;
			}
		}
		if (isValidImage == false) {
			Swal.fire({
			        icon:'error',
			        title: "Not an IMAGE! Please Select Image File ONLY!",
			        text: "",
			        showConfirmButton: 'true',
			        timer: 2500
				});
		}else{
			 previewImage($('#sample_img4'), $('#croppedPetImageModal4'), event);
		}
		// console.log(file);
		// console.log(file_ext);
		// console.log(isValidImage);
			
	});

	 //SETTING AND GETTING PHOTO/IMAGE TO BE CROPPED
	 $('#croppedPetImageModal4').on('shown.bs.modal', function() {
	 	cropper3 = new Cropper(image3, {
	 		aspectRatio: 3/3,
	 		viewMode: 'square',
	 		preview: '.preview'
	 		//preview = class of div where cropped image display as preview
	 	});
	 }).on('hidden.bs.modal', function (){
	 	cropper3.destroy();
	 	cropper3 = null;
	 });

	  //SAVING CROPPED PHOTO/IMAGE
	 $('#crop_img-Btn4').on('click', function(){
	 	var canvas = cropper3.getCroppedCanvas({
	 		width:200,
	 		height:200
	 	});
	 	canvas.toBlob(function(blob){
	 		url = URL.createObjectURL(blob);
	 		var reader = new FileReader();
	 		reader.readAsDataURL(blob);
	 		reader.onloadend = function(){
	 			var base64image = reader.result;
	 			$.ajax({
	 				method: 'post',
	 				url: 'administrator/save_userPhoto.php',
	 				data: {image:base64image, accountid:ACCOUNT_ID, accountphoto:ACCOUNT_PHOTO},
	 				success: function(res){
			          // var src = 'image/user/'+res.photo;
			          // $('#userPhoto2').attr('src',src);
	 					// alert(res.photo);
	 					$('#croppedPetImageModal4').modal('hide');
	 					setTimeout(function(){
	 						location.reload(true);
	 					},2000);
	 					if (res.status == "success") {
	 						Swal.fire({
	 					        icon:'success',
	 					        title: "Account Photo Changed Successfully",
	 					        showConfirmButton: 'true',
	 					        timer: 2500
	 						})
	 					}
	 					if (res.status == "failed") {
	 						Swal.fire({
	 					        icon:'error',
	 					        title: "Failed to change Pet Photo!",
	 					        text: "Please check internet connection",
	 					        showConfirmButton: 'true',
	 					        timer: 2500
	 						})
	 					}
	 					
	 				},error:function(e){
	 					console.log(e.responseText);
	 				}
	 			});
	 		}
	 	});
	 	// displayCroppedImage(cropper3, $('#croppedPetImageModal3'), ACCOUNT_ID, ACCOUNT_PHOTO);
	 });

	 $('#amountTendered').on('keyup change', function(e){
	 	if ($(this).val() != "") {
	 		var amounttrd = parseInt($(this).val());
	 		var balance = $('#balance').text().replace(/,/gi,"");
	 		var change = amounttrd - parseFloat(balance);
	 		$('#clientchange').text(change);
	 		if (change < 0) {
	 			$('#clientchange').text('0');
	 		}
	 		
	 	}
	 });

	 var datefrom = $('#salesdateFrom').val();
	 var dateto = $('#salesdateTo').val();
	 var href = 'administrator/print_salesreport.php?df='+datefrom+'&dt='+dateto+'&sfrom=Clinic';
	 $('#printStoreSales').attr('href', href);
	$('#salesdateFrom, #salesdateTo').on('change', function(){
		 var datefrom = $('#salesdateFrom').val();
  		 var dateto = $('#salesdateTo').val();

		$('#salesTBL').load('administrator/load_clinicSalesfromto.php',{
			datefrom: datefrom,
			dateto: dateto
		},function(restxt, statstxt, jqXHR){
		 if (statstxt == 'success') {
		   	$.ajax({
		       method: 'post',
		       url: 'administrator/load_clinicTotalSales.php',
		       data: {datefrom:datefrom,dateto:dateto},
		       success: function(res){
		       	if (res.totalsales == null) {
		       		$('#totalSales').text('0');
				$('#printStoreSales').attr('href','');
		       	}else{
	       		  	$('#totalSales').text(res.totalsales);
	       		    var href = 'administrator/print_salesreport.php?df='+datefrom+'&dt='+dateto+'&sfrom=Clinic';
	       		    $('#printStoreSales').attr('href', href);
		       	}
		       }
		      });	

		 }
		 if (statstxt == 'error') {
		    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		 }

		});
	});

	 $('#savepaymentbtn').on('click', function(){

	 	if ($('#amountTendered').val() != "" &&  $('#amountTendered').val() != 0) {

	 		$.ajax({
 			method: 'post',
 			url: 'clinic_cashier/save_payment.php',
 			data: {
 				accntid:$('#ACCOUNT_ID').val(),
 				cinid:$('#cinid').val(),
 				cinno:$('#cinno').text(),
 				balance:$('#balance').text().replace(/,/gi,""),
 				amount:$('#amountTendered').val(),
 				change:$('#clientchange').text()
 			},
 			success: function(res){
 				// setTimeout(function(){
 				// 	window.location.href = window.location.href;
 				// },2000);
 				if (res.status == "success") {
 					var bal = $('#balance').text();
 					var cash = $('#amountTendered').val();
 					var change = $('#clientchange').text();
 					window.location.href = "clinic_cashier/print_clientInvoice.php?cin="+$('#clientInvNo').val()+"&bal="+bal+"&cs="+cash+"&ch="+change;
 					// Swal.fire({
 				    //     icon:'success',
 				    //     title: "Client Payment Save Successfully",
 				    //     showConfirmButton: 'true',
 				    //     timer: 2500
 					// })
 				}
 				if (res.status == "failed") {
 					Swal.fire({
 				        icon:'error',
 				        title: "Failed to Save Client Payment!",
 				        text: "Please check internet connection",
 				        showConfirmButton: 'true',
 				        timer: 2500
 					})
 				}
 				
 			},error:function(e){
 				console.log(e.responseText);
 			}
 		});
	 	}
 	 	
	 });
	 // //Edit Product Category
	 // 	$('#categoryTBL tbody').on('click','.editProductCategoryBtn', function(e){
	 // 		e.preventDefault();
	 // 		$('#editProductCategoryModal').modal('show');

	 // 		$tr = $(this).closest('tr');

	 // 		var data = $tr.children('td').map(function(){
	 // 			return $(this).text();
	 // 		}).get();
	 		
	 // 		var ctgid = data[1];
	 // 		var ctg = data[2];

	 // 		$('input[name = "prodcategoryID2"]').val(ctgid);
	 // 		$('input[name = "prodcategory2"]').val(ctg);
	 		
	 // 	});

	 	// //Edit Product Unit
	 	// $('#unitProductsTBL tbody').on('click','.editProductUnitBtn', function(e){
	 	// 	e.preventDefault();
	 	// 	$('#editProductUnitModal').modal('show');

	 	// 	$tr = $(this).closest('tr');

	 	// 	var data = $tr.children('td').map(function(){
	 	// 		return $(this).text();
	 	// 	}).get();
	 		
	 	// 	var unitid = data[1];
	 	// 	var unitplr = data[2];
	 	// 	var unitsgl = data[3];

	 	// 	$('input[name = "unitid"]').val(unitid);
	 	// 	$('input[name = "unitplr2"]').val(unitplr);
	 	// 	$('input[name = "unitsgl2"]').val(unitsgl);
	 	// });

	 	// // ADDED PRODUCT WITH DATE FROM AND TO
	 	// var datefrom2 = $('#dateFrom2').val();
	 	// var dateto2 = $('#dateTo2').val();
	 	// var href = 'inventory/print_added_products.php?df='+datefrom2+'&dt='+dateto2;
	 	// $('#printAddedProducts').attr('href',href);

	 	// $('#dateFrom2').on('change', function(){
	 	//   var datefrom2 = $(this).val();
	 	//   var dateto2 = $('#dateTo2').val();
	 	//   var href = 'inventory/print_added_products.php?df='+datefrom2+'&dt='+dateto2;
	 	//   $('#printAddedProducts').attr('href',href);

	 	//   $('#addedProductsTBody').load('inventory/load_productsfromto.php',{
	 	//     datefrom2: datefrom2,
	 	//     dateto2: dateto2
	 	//   },
	 	//   function(restxt, statstxt, jqXHR){
	 	//     // console.log(restxt);
	 	//   });  
	 	// });

	 	// $('#dateTo2').on('change', function(){
	 	//   var datefrom2 = $('#dateFrom2').val();
	 	//   var dateto2 = $(this).val();
	 	//   var href = 'inventory/print_added_products.php?df='+datefrom2+'&dt='+dateto2;
	 	//   $('#printAddedProducts').attr('href',href);

	 	//   $('#addedProductsTBody').load('inventory/load_productsfromto.php',{
	 	//     datefrom2: datefrom2,
	 	//     dateto2: dateto2
	 	//   },function(restxt, statstxt, jqXHR){
	 	//     // console.log(restxt);
	 	//   });
	 	// });
});