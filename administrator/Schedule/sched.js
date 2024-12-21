$(document).ready(function(){

    $('#main').css('filter', 'none');
    $('#loader').hide();

    const addModal = $('#Add_scheduleModal');

    $('#clientTbl').dataTable({

    });
    $('#schedTable').dataTable({

    });


    $(document).on('submit','#addScheduleForm',function(e){
        e.preventDefault();
        
        let Data = $(this).serialize();
        $url = baseUrl + "action=addSchedule";

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
    
                message('New Schedule added successfully!','success');
                formModalClose(addModal,$('#addScheduleForm'));
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );
    
    });
    
   

    $(document).on('submit','#editRequirementsForm',function(e){
        e.preventDefault();
        
        let Data = $(this).serialize();
        $url = baseUrl + "action=updateRequirements";

       
      swalMessage('custom','Are you sure you want to update this Requirement?',function(){
        AjaxPost(
            $url,
            'POST',
            Data,
            function(){
                logs(true);
            },

            function(response){
               // res(response);

                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }

                message(response.message,'success');
                formModalClose(addModal,$('#editRequirementsForm'));
            },

            function(){
                logs(false);
            }
        );


    });
    });

});