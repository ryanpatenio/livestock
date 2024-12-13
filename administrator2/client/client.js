$(document).ready(function(){
    $('#main').css('filter', 'none');
    $('#loader').hide();

    const editModal = $('#editModal');

    $(document).on('click','#edit_btn',function(e){
        e.preventDefault();

        resetForm($('#updateClientForm'));

        let id = $(this).attr('data-id');
        $url = baseUrl + "action=getClientData";

      
            AjaxPost(
                $url,
                'POST',
                {id:id},

                function(){
                    logs(true);
                },

                function(response){
                    res(response);
                    if(response.code != 0){
                        msg("an Error Occured while Processing your request!",'error');
                        return;
                    }
                    
                    $('#hid_client_id').val(response.data[0].CLIENT_ID);

                    $('#FNAME').val(response.data[0].FNAME);
                    $('#LNAME').val(response.data[0].LNAME);
                    $('#MI').val(response.data[0].MIDINITIAL);
                    $('#ASSOC').val(response.data[0].ASSOCIATION);
                    $('#CONTACT').val(response.data[0].CONTACT_NO);
                    $('#ADDRESS').val(response.data[0].ADDRESS);
                    $('#DATE_REG').val(response.data[0].DATE_REGISTERED);
                    // $('#sect-number').val(response['message'].data['number']);
                    

                    editModal.modal('show');
                },

                function(){
                    logs(false);
                }
            );
    });

    $(document).on('submit','#updateClientForm',function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + "action=updateClient";

        swalMessage('custom','Are you sure you want to update this Client?',function(){
            AjaxPost(
                $url,
                'POST',
                Data,

                function(){
                    logs(true);
                },

                function(response){
                   //success callback
                   res(response)
                    if(response.code != 0){
                        msg(response.message,"error");
                        return;
                    }
                 
                    message('Client updated successfully!','success');
                    formModalClose(editModal,$('#updateClientForm'));

                },

                function(){
                    logs(false);
                }
            )

        });

    });

});