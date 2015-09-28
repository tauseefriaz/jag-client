$(document).ready(function() {
    
    $(mainFormID).ajaxForm({
        beforeSubmit : function() { 
            return $(mainFormID).validate({
                ignore: ":hidden:not(select)" ,
                rules: {
                    first_name: {
                        required: true,
                        minlength:2
                    }, 
                    last_name: {
                        required: true,
                        minlength:2
                    },
                    mobile_number: {
                        number:true,
                        required: function(element) {
                            return $("#phone_number").val() < 3;
                        },
                        minlength:5
                    }
                },
                errorClass: 'form-field-required',  
                errorPlacement: function(error, element) {		
                }
            }).form() ;
        },
        //target: '#returned-form-message',
        success: function(data) {
            var returnData = data.split('|');
            
            if(returnData[0] && returnData[1]){
               $(messageField).html('Profile Successfully Updated').fadeIn('fast').delay(3000).fadeOut("slow");
            }
            
        }
    }); 
    
});

        