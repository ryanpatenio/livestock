$(document).ready(function(){

    $('#main').css('filter', 'none');
    $('#loader').hide();
 
   

    const addModal = $('#Add_scheduleModal');

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

    $(document).on('submit','#approveScheduleForm',function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + "action=approveSchedule";

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

                message(response.message,'success');
                formModalClose(addModal,$('#approveScheduleForm'));
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );
        
       

    });

    $('#editRequirementsForm').submit(function(e){
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