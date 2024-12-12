$(document).ready(function(){
const addModal = $('#AddCattleModal');


$(document).on('submit','#addCattleForm',function(e){
    e.preventDefault();

    $url = baseUrl + "action=addCattle";
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
                formModalClose(addModal,"#addCattleForm");
                return;
            }
            msg(resp.message,'error');
                              
        },
        error: function(xhr, status, error) {
            res(xhr.responseText);
  
        }
    });

   

});

});