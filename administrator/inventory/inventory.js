$(document).ready(function(){
   
    $('#vaccineTypeTBL').dataTable({
            

    });
    $('.inventoryTable').dataTable({
            

    });

    
    
    $(document).on('submit','#addVaccineForm',function(e){
        e.preventDefault();
        
        let Data = $(this).serialize();
        $url = baseUrl + "action=addVaccine";

        swalMessage('custom','Please make sure all the fields, Date of Expiration and Qty are Correct! then click `OK` to Submit!',function(){
            AjaxPost(
                $url,
                'POST',
                Data,
                function(){
                    logs(true);
                },
        
                function(response){
                    //res(response);
                    res(response);
        
                    if(response.code != 0){
                        msg(response.message,'error');
                        return;
                    }
        
                    message(response.message,'success');
                    formModalClose(addModal,$('#addVaccineForm'));
                },
        
                function(){
                    logs(false);
                }
            );
        });
    });

});