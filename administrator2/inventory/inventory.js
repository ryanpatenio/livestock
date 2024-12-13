$(document).ready(function(){
   
    $('#main').css('filter', 'none');
    $('#loader').hide();
    
    $(document).on('submit','#addVaccineForm',function(e){
        e.preventDefault();
        
        let Data = $(this).serialize();
        $url = baseUrl + "action=addVaccine";
    
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