//========================================================================================
//============= INSIDE $(document).ready(funtion(){ ... }) ===============================
//========================================================================================
$(document).ready(function(){

	//RESIZE AND REDUCE IMAGE SIZE WITHOUT LOSING QUALITY
	// function process(){
	// 	const file = document.querySelector('#petimg').files[0];
	// 	// console.log(file['size']);
	// 	if (!file) return;

	// 	const reader = new FileReader();

	// 	reader.readAsDataURL(file);

	// 	reader.onload = function(event){
	// 		const imgElement = document.createElement('img');
	// 		imgElement.src = event.target.result;
	// 		// document.querySelector('#input').src = event.target.result;

	// 		imgElement.onload = function(e){
	// 			const canvas = document.createElement('canvas');
	// 			const MAX_WIDTH = 150;

	// 			const scaleSize = MAX_WIDTH / e.target.width;
	// 			canvas.width = MAX_WIDTH;
	// 			canvas.height = e.target.height * scaleSize;

	// 			const ctx = canvas.getContext("2d");
	// 			ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);
	// 			console.log(e.target);
	// 			const srcEncoded = ctx.canvas.toDataURL(e.target,"image/jpeg");
	// 			//console.log(srcEncoded);
	// 			document.querySelector('#uploaded_image').src = srcEncoded;
	// 		}
	// 	}
	// }

	//PREVIEW IMAGE UPON MODAL POPUP
	function previewImage(image, modal, event){
		var reader = new FileReader();
		var files = event.target.files;

		var done = function(url){
			//IMAGE SOURSE FROM LOCAL FILES
			image.attr('src',url);
			modal.modal('show');
		}

		//CHECK IF THERES A SELECTED IMAGE
		if (files && files.length > 0) {
			reader.onload = function(e){
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	}

	//DISPLAY CROPPED IMAGE
	function displayCroppedImage(cropper, modal, PETID, PETPHOTO){
		var canvas = cropper.getCroppedCanvas({
			//IMAGE NEW SIZE
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
					url: 'owners/save-petphoto.php',
					data: {image:base64image, petid:PETID, petphoto:PETPHOTO},
					success: function(res){
						modal.modal('hide');
						setTimeout(function(){
							location.reload(true);
						},2000);
						if (res.status == "success") {
							Swal.fire({
						        icon:'success',
						        title: "Pet Photo Changed Successfully",
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
						
					}
				});
				
			}
		});
	}

	//VALIDATE INPUT IF WHOLE NUMBER
	// function checkIfWholeNumber(inputID, resMsgID){
	// 	var input = inputID.val();
	// 	var dataArr = input.split("");
	// 	var fee = "";
	// 	for (var i = 0; i < input.length; i++) {
	// 		var data = dataArr[input.length - (input.length - i)];
			
	// 		if (!isNaN(data) && data != " " && dataArr[0] != "0") {
	// 			fee += data;
				
	// 			if (resMsgID != ""){
	// 				resMsgID.text("");
	// 			}
				
	// 			inputID.val(fee);
	// 		}else{
	// 			if (resMsgID != ""){
	// 				resMsgID.text('Invalid input "'+data+'"').fadeTo(2000,500).slideUp(500);
	// 			}
				
	// 			inputID.val("");
	// 			inputID.val(fee);
	// 			return false;
	// 		}
	// 	}
	// }
	
	//TABLES THAT USED DATATABLES LIBRARY
	$('#speciesTbl, #confinementsTBL, #serviceTypesTbl, #offeredServicesTBL').DataTable({});
	$('#userTypeTbl,#categoryTBL2,#addProductHistoryTBL2,#clientsTBL').DataTable({});
	$('#vaccinationTBL, #dewormingTBL, #groomingTBL, #petTestsTable,#clientPaymentsTbl, #petTestsTable2, #petClinicalSignsTable, #petInitDiagnosisTable, #petTreatmentsTable, #consultationTBL,#surgeryTBL').DataTable({ordering:false});
	$('#addConfinementTBL').DataTable({
		searching: false,
		paging: false,
		info: false,
		ordering: false
	});
	$('#scheduleTBL').DataTable({
		paging: false,
		ordering: false,
		info: false
	});
	$('#clinicalSignsTBL, #initDiagTBL, #finalDiagTBL').DataTable({
		searching: false,
		info: false,ordering: false
	});


	$('#searchClinSign').on('keyup', function(){
		 $('#clinicalSignsTbody').load('administrator/sigs_or_diag_search.php', {
		   sdFor:'CLIN_SIGN',
			inputvalue:$(this).val()
		}, function(restxt, statstxt, jqXHR){
		   // alert(restxt);
		});
	});
	$('#searchInitDiag').on('keyup', function(){
		 $('#initDiagTbody').load('administrator/sigs_or_diag_search.php', {
		   sdFor:'INIT_DIAG',
			inputvalue:$(this).val()
		}, function(restxt, statstxt, jqXHR){
		   // alert(restxt);
		});
	});
	$('#searchFinalDiag').on('keyup', function(){
		 $('#finalDiagTbody').load('administrator/sigs_or_diag_search.php', {
		   sdFor:'FINAL_DIAG',
			inputvalue:$(this).val()
		}, function(restxt, statstxt, jqXHR){
		   // alert(restxt);
		});
	});

	//SHOW ADD MODAL OF SIGNS AND DIAGNOSIS
	$('#clinaddbtn, #initaddbtn, #finaladdbtn').on('click', function() {
		var header = "ADD NEW INITIAL DIAGNOSIS";//Default value
		var label = "Diagnosis";//Default value
		var sdfor = "INIT_DIAG";//Default value
		if ($(this).hasClass('addclin')) {
			sdfor = "CLIN_SIGN";
			header = "ADD NEW CLINICAL SIGN";
			label = "Sign";
		}
		if ($(this).hasClass('addfinal')) {
			header = "ADD NEW FINAL DIAGNOSIS";
			sdfor = "FINAL_DIAG";
		}
		$('input[name="addsdfor"]').val(sdfor);
		$('#addSignsDiagHeader').text(header);
		$('#addSignsDiagLabel').text(label);
		$('#addSignsAndDiagnosisModal').modal('show');
	});

	//SHOW EDIT MODAL OF SIGNS AND DIAGNOSIS AND SETTING DATA TO BE EDITED
	$('#clinicalSignsTbody, #initDiagTbody, #finalDiagTbody').on('click','button', function(){
		var tr = $(this).closest('tr');
		var sdid = tr.find('td:eq(1)').text();
		var sign = tr.find('td:eq(2)').text();
		var header = "EDIT INITIAL DIAGNOSIS";//Default value
		var label = "Diagnosis";//Default value
		if ($(this).hasClass('clinbtn')) {
			var header = "EDIT CLINICAL SIGN";
			var label = "Sign";
		}
		if ($(this).hasClass('finalbtn')) {
			var header = "EDIT INITIAL DIAGNOSIS";
		}
		
		$('#signOrDiag').val(sign);
		$('input[name="hiddenSignDiag"]').val(sign);
		$('#editSignsDiagHeader').text(header);
		$('#editSignsDiagLabel').text(label);
		$('input[name="signDiagSDID"]').val(sdid);
		$('#editSignsAndDiagnosisModal').modal('show');
	});

	//SETTING PET AGE ON INPUT DATE AT ADD PET MODAL 
	$('#petDOB').on('change', function() {
			//petAGE IS WHERE TO DISPLAY THE AGE RESULT
			setPetAge(this, $("#petAGE"),$('#DOB-msg'),"","");
	});
	
	//SETTING PET AGE ON INPUT DATE AT EDIT PET MODAL
	$('#petDOB2').on('change', function() {
			//petAGE IS WHERE TO DISPLAY THE AGE RESULT
			setPetAge(this, $("#petAGE2"),$('#DOB-msg2'),"","");
	});

	//FOR VIEW ADMIN PASSWORD
	$('#viewAdminPass').on('click', function(){
		if($('#adminPass').attr('type') == "password"){
			$(this).removeClass('fas fa-eye-slash');
		   $(this).addClass('fas fa-eye');
		 	$('#adminPass').prop('type','text');
		}else{
			$(this).addClass('fas fa-eye-slash');
		 	$('#adminPass').prop('type','password');
		}
	});

    //FOR VIEW ADMIN PASSWORD EDIT
	$('#viewAdminPass2').on('click', function(){
		if($('#adminPass2').attr('type') == "password"){
			 $(this).removeClass('fas fa-eye-slash');
			 $(this).addClass('fas fa-eye');
		 	$('#adminPass2').prop('type','text');
		}else{
		$(this).addClass('fas fa-eye-slash');
		 $('#adminPass2').prop('type','password');
		}
	});

    //FOR VIEW USER PASSWORD UPON INSERTING
    $('#viewUserPass').on('click', function(){
       if($('#uPassID').attr('type') == "password"){
       	 $(this).removeClass('fas fa-eye-slash');
       	 $(this).addClass('fas fa-eye');
          $('#uPassID').prop('type','text');
       }else{
         $(this).addClass('fas fa-eye-slash');
          $('#uPassID').prop('type','password');
       }
    });

    //FOR VIEW USER PASSWORD UPOM EDITING
    $('#viewUserPass2').on('click', function(){
       if($('#uPassID2').attr('type') == "password"){
       	 $(this).removeClass('fas fa-eye-slash');
       	 $(this).addClass('fas fa-eye');
          $('#uPassID2').prop('type','text');
       }else{
         $(this).addClass('fas fa-eye-slash');
          $('#uPassID2').prop('type','password');
       }
    });

    //GET THE VALUE FROM USER TYPES TABLE THEN PASS IS ON INPUT FIELDS EDIT USERS TYPE MODAL
    $('.editUserTypeBtn').on('click', function(){
    	$('#editUserTypeModal').modal('show');
    	//console.log('Clicked!');
    	$tr = $(this).closest('tr');

    	var data = $tr.children('td').map(function(){
    		return $(this).text();
    	}).get();

    	//console.log(data[1]);
    	$('input[name="hiddenUserTypeID"]').val(data[1]);
    	$('input[name="hiddenUserType"]').val(data[2]);
    	$('input[name="userType"]').val(data[2]);
    });

    //GET THE VALUE FROM USER TYPE TABLE THEN PASS IS ON INPUT FIELDS DELETE USERS TYPE MODAL
    $('.delUserType').on('click', function(){
    	$('#deleteUserTypeModal').modal('show');
    	//console.log('Clicked!');
    	$tr = $(this).closest('tr');

    	var data = $tr.children('td').map(function(){
    		return $(this).text();
    	}).get();

    	var userTypeID = data[1];
    	var userType = data[2];
    	$('#userTypeData').text('"'+userType+'"');
    	$('#usrTypId').val(data[1]);

    });

    //GET THE VALUE FROM USER TABLE THEN PASS IS ON INPUT FIELDS EDIT USERS INFO MODAL
    $('.editUserBtn').on('click', function() {
    	$('#editUserModal').modal('show');
    	//console.log('Clicked!');
    	$tr = $(this).closest('tr');

    	var data = $tr.children('td').map(function(){
    		return $(this).text();
    	}).get();

    	var acctTypeID = data[2];
    	//console.log(breed);
    	$('input[name="acctidH"]').val(data[1]);
    	$('input[name="accttypeIdH"]').val(data[2]);
    	$('input[name="fnameH"]').val(data[3]);
    	$('input[name="fnameD"]').val(data[3]);
    	$('input[name="lnameH"]').val(data[4]);
    	$('input[name="lnameD"]').val(data[4]);
    	$('input[name="contactH"]').val(data[5]);
    	$('input[name="contactD"]').val(data[5]);
    	// if (data[7] == data[3]+""+data[4] || data[8] == data[3]+""+data[4]) {
    	// 	$('#edituserusername').removeClass('d-none');
    	// 	$('#edituserpassword').removeClass('d-none');
    	// 	$('input[name="usernH"], #checkUsername2,#dpassword2').val(data[7]);
    	// }else{
    	// 	$('#edituserusername').addClass('d-none');
    	// 	$('#edituserpassword').addClass('d-none');
    	// 	$('input[name="usernH"], #checkUsername2,#dpassword2').val("");
    	// }
    	
    	$('#userTypeID').load('administrator/load-usertype.php', {
    	   acctTypeID : acctTypeID
    	}, function(restxt, statstxt, jqXHR){
    	   // console.log(statstxt);
	    });
    });
    //SETTING DEFAULT USERNAME AND PASSWORD FOR THE USER
    $('#ffname,#llname').keyup(function(){
    	$('#dpassword, #checkUsername').val($('#ffname').val()+""+$('#llname').val());
    });
    $('#ffname2,#llname2').keyup(function(){
    	$('#dpassword2, #checkUsername2').val($('#ffname2').val()+""+$('#llname2').val());
    });

    //CHECKING FOR USERNAME VALIDITY
    // $('#checkUsername').keyup(function(e){
    // 	e.preventDefault();
    // 	$('#usernameCheck').removeClass('text-danger');
    // 	$('#usernameCheck').removeClass('text-success');
    // 	var usernameLength = $('#checkUsername').val().trim().length;
    // 	if (usernameLength < 8) {
    // 		$('#usernameCheck').addClass("text-danger");
    // 		$('#usernameCheck').text("Must consist of 8 characters ("+(8 - parseInt(usernameLength))+" left)");
    // 		// $('#inputPassword').attr("disabled", true);
    // 	}else{
    // 		$.ajax({
    // 			method:'post',
    // 			url:'administrator/checkUsername.php',
    // 			data:{username:$(this).val()},
    // 			success: function(res){
    // 				if (res.status == "existing") {
    // 					$('#usernameCheck').addClass("text-danger");
    // 					$('#usernameCheck').text("Existing! Please use different username!");
    // 				}else{
    // 					$('#usernameCheck').addClass("text-success");
    // 					$('#usernameCheck').text("Valid username");
    // 					// $('#inputPassword').prop("disabled", false);
    // 				}
    // 			},
    // 			error: function(err){
    // 				console.log(err.responseText);
    // 			}
    // 		});
    // 	}
    // });
    //
    
    //THIS FOR PAYMENT PURPOSES FOR VIEWING LIST OF SERVICES
    $('#filter').on('change', function(){
		// alert($(this).val());
		$('#PET_SERVICES').load("administrator/load_services.php",{
			srvtypeid:$(this).val()
		}, function(restxt, statstxt, jqXHR){
		  // alert(restxt);
	   });
	});

    //SETTING UP INVOICE FOR CLIENT
    var initFee = 0;
    $('#PET_SERVICES').on('change',function() {
    	var service = $(this).val().split("_");
    	var fee = $('option:selected', this).attr('class').split("_");
    	$('#createdPaymentTBody').append('<tr><td hidden>'+service[0]+'</td><td hidden>'+service[1]+'</td><td>'+service[2]+'</td><td>&#8369; '+ fee[0]+'</td><td class="text-center"><button class="btn btn-sm bg-danger  cancelServicebtn"><i class="fas fa-times"></i></button></td></tr>');
      initFee = initFee + parseFloat(fee[0].replace(/,/gi,""));

    	var discrate = parseInt($('#discRate').val()) * initFee / 100;
    	$('#totalpayment').text(initFee.toFixed(2));
    	
    	if ($('#discRate').val() != "") {
    		$('#discCost').text(parseFloat(discrate).toFixed(2));
    		$('#totalAmount').text(parseFloat((initFee-discrate)).toFixed(2));
    	}else{
    		$('#discCost').text("0.00");
    		$('#totalAmount').text(parseFloat(initFee).toFixed(2));
    	}
    	$(this).val("");
    });

    //CANCEL SERVICES TO BE PAYED
    $('#createdPaymentTBody').on('click','.cancelServicebtn', function(e){
    	e.preventDefault();
    	var tr = $(this).closest('tr');
    	var fee = tr.find('td:eq(3)').text().split(" ");
    	initFee = initFee - parseFloat(fee[1].replace(/,/gi,""));
    	var discrate = parseInt($('#discRate').val()) * initFee / 100;
    	$('#totalpayment').text(parseFloat(initFee).toFixed(2));
    	if ($('#discRate').val() != "") {
    		$('#discCost').text(discrate.toFixed(2));
    		$('#totalAmount').text((initFee-discrate).toFixed(2));
    	}else{
    		$('#discCost').text("0.00");
    		$('#totalAmount').text(initFee.toFixed(2));
    	}
    	tr.remove();
    });

    //SETTING DISCOUNT RATE
    $('#discRate').on('keyup change', function(){
 		initFee = parseInt($('#totalpayment').text());
 		var discrate = parseInt($('#discRate').val()) * initFee / 100;
 		if ($(this).val() == "" || $(this).val() == 0) {
 				$('#discCost').text("0.00");
 			 	$('#totalAmount').text(initFee.toFixed(2));
 		}else{
 			$('#discCost').text(discrate.toFixed(2));
 			$('#totalAmount').text((initFee-discrate).toFixed(2));
 		}
    });

    //SAVE CREATED CLIENT INVOICE
    var acuiredservices = [];
    $('#serviceAquired').on('click', function(e){
    e.preventDefault();
    var petage = setAge($('#RPETBDATE2').val());
    var accntid = $('#MY_ID').val(); 
    var petid = $('#hpetid').val();
    var discrate = $('#discRate').val();
    var disccost = $('#discCost').text();
    var invNo = $('#invoiceno').text();
    var ttlamount = $('#totalAmount').text();
    if (ttlamount != 0) {
    	$('#createdPaymentTBody tr').each(function(){
    		
    		var obj = {};
    		var curRow = $(this);

    		obj.sid = curRow.find('td:eq(0)').text();
    		obj.id = curRow.find('td:eq(1)').text();
    		obj.service = curRow.find('td:eq(2)').text();
    		var fee = curRow.find('td:eq(3)').text().split(" ");
    		obj.fee = fee[1].replace(/,/gi,"");

    		acuiredservices.push(obj);
    	});

    	$.ajax({
    		method:'post',
    		url:'receptionist/saveNewPetRecord.php',
    		data:{
    			data:JSON.stringify(acuiredservices),
    			petage:petage,
    			accntid:accntid,
    			petid:petid,
    			invNo:invNo,
    			discrate:discrate,
    			disccost:disccost,
    			ttlamount:ttlamount
    		},
    		success: function(res){
    			$('#createdPaymentModal').modal('hide');
    			setTimeout(function(){
    				location.reload(true);
    			},2000);
    			if (res.status == "success") {

    				Swal.fire({
    			        icon:'success',
    			        title: "Payment Save Successfully",
    			        showConfirmButton: 'true',
    			        timer: 2500
    				});
    			}else{
    				Swal.fire({
    			        icon:'error',
    			        title: "Failed! Please check internet connection!",
    			        showConfirmButton: 'true',
    			        timer: 2500
    				});
    				
    			}
    		},
    		error: function(err){
    			console.log(err.responseText);
    		}
    	});
    	}
    	
    });

    //VIEW SINGLE IMAGE AT A TIME
    $('#petTestsTable,#petTestsTable2').on('click','span', function(){
    	if ($(this).hasClass('viewtestimage') || $(this).hasClass('viewtestimage2')) {
    		var tr = $(this).closest('tr');
    		$('#test_name').text(tr.find('td:eq(1)').text());
    		var testimg = tr.find("td:eq(2)").text().split(" ");
    		Swal.fire({
    			title: tr.find('td:eq(1)').text()+' Image',
    			imageUrl: 'image/labs/'+testimg[0],
    			width: 1000
    		});
    	}
    	
    });

    //UPDATING CONFINEMENT AND SURGERY STATUS
    $('#updateConfineStatus, #updateSurgeryStatus').click(function(){
    	var status = "CONFINE";
    	var url = 'administrator/update_confinement_status.php';//Default url for confinements
    	var confSurgID = $('#confineID').val();//Default value for confinement
    	var confSurgIDStatus = $('#confinementStatus').text();//Default value for confinement
    	//this is for confinements status
    	if ($(this).attr('id') == "updateConfineStatus") {
    		if ($('#confinementStatus').text() == "CONFINE") {
    			status = "DISCHARGE";
	    	}
    	}else{
    		//this is for surgery status
    		if ($('#surgeryStatus').text() == "CONFINE") {
    			status = "DISCHARGE";
	    	}
	    	//Re-enitialize the variable data
	    	url = 'administrator/update_surgery_status.php';
	    	confSurgID = $('#surgeryID').val();
	    	confSurgIDStatus = $('#surgeryStatus').text();
    	}
    	    	 Swal.fire({
    			        title: "Do you want to "+status+" the pet?",
    			        text: "You can update it later",
    			        icon: 'warning',
    			        showCancelButton: true,
    			        confirmButtonColor:'#3085d6',
    			        cancelButtonColor:'#d33',
    			        confirmButtonText:'Yes, '+status
    				}).then((result)=>{
    					if (result.isConfirmed) {

				    		$.ajax({
								method: 'post',
								url: url,
								data: {
									confid:confSurgID,
									confstatus:confSurgIDStatus
								},
								success: function(res){
									setTimeout(function(){
										window.location.href = window.location.href;
									},2000);
									if (res.status == "success") {
									Swal.fire(
								        "Pet is "+status,
								        "",
								        'success'
									)  										
									}else{
										Swal.fire(
									        "Confinement Status Failed to Change!",
									        "Please check internet connection!",
									        'error'
										)
									}
									
								},error:function(e){
									 console.log(e.responseText);
								}
							});
    						
    					}
    				})
    });

    //REMOVING OR DELETING TEST IMAGE
    $('#petTestsTable, #petTestsTable2').on('click','button', function(){
    	if ($(this).hasClass('remove_test') || $(this).hasClass('remove_test2')) {
    		var tr = $(this).closest('tr');
	    	var test = tr.find('td:eq(1)').text();
	    	var testid = tr.find('td:eq(0)').text();
	    	var image = tr.find('td:eq(2) .test_img').text();
    	
    		Swal.fire({
		        title: "Are you sure to delete "+test,
		        text: "You won't be able to revert this!",
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor:'#3085d6',
		        cancelButtonColor:'#d33',
		        confirmButtonText:'Yes, delete it!'
			}).then((result)=>{
				if (result.isConfirmed) {
						$.ajax({
							method: 'post',
							url: 'administrator/delete_test_image.php',
							data: {image:image, testid:testid},
							success: function(res){

								setTimeout(function(){
									window.location.href = window.location.href;
								},2000);
								if (res.status == "success") {
									Swal.fire(
								        "Test has been deleted!",
								        "",
								        'success'
									)
								}else{
									Swal.fire(
								        "Failed to Delete Test!",
								        "Please check internet connection!",
								        'error'
									)
								}
								
							},error:function(e){
								console.log(e.responseText);
							}
						});
					
				}
			})
    	}
    	
    });

    //ADD NEW TEST CONDUCTED
    var TEST = "";
    $('#testLists, #testLists2').change(function(){
    	var testfor = "CONFINE";
    	var conf_surg_id = $('#confineID').val();
    	if ($(this).attr('id') == "testLists2") {
    		testfor = "SURGERY";
    		conf_surg_id = $('#surgeryID').val();
    	}
    	if ($(this).val() != "") {
    		TEST = $(this).val();
    		// $('#testImg_upload').click();
    		$.ajax({
				method: 'post',
				url: 'administrator/save_test_conducted.php',
				data: {image:"", testid:"", test:TEST, confid:conf_surg_id, testfor:testfor, recimage:""},
				success: function(res){
					setTimeout(function(){
						window.location.href = window.location.href;
					},2000);
					if (res.status == "success") {
						Swal.fire(
					        "Test is added Successfully!",
					        "",
					        'success'
						)  										
					}else{
						Swal.fire(
					        "Failed to add Test!",
					        "Please check internet connection!",
					        'error'
						)
					}
					
				},error:function(e){
					console.log(e.responseText);
				}
			});
    	}
    	$(this).val("");
    });

    //GET RECENT IMAGE TO BE UPDATED
    var TEST_ID = "";
    var REC_IMAGE = "";
    $('#petTestsTable, #petTestsTable2').on('click', 'span', function(e){
    	var tr = $(this).closest('tr');
    		TEST_ID = tr.find('td:eq(0)').text();
    		TEST = tr.find('td:eq(1)').text();
    	var testimg = tr.find('td:eq(2)').text().split(" ");
    		REC_IMAGE = testimg[0];

    	if ($(this).hasClass('addTestImage')) {
    		 $('#testImg_upload').click();
    		 $('#confinementOrSurgery').val("CONFINE");
    	}
    	if ($(this).hasClass('addTestImage2')) {
    		 $('#testImg_upload2').click();
    		 $('#confinementOrSurgery').val("SURGERY");
    	}
    	if ($(this).hasClass('editTestImage')) {
    		$('#testImg_upload').click();
    		$('#confinementOrSurgery').val("CONFINE");
    	}
    	if ($(this).hasClass('editTestImage2')) {
    		$('#testImg_upload2').click();
    		$('#confinementOrSurgery').val("SURGERY");
    	}
    	
    });

    //NOTE...
    //image = AN IMG ELEMENT WHERE THE CROPPED IMAGE WILL BE DISPLAY
    //cropper = INITIALIZE FOR cropper.js VARIABLE
    // var modal3 = $('#croppedPetImageModal3');
    var testImage = document.querySelector('#test_img_sample');
    var cropper4;

    //GET AND DISPLAY SELECTED PHOTO/IMAGE
    $('#testImg_upload, #testImg_upload2').on('change', function (event){

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
    		 previewImage($('#test_img_sample'), $('#croppedTestImageModal'), event);
    	}

    });

    //SETTING AND GETTING PHOTO/IMAGE TO BE CROPPED
    $('#croppedTestImageModal').on('shown.bs.modal', function() {
    	cropper4 = new Cropper(testImage, {
    		aspectRatio: 0
    		// viewMode: 'square',
    		//preview = class of div where cropped image display as preview
    	});
    }).on('hidden.bs.modal', function (){
    	cropper4.destroy();
    	cropper4 = null;
    });

    //SAVING CROPPED PHOTO/IMAGE
    $('#crop_img-Btn4').on('click', function(){
    	var confid = $('#confineID').val();
    	var confOrSurf = "CONFINE";

    	if ($('#confinementOrSurgery').val() == "SURGERY") {
    		confid = $('#surgeryID').val();
    		confOrSurf = "SURGERY";
    	}
    	var canvas = cropper4.getCroppedCanvas({
    		width:1000,
    		height:1000
    	});
    	canvas.toBlob(function(blob){
    		url = URL.createObjectURL(blob);
    		var reader = new FileReader();
    		reader.readAsDataURL(blob);
    		reader.onloadend = function(){
    			var base64image = reader.result;
    			var recimg = "";
    			if (REC_IMAGE != "") {
    				recimg = REC_IMAGE;
    			}
    			$.ajax({
    				method: 'post',
    				url: 'administrator/save_test_conducted.php',
    				data: {
    					image:base64image, 
    					testid:TEST_ID, 
    					test:TEST, 
    					confid:confid,
    					testfor:confOrSurf,
    					recimage:recimg
    				},
    				success: function(res){
    					if (confOrSurf == "CONFINE") {
    						$('#testLists2').val("");
    					}else{
    						$('#testLists').val("");
    					}
    					$('#croppedTestImageModal').modal('hide');
    					setTimeout(function(){
    						window.location.href = window.location.href;
    					},2000);
    					if (res.status == "success") {
    						Swal.fire({
    					        icon:'success',
    					        title: "Test Image Save Successfully",
    					        showConfirmButton: 'true',
    					        timer: 2500
    						})
    					}
    					if (res.status == "failed") {
    						Swal.fire({
    					        icon:'error',
    					        title: "Failed to Save Test Image!",
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

    // EDIT ACCOUNT INFO
    $('#edit_user_btn').click(function(){
    	$('#editAccountModal').modal('show');

    	$('#account_ID').val($('#account_id').val());
    	$('#fNAME').val($('#Fname').val());
    	$('#lNAME').val($('#Lname').val());
    	$('#contaCT').val($('#Contact').val());
    	$('#uNAME').val($('#Uname').val());
    	$('#adminPass2').val($('#adminPass').val());

    	if (parseInt($('#Uname').val().trim().length) < 8) {
    		$('#usernameCheck2').addClass("text-danger");
    		$('#usernameCheck2').text("Must consist of 8 characters ("+(8 - parseInt($('#Uname').val().trim().length))+" left)");
    		$('#editAdminInfo').attr("disabled", true);
    	}else{
    		$('#usernameCheck2').removeClass('text-danger');
    		$('#usernameCheck2').addClass("text-success");
    		$('#usernameCheck2').text("Valid Username");
    		$('#editAdminInfo').attr("disabled", false);
    	}

    	if (parseInt($('#adminPass').val().trim().length) < 8) {
    		$('#passwordCheck2').addClass('text-danger');
    		$('#passwordCheck2').text("Must consist of 8 characters ("+(8 - parseInt($('#adminPass').val().trim().length))+" left)");
    		$('#editAdminInfo').attr("disabled", true);
    	}else{
    		$('#passwordCheck2').removeClass('text-danger');
    		$('#passwordCheck2').addClass("text-success");
    		$('#passwordCheck2').text("Valid Password");
    		$('#editAdminInfo').attr("disabled", false);
    	}
    });
    // CHECKING FOR PASSWORD VALIDITY
    $('#adminPass2').keyup(function(e){
    	$('#passwordCheck2').removeClass('text-danger');
    	$('#passwordCheck2').removeClass('text-success');
    	var passwordLength = $('#adminPass2').val().trim().length;
    	if (passwordLength < 8) {
    		$('#passwordCheck2').addClass("text-danger");
    		$('#passwordCheck2').text("Must consist of 8 characters ("+(8 - parseInt(passwordLength))+" left)");
    		$('#editAdminInfo').attr("disabled", true);
    	}else{
    		$('#passwordCheck2').addClass("text-success");
    		$('#passwordCheck2').text("Valid Password");
    		$('#editAdminInfo').attr("disabled", false);
    	}
    });
    // CHECKING FOR USERNAME VALIDITY
    $('#uNAME').keyup(function(e){
    	e.preventDefault();
    	$('#usernameCheck2').removeClass('text-danger');
    	$('#usernameCheck2').removeClass('text-success');
    	var usernameLength = $('#uNAME').val().trim().length;
    	if (usernameLength < 8) {
    		$('#usernameCheck2').addClass("text-danger");
    		$('#usernameCheck2').text("Must consist of 8 characters ("+(8 - parseInt(usernameLength))+" left)");
    		$('#editAdminInfo').attr("disabled", true);
    	}else{
    		if ($('#Uname').val() == $('#uNAME').val()) {
    			$('#usernameCheck2').addClass("text-success");
    			$('#usernameCheck2').text("Valid Username");
    			$('#editAdminInfo').attr("disabled", false);
    		}else{
    			$.ajax({
    				method:'post',
    				url:'administrator/checkUsername.php',
    				data:{username:$(this).val()},
    				success: function(res){
    					if (res.status == "existing") {
    						$('#usernameCheck2').addClass("text-danger");
    						$('#usernameCheck2').text("Existing! Please use different username!");
    						$('#editAdminInfo').attr("disabled", true);
    					}else{
    						$('#usernameCheck2').addClass("text-success");
    						$('#usernameCheck2').text("Valid Username");
    						$('#editAdminInfo').attr("disabled", false);
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
    $('#edit_adminPhoto').click(function(){
    	ACCOUNT_ID = $('#account_id').val();
    	ACCOUNT_PHOTO = $('#accnt_photo').text();
    	 // console.log(ACCOUNT_ID);
    	 // console.log(ACCOUNT_PHOTO);
    	 $('#upload_adminPhoto').click();
    });

    //NOTE...
    //image = AN IMG ELEMENT WHERE THE CROPPED IMAGE WILL BE DISPLAY
    //cropper = INITIALIZE FOR cropper.js VARIABLE
    // var modal3 = $('#croppedPetImageModal3');
    var image3 = document.querySelector('#sample_img3');
    var cropper3;

    //GET AND DISPLAY SELECTED PHOTO/IMAGE
    $('#upload_adminPhoto').on('change', function (event){
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
    		 previewImage($('#sample_img3'), $('#croppedPetImageModal3'), event);
    	}
    	// console.log(file);
    	// console.log(file_ext);
    	// console.log(isValidImage);
    		
    });

    //SETTING AND GETTING PHOTO/IMAGE TO BE CROPPED
    $('#croppedPetImageModal3').on('shown.bs.modal', function() {
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
    $('#crop_img-Btn3').on('click', function(){
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
    					$('#croppedPetImageModal3').modal('hide');
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
    					        title: "Failed to change Account Photo!",
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

	// GETTING PETID AND PET PHOTO
	let PETID = "";
	let PETPHOTO = "";
	$('.croppedPetImageBtn').click(function(){
		var data = $(this).next('div').text().split(",");
		PETID = data[0];
		PETPHOTO = data[1]
		// console.log(PETID);
		// console.log(PETPHOTO);
		 $('#upload_petimage').click();
	});

	//NOTE...
	//modal = A POPUP MODAL AFTER THE CHOSING A PHOTO
	//image = AN IMG ELEMENT WHERE THE CROPPED IMAGE WILL BE DISPLAY
	//cropper = INITIALIZE FOR cropper.js VARIABLE
	// var modal = $('#croppedPetImageModal');
	var image = document.querySelector('#sample_img');
	var cropper;

	//GET AND DISPLAY SELECTED PHOTO/IMAGE
	$('#upload_petimage').on('change', function (event){
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
			previewImage($('#sample_img'), $('#croppedPetImageModal'), event);
		}
		// console.log(file);
		// console.log(file_ext);
		// console.log(isValidImage);
			
	});

	//SETTING AND GETTING PHOTO/IMAGE TO BE CROPPED
	$('#croppedPetImageModal').on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 3/3,
			viewMode: 'square',
			preview: '.preview'
			//preview = class of div where cropped image display as preview
		});
	}).on('hidden.bs.modal', function (){
		cropper.destroy();
		cropper = null;
	});

	//SAVING CROPPED PHOTO/IMAGE
	$('#crop_img-Btn').on('click', function(){
		displayCroppedImage(cropper, $('#croppedPetImageModal'), PETID, PETPHOTO);
	});

	//SETTING ID'S TO "id" ATTRIBUTE
	$('#navmenu').on('click','a', function(e){
		var aID = $(this).attr('id');
		$('#vaccination-tab, #deworming-tab, #grooming-tab, #confinement-tab, #surgeries-tab, #consultation-tab, #schedule-tab').removeClass('bg-gray-dark');
		$(this).addClass('bg-gray-dark');
		if (aID == "vaccination-tab") {
			$('.addnewrec').addClass('d-none');
		}else if (aID == "deworming-tab") {
			$('.addnewrec').addClass('d-none');
		}else if (aID == "grooming-tab") {
			$('.addnewrec').addClass('d-none');
		}else if (aID == "confinement-tab") {
			$('.addnewrec').addClass('d-none');
		}else if (aID == "surgeries-tab") {
			$('.addnewrec').addClass('d-none');
		}else if (aID == "consultation-tab") {
			$('.addnewrec').addClass('d-none');
		}else if (aID == "schedule-tab") {
			$('.addnewrec').addClass('d-none');
		}
	});

	//TARGET ID WHILE "id" INPUT ATTRIBUTE IS CHANGING
	$('#addNewSchedulesBtn').on('click', function (){
		var date = $("#RPETBDATE2").val();
		var addId = $(this).attr("id");
		var age = setAge(date);
		var petID = $('#hpetid').val();
		var ownerID = $('#owneridd').val();

		$('input[name="petIDD"]').val(petID);
		$('input[name="ownerIDD"]').val(ownerID);

		if (addId == "addNewSurgeriesBtn") {
			$('input[name="petAgeNow"]').val(age);
			$('input[name="petIDD"]').val(petID);
			$('input[name="ownerIDD"]').val(ownerID);
			$('#addNewSurgeryModal').modal('show');

		}else if (addId == "addNewConsultationsBtn") {

		}else if (addId == "addNewSchedulesBtn") {
			$('input[name="petIDD"]').val(petID);
			$('#addNewScheduleModal').modal('show');
		}
	});

	//SAVING NEW PET SURGERY RECORD
	$('#saveNewSurgeryBtn').on('click', function(e){
		// e.preventDefault();
		var date = $("#RPETBDATE2").val();
		var age = setAge(date);
		var petID = $('#hpetid').val();

		if ($('#surgeryProcedure').val() !== "") {
		// 	Swal.fire({
		//         icon:'warning',
		//         title: "No selected procedure",
		//         text: 'Please select procedure',
		//         showConfirmButton: 'true',
		//         timer: 2500
		// 	})
		// }else{
			$.ajax({
				method: 'post',
				url: 'administrator/save_surgery.php',
				data:$('#surgeryForm').serialize()+"&petid="+petID+"&age="+age,
				success: function(res){
					// console.log(res.status);
					if (res.status == "success") {
						$('#addNewSurgeryModal').modal('hide');

							Swal.fire({
						        icon:'success',
						        title: "Save Successfully",
						        text: 'New Surgery Recorded',
						        showConfirmButton: 'true',
						        timer: 2500
							})
							setTimeout(function(){
								window.location.href = window.location.href;
							},2000);
					}
					if (res.status == "failed") {
						Swal.fire({
						        icon:'error',
						        title: "Failed to save surgery record!",
						        text: "Please check internet connection!",
						        showConfirmButton: 'true',
						        timer: 2500
							})
					}
				},error: function(err){
				console.log(err.responseText);
				}
			});
		}
	});

	//SAVING NEW CONSULTATION RECORDS
	$('#saveNewConsultationBtn').on('click', function(e){
		e.preventDefault();
		var date = $("#RPETBDATE2").val();
		var age = setAge(date);
		var petID = $('#hpetid').val();
		$.ajax({
			method: 'post',
			url: 'administrator/save_consultation.php',
			data:$('#consultationform').serialize()+"&petid="+petID+"&age="+age,
			success: function(res){
				// console.log(res.status);
				if (res.status == "success") {
					$('#addNewConsultationModal').modal('hide');

						Swal.fire({

					        icon:'success',
					        title: "Save Successfully",
					        text: 'New Consultation Recorded',
					        showConfirmButton: 'true',
					        timer: 2500
						})
						setTimeout(function(){
							window.location.href = window.location.href;
						},2000);
				}
				if (res.status == "empty") {
					Swal.fire({
					        icon:'warning',
					        title: "Empty Fields!",
					        text: 'Please fill all fields',
					        showConfirmButton: 'true',
					        timer: 2500
						})
				}
				if (res.status == "failed") {
					Swal.fire({
					        icon:'error',
					        title: "Failed to save consultation record!",
					        text: "Please check internet connection!",
					        showConfirmButton: 'true',
					        timer: 2500
						})
				}
			},error: function(err){
			// console.log(err.responseText);
			}
		});
	});


	$('.border-secondary').on('change','#petTESTS', function(){
		var test = $(this).val();
		$(this).val("");
		$('#confinementsTBODY').prepend("<tr><td><input type='text' class='form-control form-control-md' readonly name='tests[]' value='"+test+"'></td><td class='imgVal'><input type='file' name='testsimg[]' accept='.png, .jpg, .jpeg'></td><td><button class='btn btn-sm btn-danger delbtn'>X</button></td></tr>");
		
	});
	$('#confinementsTBODY').on('click','.delbtn', function(){
		var tr = $(this).closest('tr');

		var file = tr.find('td:eq(1) input').val();
		if (file.length < 1) {
			tr.remove();
		}else{
			var del = confirm('Click "Okay" if you want to remove the file');
			if(del == true){
				tr.remove();
			}
		}

	});

	//GET THE VALUE FROM SERVICE TYPE TABLE THEN PASS IS ON INPUT FIELDS EDIT SERVICE TYPE MODAL
	$('#serviceTypesTbl tbody').on('click','.editServiceTypeBtn', function(){
		$('#editServiceTypeModal').modal('show');
		//console.log('Clicked!');
		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();

		//console.log(data[1]);
		$('input[name="serviceTypeID"]').val(data[1]);
		$('input[name="serviceTypeHidden"]').val(data[2]);
		$('input[name="serviceType"]').val(data[2]);
	});

	//GET THE VALUE FROM SERVICES TABLE THEN PASS IS ON INPUT FIELDS EDIT SERVICES MODAL
	$('#offeredServicesTBL tbody').on('click','.editServiceBtn', function(){

		$('#editServicesModal').modal('show');

		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();

		var fee = data[4].split(' ');
		//console.log(data[1]);
		$('input[name="hiddenServiceID"]').val(data[0]);
		$('input[name="hiddenServiceTypeID"]').val(data[1]);
		$('input[name="hiddenService"]').val(data[2]);
		$('input[name="hiddenServiceType"]').val(data[3]);
		$('input[name="hiddenServiceFee"]').val(fee[1]);

		$('input[name="service"]').val(data[2]);
		$('input[name="serviceFee"]').val(fee[1]);

		var serviceType = data[3];
		$('#allServiceType').load('administrator/load-servicetype.php', {
		   serviceType : serviceType
		}, function(restxt, statstxt, jqXHR){
		   // alert(restxt);
		});
	});

	//VALIDATE SERVICE FEE UPON INSERTING
	$('#serviceFeeID').on('keyup', function() {
		var input = $(this).val();
		var dataArr = input.split("");
		var fee = "";
		var periodCount = 0;
		for (var i = 0; i < input.length; i++) {
				var data = dataArr[input.length - (input.length - i)];

				if (!isNaN(data) && data != " " || (data == "." && periodCount == 0)) {
					if (data == "." && periodCount == 0) {
						fee += data;
						periodCount = 1;
					}else{
						fee += data;
					}
					$('#srvfee-msg').addClass("d-none");
					$(this).val(fee);
				}else{
					$('#srvfee-msg').removeClass("d-none");
					$(this).val("");
					$(this).val(fee);
				}
		}
	});

	//VALIDATE SERVICE FEE UPON UPDATING
	$('#serviceFeeID2').on('keyup', function() {
		console.log((1200).toFixed(2));
		var input = $(this).val();
		var dataArr = input.split("");
		var fee = "";
		var periodCount = 0;
		for (var i = 0; i < input.length; i++) {
				var data = dataArr[input.length - (input.length - i)];

				if (!isNaN(data) && data != " " || (data == "." && periodCount == 0)) {
					if (data == "." && periodCount == 0) {
						fee += data;
						periodCount = 1;
					}else{
						fee += data;
					}
					$('#srvfee-msg2').addClass("d-none");
					$(this).val(fee);
										
				}else{
					$('#srvfee-msg2').removeClass("d-none");
					$(this).val("");
					$(this).val(fee);
				}
		}
	});

	var datefrom = $('#salesdateFrom').val();
	var dateto = $('#salesdateTo').val();
	var href = 'store_cashier/espadera_sales_report.php?df='+datefrom+'&dt='+dateto;
	$('#printStoreSales').attr('href',href);

	// $('#salesdateFrom').on('change', function(){
	// 	var datefrom = $(this).val();
	// 	var dateto = $('#salesdateTo').val();
	//   var href = 'store_cashier/espadera_sales_report.php?df='+datefrom+'&dt='+dateto;
	//   $('#printStoreSales').attr('href',href);

	// 	$('#salesTbody').load('store_cashier/load-salesfromto.php',{
	// 		datefrom: datefrom,
	// 		dateto: dateto
	// 	},
	// 	function(restxt, statstxt, jqXHR){
	// 		//console.log(restxt);
	// 	});
		 
	// 	 $.ajax({
	// 	 	method: 'post',
	// 	 	url: 'store_cashier/load-totalsales.php',
	// 	 	data: {datefrom:datefrom,dateto:dateto},
	// 	 	success: function(res){
	// 	 		$('#totalSales').text(res.totalsales);
	// 	 		$('#totalIncome').text(res.totalincome);
	//       $('#totalDiscount').text(res.totaldiscount);
	//       $('#initialIncome').text(res.initincome);
	// 	 	}
	// 	 });
		
	// });

	// $('#salesdateTo').on('change', function(){
	// 	var datefrom = $('#salesdateFrom').val();
	// 	var dateto = $(this).val();
	//   var href = 'store_cashier/espadera_sales_report.php?df='+datefrom+'&dt='+dateto;
	//   $('#printStoreSales').attr('href',href);

	// 	$('#salesTbody').load('store_cashier/load-salesfromto.php',{
	// 		datefrom: datefrom,
	// 		dateto: dateto
	// 	},function(restxt, statstxt, jqXHR){
	// 	 if (restxt == 'success') {
	// 	   console.log('New Content Load');
	// 	 }
	// 	 if (restxt == 'error') {
	// 	    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
	// 	 }

	// 	});
	// 	$.ajax({
	//     method: 'post',
	//     url: 'store_cashier/load-totalsales.php',
	//     data: {datefrom:datefrom,dateto:dateto},
	//     success: function(res){
	//       $('#totalSales').text(res.totalsales);
	//       $('#totalIncome').text(res.totalincome);
	//       $('#totalDiscount').text(res.totaldiscount);
	//       $('#initialIncome').text(res.initincome);
	//     }
	//    });
	// });
	
	// ADDED PRODUCT WITH DATE FROM AND TO
	var datefrom2 = $('#dateFrom2').val();
	var dateto2 = $('#dateTo2').val();
	var productlocation = $('#productLocation').val();
	var href = 'administrator/print_added_products2.php?df='+datefrom2+'&dt='+dateto2+'&lc='+productlocation;
	$('#printAddedProducts2').attr('href',href);

	$('#dateFrom2').on('change', function(){
	  var datefrom2 = $(this).val();
	  var dateto2 = $('#dateTo2').val();
	  var productlocation = $('#productLocation').val();
	  var href = 'administrator/print_added_products2.php?df='+datefrom2+'&dt='+dateto2+'&lc='+productlocation;
	  $('#printAddedProducts2').attr('href',href);

	  $('#historyTBL').load('administrator/load_productsfromto2.php',{
	    datefrom2: datefrom2,
	    dateto2: dateto2,
	    productlocation:productlocation
	  },
	  function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  });  
	});

	$('#dateTo2').on('change', function(){
	  var datefrom2 = $('#dateFrom2').val();
	  var dateto2 = $(this).val();
	   var productlocation = $('#productLocation').val();
	  var href = 'administrator/print_added_products2.php?df='+datefrom2+'&dt='+dateto2+'&lc='+productlocation;
	  $('#printAddedProducts2').attr('href',href);

	  $('#historyTBL').load('administrator/load_productsfromto2.php',{
	    datefrom2: datefrom2,
	    dateto2: dateto2,
	    productlocation:productlocation
	  },function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  });
	});

	//DISPLAY ADDED PRODUCTS EITHER FROM STORE OF CLINIC AND BASE ON DATE RANGE
	$('#productLocation').on('change', function(){
	  var datefrom2 = $('#dateFrom2').val();
	  var dateto2 = $('#dateTo2').val();
	  var productlocation = $(this).val();

	 if (productlocation == "STORE") {
	  	$('#dateFrom2').load('administrator/load_addedProductDateFrom.php', function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  	});
  		$('#dateTo2').load('administrator/load_addedProductDateTo.php', function(restxt, statstxt, jqXHR){
  	   // console.log(restxt);
  		});
	  	$('#addedProdRec').text("STORE");
	  }else{
	  	$('#dateFrom2').load('administrator/load_addedStockDateFrom.php', function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  	});
  		$('#dateTo2').load('administrator/load_addedStockDateTo.php', function(restxt, statstxt, jqXHR){
  	   // console.log(restxt);
  		});
	  	$('#addedProdRec').text("CLINIC");

	  }
	  var href = 'administrator/print_added_products2.php?df='+datefrom2+'&dt='+dateto2+'&lc='+productlocation;
	  $('#printAddedProducts2').attr('href',href);

	  $('#historyTBL').load('administrator/load_productsfromto2.php',{
	    datefrom2: datefrom2,
	    dateto2: dateto2,
	    productlocation:productlocation
	  },function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  });
	});

	//SALES FROM CLINIC OR STORE
	var datefrom = $('#salesdateFrom').val();
	var dateto = $('#salesdateTo').val();
	var href = 'administrator/print_salesreport.php?df='+datefrom+'&dt='+dateto+'&sfrom=Store';
	$('#printStoreSales').attr('href',href);
	
	$('#salesLocation').on('change', function(){
	  var productlocation = $('#salesLocation').val();
	  $('#salesdateFrom').val("");//prevent null value
	  $('#salesdateTo').val("");//prevent null value
	 if (productlocation == "STORE") {
	  	$('#salesdateFrom').load('administrator/load_storeSalesDateFrom.php', 
	  		function(restxt, statstxt, jqXHR){
	   // alert(statstxt);
	  	});
  		$('#salesdateTo').load('administrator/load_storeSalesDateTo.php', function(restxt, statstxt, jqXHR){
  	  		$('#salesType').text("Store");
	  		  var datefrom = $('#salesdateFrom').val();
	  		  var dateto = $('#salesdateTo').val();
		  		$('#salesTBL').load('administrator/load-salesfromto.php',{
		  			datefrom: datefrom,
		  			dateto: dateto
		  		},function(restxt, statstxt, jqXHR){
		  			// alert(statstxt);
		  		 if (statstxt == 'success') {
		  		   	$.ajax({
		  		       method: 'post',
		  		       url: 'administrator/load-totalsales.php',
		  		       data: {datefrom:datefrom,dateto:dateto},
		  		       success: function(res){
  		           	    $('#ttlsalesinfo').html('<div class="col-2 text-left">TOTAL SALES</div><div class="col-10 text-left">&#8369; '+res.totalsales+'</div>');
  		           	    $('#initincomeinfo').html('<div class="col-2 text-left">INITIAL INCOME</div><div class="col-10 text-left">&#8369; '+res.totalincome+'</div>');
  		           	    $('#ttldiscinfo').html('<div class="col-2 text-left">TOTAL DISCOUNT</div><div class="col-10 text-left">&#8369; '+res.totaldiscount+'</div>');
  		           	    $('#ttlincinfo').html('<div class="col-2 text-left">TOTAL INCOME</div><div class="col-10 text-left">&#8369; '+res.initincome+'</div>');
  		           			
  		           			var href = 'administrator/print_salesreport.php?df='+datefrom+'&dt='+dateto+'&sfrom=Store';
  		           			$('#printStoreSales').attr('href',href);
		  		       }
		  		      });
		  		 }
		  		 if (statstxt == 'error') {
		  		    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		  		 }

	  		});
  		});
	  }else{
	  	$('#salesdateFrom').load('administrator/load_clinicSalesDateFrom.php', function(restxt, statstxt, jqXHR){
	    // alert(statstxt);
	  	});
  		$('#salesdateTo').load('administrator/load_clinicSalesDateTo.php', function(restxt, statstxt, jqXHR){
  	   	  $('#salesType').text("Clinic");
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
	  		       		  $('#ttlsalesinfo').html('<div class="col-2 text-left">TOTAL SALES</div><div class="col-10 text-left">&#8369; '+res.totalsales+'</div>');
	  		       		  $('#initincomeinfo').html('');
	  		       		  $('#ttldiscinfo').html('');
	  		       		  $('#ttlincinfo').html('');

	  		       		  var href = 'administrator/print_salesreport.php?df='+datefrom+'&dt='+dateto+'&sfrom=Clinic';
	  		       		  $('#printStoreSales').attr('href',href);
   	  		       }
   	  		      });
   	  		      
   	  		 }
   	  		 if (statstxt == 'error') {
   	  		    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
   	  		 }

   	  		});
  		});
	  }
	  
	});

	//VIEW SALES FROM STORE OR CLINIC BASE ON DATE RANGE
	$('#salesdateFrom, #salesdateTo').on('change', function(){
		 var productlocation = $('#salesLocation').val();
		 var datefrom = $('#salesdateFrom').val();
  		 var dateto = $('#salesdateTo').val();

		 if (productlocation == "STORE") {
		 		$('#salesTBL').load('administrator/load-salesfromto.php',{
		 			datefrom: datefrom,
		 			dateto: dateto
		 		},function(restxt, statstxt, jqXHR){
		 		 if (statstxt == 'success') {
		 		   	$.ajax({
		 		       method: 'post',
		 		       url: 'administrator/load-totalsales.php',
		 		       data: {datefrom:datefrom,dateto:dateto},
		 		       success: function(res){
		 		          if (res.totalsales == null) {
		 		          	    $('#ttlsalesinfo').html('<div class="col-2 text-left">TOTAL SALES</div><div class="col-10 text-left">&#8369; 0</div>');
		 		          	    $('#initincomeinfo').html('<div class="col-2 text-left">INITIAL INCOME</div><div class="col-10 text-left">&#8369; 0</div>');
		 		          	    $('#ttldiscinfo').html('<div class="col-2 text-left">TOTAL DISCOUNT</div><div class="col-10 text-left">&#8369; 0</div>');
		 		          	    $('#ttlincinfo').html('<div class="col-2 text-left">TOTAL INCOME</div><div class="col-10 text-left">&#8369; 0</div>');
									
									$('#printStoreSales').attr('href','');
		 		          }else{
		 		          	    $('#ttlsalesinfo').html('<div class="col-2 text-left">TOTAL SALES</div><div class="col-10 text-left">&#8369; '+res.totalsales+'</div>');
		 		          	    $('#initincomeinfo').html('<div class="col-2 text-left">INITIAL INCOME</div><div class="col-10 text-left">&#8369; '+res.totalincome+'</div>');
		 		          	    $('#ttldiscinfo').html('<div class="col-2 text-left">TOTAL DISCOUNT</div><div class="col-10 text-left">&#8369; '+res.totaldiscount+'</div>');
		 		          	    $('#ttlincinfo').html('<div class="col-2 text-left">TOTAL INCOME</div><div class="col-10 text-left">&#8369; '+res.initincome+'</div>');
		 		          			
		 		          			var href = 'administrator/print_salesreport.php?df='+datefrom+'&dt='+dateto+'&sfrom=Store';
		 		          			$('#printStoreSales').attr('href',href);
		 		          }
		 		       }
		 		      });
		 		 }
		 		 if (statstxt == 'error') {
		 		    console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
		 		 }

		 		});
		 		
		 }else{
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
	  		       			$('#ttlsalesinfo').html('<div class="col-2 text-left">TOTAL SALES</div><div class="col-10 text-left">&#8369; 0</div>');
	  		       		  $('#initincomeinfo').html("");
	  		       		  $('#ttldiscinfo').html("");
	  		       		  $('#ttlincinfo').html("");
								$('#printStoreSales').attr('href','');
	  		       	}else{
	  		       		  	$('#ttlsalesinfo').html('<div class="col-2 text-left">TOTAL SALES</div><div class="col-10 text-left">&#8369; '+res.totalsales+'</div>');
	  		       		    $('#initincomeinfo').html("");
	  		       		    $('#ttldiscinfo').html("");
	  		       		    $('#ttlincinfo').html("");
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
	  		
		 }
	});

	//VIEW PRODUCTS FROM STORE OR CLINIC
	var productlocation = $('#productLocation2').val();
	var href = 'administrator/print_allproducts2.php?lc='+productlocation;
	$('#printAllProducts').attr('href',href);

	$('#productLocation2').on('change', function(){
	  var productlocation = $(this).val();

	  if (productlocation == "STORE") {
	  	$('#prodRec').text("STORE");
	  	$('#searchInvOrStore').attr('placeholder','Search Product');
	  }else{
	  	$('#prodRec').text("CLINIC");
	  	$('#searchInvOrStore').attr('placeholder','Search Service / For');
	  }
	  
	  var href = 'administrator/print_allproducts2.php?lc='+productlocation;
	  $('#printAllProducts').attr('href',href);

	  $('#dataTable1').load('administrator/load_products.php',{
	    productlocation:productlocation
	  },function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  });
	});
	//search products from store or clinic
	$('#searchInvOrStore').on('keyup', function(){
		var productlocation = $('#productLocation2').val();
		var href = 'administrator/print_allproducts2.php?lc='+productlocation;
		$('#printAllProducts').attr('href',href);

		$('#dataTable1').load('administrator/searchStoreClinicProducts.php',{
		searchValue: $(this).val(),
		prodLocation:productlocation
		},
			function(restxt, statstxt, jqXHR){
			// alert(restxt);
		});
		
	});
	//LOAD PET OR CLIENT 
	$('#searchPetAndClient').on('keyup', function(){
		$('#allPets').load('administrator/load_pets.php',{
	    search:$(this).val()
	  },function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  });
	});
	//LOAD PET OR CLIENT ON OWNER RECORDS
	$('#tsearchClientPet').on('keyup', function(){
		var clientID = $('#client_ID').val();
		$('#ownerPets').load('owners/load_client_pets.php',{
	    search:$(this).val(),
	    clientID:clientID
	  },function(restxt, statstxt, jqXHR){
	   // console.log(restxt);
	  });
	});

	//EDIT CLINICAL SIGNS OF PET
	$('#petClinicalSignsTable').on('click', '.edit_clinsign', function(){
		var tr = $(this).closest('tr');
		var confSurgID = tr.find('td:eq(0)').text();
		var clinsigns = tr.find('td:eq(1) .current_clinsign').text();
		$('input[name="confOrSurgID"]').val(confSurgID);
		$('input[name="oldClinSigns"]').val(clinsigns);
		$('#listOfClinicalSigns').load('administrator/load_clinicalsigns.php',{
	    confSurgID: confSurgID,
	    clinsigns: clinsigns
	  },function(restxt, statstxt, jqXHR){
	     // console.log(restxt);
	  });
		$('#editClinicalSignsModal').modal('show');
	});
	
	//EDIT TREATMENTS FOR PET
	$('#petTreatmentsTable').on('click','.edit_treatments', function(){
		var trtid = $(this).closest('tr').find('td:eq(0)').text();
		var treatments = $(this).closest('tr').find('td:eq(1)').text().split("Edit");

		$('input[name="treatmentid"]').val(trtid);
		$('#curTreatments').text(treatments[0]);
		$('#petTreatmentsRec').text(treatments[0]);
		$('#editTreatmentsModal').modal('show');
	});

	//EDIT PET FINAL DIAGNOSIS 
	$('#custom_finaldiagnosis_tab').on('click','span', function(){
		$('#diagnosisHeader').text("UPDATE FINAL DIAGNOSIS");
		$('#diagnosisLabel').text("List of Final Diagnosis");
		$('#initOrFinal').val('FINAL');
		var finalDiag = $('#petFinalDiag').text();
		$('input[name="oldInitDiag"]').val(finalDiag);
		$('#listOfInitDiagnosis').load('administrator/load_initfinaldiagnosis.php',{
	    initorfinaldiagnosis: finalDiag,
	    inifOrfinal: "FINAL"
	  },function(restxt, statstxt, jqXHR){
	     // console.log(restxt);
	  });
		$('#editInitialFinalDiagnosisModal').modal('show');
	});

	//EDIT PET INITIAL DIAGNOSIS
	$('#petInitDiagnosisTable').on('click', '.edit_initdiag', function(){
		var tr = $(this).closest('tr');
		var confSurgID = tr.find('td:eq(0)').text();
		var initdiagnosis = tr.find('td:eq(1) .current_initdiag').text();
		$('input[name="confOrSurgID"]').val(confSurgID);
		$('input[name="oldInitDiag"]').val(initdiagnosis);
		$('#initOrFinal').val('INIT');
		$('#diagnosisHeader').text("UPDATE INITIAL DIAGNOSIS");
		$('#diagnosisLabel').text("List of Initial Diagnosis");
		$('#listOfInitDiagnosis').load('administrator/load_initfinaldiagnosis.php',{
	    initorfinaldiagnosis: initdiagnosis,
	    inifOrfinal: "INIT"
	  },function(restxt, statstxt, jqXHR){
	     if (statstxt == "success") {
	     	$('#editInitialFinalDiagnosisModal').modal('show');
	     }
	  });
		
	});

	//SETTING PET RETURN SCHEDULE
	$('#scheduleTBL').on('click','.status', function(){
		var tr = $(this).closest('tr');
		if ($(this).text() != "NOT SHOW" && !tr.find('td:eq(10) button').hasClass('d-none')) {
			var schedstat = "ONGOING";
			if ($(this).text() == "ONGOING") {
				schedstat = "ARRIVED";
			}
			Swal.fire({
		        title: 'Change Status to <b>"'+schedstat+'"</b>?',
		        text: 'You can change it to "'+ $(this).text() +'" later',
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor:'#3085d6',
		        cancelButtonColor:'#d33',
		        confirmButtonText:'Yes, change it!'
			}).then((result)=>{
				if (result.isConfirmed) {
	    		$.ajax({
					method: 'post',
					url: 'administrator/update_specific_schedstatus.php',
					data: {
						schedid:tr.find("td:eq(0)").text(),
						schedstat:schedstat
					},
					success: function(res){
						setTimeout(function(){
							window.location.href = window.location.href;
						},2000);
						if (res.status == "success") {
							Swal.fire(
						        'Status successfully change to "'+schedstat+'"',
						        "",
						        'success'
							)  										
						}else{
							Swal.fire(
						        "Status failed to change!",
						        "Please check internet connection!",
						        'error'
							)
						}
						
					},error:function(e){
						 console.log(e.responseText);
					}
				});
					
				 }
			})
		}

	});

	//FORMATTED DATE FOR RETURN
	function formattedDate(date){
		var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		var str_date = date.split('-');
		return newDate = months[Number(str_date[1]-1)]+" "+str_date[2]+", "+str_date[0];
	}

	// SET RESON FOR RETURN AND SETTING SMS NOTIFICATIONS
	var notif = "";
	var formattedReturnDate="";
	$('#returnReason').on('change', function(){
		var retID = $(this).val();
		var petname = $('#hdpetname').val();
		if (retID != "") {
				$.ajax({
					method: 'post',
					url: 'receptionist/get-notification.php',
					data: {retID:retID},
					success: function(res){
						notif = res.replace(/PETNAME/gi,$('#hdpetname').val());

						if ($('#returnDate').val() == "") {
							$('#notification').val(notif);
						}else{
							$('#notification').val(notif+ formattedReturnDate);
						}
					}
					// ,error: function(err){
					// 	alert(err.responseText);
					// }
				});

				$('#specificReturn').load("receptionist/load-specific-return.php",{
					retID:retID
				}, function(restxt, statstxt, jqXHR){
				   // alert(restxt);
			   });
		}else{
			$('#notification').val("");
		}


	});

	//SAVING CREATED PET RETURN SCHEDULE
	$('#saveSchedule').click(function(e){
		e.preventDefault();
		var petid = $('#hpetid').val();
		var accntid = $('#MY_ID').val();
		var returnReason = $('#returnReason').val();
		var specificReturn = $('#specificReturn').val();
		var returnDate = $('#returnDate').val();
		var sendDate = $('#sendDate').val();
		var notification = $('#notification').val();

		if (returnReason == "" ) {
			$('#reasonmsg').text("Choose Reason for Return").fadeTo(3000,500).slideUp(300);
		}else if (returnDate == "") {
			$('#retmsg').text("Choose return date").fadeTo(3000,500).slideUp(300);
		}else if (sendDate == "") {
			$('#sendmsg').text("Choose send date").fadeTo(3000,500).slideUp(300);
		}else{
			$.ajax({
				method: 'post',
				url: 'receptionist/save-petschedule.php',
				data: {
					petid:petid,
					accntid:accntid,
					returnReason:returnReason,
					specificReturn:specificReturn,
					returnDate:returnDate,
					sendDate:sendDate,
					notification:notification
				},
				success: function(res){

					if (res == "success") {
						$('#addNewScheduleModal').modal('hide');
						setTimeout(function() {
							location.reload(true);
						},2000);

						Swal.fire({
					        icon:'success',
					        title: "New Pet Schedule Save Successfully",
					        showConfirmButton: 'true',
					        timer: 2500
						});
					}else{
						Swal.fire({
					        icon:'error',
					        title: "Failed! Please check internet connection!",
					        showConfirmButton: 'true',
					        timer: 2500
						});
					}
				}
				// ,error: function(err){
				// 	alert(err.responseText);
				// }
			});
		}
	});

	//CLEAR SEND DATE
	$('#clear').click(function(){
		$('#sendDate').val("");
		$('#notification').val("");
	});

	var curdate = new Date();//curent date
	var curtime = curdate.getTime();//current time

	//SET RETURN DATE
	$('#returnDate').change(function(){
		var retdate = new Date($(this).val());//return date
		var [year, month, day] = $(this).val().split('-');
		var result = [month, day, year].join('/');
		var rettime = retdate.getTime();

		var sendate = new Date($('#sendDate').val());//send date
		var sendtime = sendate.getTime();

		formattedReturnDate = " on "+formattedDate($(this).val())+". See you!";
		if (rettime <= curtime) {
			$('#retmsg').text("Date must be greater than current date").fadeTo(3000,500).slideUp(300);
			$(this).val("");
		}else if (sendtime >= rettime || sendtime <= curtime) {
			$('#sendmsg').text("Date must be less than "+result).fadeTo(3000,500).slideUp(300);
			$('#sendDate').val("");
			$('#notification').val(notif+ formattedReturnDate);
		}else{
			if ($('#returnReason').val() != "") {
				$('#notification').val(notif+ formattedReturnDate);
			}
		}
	});

	//SET SMS NOTIFICATION SEND DATE
	$('#sendDate').change(function(){
		var retdate = new Date($('#returnDate').val());//return date
		var [year, month, day] = $('#returnDate').val().split('-');
		var result = [month, day, year].join('/');
		var rettime = retdate.getTime();

		var sendate = new Date($(this).val());//send date
		var sendtime = sendate.getTime();
		if ($('#returnDate').val() != "") {//if not empty 
			if (sendtime >= rettime || sendtime <= curtime) {
				if (sendtime <= curtime) {
					$('#sendmsg').text("Date must be greater than current date").fadeTo(3000,500).slideUp(300);
				}else{
					$('#sendmsg').text("Date must be less than "+result).fadeTo(3000,500).slideUp(300);
				}
				$(this).val("");
			}
		}else{
			$(this).val("");
			$('#retmsg').text("Choose return date!").fadeTo(3000,500).slideUp(300);
		}
		
	});

	//EDIT OR MODIFY PET SCHEDULE
	var oldReturnDate = "";
	var oldMsg = "";
	$('#scheduleTBL tbody').on('click', 'button',function(){
		var tr = $(this).closest('tr');
		var schedid = tr.find("td:eq(0)").text();
		var retdate = tr.find("td:eq(1)").text();
		var senddate = tr.find("td:eq(2)").text();
		var returnID = tr.find("td:eq(3)").text();
		var service = tr.find("td:eq(5)").text();
		var msg = tr.find("td:eq(8)").text();
		var status = tr.find("td:eq(9)").text();
		oldReturnDate = retdate;
		oldMsg = msg;

		$('#returnReason2').load("receptionist/load-return-reason.php",{
			returnID:returnID
		}, function(restxt, statstxt, jqXHR){
		    if (statstxt == "success") {
	    		$('#specificReturn2').load("receptionist/load-specific-service.php",{
	    			returnID:returnID,
	    			service:service
	    		}, function(restxt, statstxt, jqXHR){
	    		    if (statstxt == "success") {
	    		    	$('#petScheduleID').val(schedid);
	    		    	$('#returnDate2').val(retdate);
	    		    	$('#sendDate2').val(senddate);
	    		    	$('#notification2').val(msg);
	    		    	$('#editPetScheduleModal').modal('show');
	    		    }
	    	   });
		    }
	   });
	});

	//SET EDITED RETURN DATE 
	$('#returnDate2').change(function(){
		var retdate = new Date($(this).val());//return date
		var [year, month, day] = $('#returnDate2').val().split('-');
		var result = [month, day, year].join('/');
		var rettime = retdate.getTime();

		var sendate = new Date($('#sendDate2').val());//send date
		var sendtime = sendate.getTime();

		var formattedOldReturnDate = formattedDate(oldReturnDate);
		var newReturnDate = formattedDate($(this).val());
		var newReturnMsg = oldMsg.replace(formattedOldReturnDate, newReturnDate);
		if (rettime <= curtime) {
			$('#retmsg2').text("Date must be greater than current date").fadeTo(3000,500).slideUp(300);
			$(this).val("");
		}else if (sendtime >= rettime || sendtime <= curtime) {
			$('#sendmsg2').text("Date must be less than "+result).fadeTo(3000,500).slideUp(300);
			$('#sendDate2').val("");
			$('#notification2').val(newReturnMsg);
		}else{
			if ($('#returnReason2').val() != "") {
				$('#notification2').val(newReturnMsg);
			}
		}
	});

	//SET EDITED SMS NOTIFICATION SEND DATE
	$('#sendDate2').change(function(){
		var retdate = new Date($('#returnDate2').val());//return date
		var [year, month, day] = $('#returnDate2').val().split('-');
		var result = [month, day, year].join('/');
		var rettime = retdate.getTime();

		var sendate = new Date($(this).val());//send date
		var sendtime = sendate.getTime();

		if ($('#returnDate2').val() != "") {
			if (sendtime >= rettime || sendtime <= curtime) {
				if (sendtime <= curtime) {
					$('#sendmsg2').text("Date must be greater than current date").fadeTo(3000,500).slideUp(300);
				}else{
					$('#sendmsg2').text("Date must be less than "+result).fadeTo(3000,500).slideUp(300);
				}
				$(this).val("");
				// $('#notification2').val("");
			}else{

			}
		}else{
			$(this).val("");
			$('#retmsg2').text("Choose return date!").fadeTo(3000,500).slideUp(300);
		}
		 
	});

	//SAVE EDITED PET RETURN SCHEDULE
	$('#saveEditSchedule').click(function(e){
		// alert(true);
		e.preventDefault();
		var schedid = $('#petScheduleID').val();
		var petid = $('#hpetid').val();
		var accntid = $('#MY_ID').val();
		var returnReason = $('#returnReason2').val();
		var specificReturn = $('#specificReturn2').val();
		var returnDate = $('#returnDate2').val();
		var sendDate = $('#sendDate2').val();
		var notification = $('#notification2').val();


		if (returnReason == "" ) {
			$('#reasonmsg2').text("Choose Reason for Return").fadeTo(3000,500).slideUp(300);
		}else if (returnDate == "") {
			$('#retmsg2').text("Choose return date").fadeTo(3000,500).slideUp(300);
		}else if (sendDate == "") {
			$('#sendmsg2').text("Choose send date").fadeTo(3000,500).slideUp(300);
		}else{
			$.ajax({
				method: 'post',
				url: 'receptionist/save-editpetschedule.php',
				data: {
					schedid:schedid,
					petid:petid,
					accntid:accntid,
					returnReason:returnReason,
					specificReturn:specificReturn,
					returnDate:returnDate,
					sendDate:sendDate,
					notification:notification
				},
				success: function(res){
					if (res == "success") {
						$('#editPetScheduleModal').modal('hide');
						setTimeout(function() {
							location.reload(true);
						},2000);

						Swal.fire({
					        icon:'success',
					        title: "Pet Schedule Update Successfully",
					        showConfirmButton: 'true',
					        timer: 2500
						});
					}else if (res == "exist") {
						$('#editPetScheduleModal').modal('hide');
							Swal.fire({
						        icon:'info',
						        title: "No Changes On Schedule",
						        showConfirmButton: 'true',
						        timer: 2500
							});
					}else{
						Swal.fire({
					        icon:'error',
					        title: "Failed! Please check internet connection!",
					        showConfirmButton: 'true',
					        timer: 2500
						});
					}
				}
				,error: function(err){
					//console.log(err.responseText);
				}
			});
		}
	});

	//SHOW 
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
		   	$('#clientPaymentInfoModal').modal('show');
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
	//SCHEDULES FILTER EITHER FOR VACCINATIONS, DEWORMINGS, CONSULTATIONS, SURGERIES  
	$('#schedulesFilter').on('change', function(){
		var returnID = $(this).val();
		$('#schedulesTbody').load('administrator/load_specific_schedule.php',{
		returnID: returnID} ,
			function(restxt, statstxt, jqXHR){
			// alert(restxt);
		});
	});
});//ENF OF $(document).ready(funtion(){ ... })