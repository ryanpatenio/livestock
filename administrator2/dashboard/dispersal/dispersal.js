$(document).ready(function(){

    $('#main').css('filter', 'none');
    $('#loader').hide();


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
        $('#animal-type-to-give').val("");

        // Get the selected option
        var selectedOption = $(this).find('option:selected');
        
        // Get the data attribute value
        var animalType = selectedOption.data('animal-type');
        
        // Set the value in the input field
        $('#animal-type-to-give').val(animalType);
    });

    $('#animal_parent2').on('change', function () {
        $('#animal-type-to-give2').val("");

        // Get the selected option
        var selectedOption = $(this).find('option:selected');
        
        // Get the data attribute value
        var animalType = selectedOption.data('animal-type');
        
        // Set the value in the input field
        $('#animal-type-to-give2').val(animalType);
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

    $('#firstPaymentForm').submit(function(e){
        e.preventDefault();
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


        $url = baseUrl + "action=addFirstPayment";
        let formData = new FormData(this);

        swalMessage('custom','Are you sure you want to update this First Payment Dispersal?',function(){
            $.ajax({
                url: $url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
        
        
                success: function(response) {
                // res(resp);
                
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }

                message(response.message,'success');
                formModalClose(updateFirstModal,$('#firstPaymentForm'));
                
                                    
                },
                error: function(xhr, status, error) {
                    res(xhr.responseText);
        
                }
            });
        });
       
      
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
                res(response);
                
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }

                message(response.message,'success');
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

        $('#animal_parent').empty().append('<option value="">Select an animal</option>');
        $('#animal-type-to-give').val("");

        let ID = $(this).attr('data-dispersal-id1');
        let clientName = $(this).attr('data-client-name1');
        let clientID = $(this).attr('data-client-id')

        $('#dispersalId1').val(ID);
        $('#paid_by1').val(clientName);
        $('#client-id1').val(clientID);

        $url = baseUrl + "action=getAnimalsByClientFemale";

        AjaxPost(
            $url,
            'POST',
            {client_id : clientID},

            function(){

            },
            function(response){
               // res(response);

                if (response.data && response.data.length > 0) {
                    // Loop through the data and populate the select tag
                    $.each(response.data, function (index, item) {
                        $('#animal_parent').append(
                            `<option data-animal-type="${item.ANIMALTYPE}" value="${item.ANIMAL_ID}">
                                ${item.ANIMALTYPE} | ${item.ANIMAL_SEX}
                            </option>`
                        );
                    });
                }
               
            },

            function(){

            }
        );
      
      updateFirstModal.modal('show');
    });

    $(document).on('click','.payment-button-2nd',function(e){
        e.preventDefault();

        $('#animal_parent2').empty().append('<option value="">Select an animal</option>');
        $('#animal-type-to-give2').val("");


        let ID = $(this).attr('data-dispersal-id2');
        let clientName = $(this).attr('data-client-name2');
        let clientID = $(this).attr('data-client-id2')

        $('#dispersalId2').val(ID);
        $('#paid_by2').val(clientName);
        $('#client-id2').val(clientID);

        $url = baseUrl + "action=getAnimalsByClientFemale";

        AjaxPost(
            $url,
            'POST',
            {client_id : clientID},

            function(){
                
            },
            function(response){
               // res(response);

                if (response.data && response.data.length > 0) {
                    // Loop through the data and populate the select tag
                    $.each(response.data, function (index, item) {
                        $('#animal_parent2').append(
                            `<option data-animal-type="${item.ANIMALTYPE}" value="${item.ANIMAL_ID}">
                                ${item.ANIMALTYPE} | ${item.ANIMAL_SEX}
                            </option>`
                        );
                    });
                }
               
            },

            function(){

            }
        );

      
        updateSecondModal.modal('show');
    });
    

});