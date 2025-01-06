$(document).ready(function(){

const addVaccTypeModal = $('#addVaccTypeModal');
const editVaccTypeModal = $('#editVaccTypeModal');


    $('#addVaccTypeForm').submit(function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + "action=addVaccType";

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
    
                message(response.message,'success');
                formModalClose(addVaccTypeModal,$('#addVaccTypeForm'));
            },
    
            function(){
                logs(false);
            }
        );

    });


    $(document).on('click','#edit-vacc-type-btn',function(e){
        e.preventDefault();
        resetForm($('#updateVaccTypeForm'));

        let ID = $(this).attr('data-id');
        $url = baseUrl + "action=getVaccTypeDetails";

       
        AjaxPost(
            $url,
            'POST',
            {id : ID},
            function(){
                logs(true);
            },
    
            function(response){
                
              //  res(response);
    
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
                $('#vaccine-type-id').val(response.data[0].VACCINE_TYPE_ID);

                $('#vaccine-type-name').val(response.data[0].VACCINE_NAME);
                $('#edit-description').val(response.data[0].DESCRIPTION);
                
                editVaccTypeModal.modal('show');
            },
    
            function(){
                logs(false);
            }
        );

    });

    $('#updateVaccTypeForm').submit(function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + "action=updateVaccTypeName";

        swalMessage('custom','are you sure you want to update this Vaccine Name?',function(){
    
            AjaxPost(
                $url,
                'POST',
                Data,
                function(){
                    logs(true);
                },
        
                function(response){
                   
                    res(response);
        
                    if(response.code != 0){
                        msg(response.message,'error');
                        return;
                    }
        
                    message(response.message,'success');
                    formModalClose(addVaccTypeModal,$('#updateVaccTypeForm'));
                },
        
                function(){
                    logs(false);
                }
            );
        });


    });


});

