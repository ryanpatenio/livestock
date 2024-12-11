//========================================================================================
//============= INSIDE $(document).ready(funtion(){ ... }) ==============================
//==============  to be able to execute the "funtion({})" ================================
//========================================================================================
$(document).ready(function(){

	$('#PRINTSAMPLE').on('click',function(e){

			// $.ajax({
			// 	method: 'post',
			// 	url: 'owners/update_pet_client_schedule.php',
			// 	success: function(res){
			// 		alert(res);
			// 	},error:function(err){
			// 		alert(err.responseText);
			// 	}
			// });
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
	//DATATABLES MODIFIED
	$('#serviceTypesTbl, #speciesTbl, #cleintTableList,#breedsTable').DataTable({});
	$('#acquiredServicesTbl').DataTable({scrollY:"300px", scrollCollapse:false});
	//DATATABLES ORDERING FALSE
	$('#scheduleTBL, #vaccinationTBL, #dewormingTBL, #groomingTBL, #confinementsTBL,  #clientPaymentsTbl, #serviceOfferedTBL,#addedStockHistoryTBL' ).DataTable({ordering:false});
	//LOAD PET OR CLIENT 
	$('#searchPetAndClient').on('keyup', function(){
		var receptionistID = $('#receptionistID').val();
		$('#receptionistAllPets').load('receptionist/load-pets.php',{
	    search:$(this).val(),
	    receptionistID:receptionistID
	  },function(restxt, statstxt, jqXHR){
	   console.log(restxt);
	  });
	});

	$('#schedulesFilter').on('change', function(){
		var returnID = $(this).val();
		$('#schedulesTbody').load('administrator/load_specific_schedule.php',{
		returnID: returnID} ,
			function(restxt, statstxt, jqXHR){
			// alert(restxt);
		});
	});
	
	//LOAD PET OR CLIENT ON OWNER RECORDS
	$('#tsearchClientPet').on('keyup', function(){
		var clientID = $('#client_ID').val();
		var receptionist_id = $('#receptionist_id').val();
		$('#clientPetsList').load('receptionist/load-client-pets.php',{
	    search:$(this).val(),
	    clientID:clientID,
	    receptionist_id:receptionist_id
	  },function(restxt, statstxt, jqXHR){
	    // console.log(restxt);
	  });
	});

	//GET THE VALUE FROM LIST OF CIENTS TABLE THEN PASS IS ON INPUT FIELDS EDIT CLIENT MODAL
	$('#cleintTableList tbody').on('click','.editClientBtn', function(){
		if (!$(this).hasClass('disabled')) {
			$('#editClientInfoModal').modal('show');
			//console.log('Clicked!');
			$tr = $(this).closest('tr');

			var data = $tr.children('td').map(function(){
				return $(this).text();
			}).get();

			//console.log(data[1]);
			$('input[name="clientID"]').val(data[1]);
			$('#clientFullname').val(data[2]);
			$('input[name="hiddenFulname"]').val(data[2]);
			$('#recAdd').val(data[3]);
			$('input[name="hiddenAddress"]').val(data[3]);
			$('#clientContact').val(data[4]);
			$('input[name="hiddenContact"]').val(data[4]);
		}
		
	});

	//ADD NEW SERVICE PRODUCT MODAL
	$('#serviceOfferedTBL tbody').on('click','.addServProdQty', function(){
		var tr = $(this).closest('tr');
		var data = tr.children('td').map(function(){
						return $(this).text();
					}).get();
		$('#serviceID').val(data[0]);
		$('#service').html(data[1]);
		$('#serviceType').html(data[2]);
		$('#serviceFee').html(data[3]);
		var onhand = data[5].split(' ');
		var bg = "bg-success";
		if (onhand[0] <= 10) {
			bg = "bg-danger";
		}else if (onhand[0] <= 20) {
			bg = "bg-warning";
		} 
		$('#currentOnhand').val(onhand[0]);
		$('#onhandServProd').html('<span class="'+bg+' p-1" >'+data[5]+'</span>');
		$('#addNewServiceProduct').modal('show');
	});

	//GET THE VALUE FROM SPECIES TABLE THEN PASS IS ON INPUT FIELDS EDIT SPECIES MODAL
	$('#speciesTbl tbody').on('click','.editSpeciesBtn', function(){
		$('#editSpeciesModal').modal('show');
		//console.log('Clicked!');
		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();

		//console.log(data[1]);
		$('#hdbspsID').val(data[1]);
		$('#hdbsps').val(data[2]);
		$('#petsps').val(data[2]);
	});

	//GET THE VALUE FROM BREEDS TABLE THEN PASS IS ON INPUT FIELDS EDIT BREEDS MODAL
	$('#breedsTable tbody').on('click','.editBreedBtn', function(){
		$('#editBreedModal').modal('show');
		$tr = $(this).closest('tr');

		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
		//console.log(data[1]);
		$('input[name="hiddenBreedID"]').val(data[1]);
		$('input[name="hiddenSpeciesID"]').val(data[2]);
		$('input[name="hiddenBreed"]').val(data[3]);
		$('#brd').val(data[3]);

		var species = data[4];
		//alert(data);
		$('#editPetSpecies').load('receptionist/load-petspecies2.php', {
		   species : species
		}, function(restxt, statstxt, jqXHR){
		   	//console.log(restxt);
		   }
		 );  
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
			$('#passwordCheck').text("Must consist of 8 characters ("+(8 - parseInt($('#userPassword').val().trim().length))+" left)");
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
					url: 'receptionist/save_userPhoto.php',
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
	});

	// THIS IS FOR THE LOAD OF PET SPECIES ON ADD PET MODAL
	$('#petBreeds').on('change', function() {
	  var brdID = this.value;
	  if (brdID == "") {
	  	brdID = "0";
	  }
	   $('#petSpecies').load('owners/load-petspecies.php', {
	      brdID : brdID
	   }, function(restxt, statstxt, jqXHR){
	    if (restxt == 'success') {
	      console.log('New Content Load');
	    }
	    if (restxt == 'error') {
	       console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
	    }
	   });
	});

	// THIS IS FOR THE LOAD OF PET SPECIES ON EDIT PET MODAL
	$('#petBreeds2').on('change', function() {
	  var brdID = this.value;
	  if (brdID == "") {
	  	brdID = "0";
	  }
	   $('#petSpecies2').load('owners/load-petspecies.php', {
	      brdID : brdID
	   }, function(restxt, statstxt, jqXHR){
	    if (restxt == 'success') {
	      console.log('New Content Load');
	    }
	    if (restxt == 'error') {
	       console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
	    }
	   });
	});

	//NOTE...
	//cropper = INITIALIZE FOR cropper.js VARIABLE
	// var modal = $('#croppedPetImageModal');
	var image = document.querySelector('#sample_img');
	var cropper;

	//GET AND DISPLAY SELECTED PHOTO/IMAGE
	$('.upload_petimage').on('change', function (event){
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
		var canvas = cropper.getCroppedCanvas({
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
						$('#croppedPetImageModal').modal('hide');
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
						
					}, error: function(e){
						alert(e.responseText);
					}
				});
				
			}
		});
	});

	// GETTING PETID AND PET PHOTO
	let PETID = "";
	let PETPHOTO = "";
	//EDIT PET INFO FROM PET PAGE
	$('#receptionistAllPets').on('click','button',function(){
		var petid = $(this).val();
		if (petid == "") {
			 var data = $(this).next('div').text().split(",");
			PETID = data[0];
			PETPHOTO = data[1]
			// console.log(PETID);
			// console.log(PETPHOTO);
			 $('.upload_petimage').click();
		}else{
			$.ajax({
				method: 'post',
				url: 'receptionist/get-petinfo.php',
				data: {petid:petid},
				success: function(res){
					if (res.status == "failed") {
						Swal.fire({
					        icon:'error',
					        title: "Failed! Please check internet connection!",
					        showConfirmButton: 'true',
					        timer: 2500
						});
					}else{

						$('#editPetModal').modal('show');

						$('#pet-id').val(petid);
						$('#petName2').val(res.name);
						$('#pet-sps').val(res.species);
						$('input[name="petbdate2"]').val(res.bdate);
						if (res.sex == "Male") {
							$('#radmale2').attr('checked', true);
						}else{
							$('#radfemale2').attr('checked', true);
						}

						$('#petBreeds2').load('receptionist/load-petbreeds.php', {
						   breed : res.breed
						}, function(restxt, statstxt, jqXHR){
						   // console.log(statstxt);
						});
					}
				}
			});
		}
		// console.log(data)
		//$('#editPetModal').modal('show');
	});
	//EDIT PET INFO FROM CLIENT RECORD PAGE 
	$('#clientPetsList').on('click','button',function(){
		var petid = $(this).val();
		if (petid == "") {
			var data = $(this).next('div').text().split(",");
			PETID = data[0];
			PETPHOTO = data[1]
			// console.log(PETID);
			// console.log(PETPHOTO);
			 $('.upload_petimage').click();
			}else{
				$.ajax({
					method: 'post',
					url: 'receptionist/get-petinfo.php',
					data: {petid:petid},
					success: function(res){
						if (res.status == "failed") {
							Swal.fire({
						        icon:'error',
						        title: "Failed! Please check internet connection!",
						        showConfirmButton: 'true',
						        timer: 2500
							});
						}else{

							$('#editPetModal').modal('show');

							$('#pet-id').val(petid);
							$('#petName2').val(res.name);
							$('#pet-sps').val(res.species);
							$('input[name="petbdate2"]').val(res.bdate);
							if (res.sex == "Male") {
								$('#radmale2').attr('checked', true);
							}else{
								$('#radfemale2').attr('checked', true);
							}

							$('#petBreeds2').load('receptionist/load-petbreeds.php', {
							   breed : res.breed
							}, function(restxt, statstxt, jqXHR){
							   // console.log(statstxt);
							});
						}
					}
				});
			}
		// console.log(data)
		//$('#editPetModal').modal('show');
	});
	//UPDATE PET INFO
	$('#updatePetForm').on('submit', function(e){
		e.preventDefault();
		// console.log($(this).serialize());
		$.ajax({
			method: 'post',
			url: 'receptionist/savePetUpdate.php',
			data: $(this).serialize(),
			success: function(res){
				$('#editPetModal').modal('hide');
				setTimeout(function(){
					location.reload(true);
				},2000);
				if (res.status == "success") {
					Swal.fire({
				        icon:'success',
				        title: "Pet Information Update Successfully",
				        showConfirmButton: 'true',
				        timer: 2500
					});
				}else if (res.status == "exist") {
					Swal.fire({
				        icon:'info',
				        title: "No changes done! Information still the same!",
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
				
			},error:function(e){
				console.log(e.responseText);
			}
		});
	});

	// THIS IS FOR THE LOAD OF PET SPECIES ON EDIT PET MODAL
	$('#petBreeds2').on('change', function() {
	  var brdID = this.value;
	  if (brdID == "") {
	  	brdID = "0";
	  }
	   $('#petSpecies2').load('receptionist/load-petspecies.php', {
	      brdID : brdIDs
	   }, function(restxt, statstxt, jqXHR){
	    if (restxt == 'success') {
	      console.log('New Content Load');
	    }
	    if (restxt == 'error') {
	       console.log("Error: "+jqXHR.status+" "+jqXHR.statstxt);
	    }
	   });
	});

	//SAMPLE
	$('#viewPetRec').click(function(){
		var data = $(this).closest('table');

		console.log(data);
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
	    $('#rpetconfinement').click(function(){
    	 Swal.fire({
		        title: "Do you want to Confine the pet?",
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonColor:'#3085d6',
		        cancelButtonColor:'#d33',
		        confirmButtonText:'Yes, confine!'
			}).then((result)=>{
				if (result.isConfirmed) {
		    		$.ajax({
						method: 'post',
						url: 'receptionist/saveNewConfinement.php',
						data: {
							petAgeNow:setAge($('#RPETBDATE2').val()),
							petID:$('#hpetid').val()
						},
						success: function(res){
							setTimeout(function(){
								window.location.href = window.location.href;
							},2000);
							if (res.status == "success") {
							Swal.fire(
						        "Pet is now Confine",
						        "",
						        'success'
							)  										
							}else{
								Swal.fire(
							        "Failed to Confine!",
							        "Please check internet connection!",
							        'error'
								)
							}
							
						},error:function(e){
							// console.log(e.responseText);
						}
					});
					
				}
			})
    });
	//TARGET ID WHILE "id" INPUT ATTRIBUTE IS CHANGING
	$('#addNewSchedulesBtn').on('click', function (){
		var date = $("#RPETBDATE2").val();
		var addId = $(this).attr("id");
		var age = setAge(date);
		var petID = $('#hpetid').val();
		var ownerID = $('#owneridd').val();

		$('input[name="petAgeNow"]').val(age);
		$('input[name="petIDD"]').val(petID);
		$('input[name="ownerIDD"]').val(ownerID);

		if (addId == "addNewConfinementsBtn") {
			$('#addNewConfinementsModal').modal('show');

		}else if (addId == "addNewSurgeriesBtn") {
			$('#addNewSurgeryModal').modal('show');

		}else if (addId == "addNewConsultationsBtn") {

		}else if (addId == "addNewSchedulesBtn") {
			$('input[name="petIDD"]').val(petID);
			$('#addNewScheduleModal').modal('show');
		}
	});


	var totalFee = 0;
	$('#PetServices').on('change', function(){
		var data = $(this).val().split(';');
		var srv = data[0];
		var fee = data[1];
		totalFee = totalFee + parseFloat(fee);
		$('#groomingServiceTbody').prepend('<tr><td>'+srv+'</td><td>&#8369; '+fee+'</td><td><button class="btn btn-sm bg-danger cancelService"><i class="fas fa-times"></i></button></td></tr>');
		$('#initServFee').text(totalFee);
	});

	$('#groomingServiceTbody').on('click','.cancelService', function(e){
		e.preventDefault();
		var tr = $(this).closest('tr');
		var fee = tr.find('td:eq(1)').text().split(' ');
		totalFee = totalFee - parseFloat(fee[1]);
		$('#initServFee').text(totalFee);
		tr.remove();
	});
	
	$('#confinementsTBL tbody').on('click','.updatePetConfinementBTN', function(e){
		e.preventDefault();
		var tr = $(this).closest('tr');
		var confID = tr.find('td:eq(0)').text();
		$('input[name="confinementID"]').val(confID);
		$('#petidd').val($('#hpetid').val());
		$('#ownerId').val($('#owneridd').val());
		$('#updateConfinementsModal').modal('show');
	});

	var initFee = 0;
	$('#PET_SERVICES').on('change',function() {
		var service = $(this).val().split("_");
		var fee = $('option:selected', this).attr('class').split("_ ");

		$('#createdPaymentTBody').append('<tr><td hidden>'+service[0]+'</td><td hidden>'+service[1]+'</td><td>'+service[2]+'</td><td>&#8369; '+ fee[0]+'</td><td class="text-center"><button class="btn btn-sm bg-danger  cancelServicebtn"><i class="fas fa-times"></i></button></td></tr>');
	    initFee = initFee + parseFloat(fee[0]);
		var discrate = parseInt($('#discRate').val()) * initFee / 100;
		$('#totalpayment').text(initFee.toFixed(2));
		
		if ($('#discRate').val() != "") {
			$('#discCost').text(discrate.toFixed(2));
			$('#totalAmount').text((initFee-discrate).toFixed(2));
		}else{
			$('#discCost').text("0.00");
			$('#totalAmount').text(initFee.toFixed(2));
		}
		$(this).val("");
	});
	$('#createdPaymentTBody').on('click','.cancelServicebtn', function(e){
		e.preventDefault();
		var tr = $(this).closest('tr');
		var fee = tr.find('td:eq(3)').text().split(" ");
		initFee = initFee - parseFloat(fee[1]);
		var discrate = parseInt($('#discRate').val()) * initFee / 100;
		$('#totalpayment').text(initFee.toFixed(2));	
		if ($('#discRate').val() != "") {
			$('#discCost').text(discrate.toFixed(2));
			$('#totalAmount').text((initFee-discrate).toFixed(2));
		}else{
			$('#discCost').text("0.00");
			$('#totalAmount').text(initFee.toFixed(2));
		}
		tr.remove();
	});

	$('#discRate').on('keyup change', function(){
		initFee = parseInt($('#totalpayment').text());
		var discrate = parseInt($('#discRate').val()) * initFee / 100;
		if ($(this).val() == "") {
				$('#discCost').text("0.00");
			 	$('#totalAmount').text(initFee.toFixed(2));
		}else{
			$('#discCost').text(discrate.toFixed(2));
			$('#totalAmount').text((initFee-discrate).toFixed(2));
		}
	});

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
					$('#groomingServiceTbl').html("");
					$('#totalGroomingPrice').text("");

					Swal.fire({
				        icon:'success',
				        title: "New Pet Record Save Successfully",
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
	$('#scheduleTBL').on('click','.status', function(){
		var tr = $(this).closest('tr');
		if ($(this).text() != "NOT SHOW") {
			var tr = $(this).closest('tr');
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
	$('#filter').on('change', function(){
		// alert($(this).val());
		$('#PET_SERVICES').load("receptionist/load_services.php",{
			srvtypeid:$(this).val()
		}, function(restxt, statstxt, jqXHR){
		  // alert(restxt);
	   });
	});
	
	function formattedDate(date){
		var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		var str_date = date.split('-');
		return newDate = months[Number(str_date[1]-1)]+" "+str_date[2]+", "+str_date[0];
	}
	var notif = "";
	$('#returnReason').on('change', function(){
		var retID = $(this).val();
		var petname = $('#hdpetname').val();
		if (retID == "") {
			retID = 0;
		}
		$.ajax({
			method: 'post',
			url: 'receptionist/get-notification.php',
			data: {retID:retID},
			success: function(res){
				notif = res.replace("PETNAME",$('#hdpetname').val());

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

	});

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
			$('#sendmsg').text("Choose return date").fadeTo(3000,500).slideUp(300);
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

	$('#clear').click(function(){
		$('#sendDate').val("");
		$('#notification').val("");
	});

	$('#clear2').click(function(){
		$('#sendDate2').val("");
		$('#notification2').val("");
	}); 
	var curdate = new Date();//curent date
	var curtime = curdate.getTime();

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
			$('#notification2').val("");
			$('#notification2').val(newReturnMsg);
		}else{
			if ($('#returnReason2').val() != "") {
				$('#notification2').val(newReturnMsg);
			}
		}
	});

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
			$('#sendmsg2').text("Choose return date").fadeTo(3000,500).slideUp(300);
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

});