$(document).ready(function(){

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
                    // if(response['message'].code != 0){
                    //     msg(response['message'].message,'error');
                    //     return;
                    // }
                    // $('#sect-id').val(response['message'].data['sect_id']);
                    // $('#sect-number').val(response['message'].data['number']);
                    

                    editModal.modal('show');
                },

                function(){
                    logs(false);
                }
            );
    });

});