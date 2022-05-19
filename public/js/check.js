$(document).on('change', 'form select', function(){

    var class_id = $('#class_id').val();
    var group_id = $('#group_id').val();
    var _token = $('input[name="_token"]').val();
    if(class_id != '' && group_id != ''){    
        $.ajax({
            url:"find",
            method:"POST",
            data:{class_id:class_id, group_id:group_id, _token:_token},
            success:function(result)
            {
                $('#select_result').html(result);
            }

        });
    }else{
        $('#select_result').html('');
    }
});

