
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

$(document).ready(function(){

    applySorting();
    form_functions();
    
})

// -- Apply sorting to all tables ------------------------------------------
    var applySorting = function(){
        if( $('table').hasClass('sortable') ){
            var getCellValue = function(tr, idx){ return tr.children[idx].innerText || tr.children[idx].textContent; }

            var comparer = function(idx, asc) { return function(a, b) { return function(v1, v2) {
                    return v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2);
                }(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));
            }};

            Array.prototype.slice.call(document.querySelectorAll('th')).forEach(function(th) { th.addEventListener('click', function() {
                    var table = th.parentNode
                    while(table.tagName.toUpperCase() != 'TABLE') table = table.parentNode;
                    Array.prototype.slice.call(table.querySelectorAll('tr:nth-child(n+2)'))
                        .sort(comparer(Array.prototype.slice.call(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                        .forEach(function(tr) { table.appendChild(tr) });
                })
            });
        }
    }
// -------------------------------------------------------------------------
