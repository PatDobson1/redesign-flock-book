
// -- Form functions -----------------------------------------------------------

    var form_functions = function(){

        // -- Submit a form ----------------------------------------------------
            $(document).on('submit','.js_form',function(e){
                e.preventDefault();
                var payload = {
                    action: $(this).data('action'),
                    formData: $(this).serializeArray()
                }
                $.post('http://localhost/redesign-flock-book/form_process.php', payload, function(data){
                    processAdd(data);
                });
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

        var processAdd = function(data){
            var returnedData = JSON.parse(data);
            switch(returnedData.action){
                case 'speciesAdded':
                    var newRow = "<tr><td class='left'>" + returnedData.name + "</td><td>0</td><td>0</td><td>0</td></tr>";
                    $('body').prepend('<div class="message">The new species has been added</div>');
                    $('.species_table').append(newRow);
                    $("html, body").animate({ scrollTop: 0 }, 500, function(){
                        $('.message').animate({top: '0px'},500,function(){
                            $('.add_species').slideUp(500,function(){
                                $('.js_showForm').show();
                                $('form[name=add_species]')[0].reset();
                                $('.message').delay(7000).animate({top: '-200px'},500);
                            });
                        });
                    });
                    break;
            }
        }
    }

// -----------------------------------------------------------------------------
