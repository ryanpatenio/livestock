$(document).ready(function(){

    $('#loginForm').submit(function(e){
       e.preventDefault(); 
        let data = $(this).serialize();
        $url = baseUrl + "action=login";

        AjaxPost(
            $url,
            'POST',
            data,
            function(){
                logs(true);
                loader(true);
            },
    
            function(response){
                res(response);
    
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
                msgThenRedirect('Login Successfully','success',response.data);
                
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );
        


    });

});