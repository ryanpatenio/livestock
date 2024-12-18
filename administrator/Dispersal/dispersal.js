$(document).ready(function(){

    const addModal = $('#Add_dispersalModal');

    const updateFirstModal = $('#firstPaymentModal');
    const updateSecondModal = $('#secondPaymentModal');

    $('#existingClient').on('change', function () {
        const selectedValue = $(this).val();
    
        if (selectedValue === 'notexisting') {
            $('#clientForm').slideDown(); // Show the form
            $('#paidtToDiv').css('display', 'none');
        } else {
            $('#clientForm').slideUp(); // Hide the form
            $('#paidtToDiv').css('display', 'block');
        }
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