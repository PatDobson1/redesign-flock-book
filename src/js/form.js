
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

        // -- Filter livestock -------------------------------------------------
            $(document).on('submit', '.js_filter', function(e){
                e.preventDefault();
                var breed = $('select[name=breed_filter]').val();
                var species = $('select[name=species_filter]').val();
                var year = $('select[name=year_filter]').val();
                $('.livestock_table').find('tr').each(function(i){
                    $(this).show();
                    var displayed_year = $(this).find('td:nth-child(3)').text();
                    displayed_year = displayed_year.slice(0,4);
                    if( breed != 'null' && $(this).find('td:nth-child(5)').text() != breed && i > 0){
                        $(this).hide();
                    }
                    if( species != 'null' && $(this).find('td:nth-child(4)').text() != species && i > 0 ){
                        $(this).hide();
                    }
                    if( year != 'null' && displayed_year != year && i > 0 ){
                        $(this).hide();
                    }
                })
            })
        // ---------------------------------------------------------------------

        // -- Display forms ----------------------------------------------------
            $(document).on('click','.js_showForm',function(){
                var form = '.' + $(this).data('form');
                $(this).slideUp(300,function(){
                    $(form).slideDown(500,function(){
                        $('body').animate({
                            scrollTop: $(form).offset().top
                        }, 500);
                    });
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

        // -- Display form on click 'edit' button ------------------------------
            $(document).on('click','.js_edit_btn',function(){
                var id = $(this).data('editid');
                var type = $(this).data('edittype');
                var form = '.' + $(this).data('form');
                var payload = { id: id, table: type };
                var apiUrl = hostname + 'data_get.php';
                $.post(apiUrl,payload,function(data){
                    var returnedData = JSON.parse(data);
                    // -- Populate inputs and textareas --
                        for( var key in returnedData){
                            if( key == 'home_bred' || key == 'for_slaughter'){
                                var input = form + ' [name=' + key + ']';
                                if(returnedData[key] == 1){
                                    $(input).prop('checked',true);
                                }
                            }else{
                                var input = form + ' [name=' + key + ']';
                                $(input).val(returnedData[key]);
                            }
                        }
                        if( type === 'livestock' ){
                            var payload = {
                                species: returnedData.species,
                                class_name: 'getBreeds',
                                return_action: 'editLivestock_breedList'
                            }
                            callClass(payload,returnedData);
                            var payload = {
                                species: returnedData.species,
                                class_name: 'getMothersList',
                                return_action: 'editLivestock_motherList'
                            }
                            callClass(payload,returnedData);
                            var payload = {
                                species: returnedData.species,
                                class_name: 'getFathersList',
                                return_action: 'editLivestock_fatherList'
                            }
                            callClass(payload,returnedData);
                        }
                    $('.js_edit_btn').fadeOut(300,function(){
                        $(form).slideDown(500);
                        $('body').animate({
                            scrollTop: $(form).offset().top
                        }, 500);
                    });
                });

            })
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
                    case 'livestock':
                        $modal_content = '<h2>Delete livestock</h2>' +
                                         '<p>Are you sure you want to delete this livestock?</p><p>Deleting is permanent and cannot be undone</p>' +
                                         '<form class="js_form" data-action="delete_livestock">' +
                                         '<input type="hidden" name="id" value="' + deleteid + '" />' +
                                         '<input type="submit" value="Confirm" class="form_btn" />' +
                                         '</form>' +
                                         '<button class="js_closeModal btn_right" />Cancel</button>';
                    break;
                    case 'supplier':
                        $modal_content = '<h2>Delete supplier</h2>' +
                                         '<p>Are you sure you want to delete this supplier?</p><p>Deleting is permanent and cannot be undone</p>' +
                                         '<form class="js_form" data-action="delete_supplier">' +
                                         '<input type="hidden" name="id" value="' + deleteid + '" />' +
                                         '<input type="submit" value="Confirm" class="form_btn" />' +
                                         '</form>' +
                                         '<button class="js_closeModal btn_right" />Cancel</button>';
                    break;
                }
                openModal($modal_content);
            })
        // ---------------------------------------------------------------------

        // -- Process form submit ----------------------------------------------
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
                    case 'livestockFreeTextSearch':
                        $('.search_results').html(returnedData.html).slideDown();
                        applySorting();
                        break;
                    case 'livestockFiltered':
                        $('.livestock_data').empty().append(returnedData.filter).append(returnedData.html);
                        applySorting();
                        break;
                    case 'livestockAdded':
                        var DOB = returnedData.date_of_birth == null ? '' : returnedData.date_of_birth;
                        var newRow = "<tr class='edited'><td class='left'>" + returnedData.uk_tag_no + "</td><td class='left'>" + returnedData.livestock_name + "</td><td class='cen'>" + DOB +"</td><td class='left'>" + returnedData.species + "</td><td class='left'>" + returnedData.breed + "</td><td></td></tr>";
                        $('.livestock_table').find('tr:first-child').after(newRow);
                        $('form')[2].reset();
                        displayMessage("Livestock edited");
                        $('.add_livestock').slideUp();
                        $('.js_showForm').show();
                        setTimeout(function(){
                            $('.edited').removeClass('edited');
                        },7000);
                        break;
                    case 'livestockEdited':
                        $('.edit_livestock').slideUp();
                        $('.js_edit_btn').show();
                        $('form')[0].reset();
                        displayMessage("Livestock edited");
                        var payload = {
                            id: returnedData.id,
                            class_name: 'livestockEdited',
                            return_action: 'livestockEdited'
                        }
                        callClass(payload,'');
                        break;
                    case 'livestockDeleted':
                        window.location.replace(returnedData.site_root + '/livestock?ld=true');
                        break;
                    case 'supplierAdded':
                        $('.add_supplier').slideUp();
                        $('.js_showForm').show();
                        $('form')[0].reset();
                        var newRow = '<tr data-id="4" class="js-view"><td class="left">' + returnedData.supplier_name + '</td><td class="left">' + returnedData.supplies + '</td><td class="left">' + returnedData.telephone + '</td><td class="cen">' + returnedData.email + '</td><td class="cen">' + returnedData.website + '</td><td></td></tr>';
                        $('.suppliers_table').find('tr:first-child').after(newRow);
                        displayMessage("Supplier added");
                        break;
                    case 'supplierEdited':
                        $('.edit_supplier').slideUp();
                        $('.js_edit_btn').show();
                        $('form')[0].reset();
                        displayMessage("Supplier edited");
                        var payload = {
                            id: returnedData.id,
                            class_name: 'supplierEdited',
                            return_action: 'supplierEdited'
                        }
                        callClass(payload,'');
                        break;
                    case 'supplierDeleted':
                        var target = $('[data-id="' + returnedData.id + '"]');
                        target.remove();
                        displayMessage("Supplier deleted");
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

        // -- Filters ----------------------------------------------------------
            $(document).on('change', '.js-filter select', function(){
                $(this).closest('form').submit();
            })
            $(document).on('click','.js_clearFilters',function(){
                $(this).closest('form').find('select').val('null');
                $(this).closest('form').submit();
            })
        // ---------------------------------------------------------------------

        // -- Add livestock ----------------------------------------------------
            $(document).on('change', '.add_livestock select[name=species], .edit_livestock select[name=species]', function(){
                var species = $(this).val();
                var payload = {
                    species: $(this).val(),
                    class_name: 'getBreeds',
                    return_action: 'addLivestock_breedList'
                }
                callClass(payload,'');
                var payload = {
                    species: $(this).val(),
                    class_name: 'getMothersList',
                    return_action: 'addLivestock_motherList'
                }
                callClass(payload,'');
                var payload = {
                    species: $(this).val(),
                    class_name: 'getFathersList',
                    return_action: 'addLivestock_fatherList'
                }
                callClass(payload,'');
            })
        // ---------------------------------------------------------------------

        // -- Display message after livestock deletion -------------------------
            if( getUrlParameter('ld') ){
                displayMessage('Livestock deleted');
            }
        // ---------------------------------------------------------------------
    }

// -----------------------------------------------------------------------------
