$(document).ready(function(){
    
const addModal = $('#addVaccinationModal');
const viewModal = $('#viewModal');

$('#clientTBL').dataTable({
            

});

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

        swalMessage('custom','Are you sure you want to update this Vaccination in this Animal?',function(){
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

    $(document).on('click','#view-btn',function(e){
        e.preventDefault();

        const tableBody = $('#tbl-data tbody');
        tableBody.empty();

        $url = baseUrl + "action=getAnimalDetails";

        AjaxPost(
            $url,
            'POST',
            {animal_id : $(this).attr('data-id')},
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
                //no data found or no vaccine Details yet for this selected animals
                if(response.message == "NODF"){
                    viewModal.modal('show');
                    return;
                }

                $('#vaccine-id').text(response.data.tbl_head[0].VACCINE_CARD_ID);
                $('#animal-type').text(response.data.tbl_head[0].ANIMALTYPE);
                
                //populate the table
                response.data.tbl_data.forEach((item, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td> <!-- Counter -->
                            <td>${item.VACCINE_NAME}</td>
                            <td>${item.QTY_USED}</td>
                            <td>${item.EVENT_DATE}</td>
                        </tr>
                    `;
                    tableBody.append(row); // Append each row to the table's tbody
                });

                viewModal.modal('show');
           
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );


       

    });
     
});