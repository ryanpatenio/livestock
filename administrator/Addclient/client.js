$(document).ready(function(){

//msg("hello",'success')

const addModal = $('#AddclientModal');
//const editModal = $('#editModal');

$(document).on('submit','#addClientForm',function(e){
    e.preventDefault();
    
    let Data = $(this).serialize();
    $url = baseUrl + "action=addClient";

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

            message('New Client added successfully!','success');
            formModalClose(addModal,$('#addClientForm'));
        },

        function(){
            logs(false);
        }
    );

});

});