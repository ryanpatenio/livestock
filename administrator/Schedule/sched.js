$(document).ready(function(){

    const addModal = $('#Add_scheduleModal');

    $(document).on('submit','#addScheduleForm',function(e){
        e.preventDefault();
        
        let Data = $(this).serialize();
        $url = baseUrl + "action=addSchedule";

        AjaxPost(
            $url,
            'POST',
            Data,
            function(){
                logs(true);
            },
    
            function(response){
                //res(response);

                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
    
                message('New Schedule added successfully!','success');
                formModalClose(addModal,$('#addClientForm'));
            },
    
            function(){
                logs(false);
            }
        );
    
    });
    
   

});