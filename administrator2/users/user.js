$(document).ready(function(){

    const addModal = $('#addModal');
    const editModal = $('#editModal');


$('#addUserForm').submit(function(e){
    e.preventDefault();

    let Data = $(this).serialize();
    $url = baseUrl + "action=addUser";

    AjaxPost(
        $url,
        'POST',
        Data,
        function(){
            logs(true);
            loader(true);
        },

        function(response){
           // res(response);

            if(response.code != 0){
                msg(response.message,'error');
                return;
            }

            message(response.message,'success');
            formModalClose(addModal,$('#addUserForm'));
        },

        function(){
            logs(false);
            loader(false);
        }
    );
    

});

$(document).on('click','#edit-btn',function(e){
    e.preventDefault();

    resetForm($('#updateUserForm'));

    let user_id = $(this).attr('data-id');
    $url = baseUrl + "action=getUser";

    AjaxPost(
        $url,
        'POST',
        {user_id : user_id},
        function(){
            logs(true);
            loader(true);
        },

        function(response){
            //res(response);

            if(response.code != 0){
                msg(response.message,'error');
                return;
            }
            $('#user-id').val(response.data[0].user_id);

            $('#full-name').val(response.data[0].fullname)
            $('#user-name').val(response.data[0].username)
           
            $('#get-account-type').text(response.data[0].ACCOUNT_TYPE);
            $('#get-account-type').val(response.data[0].account_type_id);
            
            editModal.modal('show');
        },

        function(){
            logs(false);
            loader(false);
        }
    );
    
   
});

$('#updateUserForm').submit(function(e){
    e.preventDefault();

    let Data = $(this).serialize();
    $url = baseUrl + "action=updateUser";

    swalMessage('custom','Are you sure you want to update User?',function(){
        AjaxPost(
            $url,
            'POST',
              Data,
            function(){
                logs(true);
                loader(true);
            },
    
            function(response){
                //res(response);
    
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
                message(response.message,'success');
                formModalClose(editModal,$('#updateUserForm'));
               
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );
    });

});

});