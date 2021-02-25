
// -- Form validation ----------------------------------------------------------

    var form_validation = function(form_name){

        var formValid = true;
        $('.error_message').remove();
        $('.error').removeClass('error');
        var form = 'form[name="' + form_name + '"] input, form[name="' + form_name + '"] select';
        $(form).each(function(){
            var validation = $(this).data('validation')
            var input = $(this);
            if( typeof validation != 'undefined' ){
                validation = validation.split(',');
                value = input.val();
                validation.forEach(function(item,index){
                    if( item === 'required' && (value == '' || value == 'null') ){
                        formValid = false;
                        input.addClass('error').after('<span class="error_message">' + input.data('errormessage') + '</span>');
                    }
                    if( item === 'number' && (isNaN(value) || value == '') ){
                        formValid = false;
                        input.addClass('error').after('<span class="error_message">Please enter only numbers</span>');
                    }
                });
            }
        });
        return formValid;

    };

// -----------------------------------------------------------------------------
