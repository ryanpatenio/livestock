//========================================================================================
//============= INSIDE $(document).ready(funtion(){ ... }) ==============================
//==============  to be able to execute the "funtion({})" ================================
//========================================================================================
$(document).ready(function(){
	//alert(sgl_Unit);
	//alert(plr_Unit);
	//DATATABLES

	$("#inventoryTBL, #unitProductsTBL, #addProductHistoryTBL, #categoryTBL").DataTable({
       "autoWidth": false,
       "ordering":false
    });

    // $("#itemproductTBL").DataTable({
    //   "autoWidth": false,
    //   "ordering":false,
    //   paging:false,
    //   pageLength: 10

    // });
    // $('#showDateTime').click(function(){
    // 	console.log(dateAndTime());
    // });
    $("#salesTBL").DataTable({
      "autoWidth": false,
      info: false,
      "ordering": false
    });

    //FOR VIEW ADMIN PASSWORD
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

    //FOR VIEW ADMIN PASSWORD EDIT
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
    //GET DATETIME
    function dateAndTime(){
    	var date = new Date();
    	var	day = date.getDate();
    	var	month = date.getMonth()+1;
    	var	year = date.getFullYear();
    	var	hour = date.getHours();
    	var	mins = date.getMinutes();
    	
    	return year+"-"+month+"-"+day+" "+hour+":"+mins+":00";
    }

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
// =============================================================
// THIS IS FOR ACCOUNT2 PAGE ==================================
// =============================================================

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

    function removeArray(arr, value){
    	var newArr = [];
    	for (var i = 0; i < arr.length; i++) {
    		var res = arr[value];
    	}
    	return newArr;
    }
    
    var tableData = [];
    $('#itemsproducttbody').on('click','.purchase', function(){

    	var $tr = $(this).closest('tr');
    	var data = $tr.children('td').map(function(){
    			return $(this).text();
    	}).get();
    	var id = data[1];
    	var product = data[2];
    	var categoryid = data[3];
    	var category = data[4];
    	var description = data[5];
    	var price = data[6];
    	var onhand  = data[7];
    	var quantity  = $tr.find("td:eq(8) input").val();
    	var key = data[1];
    	if ($(this).prop("checked")) {
    		$tr.find("td:eq(8) input").removeAttr("readonly");
            $tr.find("td:eq(8) input").val("1");
    		//$('#purchasetbody').append('<tr><td hidden>'+id+'</td><td>'+product+'</td><td>'+price+'</td><td><input type="text" value="1" max="'+onhand+'" class="form-control form-control-sm text-center orderQty"></td><td><button class="btn btn-sm bg-danger"><i class="fas fa-times cancelOrder"></i></button></td></tr>');
    		tableData[key] = {
    			id,
    			product,
    			categoryid,
    			category,
    			description,
    			price,
    			onhand,
    			quantity
    		}

    	}else{
    		$tr.find("td:eq(8) input").attr("readonly",true);
    		$tr.find("td:eq(8) input").val("0");
    		tableData[key] = {};
    		// var $tr = $('tbody #purchasetbody').closest('tr');
    		// var data = $tr.children('td').map(function(){
    		// 	return $(this).text();
    		// }).get();
    		// console.log(data);
    	}
    	// console.log("----------------------------");
    	//console.log(purchaseList);
    });

    
    $('#done').on('click', function(){
    	$('#itemsproducttbody tr').each(function(){
    		var curRow = $(this);

    		var id = curRow.find("td:eq(1)").text(); 
    		var product = curRow.find("td:eq(2)").text();
    		var categoryid = curRow.find("td:eq(3)").text();
    		var category = curRow.find("td:eq(4)").text();
    		var description = curRow.find("td:eq(5)").text();
    		var price = curRow.find("td:eq(6)").text();
    		var onhand = curRow.find("td:eq(7)").text();
    		var quantity = curRow.find("td:eq(8) input").val();
    		var col9_val = curRow.find("td:eq(9) input").prop("checked");

    		if (col9_val == true) {
    			tableData[id] = {
    				id,
    				product,
    				categoryid,
    				category,
    				description,
    				price,
    				onhand,
    				quantity
    			};
    		}

    	});
    	// console.log(tableData);

    	$('#purchasetbody tr').remove();
    	var subtotal = 0;
    	for(var data in tableData){
    		// console.log(tableData[data]);
    		if (tableData[data].id != undefined) {
    			var id = tableData[data].id;
    			var product = tableData[data].product;
    			var price = tableData[data].price;
    			var onhand = tableData[data].onhand.split(" ");
    			var quantity = tableData[data].quantity;
                var unit = onhand[1];
                if (quantity != "" && quantity != 0) {
                    if (quantity == 1) {
                        unit = unitSingular(sgl_Unit, plr_Unit, onhand[1]);
                    }
                        var initAmount = parseFloat(price.replace(/,/gi,"")) * parseInt(quantity.replace(/,/gi,""));
                        subtotal += initAmount;
                        $('#purchasetbody').append('<tr style="font-size:1.2rem"><td hidden>'+id+'</td><td class="text-left">'+product+'</td><td>'+price+'</td><td>'+quantity+' '+unit+'</td><td>'+initAmount.toFixed(2)+'</td><td hidden>'+onhand[0]+'</td><td><button class="btn btn-md bg-danger cancelOrderBtn"><i class="fas fa-times"></i></button></td></tr>');
                }
            }
    	}
    	$("#subTotal").val((subtotal).toFixed(2));
    	var discountRate = parseInt($('#discountRate').val());
    	var discountcost = parseInt(subtotal * discountRate / 100);// 100 IS PERCENTAGE
    	$('#discountCost').val((discountcost).toFixed(2));
    	var totalAmount = (subtotal - discountcost).toFixed(2);
    	$('#totalAmount').val(totalAmount);
    	var cash = parseInt($("#Cash").val());
    	$("#Change").val((cash - totalAmount).toFixed(2));

    	subtotal = 0;//RESET THE VALUE
    });

    $('.purchQty').on('keyup', function(){
    	var tr = $(this).closest('tr');
    	var data = tr.children('td').map(function() {
    		return $(this).text();
    	}).get();
    	var onhandArray = data[7].split(" ");
    	if (parseInt($(this).val()) > parseInt(onhandArray[0])) {
    			$(this).val(onhandArray[0]);    	

    	}
    });

    $('#purchasetbody').on('click','.cancelOrderBtn', function(){
    	var $tr = $(this).closest('tr');

    	var data = $tr.children('td').map(function(){
    		return $(this).text();
    	}).get();

    	var id = data[0];
    	tableData[id] = {};//CLEAR SPECIFIC ARRAY ELEMENT

    	var subtotal = parseFloat($('#subTotal').val());
    	var amount = parseFloat(data[4]);//amount of an item
    	var initamount = (subtotal - amount).toFixed(2);//NEW SUBTOTAL
    	$('#subTotal').val(initamount);//SUBTOTAL

    	var discountRate = parseInt($('#discountRate').val());
    	var discountcost = parseInt(initamount * discountRate / 100);// 100 IS PERCENTAGE
    	var totalAmount = (initamount - discountcost).toFixed(2);
    	$('#totalAmount').val(totalAmount);
    	$('#discountCost').val((discountcost).toFixed(2));
    	var cash = parseInt($("#Cash").val());
    	$("#Change").val((cash - totalAmount).toFixed(2));
    	$tr.remove();//REMOVE ORDER FROM "customer invoice"

    	$('#itemsproducttbody tr').each(function(){
    		var check = $(this).find('td:eq(9) input').prop("checked");
    		var prodID = $(this).find('td:eq(1)').text();
    		var prod = $(this).find('td:eq(2)').text();

    		if (id == prodID) {
    			//console.log(check);
                $(this).find('td:eq(8) input').val('0');
    			$(this).find('td:eq(8) input').attr('readonly', true);
    			$(this).find('td:eq(9) input').prop('checked', false);
    		}
    	});
    	
    });

    $('#discountRate').on('keyup change', function(){
        if ($(this).val() != "") {
            var subtotal = parseFloat($('#subTotal').val());
            var discountRate = parseInt($(this).val());
            var discountcost = parseInt(subtotal * discountRate / 100);// 100 IS PERCENTAGE
            var totalAmount = (subtotal - discountcost).toFixed(2);
            $('#totalAmount').val(totalAmount);
            $('#discountCost').val((discountcost).toFixed(2));
            var cash = parseInt($("#Cash").val());
            $("#Change").val((cash - totalAmount).toFixed(2));
        }else{
            $('#totalAmount').val($('#subTotal').val());
            $('#discountCost').val("0");
            var cash = parseInt($("#Cash").val());
            $("#Change").val((cash - parseFloat($('#subTotal').val())).toFixed(2));
        }
 		// $("#Cash").attr("min",totalAmount);
    });


    $('#Cash').on('keyup change', function(){
        var cash = parseFloat($(this).val());
        if (!isNaN(cash)) {
            var totalAmount = parseFloat($('#totalAmount').val());
            var change = (cash - totalAmount).toFixed(2);
            $('#Change').val(change);
        }
        
    });

    $('#salesPage').click(function(e){
    	e.preventDefault();
    	var emptyCount = 0;
    	for(d in tableData){
    		// console.log(tableData[d]);
    		if (tableData[d].id != undefined) {
    			emptyCount += 1;
    		}
    	}
    	// if (emptyCount == 0) {
    		window.location.href = "index2.php?page=sales";
    	// }else{
    	// 	$('#confirmationModal').modal('show');
    	// }
    });



    $('#submitInvoice').on('click', function(){

    	if ($('#subTotal').val() == "0" || $('#subTotal').val() == "0.00") {
    		Swal.fire({
    		        icon:'error',
    		        title: "Please Select Item/Product First!",
    		        showConfirmButton: 'true',
    		        timer: 2500
    		})
    	}else if ($('#Cash').val() == "0" || $('#Cash').val() == "") {
    		Swal.fire({
    		        icon:'error',
    		        title: "No Cash Input!",
    		        showConfirmButton: 'true',
    		        timer: 2500
    		})
    	}else if (parseFloat($('#Cash').val()) < parseFloat($('#totalAmount').val())  ) {
    		Swal.fire({
    		        icon:'error',
    		        title: "Insufficient Cash!",
    		        showConfirmButton: 'true',
    		        timer: 2500
    		})
    	}else{
            //for save only
                $('#cashMsg').addClass("d-none");
                var ACCOUNT_ID = $('#ACCOUNT_ID').text();
                var data = [];
                $('#purchasetbody tr').each(function(){

                var obj = {};
                obj.id = $(this).find('td:eq(0)').text();
                obj.qty = $(this).find('td:eq(3)').text();
                obj.amount = $(this).find('td:eq(4)').text().replace(/,/gi,"");
                obj.onhand = $(this).find('td:eq(5)').text();
                obj.ttlamount = $('#totalAmount').val().replace(/,/gi,"");
                obj.discountrate = $('#discountRate').val();
                obj.discountcost = $('#discountCost').val();
                obj.cash = $('#Cash').val();
                obj.change = $('#Change').val();

                data.push(obj);
                }); //console.log(data);

                $.ajax({
                    method: 'post',
                    url: 'store_cashier/action2.php',
                    data: {data: JSON.stringify(data), accountid: ACCOUNT_ID},
                    success: function(res){
                        if (res.status == "success") {
                            window.location.href = "store_cashier/print_invoice.php";
                            // Swal.fire({
                            //         icon:'success',
                            //         title: "Customer Invoice Save Succefully",
                            //         showConfirmButton: 'true',
                            //         timer: 2500
                            // })

                            // setTimeout(function(){
                            //         window.location.href = "store_cashier/print_invoice.php";
                            // },2000);
                        }else{
                            Swal.fire({
                                    icon:'error',
                                    title: "Failed To Save Customer Invoice",
                                    showConfirmButton: 'true',
                                    timer: 2500
                            })
                        }
                        
                    },
                    error: function(err){
                        alert(err.responseText);
                    }
                });
            }
    });

    var datefrom = $('#dateFrom').val();
    var dateto = $('#dateTo').val();
    var href = 'store_cashier/espadera_sales_report.php?df='+datefrom+'&dt='+dateto;
    $('#printStoreSales').attr('href',href);

    $('#dateFrom').on('change', function(){
    	var datefrom = $(this).val();
    	var dateto = $('#dateTo').val();
      var href = 'store_cashier/espadera_sales_report.php?df='+datefrom+'&dt='+dateto;
      $('#printStoreSales').attr('href',href);

    	$('#salesTbody').load('store_cashier/load-salesfromto.php',{
    		datefrom: datefrom,
    		dateto: dateto
    	},
    	function(restxt, statstxt, jqXHR){
    		//console.log(restxt);
    	});
    	 
    	 $.ajax({
    	 	method: 'post',
    	 	url: 'store_cashier/load-totalsales.php',
    	 	data: {datefrom:datefrom,dateto:dateto},
    	 	success: function(res){
    	 		$('#totalSales').text(res.totalsales);
    	 		$('#totalIncome').text(res.totalincome);
                  $('#totalDiscount').text(res.totaldiscount);
                  $('#initialIncome').text(res.initincome);
    	 	}
    	 });
    	
    });

    $('#dateTo').on('change', function(){
    	var datefrom = $('#dateFrom').val();
    	var dateto = $(this).val();
      var href = 'store_cashier/espadera_sales_report.php?df='+datefrom+'&dt='+dateto;
      $('#printStoreSales').attr('href',href);

    	$('#salesTbody').load('store_cashier/load-salesfromto.php',{
    		datefrom: datefrom,
    		dateto: dateto
    	},function(restxt, statstxt, jqXHR){
    	 if (restxt == 'success') {
    	   console.log('New Content Load');
    	 }
    	 if (restxt == 'error') {
    	    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
    	 }

    	});
    	$.ajax({
        method: 'post',
        url: 'store_cashier/load-totalsales.php',
        data: {datefrom:datefrom,dateto:dateto},
        success: function(res){
          $('#totalSales').text(res.totalsales);
          $('#totalIncome').text(res.totalincome);
          $('#totalDiscount').text(res.totaldiscount);
          $('#initialIncome').text(res.initincome);
        }
       });
    });

    // ADDED PRODUCT WITH DATE FROM AND TO
    var datefrom2 = $('#dateFrom2').val();
    var dateto2 = $('#dateTo2').val();
    var href = 'store_cashier/print_added_products.php?df='+datefrom2+'&dt='+dateto2;
    $('#printAddedProducts').attr('href',href);

    $('#dateFrom2').on('change', function(){
      var datefrom2 = $(this).val();
      var dateto2 = $('#dateTo2').val();
      var href = 'store_cashier/print_added_products.php?df='+datefrom2+'&dt='+dateto2;
      $('#printAddedProducts').attr('href',href);

      $('#addedProductsTBody').load('store_cashier/load_productsfromto.php',{
        datefrom2: datefrom2,
        dateto2: dateto2
      },
      function(restxt, statstxt, jqXHR){
        // console.log(restxt);
      });  
    });

    $('#dateTo2').on('change', function(){
      var datefrom2 = $('#dateFrom2').val();
      var dateto2 = $(this).val();
      var href = 'store_cashier/print_added_products.php?df='+datefrom2+'&dt='+dateto2;
      $('#printAddedProducts').attr('href',href);

      $('#addedProductsTBody').load('store_cashier/load_productsfromto.php',{
        datefrom2: datefrom2,
        dateto2: dateto2
      },function(restxt, statstxt, jqXHR){
        // console.log(restxt);
      });
    });
// =============================================================
// THIS IS FOR INVENTORY PAGE ==================================
// =============================================================
    $('#prodCTG').on('change', function(){
        $('#origUnit').val("");
        $('#initQty').val("");
        $('#initPrice').val("");
        $('#incRate').val("");
        $('#onHand').val("");
        $('#ratePeso').val("");
        $('#pricePeso').val("");
    });

	$('#initQty').on('keyup', function(){
		var onHand = $('#onHand');
		var initQty = $(this).val();
		var origUnit = $('#origUnit').val();
		var initPrice = $('#initPrice').val();
		var incRate = $('#incRate').val();

		if (checkIfWholeNumber($(this), $('#initQtyRes')) != false) {
			var init_price = initPrice / initQty;
			if (origUnit != "" && initQty != "") {
				onHand.val(initQty+" "+unitPlural(sgl_Unit, plr_Unit, origUnit));

				if (initQty == 1 ) {
					onHand.val(initQty+" "+origUnit);
				}

				var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
				var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);
			
				if (incRate != "") {
					$('#ratePeso').val((rate_peso).toFixed(2));
					$('#pricePeso').val((price_peso).toFixed(2));

				}else{
					$('#ratePeso').val("");
					$('#pricePeso').val("");
				}
			}else{
				onHand.val("");
			}
		}
	});

	$('#origUnit').on('change', function(){
		var unit = $(this).val();
		$('#initPricelb').html('Init. Price per '+unit+' (<span>&#8369;</span>)');
		$('#costratelb').html('Cost Rate per '+unit+' (<span>&#8369;</span>)');
		$('#pricelb').html('Price per '+unit+' (<span>&#8369;</span>)');

		if ($('#initQty').val() != "" && $(this).val() != "") {
			$('#onHand').val($('#initQty').val()+" "+unitPlural(sgl_Unit, plr_Unit, unit));

			if ($('#initQty').val() == 1) {
				$('#onHand').val($('#initQty').val()+" "+unit);
			} 
		}else{
			$('#onHand').val("");
		}
	});

	$('#initPrice').on('keyup', function(){
		var initQty = $('#initQty').val();
		var origUnit = $('#origUnit').val();
		var initPrice = $(this).val();
		var incRate = $('#incRate').val();

		if (initQty == "") {
			$(this).val("");
			$('#initQty').addClass("border border-danger");
			$('#initQty').attr('placeholder', 'Please fill!	');
			$('#initQtyRes').html("<i> Please fill this field!</i>");
			setTimeout(function(){
				$('#initQty').removeClass("border border-danger");
				$('#initQtyRes').text("");
			},3000);
		}else{
			var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
			var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

			if (checkIfNumber($(this), $('#initPriceRes')) != false ) {
				if (initPrice != "") {
					if (incRate == "") {
						$('#ratePeso').val("");
						$('#pricePeso').val("");
					}else{
						$('#ratePeso').val((rate_peso).toFixed(2));
						$('#pricePeso').val((price_peso).toFixed(2));
					}
				}else{
					$('#ratePeso').val("");
					$('#pricePeso').val("");
				}
				
			}else{
				$('#ratePeso').val("");
				$('#pricePeso').val("");
			}

		}
		
	});

	$('#incRate').on('keyup', function(){
		var incRate = $(this).val();
		var initPrice = $('#initPrice').val();
		var initQty = $('#initQty').val();
		var origUnit = $('#origUnit').val();

		if (initQty == "") {
			$(this).val("");
			$('#initQty').addClass("border border-danger");
			$('#initQty').attr('placeholder', 'Please fill!	');
			$('#initQtyRes').html("<i> Please fill this field!</i>");
			setTimeout(function(){
				$('#initQty').removeClass("border border-danger");
				$('#initQtyRes').text("");
			},3000);
		}else {
			if (initPrice == "") {
				$(this).val("");
				$('#initPrice').addClass("border border-danger");
				$('#initPrice').attr('placeholder', 'Please fill!	');
				$('#initPriceRes').html("<i> Please fill this field!</i>");
				setTimeout(function(){
					$('#initPrice').removeClass("border border-danger");
					$('#initPriceRes').text("");
				},3000);
			}else{
				if (origUnit == "") {
					$(this).val("");
					$('#origUnit').addClass("border border-danger");
					$('#origUnit').attr('placeholder', 'Please fill!');
					setTimeout(function(){
						$('#origUnit').removeClass("border border-danger");
						$('#origUnitRes').text("");
					},3000);
				}else{
					var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
					var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

					if (incRate != "") {
						if(checkIfNumber($(this), $('#incRateRes')) != false) {
							// ttlQty.val(initQty);
							$('#ratePeso').val((rate_peso).toFixed(2));
							$('#pricePeso').val((price_peso).toFixed(2));
							// $('#ratePeso2').val((rate_peso).toFixed(2));
							// $('#pricePeso2').val((price_peso).toFixed(2));
							// initPrice.,'#initPrice2'val(initprice);
						}else{
							// ttlQty.val("");
							$('#ratePeso').val("");
							$('#pricePeso').val("");
							// $('#ratePeso2').val("");
							// $('#pricePeso2').val("");
							// initPrice.val("");
						}
					}else{
						$('#ratePeso').val("");
						$('#pricePeso').val("");
						// $('#ratePeso2').val("");
						// $('#pricePeso2').val("");
					}
				}
				
			}
		}
			
	});

	$('#inventoryTBL tbody').on('click','.addProductQty', function(e){
		e.preventDefault();
		$('#addProductQtyModal').modal('show');

		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
		var onhand = data[9].split(" ");
		var id = data[0];
		var product = data[1];
		var ctg = data[2];
		var desc = data[3];
		var onhandP = data[9];
		var stat = $.trim(data[10]); 
		var price = data[8];
		$('input[name = "prodID"]').val(id);
		$('#pname').text(product);
		$('#ctgname').text(ctg);
		$('#pdesc').text(desc);
		$('#ponhand').text(onhandP);
		$('#pprice').text(price);
		if (stat == "FULL") {
			$('#pstat').html(`<span class="bg-success p-2" >FULL</span>`);
		}
		if (stat == "LOW") {
			$('#pstat').html(`<span class="bg-warning p-2" >LOW</span>`);
		}
		if (stat == "CRITICAL") {
			$('#pstat').html(`<span class="bg-danger p-2" >CRITICAL</span>`);
		}
    if (stat == "NORMAL") {
      $('#pstat').html(`<span class="bg-olive p-2" >NORMAL</span>`);
    }
    if (stat == "OUT OF STOCK") {
      $('#pstat').html(`<span class="bg-gray-dark p-2" >OUT OF STOCK</span>`);
    }
		$('#ttlQTYRes').text(onhandP);
		$('#ttlQTYRes2').text(onhandP);
		$('input[name = "onhandProd"]').val(onhand[0]);
		$('input[name = "unitProd"]').val(onhand[1]);
		$('input[name = "ctgProd"]').val(ctg);
    $('#addedQtyUnit').text(onhand[1]);
		$('input[name = "descProd"]').val(desc);
		$('input[name = "priceProd"]').val(price);
		//console.log(data);

	});

  $('#inventoryTBL tbody').on('click','.editProductBTN', function(e){
		e.preventDefault();
		$('#editProductModal').modal('show');

		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
		var onhand = data[9].split(" ");
		var id = data[0];
		var product = data[1];
		var ctg = data[2];
		var desc = data[3];
		var ttlq = data[4].split(" ");
		var orgP = data[5];
		var ratePerc = data[6];
		var rateP = data[7];
		var price = data[8];
		var onhandP = data[9];
		var stat = data[10];
		var ctgID = data[11];
		//alert(stat);
		$('input[name = "hdProdID"]').val(id);
		$('input[name = "product2"]').val(product);
		$('input[name = "ctgProd"]').val(ctg);
		$('#prodDesc2').text(desc);
		$('input[name = "qty2"]').val(ttlq[0]);
		$('input[name = "price2"]').val(orgP);
		$('input[name = "qtyOnhand2"]').val(onhandP);
		$('input[name = "incrate2"]').val(ratePerc);
		$('input[name = "pesoRate2"]').val(rateP);
		$('input[name = "pesoPrice2"]').val(price);
		$('input[name = "hdStat3"]').val(stat);

		$('#initPricelb2').html('Init. Price per '+unitSingular(sgl_Unit, plr_Unit, onhand[1])+' (<span>&#8369;</span>)');
		$('#costratelb2').html('Cost Rate per '+unitSingular(sgl_Unit, plr_Unit, onhand[1])+' (<span>&#8369;</span>)');
		$('#pricelb2').html('Price per '+unitSingular(sgl_Unit, plr_Unit, onhand[1])+' (<span>&#8369;</span>)');

		$('#loadcategories').load('store_cashier/load-categories.php', {
		   ctg : ctg
		}, function(restxt, statstxt, jqXHR){
		 if (restxt == 'success') {
		   console.log('New Content Load');
		 }
		 if (restxt == 'error') {
		    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		 }
		});

		//$('#origUnit2').val(unitSingular(sgl_Unit, plr_Unit, onhand[1]));
		$('#origUnit2').load('store_cashier/load-units.php', {
		   unit : onhand[1]
		}, function(restxt, statstxt, jqXHR){
		 if (restxt == 'success') {
		   console.log('New Content Load');
		 }
		 if (restxt == 'error') {
		    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		 }
		});
	});

	$('#addedQty').on('keyup', function(){
		var onhand = $('input[name = "onhandProd"]').val();
		var unit = $('input[name = "unitProd"]').val();
		var addQty = $(this).val();
		var newqty = parseInt(onhand) + parseInt(addQty);
		if (addQty != "") {
			if (checkIfWholeNumber($(this), $('#addedQtyRes')) != false) {
				$('#ttlQTYRes').text(newqty+" "+unit );
				if (true) {}
				$('input[name = "totalProdQty"]').val(newqty);
			}
		}else{
			$('#ttlQTYRes').text(onhand+" "+unit );
			$('input[name = "totalProdQty"]').val(newqty);
		}
	});


	$('#initQty2').on('keyup', function(){
		var onHand = $('#onHand2');
		var initQty = $(this).val();
		var origUnit = $('#origUnit2').val();
		var initPrice = $('#initPrice2').val();
		var incRate = $('#incRate2').val();

		if (checkIfWholeNumber($(this), $('#initQtyRes2')) != false) {

			if (origUnit != "" && initQty != "") {
				onHand.val(initQty+" "+unitPlural(sgl_Unit, plr_Unit, origUnit));
				if (initQty == 1 ) {
					onHand.val(initQty+" "+origUnit);
				}
				// $('#lbPrice2').text("Price per "+units[unit]+" (Peso)");

				var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
				var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);
			
				if (incRate != "") {
					$('#ratePeso2').val((rate_peso).toFixed(2));
					$('#pricePeso2').val((price_peso).toFixed(2));

				}else{
					$('#ratePeso2').val("");
					$('#pricePeso2').val("");
				}
			}else{
				onHand.val("");
				// $('#lbPrice2').text('Price (Peso)');
			}
		}
	});

	$('#origUnit2').on('change', function(){
		
		var unit = $(this).val();

		$('#initPricelb2').html('Init. Price per '+unit+' (<span>&#8369;</span>)');
		$('#costratelb2').html('Cost Rate per '+unit+' (<span>&#8369;</span>)');
		$('#pricelb2').html('Price per '+unit+' (<span>&#8369;</span>)');

		if ($('#initQty2').val() != "" && $(this).val() != "") {
			$('#onHand2').val($('#initQty2').val()+" "+unitPlural(sgl_Unit, plr_Unit, unit));
			// $('#lbPrice').text("Price per "+units[unit]+" (Peso)");2
			if ($('#initQty2').val() == 1) {
				$('#onHand2').val($('#initQty2').val()+" "+unit);
			} 
		}else{
			$('#onHand2').val("");
		}
	});

	$('#initPrice2').on('keyup', function(){
		var initQty = $('#initQty2').val();
		var origUnit = $('#origUnit2').val();
		var initPrice = $(this).val();
		var incRate = $('#incRate2').val();

		if (initQty == "") {
			$(this).val("");
			$('#initQty2').addClass("border border-danger");
			$('#initQty2').attr('placeholder', 'Please fill!	');
			$('#initQtyRes2').html("<i> Please fill this field!</i>");
			setTimeout(function(){
				$('#initQty2').removeClass("border border-danger");
				$('#initQtyRes2').text("");
			},3000);
		}else{
			var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
			var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

			if (checkIfNumber($(this), $('#initPriceRes2')) != false ) {
				if (initPrice != "") {
					if (incRate == "") {
						$('#ratePeso2').val("");
						$('#pricePeso2').val("");
					}else{
						$('#ratePeso2').val((rate_peso).toFixed(2));
						$('#pricePeso2').val((price_peso).toFixed(2));
					}
				}else{
					$('#ratePeso2').val("");
					$('#pricePeso2').val("");
				}
				
			}else{
				$('#ratePeso2').val("");
				$('#pricePeso2').val("");
			}

		}
		
	});

	$('#incRate2').on('keyup', function(){
		var incRate = $(this).val();
		var initPrice = $('#initPrice2').val();
		var initQty = $('#initQty2').val();
		var origUnit = $('#origUnit2').val();

		if (initQty == "") {
			$(this).val("");
			$('#initQty2').addClass("border border-danger");
			$('#initQty2').attr('placeholder', 'Please fill!	');
			$('#initQtyRes2').html("<i> Please fill this field!</i>");
			setTimeout(function(){
				$('#initQty2').removeClass("border border-danger");
				$('#initQtyRes2').text("");
			},3000);
		}else {
			if (initPrice == "") {
				$(this).val("");
				$('#initPrice2').addClass("border border-danger");
				$('#initPrice2').attr('placeholder', 'Please fill!	');
				$('#initPriceRes2').html("<i> Please fill this field!</i>");
				setTimeout(function(){
					$('#initPrice2').removeClass("border border-danger");
					$('#initPriceRes2').text("");
				},3000);
			}else{
				if (origUnit == "") {
					$(this).val("");
					$('#origUnit2').addClass("border border-danger");
					$('#origUnit2').attr('placeholder', 'Please fill!');
					setTimeout(function(){
						$('#origUnit2').removeClass("border border-danger");
						$('#origUnitRes2').text("");
					},3000);
				}else{
					var rate_peso = initPrice * incRate / 100;//100 is equevalent to 100%
					var price_peso = parseFloat(initPrice) + parseFloat(rate_peso);

					if (incRate != "") {
						if(checkIfNumber($(this), $('#incRateRes2')) != false) {
							// ttlQty.val(initQty);
							$('#ratePeso2').val((rate_peso).toFixed(2));
							$('#pricePeso2').val((price_peso).toFixed(2));
						}else{
							$('#ratePeso2').val("");
							$('#pricePeso2').val("");
						}
					}else{
						$('#ratePeso2').val("");
						$('#pricePeso2').val("");
					}
				}
				
			}
		}
			
	});

	//SHOW SALES FROM DATE RANGE
	$('#dateFrom').on('change', function(){
		var datefrom = $(this).val();
		var dateto = $('#dateTo').val();

	});

	$('form').on('click','#updatecashierinfo', function(e){
		e.preventDefault();
		console.log($('form').serialize());
		$.ajax({
			method: 'post',
			url: 'account/edit-cashierinfo.php',
			data: $('form').serialize(),
			success: function(res){
				alert(res);
			}
		});
	});

//Edit product Category
	$('#categoryTBL tbody').on('click','.editProductCategoryBtn', function(e){
		e.preventDefault();
		$('#editProductCategoryModal').modal('show');

		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
		
		var ctgid = data[1];
		var ctg = data[2];

		$('input[name = "prodcategoryID2"]').val(ctgid);
		$('input[name = "prodcategory2"]').val(ctg);
		
	});

	//Edit product Category
	$('#unitProductsTBL tbody').on('click','.editProductUnitBtn', function(e){
		e.preventDefault();
		$('#editProductUnitModal').modal('show');

		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
		
		var unitid = data[1];
		var unitplr = data[2];
		var unitsgl = data[3];

		$('input[name = "unitid"]').val(unitid);
		$('input[name = "unitplr2"]').val(unitplr);
		$('input[name = "unitsgl2"]').val(unitsgl);
	});

    // $('#printAndSave').click(()=>{
    //     window.location.href = "store_cashier/print_invoice.php";
    // })
});//end of dicument ready function