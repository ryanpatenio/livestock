$(document).ready(function(){

    const addModal = $('#addModal');
    const editModal = $('#editModal');

    $('#addCategoryForm').submit(function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + 'action=addCategory';

        AjaxPost(
            $url,
            'POST',
            Data,
            function(){
                logs(true);
                loader(true);
            },
    
            function(response){
              //  res(response);
    
                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
                message(response.message,'success');
               formModalClose(addModal,$('#addCategoryForm'));
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );

    });

    $(document).on('click','#edit-btn',function(e){
        e.preventDefault();

        resetForm($('#updateCategoryForm'));

        let cat_id = $(this).attr('data-id');
        $url = baseUrl + 'action=getCategory';

        AjaxPost(
            $url,
            'POST',
            {cat_id : cat_id},
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
                $('#cat-id').val(response.data[0].category_id);

                $('#category-name').val(response.data[0].category_name);

                editModal.modal('show');
            },
    
            function(){
                logs(false);
                loader(false);
            }
        );

        

    });

    $('#updateCategoryForm').submit(function(e){
        e.preventDefault();

        let Data = $(this).serialize();
        $url = baseUrl + 'action=updateCategory';

        swalMessage('custom','Are you sure you want to update this Selected Category?',function(){
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
                   formModalClose(editModal,$('#updateCategoryForm'));
                
                },
        
                function(){
                    logs(false);
                    loader(false);
                }
            );

        });

    });

});