function message($text = "", $msg_type = "") {
	swal($text, {
		icon: $msg_type,
	}).then((confirmed) => {
		swal.close();
		window.location.reload();
	});
}

function msgThenRedirect($text ="",$msg_type ="", _url){
	swal($text, {
		icon: $msg_type,
	}).then((confirmed) => {
		swal.close();
		window.location.href = _url;
	});
}

// function message(_message, _msg_type, _url) {
// 	Swal.fire({
// 		title: _message,
// 		icon: _msg_type,
// 		allowOutsideClick: false,

// 		preConfirm: function () {
// 			return new Promise(function (resolve) {
// 				if (_url && _url !== "") {
// 					window.location.href = _url;
// 				} else {
// 					resolve(); // Resolve the promise without doing anything
// 				}
// 			});
// 		},
// 	});
// }

function msg(message = "", msg_type = "") {
	swal(message, {
		icon: msg_type,
	});
}

const resetForm = (thisForm) => {
	thisForm.get(0).reset();
};

const formModalClose = (modalName, thisForm) => {
	$(modalName).modal("hide");
	thisForm.get(0).reset();
};
const res = (param) => {
	console.log(param);
};

const modalClose = (modalName) => {
	$(modalName).modal("hide");
};



function successSwal(_message, _redirect = "") {
	swal({
		title: "Success!",
		html: _message,
		type: "success",
		allowEscapeKey: false,
		allowOutsideClick: false,
		showLoaderOnConfirm: true,
		preConfirm: function () {
			return new Promise(function (success) {
				if (_redirect == "") {
					swal.close();
				} else {
					// setTimeout(() => {
					window.location.href = _redirect;
					// success();
					// }, 500);
				}
				// setTimeout(() => {
				// 	((_redirect == '') ? swal.close() : window.location.href = _redirect);
				// 	success();
				// }, 500);
			});
		},
	});
}


function AjaxPost(url, method, formData, beforeSendCallback, successCallback, completeCallback) {
    $.ajax({
        url: url,
        method: method || 'POST',  // Default to POST if no method is provided
        data: formData,
        dataType: 'json',

        beforeSend: function() {
            if (beforeSendCallback && typeof beforeSendCallback === 'function') {
                beforeSendCallback();
            }
        },

        success: function(response) {
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },

        complete: function() {
            if (completeCallback && typeof completeCallback === 'function') {
                completeCallback();
            }
        },

        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
			console.log(xhr.responseText);
        }
    });
}

function loader(_status){
	_status == false;
  
	if(_status === true){
	  $('#loader').show();
	}else{
	  $('#loader').hide();
	}
   }

   function Redirect(_url,_logs = ""){

	if(_logs == ""){
	  setTimeout(function() {
		// Delay 1 second to proceed
		window.location.href = _url;
  
	  }, 1000);
  
	}else{
	  console.log(_logs);
  
	  setTimeout(function() {
		// Delay 1 second to proceed
		window.location.href = _url;
  
	  }, 1000);
	}
  
	
   }


   function loader(_status){
	_status == false;
  
	if(_status === true){
	  $('#loader').show();
	}else{
	  $('#loader').hide();
	}
   }

   function logs(_logs) {

    if (_logs === true) {
      console.log('Sending Request to API...');
    } else if (_logs === false) {
      console.log('Request Completed...');
    } else {
      console.log(_logs);
    }
}

function swalMessage(swal_type, message, willConfirmedCallback) {
    let defaultMessages = {
        'update': "Are you sure you want to update this item?",
        'delete': "Are you sure you want to delete this item?",
        'custom': message || "Are you sure you want to proceed?",
    };

    swal({
        text: defaultMessages[swal_type] || defaultMessages['custom'],
        icon: "info",
        buttons: true,
        dangerMode: swal_type === 'delete',
    }).then((willconfirmed) => {
        if (willconfirmed && typeof willConfirmedCallback === 'function') {
            willConfirmedCallback();
        }
    });
}