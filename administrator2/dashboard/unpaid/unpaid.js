$(document).ready(function(){
    
  

    const addModal = $('#Add_dispersalModal');

    const updateFirstModal = $('#firstPaymentModal');
    const updateSecondModal = $('#secondPaymentModal');

    $('#clientTBL').dataTable({
            

    });

    $('#existingClient').on('change', function () {
        const selectedValue = $(this).val();
    
        if (selectedValue === 'notexisting') {
            $('#clientForm').slideDown(); // Show the form
            $('#paidtToDiv').css('display', 'none');

            $('#clientForm input').prop('required', true); // Add required attributes
        } else {
            $('#clientForm').slideUp(); // Hide the form
            $('#paidtToDiv').css('display', 'block');
            $('#clientForm input').prop('required', false); // Remove required attributes
        }
    });

    $('#existingClient2').on('change', function () {
        const selectedValue = $(this).val();
    
        if (selectedValue === 'notexisting') {
            $('#clientForm2').slideDown(); // Show the form
            $('#paidtToDiv2').css('display', 'none');
        } else {
            $('#clientForm2').slideUp(); // Hide the form
            $('#paidtToDiv2').css('display', 'block');
            $('#clientForm2 input').prop('required', false); // Remove required attributes
        }
    });
    

    $('#animal_parent').on('change', function () {
        // Get the selected option
        var selectedOption = $(this).find('option:selected');
        
        // Get the data attribute value
        var animalType = selectedOption.data('animal-type');
        let animalTypeID = selectedOption.data('animal-type-id');
        
        // Set the value in the input field
        $('#animal-type-to-give').val(animalType);
        $('#animal-type-id').val(animalTypeID);
    });

    $('#animal_parent2').on('change', function () {
        // Get the selected option
        var selectedOption = $(this).find('option:selected');
        
        // Get the data attribute value
        var animalType = selectedOption.data('animal-type');
        let animalTypeID = selectedOption.data('animal-type-id');
        
        // Set the value in the input field
        $('#animal-type-to-give2').val(animalType);
        $('#animal-type-id2').val(animalTypeID);
    });

    

    $(document).on('submit','#addForm',function(e){
        e.preventDefault();
        
        let Data = $(this).serialize();
        $url = baseUrl + "action=addDispersal";
    
        AjaxPost(
            $url,
            'POST',
            Data,
            function(){
                logs(true);
            },
    
            function(response){
               
    
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
    
                message(response.message,'success');
                formModalClose(addModal,$('#addForm'));
            },
    
            function(){
                logs(false);
            }
        );
    
    });

    $('#firstPaymentForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
    
    
        // Check if 'notexisting' or 'existing' is selected
        const clientType = $('#existingClient').val();

        if (clientType === 'notexisting') {
            // Find missing required visible input fields in #clientForm
            const missingFields = $('#clientForm input:visible[required], #clientForm select:visible[required]').filter(function () {
                return !$(this).val().trim(); // Check for empty values
            });

            if (missingFields.length > 0) {
                // Focus the first missing field
                missingFields.first().focus();

                // Show an alert
                alert('Please fill out all required fields!');
                return false; // Stop form submission
            }
        }

        if (clientType === 'existing') {
            // Find missing required visible input fields in #paymentDetails1
            const missingFields1 = $('#paymentDetails1 input:visible[required], #paymentDetails1 select:visible[required]').filter(function () {
                return !$(this).val().trim(); // Check for empty values
            });

            if (missingFields1.length > 0) {
                // Focus the first missing field
                missingFields1.first().focus();

                // Show an alert
                alert('Please fill out all required fields!');
                return false; // Stop form submission
            }
        }

        const $url = baseUrl + "action=addFirstPayment";
        const formData = new FormData(this);
    
        swalMessage(
            'custom',
            'Are you sure you want to update this First Payment Dispersal?',
            function() {
                $.ajax({
                    url: $url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        res(response)
                        if (response.code !== 0) {
                            msg(response.message, 'error'); // Show error message
                            return;
                        }
    
                        msgThenRedirect(response.message, 'success',"livestock2/"+"../index2.php?page=unpaid"); // Show success message
                        formModalClose(updateFirstModal, $('#firstPaymentForm')); // Close the modal and reset the form
                    },
                    error: function(xhr) {
                        res(xhr.responseText); // Log error details
                    }
                });
            }
        );
    });
    

    $('#secondPaymentForm').submit(function(e){
        e.preventDefault();
        
         // Check if 'notexisting' or 'existing' is selected
         const clientType = $('#existingClient2').val();

         if (clientType === 'notexisting') {
             // Find missing required visible input fields in #clientForm
             const missingFields = $('#clientForm2 input:visible[required], #clientForm2 select:visible[required]').filter(function () {
                 return !$(this).val().trim(); // Check for empty values
             });
 
             if (missingFields.length > 0) {
                 // Focus the first missing field
                 missingFields.first().focus();
 
                 // Show an alert
                 alert('Please fill out all required fields!');
                 return false; // Stop form submission
             }
         }
 
         if (clientType === 'existing') {
             // Find missing required visible input fields in #paymentDetails1
             const missingFields1 = $('#paymentDetails2 input:visible[required], #paymentDetails2 select:visible[required]').filter(function () {
                 return !$(this).val().trim(); // Check for empty values
             });
 
             if (missingFields1.length > 0) {
                 // Focus the first missing field
                 missingFields1.first().focus();
 
                 // Show an alert
                 alert('Please fill out all required fields!');
                 return false; // Stop form submission
             }
         }


        $url = baseUrl + "action=addSecondPayment";
        let formData = new FormData(this);

        swalMessage('custom','Are you sure you want to update this Second Payment Dispersal?',function(){

            $.ajax({
                url: $url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                   // res(response);
                    
                    if(response.code != 0){
                        msg(response.message,'error');
                        return;
                    }
                    msgThenRedirect(response.message, 'success',"livestock2/"+"../index2.php?page=unpaid"); // Show success message
                    formModalClose(updateSecondModalModal,$('#secondPaymentForm'));
 
                                    
                },
                error: function(xhr, status, error) {
                    res(xhr.responseText);
        
                }
            });

         });

    });

    $(document).on('click','.payment-button-1st',function(e){
        e.preventDefault();

        let ID = $(this).attr('data-dispersal-id1');
        $('#dispersalId1').val(ID);
      
      updateFirstModal.modal('show');
    });

    $(document).on('click','.payment-button-2nd',function(e){
        e.preventDefault();

        let ID = $(this).attr('data-dispersal-id2');
        $('#dispersalId2').val(ID);
      
        updateSecondModal.modal('show');
    });
    

});