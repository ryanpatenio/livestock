$(document).ready(function(){

    const addModal = $('#Add_dispersalModal');

    $('#existingClient').on('change', function () {
        const selectedValue = $(this).val();

        if (selectedValue === 'notexisting') {
            $('#clientForm').slideDown(); // Show the form
        } else {
            $('#clientForm').slideUp(); // Hide the form
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
    

});