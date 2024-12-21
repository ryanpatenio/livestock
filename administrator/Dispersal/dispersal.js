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
        
        // Set the value in the input field
        $('#animal-type-to-give').val(animalType);
    });

    $('#animal_parent2').on('change', function () {
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

        if ($('#existingClient').val() === 'notexisting' && $('#clientForm input:visible[required]').filter(function () {
            return !this.value;
        }).length > 0) {
            alert('Please fill out all required fields!');
            e.preventDefault();
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

        if ($('#existingClient2').val() === 'notexisting' && $('#clientForm2 input:visible[required]').filter(function () {
            return !this.value;
        }).length > 0) {
            alert('Please fill out all required fields!');
            e.preventDefault();
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