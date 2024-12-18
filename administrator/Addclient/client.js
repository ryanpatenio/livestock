$(document).ready(function(){

        $('#main').css('filter', 'none');
        $('#loader').hide();

        $('#pendingTBL').dataTable({
            

        });


const addModal = $('#AddclientModal');
const editModal = $('#editModal');

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


$(document).on('click','#edit-btn-client',function(e){
    e.preventDefault();

    resetForm($('#updateForm'));

    let ID = $(this).attr('data-id');
    $url = baseUrl + "action=getClientData";

    AjaxPost(
        $url,
        'POST',
        {id : ID},
        function(){
            logs(true);
        },

        function(response){
         
            if(response.code != 0){
                msg("an Error Occured while Processing your request!",'error');
                return;
               
            }
            $('#hid_client_id').val(response.data[0].CLIENT_ID);
            $('#edit-fname').val(response.data[0].FNAME);
            $('#edit-lname').val(response.data[0].LNAME);
            $('#edit-mi').val(response.data[0].MIDINITIAL);
            $('#edit-assoc').val(response.data[0].ASSOCIATION);
            $('#edit-contact').val(response.data[0].CONTACT_NO);
            $('#edit-address').val(response.data[0].ADDRESS);
            $('#edit-reg').val(response.data[0].DATE_REGISTERED);

            editModal.modal('show');

            
        },

        function(){
            logs(false);
        }
    );

});

$(document).on('submit','#updateForm',function(e){
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
             
                    if(response.code != 0){
                        msg(response.message,"error");
                        return;
                    }
                
                    message('Client updated successfully!','success');
                    formModalClose(editModal,$('#updateForm'));

                },

                function(){
                    logs(false);
                }
            )
        });

    });



});