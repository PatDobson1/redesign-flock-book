
// -- Form functions -----------------------------------------------------------

    var form_functions = function(){

        // -- Submit a form ----------------------------------------------------
            $(document).on('submit','.js_form',function(e){
                e.preventDefault();
                var form = $(this).prop('name');
                var formValid = form_validation(form);
                if( formValid ){
                    var payload = {
                        action: $(this).data('action'),
                        formData: $(this).serializeArray()
                    }
                    var apiUrl = hostname + 'form_process.php';
                    $.post(apiUrl, payload, function(data){
                        processSubmit(data);
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

        // -- Display form on click on 'edit' row ------------------------------
            $(document).on('click','.js_edit',function(){
                $('.form_container').hide();
                var id = $(this).data('editid');
                var form = '.' + $(this).data('form');
                var table = $(this).data('table');
                var payload = { id: id, table: table };
                var apiUrl = hostname + 'data_get.php';

                $.post(apiUrl,payload,function(data){
                    var returnedData = JSON.parse(data);
                    for( var key in returnedData){
                        var input = form + ' [name=' + key + ']';
                        $(input).val(returnedData[key]);
                    }
                    $('.js_showForm').fadeOut(300,function(){
                        $(form).slideDown(500);
                    });
                });
            });
        // ---------------------------------------------------------------------

        // -- Form - add -------------------------------------------------------
            var processSubmit = function(data){
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
                    case 'speciesEdited':
                        var target = $('[data-editid="' + returnedData.id + '"]');
                        $('.edit_species').slideUp(500,function(){
                            target.find('td:first-child').html(returnedData.species);
                            target.addClass('edited');
                            displayMessage("Species edited");
                            $('form')[0].reset();
                            $('.js_showForm').show();
                            setTimeout(function(){
                                target.removeClass('edited');
                            },7000);
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
                        $('.message').delay(5000).animate({top: '-200px'},1000,function(){
                            $('.message').remove();
                        });
                    });
                });
            }
        // ---------------------------------------------------------------------
    }

// -----------------------------------------------------------------------------
