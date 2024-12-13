$(document).ready(function(){

    const addModal = $('#Add_dispersalModal');

    

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