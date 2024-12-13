$(document).ready(function(){
    
const addModal = $('#addVaccinationModal');

    $(document).on('submit','#addCattleForm',function(e){
        e.preventDefault();

        $url = baseUrl + "action=addCattleStaff";
        let formData = new FormData(this);

        $.ajax({
            url: $url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',


            success: function(resp) {
            //res(resp);
                if (resp.message == 'success') {
                    //message('!', 'success');
                    msgThenRedirect("New Animal added successfully!",'success',"livestock2/"+resp.data);
                    formModalClose(addModal,$("#addCattleForm"));
                    return;
                }
                msg(resp.message,'error');
                                
            },
            error: function(xhr, status, error) {
                res(xhr.responseText);
    
            }
        });
    });

    $(document).on('click','#add-btn',function(e){
        e.preventDefault();
        resetForm($('#editAnimalVaccineForm'));

        let vacStatus = $(this).attr('data-current-vaccination-status');
        let animal_ID = $(this).attr('data-id');
        

        $('#vaccination_status').val(vacStatus);
        $('#vaccineAnimalIdInput').val(animal_ID);

        $('#addVaccinationModal').modal('show');

    });

    $(document).on('change','#select-schedule',function(e){
        e.preventDefault();

       

        let schedule_ID = $(this).val();
        let animal_id = $('#vaccineAnimalIdInput').val();
        $url = baseUrl + "action=getScheduleData";

        res(animal_id)

        AjaxPost(
            $url,
            'POST',
           {schedule_id : schedule_ID, animal_id : animal_id},
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

                $('#vaccine-name').val(response.data.vaccine_name);
                $("#vaccine-description").val(response.data.description);
                $('#vaccine-card-id').val(response.data.vaccine_card_id);
                $('#vaccine-qty-request').val(response.data.req_qty);
                $('#DATE').val(response.data.event_date);
    
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );

    });

    $('#editAnimalVaccineForm').submit(function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + "action=addAnimalVaccine";

        AjaxPost(
            $url,
            'POST',
            Data,
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
    
                message('Animal Vaccination Added Successfully!','success');
                formModalClose(addModal,$('#editAnimalVaccineForm'));
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );

    });
     
});