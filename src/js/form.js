
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
                    console.log("---");
                    console.log(data);
                    console.log("---");
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

    }

// -----------------------------------------------------------------------------
