$(document).ready(function(){

    const editModal = $('#editModal');

    $(document).on('click','#edit-btn',function(e){
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

        let data = $(this).serialize();
        $url = baseUrl + "action=updateMyAccount";

        swalMessage('custom','Are you sure you want to update your Account?',function(){
            AjaxPost(
                $url,
                'POST',
                data,
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