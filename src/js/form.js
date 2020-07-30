
// -- Form functions -----------------------------------------------------------

    var form_functions = function(){

        // -- Submit a form ----------------------------------------------------
            $(document).on('submit','.js_form',function(e){
                e.preventDefault();
                var formValid = form_validation();
                if( formValid ){
                    var payload = {
                        action: $(this).data('action'),
                        formData: $(this).serializeArray()
                    }
                    $.post('http://localhost/redesign-flock-book/form_process.php', payload, function(data){
                        processAdd(data);
                    });
                }
            });
        // ---------------------------------------------------------------------

        // -- Display forms ----------------------------------------------------
            $(document).on('click','.js_showForm',function(){
                var form = '.' + $(this).data('form');
                $(this).fadeOut(300,function(){
                    $(form).slideDown(500);
                });
            })
        // ---------------------------------------------------------------------

        // -- Form - add -------------------------------------------------------
            var processAdd = function(data){
                var returnedData = JSON.parse(data);
                switch(returnedData.action){
                    case 'speciesAdded':
                        var newRow = "<tr><td class='left'>" + returnedData.name + "</td><td>0</td><td>0</td><td>0</td></tr>";
                        $('.species_table').append(newRow);
                        $('.add_species').slideUp(500,function(){
                            displayMessage("The new species has been added");
                            $('form')[0].reset();
                            $('.js_showForm').show();
                        });
                        break;
                }
            }
        // ---------------------------------------------------------------------

        // -- Display message --------------------------------------------------
            var displayMessage = function(message){
                $('body').prepend('<div class="message">' + message + '</div>');
                $("html, body").animate({ scrollTop: 0 }, 500, function(){
                    $('.message').animate({top: '0px'},500,function(){
                        $('.message').delay(5000).animate({top: '-200px'},1000);
                    });
                });
            }
        // ---------------------------------------------------------------------
    }

// -----------------------------------------------------------------------------
