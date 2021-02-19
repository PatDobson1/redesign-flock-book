
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
                    // -- Populate inputs and textareas --
                        for( var key in returnedData){
                            var input = form + ' [name=' + key + ']';
                            $(input).val(returnedData[key]);
                        }
                    // -- Set selected value for dropdowns --
                        switch(returnedData.context){
                            case 'editBreed':
                                $('select[name=species]').val(returnedData.species);
                            break;
                        }
                    $('.js_showForm').fadeOut(300,function(){
                        $(form).slideDown(500);
                    });
                });
            });
        // ---------------------------------------------------------------------

        // -- Delete -----------------------------------------------------------
            $(document).on('click', '.js-delete', function(e){
                e.stopPropagation();
                var deletetype = $(this).data('deletetype');
                var deleteid = $(this).data('id');
                switch(deletetype){
                    case 'species':
                        $modal_content = '<h2>Delete species</h2>' +
                                         '<p>Are you sure you want to delete this species?</p><p>Deleting is permanent and cannot be undone</p>' +
                                         '<form class="js_form" data-action="delete_species">' +
                                         '<input type="hidden" name="id" value="' + deleteid + '" />' +
                                         '<input type="submit" value="Confirm" class="form_btn" />' +
                                         '</form>' +
                                         '<button class="js_closeModal btn_right" />Cancel</button>';
                    break;
                    case 'breed':
                        $modal_content = '<h2>Delete breed</h2>' +
                                         '<p>Are you sure you want to delete this breed?</p><p>Deleting is permanent and cannot be undone</p>' +
                                         '<form class="js_form" data-action="delete_breed">' +
                                         '<input type="hidden" name="id" value="' + deleteid + '" />' +
                                         '<input type="submit" value="Confirm" class="form_btn" />' +
                                         '</form>' +
                                         '<button class="js_closeModal btn_right" />Cancel</button>';
                    break;
                }
                openModal($modal_content);
            })
        // ---------------------------------------------------------------------

        // -- Form - add -------------------------------------------------------
            var processSubmit = function(data){
                var returnedData = JSON.parse(data);
                switch(returnedData.action){
                    case 'speciesAdded':
                        var newRow = "<tr><td class='left'>" + returnedData.name + "</td><td>0</td><td>0</td><td>0</td><td></td></tr>";
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
                    case 'speciesDeleted':
                        var target = $('[data-editid="' + returnedData.id + '"]');
                        target.remove();
                        displayMessage("Species deleted");
                        break;
                    case 'breedAdded':
                        var newRow ="<tr><td class='left'>" + returnedData.name + "</td><td class='left'>"  + returnedData.species + "</td><td>0</td><td>0</td><td>0</td><td></td></tr>";
                        $('.simple_breed_table').append(newRow);
                        $('.add_breed').slideUp(500,function(){
                            displayMessage("The new breed has been added");
                            $('form')[0].reset();
                            $('.js_showForm').show();
                        });
                        break;
                    case 'breedEdited':
                        var target = $('[data-editid="' + returnedData.id + '"]');
                        $('.edit_breed').slideUp(500,function(){
                            target.find('td:first-child').html(returnedData.name);
                            target.find('td:last-child').html(returnedData.species);
                            target.addClass('edited');
                            displayMessage("Breed edited");
                            $('form')[0].reset();
                            $('.js_showForm').show();
                            setTimeout(function(){
                                target.removeClass('edited');
                            },7000);
                        });
                        break;
                    case 'breedDeleted':
                        var target = $('[data-editid="' + returnedData.id + '"]');
                        target.remove();
                        displayMessage("Breed deleted");
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

$(document).ready(function(){

    hostname = 'http://' + window.location.hostname + '/redesign-flock-book/';
    applySorting();
    form_functions();
    general();

})

var general = function(){

    // -- Modal close ----------------------------------------------------------
        $('.modalFade, .modal::before, .js_closeModal').on('click', function(){
            closeModal();
        })
    // -------------------------------------------------------------------------

    // -- View -----------------------------------------------------------------
        $(document).on('click','.js-view',function(){
            var id = $(this).data('id');
            window.location.href = '?id=' + id;
        })
    // -------------------------------------------------------------------------

    // -- Quick view -----------------------------------------------------------
        $(document).on('click','.js-quickView',function(e){
            e.stopPropagation();
            var id = $(this).data('id');
            var payload = { id: id, table: 'quickView' };
            var apiUrl = hostname + 'data_get.php';
            $.post(apiUrl,payload,function(data){
                openModal('<h2>Quick view</h2>' + data);
            })
        })
    // -------------------------------------------------------------------------

    // -- Family tree ----------------------------------------------------------
        if( $('.family_tree').length !== 0 ){
            $('.family_tree').html("'f a m i l y  t r e e'");
            var payload = { id: 123, table: 'familyTree' };
            var apiUrl = hostname + 'data_get.php';
			var id = $('.family_tree').data('id');
            $.post(apiUrl,payload,function(data){
                // -- Parse data -> JSON --------
                    var data = $.parseJSON(data);
                // ------------------------------
				var list = createSheepHTML(data, id);
				$('.family_tree').html( '<ul>' + list + '</ul>' );
            })
        }
    // -------------------------------------------------------------------------

}

// -- Apply sorting to all tables ------------------------------------------
    var applySorting = function(){
        if( $('table').hasClass('sortable') ){
            $('table th').addClass('sortThis');
            $('table th.no_sort').removeClass('sortThis');
            var getCellValue = function(tr, idx){ return tr.children[idx].innerText || tr.children[idx].textContent; }

            var comparer = function(idx, asc) { return function(a, b) { return function(v1, v2) {
                    return v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2);
                }(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));
            }};

            Array.prototype.slice.call(document.querySelectorAll('th.sortThis')).forEach(function(th) { th.addEventListener('click', function() {
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

// -- Open/close modal -----------------------------------------------------
    var openModal = function(modal_content){
        $('body').addClass('no_scroll');
        $('.modal').empty().append(modal_content);
        $('.modalFade').fadeIn(400, function(){
            $('.modal').fadeIn(300);
        });
    }
    var closeModal = function(){
        $('.modal').fadeOut(200, function(){
            $('.modalFade').fadeOut(100);
            $('body').removeClass('no_scroll');
        })
    }
// -------------------------------------------------------------------------

// -- Create the HTML list for family tree ---------------------------- //
    function createSheepHTML(sheep,id) {
        var s = getSheep(sheep,id), out, gender, historic;
        if (s) {
            gender = s.gender == 1 ? 'ram' : 'ewe';
            deadAlive = s.date_of_death == null ? 'alive' : 'dead';
            out = "<li>";
                out += "<div class='" + gender + " js-view' data-id='" + s.id + "'>";
                    out += "<span class='status " + deadAlive + "'></span>";
                    out += "<span><p>" + s.livestock_name + "</p><p>" + s.uk_tag_no + "</p></span>";
                    out += "<a class='icon icon_quickView js-quickView' data-id='" + s.id + "'></a>";
                out += "</div>";
            if (s.mother || s.father) {
                out += "<ul>";
                    if (s.mother) {
                        out += createSheepHTML(sheep,s.mother);
                    }
                    if (s.father) {
                        out += createSheepHTML(sheep,s.father);
                    }
                    out += "</ul>";
            }
            out += "</li>";
            return out;
        }
    }
// -------------------------------------------------------------------- //

// -- Get a single sheep ---------------------------------------------- //
    function getSheep(data,id){
        for( var i=0; i<data.length; i++ ){
            if( data[i].id == id ){
                sheep = data[i];
            }
        }
        return sheep;
    }
// -------------------------------------------------------------------- //


// -- Form validation ----------------------------------------------------------

    var form_validation = function(form_name){

        var formValid = true;
        $('.error_message').remove();
        $('.error').removeClass('error');
        var form = 'form[name="' + form_name + '"] input';
        $(form).each(function(){
            var validation = $(this).data('validation')
            var input = $(this);
            if( typeof validation != 'undefined' ){
                validation = validation.split(',');
                value = input.val();
                validation.forEach(function(item,index){
                    if( item === 'required' && value == '' ){
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
