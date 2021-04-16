
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
                if( $('.livestock_table').is(':visible') ){
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
                    });
                }else{
                    $('.livestock_data .mobile_table').find('tbody').each(function(){
                        $(this).show();
                        var displayed_year = ($(this).find('tr:nth-child(3) td').text()).slice(3);
                        var displayed_breed = ($(this).find('tr:nth-child(5) td').text()).slice(5);
                        var displayed_species = ($(this).find('tr:nth-child(4) td').text()).slice(7);
                        if( breed != 'null' && displayed_breed != breed){
                            $(this).hide();
                        }
                        if( species != 'null' && displayed_species != species ){
                            $(this).hide();
                        }
                        if( year != 'null' && displayed_year != year ){
                            $(this).hide();
                        }
                    });
                }
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
                        $(form).slideDown(500,function(){
                            $('body').animate({
                                scrollTop: $(form).offset().top
                            }, 500);
                        });
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
                        if( type === 'diary' ){
                            var livestock = returnedData.livestock.split(',');
                            var medicine = returnedData.medicine.split(',');
                            var manual_treatment = returnedData.manual_treatment.split(',');
                            $('select[name=medicine]').val(medicine);
                            $('select[name=manual_treatment]').val(manual_treatment);
                            for( var i=0; i<livestock.length; i++ ){
                                $('#livestockSource').find('option[value="' + livestock[i] + '"]').clone().appendTo('#livestockSelected');
                                $('#livestockSource').find('option[value="' + livestock[i] + '"]').remove();
                            }
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

        // -- Finished feed link -----------------------------------------------
            $(document).on('click', '.js-finish', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                var type = $(this).data('type');
                if( type == 'feed' ){
                    $modal_content = '<h2>Mark feed as finished</h2>' +
                                     '<p>Are you sure you want to mark this feed as finished?</p>' +
                                     '<p>Finished date will be todays date.</p>' +
                                     '<p>To set another date, please edit the feed.</p>' +
                                     '<form class="js_form" data-action="finish_feed">' +
                                     '<input type="hidden" name="id" value="' + id + '" />' +
                                     '<input type="submit" value="Confirm" class="form_btn" />' +
                                     '</form>' +
                                     '<button class="js_closeModal btn_right" />Cancel</button>';
                 }else if( type == 'medicine' ){
                     $modal_content = '<h2>Mark medicine as finished</h2>' +
                                      '<p>Are you sure you want to mark this medicine as finished?</p>' +
                                      '<p>Finished date will be todays date.</p>' +
                                      '<p>To set another date, please edit the medicine.</p>' +
                                      '<form class="js_form" data-action="finish_medicine">' +
                                      '<input type="hidden" name="id" value="' + id + '" />' +
                                      '<input type="submit" value="Confirm" class="form_btn" />' +
                                      '</form>' +
                                      '<button class="js_closeModal btn_right" />Cancel</button>';
                 }
                 openModal($modal_content);

            })
        // ---------------------------------------------------------------------

        // -- Process form submit ----------------------------------------------
            var processSubmit = function(data){
                var returnedData = JSON.parse(data);
                switch(returnedData.action){

                    // -- Species ----------------------------------------------
                        case 'speciesAdded':
                            var newRow = "<tr><td class='left'>" + returnedData.name + "</td><td>0</td><td>0</td><td>0</td><td></td><td></td></tr>";
                            $('.species_table').append(newRow);
                            $('.add_species').slideUp(500,function(){
                                displayMessage("The new species has been added");
                                $('form')[0].reset();
                                $('.js_showForm').show();
                            });
                        break;
                        case 'speciesEdited':
                            $('.edit_species').slideUp();
                            $('.js_edit_btn').show();
                            $('form')[0].reset();
                            displayMessage("Species edited");
                            var payload = {
                                id: returnedData.id,
                                class_name: 'speciesEdited',
                                return_action: 'speciesEdited'
                            }
                            callClass(payload,'');
                        break;
                        case 'speciesDeleted':
                            var target = $('[data-id="' + returnedData.id + '"]');
                            target.remove();
                            displayMessage("Species deleted");
                        break;
                    // ---------------------------------------------------------

                    // -- Breed ------------------------------------------------
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
                            $('.edit_breed').slideUp();
                            $('.js_edit_btn').show();
                            $('form')[0].reset();
                            displayMessage("Breed edited");
                            var payload = {
                                id: returnedData.id,
                                class_name: 'breedEdited',
                                return_action: 'breedEdited'
                            }
                            callClass(payload,'');
                        break;
                        case 'breedDeleted':
                            var target = $('[data-editid="' + returnedData.id + '"]');
                            target.remove();
                            displayMessage("Breed deleted");
                        break;
                    // ---------------------------------------------------------

                    // -- Search -----------------------------------------------
                        case 'livestockFreeTextSearch':
                            $('.search_results').html(returnedData.html).slideDown();
                            applySorting();
                        break;
                    // ---------------------------------------------------------

                    // -- Livestock --------------------------------------------
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
                            var newRow = '<tr><td class="left">' + returnedData.supplier_name + '</td><td class="left">' + returnedData.supplies + '</td><td class="left">' + returnedData.telephone + '</td><td class="cen">' + returnedData.email + '</td><td class="cen">' + returnedData.website + '</td><td></td></tr>';
                        break;
                        case 'livestockDeleted':
                            window.location.replace(returnedData.site_root + '/livestock?ld=true');
                        break;
                    // ---------------------------------------------------------

                    // -- Supplier ---------------------------------------------
                        case 'supplierAdded':
                            $('.add_supplier').slideUp();
                            $('.js_showForm').show();
                            $('form')[0].reset();
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
                    // ---------------------------------------------------------

                    // -- Feed -------------------------------------------------
                        case 'feedAdded':
                            $('.add_feed').slideUp();
                            $('.js_showForm').show();
                            $('form')[0].reset();
                            displayMessage("Feed added");
                            var purchase_date = returnedData.purchase_date != null ? returnedData.purchase_date : '';
                            var expiration_date = returnedData.expiration_date != null ? returnedData.expiration_date : '';
                            var newRow = '<tr><td>' + returnedData.product_name + '</td><td>' + purchase_date + '</td><td>' + expiration_date + '</td><td>' + returnedData.batch_number +'</td><td></td></tr>';
                            $('.feed_table').find('tr:first-child').after(newRow);
                        break;
                        case 'feedFinished':
                            var target = $('[data-id="' + returnedData.id + '"]');
                            target.remove();
                            displayMessage("Feed marked as finished");
                        break;
                        case 'feedEdited':
                            $('.edit_feed').slideUp();
                            $('.js_edit_btn').slideDown();
                            displayMessage("Feed edited");
                            var payload = {
                                id: returnedData.id,
                                class_name: 'feedEdited',
                                return_action: 'feedEdited'
                            }
                            callClass(payload,'');
                        break;
                    // ---------------------------------------------------------

                    // -- Medicine ---------------------------------------------
                        case 'medicineAdded':
                            $('.add_medicine').slideUp();
                            $('.js_showForm').show();
                            $('form')[0].reset();
                            displayMessage("Medicine added");
                            var purchase_date = returnedData.purchase_date != null ? returnedData.purchase_date : '';
                            var expiry_date = returnedData.expiry_date != null ? returnedData.expiry_date : '';
                            var newRow = '<tr><td>' + returnedData.medicine_name + '</td><td>' + purchase_date + '</td><td>' + expiry_date + '</td><td>' + returnedData.batch_number + '</td><td>' + returnedData.description + '</td><td></td></tr>';
                            $('.medicine_table').find('tr:first-child').after(newRow);
                        break;
                        case 'medicineFinished':
                            var target = $('[data-id="' + returnedData.id + '"]');
                            target.remove();
                            displayMessage("Medicine marked as finished");
                        break;
                        case 'medicineEdited':
                            $('.edit_medicine').slideUp();
                            $('.js_edit_btn').slideDown();
                            displayMessage("Medicine edited");
                            var payload = {
                                id: returnedData.id,
                                class_name: 'medicineEdited',
                                return_action: 'medicineEdited'
                            }
                            callClass(payload,'');

                        break;
                    // ---------------------------------------------------------

                    // -- Manual treatment -------------------------------------
                        case 'treatmentAdded':
                            $('.add_manualTreatment').slideUp();
                            $('.js_showForm').show();
                            $('form')[0].reset();
                            var newRow = "<tr><td class='left'>" + returnedData.treatment_name + "</td><td class='left'>" + returnedData.supplier + "</td><td>£" + returnedData.price + "</td><td></td></tr>";
                            $('.manualTreatment_table').find('tr:first-child').after(newRow);
                            displayMessage("Manual treatment added");
                        break;
                        case 'treatmentEdited':
                            $('.edit_manualTreatment').slideUp();
                            $('.js_edit_btn').slideDown();
                            var payload = {
                                id: returnedData.id,
                                class_name: 'manualTreatmentEdited',
                                return_action: 'manualTreatmentEdited'
                            }
                            callClass(payload, '');
                            displayMessage("Manual treatment edited");
                        break;
                    // ---------------------------------------------------------

                    // -- Diary ------------------------------------------------
                        case 'diaryAdded':
                            $('.add_diary').slideUp();
                            $('.js_showForm').show();
                            $('form')[0].reset();
                            $('#livestockSelected option').each(function(){
                                $(this).clone().appendTo('#livestockSource');
                                $(this).remove();
                            });
                            sort();
                            displayMessage("Diary entry added");
                        break;
                        case 'diaryEdited':
                            $('.edit_diary').slideUp();
                            $('.js_edit_btn').show();
                            $('#livestockSelected option').each(function(){
                                $(this).clone().appendTo('#livestockSource');
                                $(this).remove();
                            });
                            sort();
                            $('form')[0].reset();
                            displayMessage("Diary entry edited");
                            var payload = {
                                id: returnedData.id,
                                class_name: 'diaryEdited',
                                return_action: 'diaryEdited'
                            }
                            callClass(payload,'');
                        break;
                    // ---------------------------------------------------------

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

        // -- Livestock multiselect --------------------------------------------
            jQuery(document).on('click','#livestockSource',function(){
                var selected = jQuery(this).find('option:selected');
                var option = selected.clone();
                selected.remove();
                jQuery('#livestockSelected').append(option);
                sort();
            })
            jQuery(document).on('click','#livestockSelected',function(){
                var selected = jQuery(this).find('option:selected');
                var option = selected.clone();
                jQuery('#livestockSource').append(option).prop('selected',true);
                selected.remove();
                sort();
            })
            jQuery(document).on('click','.addAll',function(){
                var options = jQuery('#livestockSource option').sort().clone();
                jQuery('#livestockSelected').append(options);
                jQuery('#livestockSource option').remove();
                sort();
            })
            jQuery(document).on('click','.removeAll',function(){
                var options = jQuery('#livestockSelected option').sort().clone();
                jQuery('#livestockSource').append(options);
                jQuery('#livestockSelected option').remove();
                sort();
            })
            // -- On submit, make sure #livestockSelected options are marked 'selected' --
            jQuery(document).on('mousedown','form[name=add_diary] input[type=submit], form[name=edit_diary] input[type=submit]',function(){
                var options = jQuery('#livestockSelected option');
                for( var i=0; i<options.length; i++ ){
                  options[i].selected = true;
                }
            })
            // -- Sort multiselect on initial load --
            if( $('#livestockSource').length != 0 ){
                sort();
            }
        // ---------------------------------------------------------------------

        // -- Sort elements in a select box ------------------------------------
            function sort(){
                doSort('livestockSource');
                doSort('livestockSelected');
            }
            function doSort(target){

                var lb = document.getElementById(target);
                arrTexts = [], arrValues = [], arrOldTexts = [];

                for(i=0; i<lb.length; i++)
                {
                    arrTexts[i] = lb.options[i].text;
                    arrValues[i] = lb.options[i].value;
                    arrOldTexts[i] = lb.options[i].text;
                }

                arrTexts.sort(
                  function (a, b) {
                    var _a = a[0].toLowerCase();
                    var _b = b[0].toLowerCase();
                    if (_a < _b) return -1;
                    if (_a > _b) return 1;
                    return 0;
                });

                for(i=0; i<lb.length; i++)
                {
                    lb.options[i].text = arrTexts[i];
                    for(j=0; j<lb.length; j++)
                    {
                        if (arrTexts[i] == arrOldTexts[j])
                        {
                            lb.options[i].value = arrValues[j];
                            j = lb.length;
                        }
                    }
                }
            }
        // ---------------------------------------------------------------------

        // -- Unselect all from multi-dropdowns --------------------------------
            $(document).on('click','.js-unselect',function(){
                $(this).prev().val('');
            });
        // ---------------------------------------------------------------------

    }

// -----------------------------------------------------------------------------

$(document).ready(function(){

    hostname = 'http://' + window.location.hostname + '/redesign-flock-book/';
    applySorting();
    form_functions();
    pikaday();
    general();
    tables();

})

var general = function(){

    // -- Print ----------------------------------------------------------------
        $('.js_print').on('click',function(e){
            e.preventDefault();
            window.print();
        });
    // -------------------------------------------------------------------------

    // -- Mobile menu ----------------------------------------------------------
        $(document).on('click',function(){
            if( $('.mobileMenu').hasClass('open') ){
                $('.mobileMenu').animate({left: '-100%'}).removeClass('open');
                $('.modalFade').hide();
            }
        })
        $(document).on('click','.menuTrigger',function(e){
            e.stopPropagation();
            if( $('.mobileMenu').hasClass('open') ){
                $('.mobileMenu').animate({left: '-100%'}).removeClass('open');
                $('.modalFade').hide();
            }else{
                $('.modalFade').show();
                $('.mobileMenu').animate({left: 0}).addClass('open');
            }

        })
    // -------------------------------------------------------------------------

    // -- Modal close ----------------------------------------------------------
        $('.modalFade, .modal::before, .js_closeModal').on('click', function(){
            closeModal();
        })
    // -------------------------------------------------------------------------

    // -- Scroll to top --------------------------------------------------------
        $(document).on('click','.js-top button',function(){
            $('body').animate({
                scrollTop: $('body').offset().top
            }, 500);
        })
    // -------------------------------------------------------------------------

    // -- View -----------------------------------------------------------------
        $(document).on('click','.js-view',function(){
            var path = $(this).data('path');
            var id = $(this).data('id');
            var destination = path ? path + '/livestock?id=' + id : '?id=' + id;
            window.location.href = destination;
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
        $(document).on('click','.js-diaryQuickView',function(e){
            e.stopPropagation();
            var id = $(this).data('id');
            var payload = { id: id, table: 'diaryQuickView' };
            var apiUrl = hostname + 'data_get.php';
            $.post(apiUrl,payload,function(data){
                openModal('<h2>Quick view</h2>' + data);
            })
        })
    // -------------------------------------------------------------------------

    // -- Table links ----------------------------------------------------------
        $(document).on('click','.tableLink',function(e){
            e.stopPropagation();
        });
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

    // -- Create livestock filters ---------------------------------------------
        if($('.livestockFiltered').length != 0){
            var table = $('.livestockFiltered');

            var species_list = [];
            var breed_list = [];
            var dob_list = [];
            var species_options = '';
            var breed_options = '';
            var dob_options = '';


            table.find('tr').each(function(i){
                if( i > 0 ){
                    var species = $(this).find('td:nth-child(4)').text();
                    var breed = $(this).find('td:nth-child(5)').text();
                    var dobTemp = $(this).find('td:nth-child(3)').text();
                    var dob = dobTemp.slice(0,4);
                    if( species_list.indexOf(species) == -1 ){
                        species_list.push( species );
                    }
                    if( breed_list.indexOf(breed) == -1 ){
                        breed_list.push( breed );
                    }
                    if( dob_list.indexOf(dob) == -1 ){
                        dob_list.push( dob );
                    }
                }
            })

            $.each(species_list, function(index, item){
                species_options += '<option value="' + item + '">' + item + '</option>'
            });
            $.each(breed_list, function(index, item){
                breed_options += '<option value="' + item + '">' + item + '</option>'
            });
            dob_list.sort().reverse();
            $.each(dob_list, function(index, item){
                dob_options += '<option value="' + item + '">' + item + '</option>'
            });

            $('select[name=species_filter]').append(species_options);
            $('select[name=breed_filter]').append(breed_options);
            $('select[name=year_filter]').append(dob_options);
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

// -- Family tree ----------------------------------------------------------
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
// -------------------------------------------------------------------------

// -- Call a PHP class -----------------------------------------------------
    function callClass(payload, otherData){
        var apiUrl = hostname + 'call_class.php';
        $.post(apiUrl, payload, function(data){
            processClassCall(data, otherData);
        });
    }
    function processClassCall(data, otherData){
        var returnedData = JSON.parse(data);
        var action = returnedData.returnAction;
        switch(returnedData.returnAction){
            case 'addLivestock_breedList':
                $('select[name=breed]').empty().html(returnedData.html).attr('disabled',false);
            break;
            case 'addLivestock_motherList':
                $('select[name=mother]').empty().html(returnedData.html).attr('disabled',false);
            break;
            case 'addLivestock_fatherList':
                $('select[name=father]').empty().html(returnedData.html).attr('disabled',false);
            break;
            case 'editLivestock_breedList':
                $('select[name=breed]').empty().html(returnedData.html).val(otherData.breed);
            break;
            case 'editLivestock_motherList':
                var mother = otherData.mother != '0' ? otherData.mother : 'null';
                $('select[name=mother]').empty().html(returnedData.html).val(mother);
            break;
            case 'editLivestock_fatherList':
                var father = otherData.father != '0' ? otherData.father : 'null';
                $('select[name=father]').empty().html(returnedData.html).val(father);
            break;
            case 'speciesEdited':
                $('.controls, .speciesCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'breedEdited':
                $('.controls, .breedCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'livestockEdited':
                $('.controls, .animalCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'supplierEdited':
                $('.controls, .supplierCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'feedEdited':
                $('.controls, .feedCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'medicineEdited':
                $('.controls, .medicineCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'treatmentEdited':
                $('.controls, .manualTreatmentCard').remove();
                $('content').prepend(returnedData.html);
            break;
            case 'diaryEdited':
                $('.controls, .diaryCardSingle').remove();
                $('content').prepend(returnedData.html);
            break;
        }
    }
// -------------------------------------------------------------------------

// -- Get URL parameters ---------------------------------------------------
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };
// -------------------------------------------------------------------------

/*!
 * Pikaday
 *
 * Copyright © 2014 David Bushell | BSD & MIT license | https://github.com/Pikaday/Pikaday
 */

var pikaday = function(){
    (function (root, factory)
    {
        'use strict';

        var moment;
        if (typeof exports === 'object') {
            // CommonJS module
            // Load moment.js as an optional dependency
            try { moment = require('moment'); } catch (e) {}
            module.exports = factory(moment);
        } else if (typeof define === 'function' && define.amd) {
            // AMD. Register as an anonymous module.
            define(function (req)
            {
                // Load moment.js as an optional dependency
                var id = 'moment';
                try { moment = req(id); } catch (e) {}
                return factory(moment);
            });
        } else {
            root.Pikaday = factory(root.moment);
        }
    }(this, function (moment)
    {
        'use strict';

        /**
         * feature detection and helper functions
         */
        var hasMoment = typeof moment === 'function',

        hasEventListeners = !!window.addEventListener,

        document = window.document,

        sto = window.setTimeout,

        addEvent = function(el, e, callback, capture)
        {
            if (hasEventListeners) {
                el.addEventListener(e, callback, !!capture);
            } else {
                el.attachEvent('on' + e, callback);
            }
        },

        removeEvent = function(el, e, callback, capture)
        {
            if (hasEventListeners) {
                el.removeEventListener(e, callback, !!capture);
            } else {
                el.detachEvent('on' + e, callback);
            }
        },

        trim = function(str)
        {
            return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
        },

        hasClass = function(el, cn)
        {
            return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
        },

        addClass = function(el, cn)
        {
            if (!hasClass(el, cn)) {
                el.className = (el.className === '') ? cn : el.className + ' ' + cn;
            }
        },

        removeClass = function(el, cn)
        {
            el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
        },

        isArray = function(obj)
        {
            return (/Array/).test(Object.prototype.toString.call(obj));
        },

        isDate = function(obj)
        {
            return (/Date/).test(Object.prototype.toString.call(obj)) && !isNaN(obj.getTime());
        },

        isWeekend = function(date)
        {
            var day = date.getDay();
            return day === 0 || day === 6;
        },

        isLeapYear = function(year)
        {
            // solution lifted from date.js (MIT license): https://github.com/datejs/Datejs
            return ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0);
        },

        getDaysInMonth = function(year, month)
        {
            return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
        },

        setToStartOfDay = function(date)
        {
            if (isDate(date)) date.setHours(0,0,0,0);
        },

        compareDates = function(a,b)
        {
            // weak date comparison (use setToStartOfDay(date) to ensure correct result)
            return a.getTime() === b.getTime();
        },

        extend = function(to, from, overwrite)
        {
            var prop, hasProp;
            for (prop in from) {
                hasProp = to[prop] !== undefined;
                if (hasProp && typeof from[prop] === 'object' && from[prop] !== null && from[prop].nodeName === undefined) {
                    if (isDate(from[prop])) {
                        if (overwrite) {
                            to[prop] = new Date(from[prop].getTime());
                        }
                    }
                    else if (isArray(from[prop])) {
                        if (overwrite) {
                            to[prop] = from[prop].slice(0);
                        }
                    } else {
                        to[prop] = extend({}, from[prop], overwrite);
                    }
                } else if (overwrite || !hasProp) {
                    to[prop] = from[prop];
                }
            }
            return to;
        },

        fireEvent = function(el, eventName, data)
        {
            var ev;

            if (document.createEvent) {
                ev = document.createEvent('HTMLEvents');
                ev.initEvent(eventName, true, false);
                ev = extend(ev, data);
                el.dispatchEvent(ev);
            } else if (document.createEventObject) {
                ev = document.createEventObject();
                ev = extend(ev, data);
                el.fireEvent('on' + eventName, ev);
            }
        },

        adjustCalendar = function(calendar) {
            if (calendar.month < 0) {
                calendar.year -= Math.ceil(Math.abs(calendar.month)/12);
                calendar.month += 12;
            }
            if (calendar.month > 11) {
                calendar.year += Math.floor(Math.abs(calendar.month)/12);
                calendar.month -= 12;
            }
            return calendar;
        },

        /**
         * defaults and localisation
         */
        defaults = {

            // bind the picker to a form field
            field: null,

            // automatically show/hide the picker on `field` focus (default `true` if `field` is set)
            bound: undefined,

            // data-attribute on the input field with an aria assistance text (only applied when `bound` is set)
            ariaLabel: 'Use the arrow keys to pick a date',

            // position of the datepicker, relative to the field (default to bottom & left)
            // ('bottom' & 'left' keywords are not used, 'top' & 'right' are modifier on the bottom/left position)
            position: 'bottom left',

            // automatically fit in the viewport even if it means repositioning from the position option
            reposition: true,

            // the default output format for `.toString()` and `field` value
            format: 'YYYY-MM-DD',

            // the toString function which gets passed a current date object and format
            // and returns a string
            toString: null,

            // used to create date object from current input string
            parse: null,

            // the initial date to view when first opened
            defaultDate: null,

            // make the `defaultDate` the initial selected value
            setDefaultDate: false,

            // first day of week (0: Sunday, 1: Monday etc)
            firstDay: 0,

            // minimum number of days in the week that gets week number one
            // default ISO 8601, week 01 is the week with the first Thursday (4)
            firstWeekOfYearMinDays: 4,

            // the default flag for moment's strict date parsing
            formatStrict: false,

            // the minimum/earliest date that can be selected
            minDate: null,
            // the maximum/latest date that can be selected
            maxDate: null,

            // number of years either side, or array of upper/lower range
            yearRange: 10,

            // show week numbers at head of row
            showWeekNumber: false,

            // Week picker mode
            pickWholeWeek: false,

            // used internally (don't config outside)
            minYear: 0,
            maxYear: 9999,
            minMonth: undefined,
            maxMonth: undefined,

            startRange: null,
            endRange: null,

            isRTL: false,

            // Additional text to append to the year in the calendar title
            yearSuffix: '',

            // Render the month after year in the calendar title
            showMonthAfterYear: false,

            // Render days of the calendar grid that fall in the next or previous month
            showDaysInNextAndPreviousMonths: false,

            // Allows user to select days that fall in the next or previous month
            enableSelectionDaysInNextAndPreviousMonths: false,

            // how many months are visible
            numberOfMonths: 1,

            // when numberOfMonths is used, this will help you to choose where the main calendar will be (default `left`, can be set to `right`)
            // only used for the first display or when a selected date is not visible
            mainCalendar: 'left',

            // Specify a DOM element to render the calendar in
            container: undefined,

            // Blur field when date is selected
            blurFieldOnSelect : true,

            // internationalization
            i18n: {
                previousMonth : 'Previous Month',
                nextMonth     : 'Next Month',
                months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
                weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
            },

            // Theme Classname
            theme: null,

            // events array
            events: [],

            // callback function
            onSelect: null,
            onOpen: null,
            onClose: null,
            onDraw: null,

            // Enable keyboard input
            keyboardInput: true
        },


        /**
         * templating functions to abstract HTML rendering
         */
        renderDayName = function(opts, day, abbr)
        {
            day += opts.firstDay;
            while (day >= 7) {
                day -= 7;
            }
            return abbr ? opts.i18n.weekdaysShort[day] : opts.i18n.weekdays[day];
        },

        renderDay = function(opts)
        {
            var arr = [];
            var ariaSelected = 'false';
            if (opts.isEmpty) {
                if (opts.showDaysInNextAndPreviousMonths) {
                    arr.push('is-outside-current-month');

                    if(!opts.enableSelectionDaysInNextAndPreviousMonths) {
                        arr.push('is-selection-disabled');
                    }

                } else {
                    return '<td class="is-empty"></td>';
                }
            }
            if (opts.isDisabled) {
                arr.push('is-disabled');
            }
            if (opts.isToday) {
                arr.push('is-today');
            }
            if (opts.isSelected) {
                arr.push('is-selected');
                ariaSelected = 'true';
            }
            if (opts.hasEvent) {
                arr.push('has-event');
            }
            if (opts.isInRange) {
                arr.push('is-inrange');
            }
            if (opts.isStartRange) {
                arr.push('is-startrange');
            }
            if (opts.isEndRange) {
                arr.push('is-endrange');
            }
            return '<td data-day="' + opts.day + '" class="' + arr.join(' ') + '" aria-selected="' + ariaSelected + '">' +
                     '<button class="pika-button pika-day" type="button" ' +
                        'data-pika-year="' + opts.year + '" data-pika-month="' + opts.month + '" data-pika-day="' + opts.day + '">' +
                            opts.day +
                     '</button>' +
                   '</td>';
        },

        isoWeek = function(date, firstWeekOfYearMinDays) {
            // Ensure we're at the start of the day.
            date.setHours(0, 0, 0, 0);

            // Thursday in current week decides the year because January 4th
            // is always in the first week according to ISO8601.
            var yearDay        = date.getDate(),
                weekDay        = date.getDay(),
                dayInFirstWeek = firstWeekOfYearMinDays,
                dayShift       = dayInFirstWeek - 1, // counting starts at 0
                daysPerWeek    = 7,
                prevWeekDay    = function(day) { return (day + daysPerWeek - 1) % daysPerWeek; };

            // Adjust to Thursday in week 1 and count number of weeks from date to week 1.
            date.setDate(yearDay + dayShift - prevWeekDay(weekDay));

            var jan4th      = new Date(date.getFullYear(), 0, dayInFirstWeek),
                msPerDay    = 24 * 60 * 60 * 1000,
                daysBetween = (date.getTime() - jan4th.getTime()) / msPerDay,
                weekNum     = 1 + Math.round((daysBetween - dayShift + prevWeekDay(jan4th.getDay())) / daysPerWeek);

            return weekNum;
        },

        renderWeek = function (d, m, y, firstWeekOfYearMinDays) {
            var date = new Date(y, m, d),
                week = hasMoment ? moment(date).isoWeek() : isoWeek(date, firstWeekOfYearMinDays);

            return '<td class="pika-week">' + week + '</td>';
        },

        renderRow = function(days, isRTL, pickWholeWeek, isRowSelected)
        {
            return '<tr class="pika-row' + (pickWholeWeek ? ' pick-whole-week' : '') + (isRowSelected ? ' is-selected' : '') + '">' + (isRTL ? days.reverse() : days).join('') + '</tr>';
        },

        renderBody = function(rows)
        {
            return '<tbody>' + rows.join('') + '</tbody>';
        },

        renderHead = function(opts)
        {
            var i, arr = [];
            if (opts.showWeekNumber) {
                arr.push('<th></th>');
            }
            for (i = 0; i < 7; i++) {
                arr.push('<th scope="col"><abbr title="' + renderDayName(opts, i) + '">' + renderDayName(opts, i, true) + '</abbr></th>');
            }
            return '<thead><tr>' + (opts.isRTL ? arr.reverse() : arr).join('') + '</tr></thead>';
        },

        renderTitle = function(instance, c, year, month, refYear, randId)
        {
            var i, j, arr,
                opts = instance._o,
                isMinYear = year === opts.minYear,
                isMaxYear = year === opts.maxYear,
                html = '<div id="' + randId + '" class="pika-title" role="heading" aria-live="assertive">',
                monthHtml,
                yearHtml,
                prev = true,
                next = true;

            for (arr = [], i = 0; i < 12; i++) {
                arr.push('<option value="' + (year === refYear ? i - c : 12 + i - c) + '"' +
                    (i === month ? ' selected="selected"': '') +
                    ((isMinYear && i < opts.minMonth) || (isMaxYear && i > opts.maxMonth) ? ' disabled="disabled"' : '') + '>' +
                    opts.i18n.months[i] + '</option>');
            }

            monthHtml = '<div class="pika-label">' + opts.i18n.months[month] + '<select class="pika-select pika-select-month" tabindex="-1">' + arr.join('') + '</select></div>';

            if (isArray(opts.yearRange)) {
                i = opts.yearRange[0];
                j = opts.yearRange[1] + 1;
            } else {
                i = year - opts.yearRange;
                j = 1 + year + opts.yearRange;
            }

            for (arr = []; i < j && i <= opts.maxYear; i++) {
                if (i >= opts.minYear) {
                    arr.push('<option value="' + i + '"' + (i === year ? ' selected="selected"': '') + '>' + (i) + '</option>');
                }
            }
            yearHtml = '<div class="pika-label">' + year + opts.yearSuffix + '<select class="pika-select pika-select-year" tabindex="-1">' + arr.join('') + '</select></div>';

            if (opts.showMonthAfterYear) {
                html += yearHtml + monthHtml;
            } else {
                html += monthHtml + yearHtml;
            }

            if (isMinYear && (month === 0 || opts.minMonth >= month)) {
                prev = false;
            }

            if (isMaxYear && (month === 11 || opts.maxMonth <= month)) {
                next = false;
            }

            if (c === 0) {
                html += '<button class="pika-prev' + (prev ? '' : ' is-disabled') + '" type="button">' + opts.i18n.previousMonth + '</button>';
            }
            if (c === (instance._o.numberOfMonths - 1) ) {
                html += '<button class="pika-next' + (next ? '' : ' is-disabled') + '" type="button">' + opts.i18n.nextMonth + '</button>';
            }

            return html += '</div>';
        },

        renderTable = function(opts, data, randId)
        {
            return '<table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="' + randId + '">' + renderHead(opts) + renderBody(data) + '</table>';
        },


        /**
         * Pikaday constructor
         */
        Pikaday = function(options)
        {
            var self = this,
                opts = self.config(options);

            self._onMouseDown = function(e)
            {
                if (!self._v) {
                    return;
                }
                e = e || window.event;
                var target = e.target || e.srcElement;
                if (!target) {
                    return;
                }

                if (!hasClass(target, 'is-disabled')) {
                    if (hasClass(target, 'pika-button') && !hasClass(target, 'is-empty') && !hasClass(target.parentNode, 'is-disabled')) {
                        self.setDate(new Date(target.getAttribute('data-pika-year'), target.getAttribute('data-pika-month'), target.getAttribute('data-pika-day')));
                        if (opts.bound) {
                            sto(function() {
                                self.hide();
                                if (opts.blurFieldOnSelect && opts.field) {
                                    opts.field.blur();
                                }
                            }, 100);
                        }
                    }
                    else if (hasClass(target, 'pika-prev')) {
                        self.prevMonth();
                    }
                    else if (hasClass(target, 'pika-next')) {
                        self.nextMonth();
                    }
                }
                if (!hasClass(target, 'pika-select')) {
                    // if this is touch event prevent mouse events emulation
                    if (e.preventDefault) {
                        e.preventDefault();
                    } else {
                        e.returnValue = false;
                        return false;
                    }
                } else {
                    self._c = true;
                }
            };

            self._onChange = function(e)
            {
                e = e || window.event;
                var target = e.target || e.srcElement;
                if (!target) {
                    return;
                }
                if (hasClass(target, 'pika-select-month')) {
                    self.gotoMonth(target.value);
                }
                else if (hasClass(target, 'pika-select-year')) {
                    self.gotoYear(target.value);
                }
            };

            self._onKeyChange = function(e)
            {
                e = e || window.event;

                if (self.isVisible()) {

                    switch(e.keyCode){
                        case 13:
                        case 27:
                            if (opts.field) {
                                opts.field.blur();
                            }
                            break;
                        case 37:
                            self.adjustDate('subtract', 1);
                            break;
                        case 38:
                            self.adjustDate('subtract', 7);
                            break;
                        case 39:
                            self.adjustDate('add', 1);
                            break;
                        case 40:
                            self.adjustDate('add', 7);
                            break;
                        case 8:
                        case 46:
                            self.setDate(null);
                            break;
                    }
                }
            };

            self._parseFieldValue = function()
            {
                if (opts.parse) {
                    return opts.parse(opts.field.value, opts.format);
                } else if (hasMoment) {
                    var date = moment(opts.field.value, opts.format, opts.formatStrict);
                    return (date && date.isValid()) ? date.toDate() : null;
                } else {
                    return new Date(Date.parse(opts.field.value));
                }
            };

            self._onInputChange = function(e)
            {
                var date;

                if (e.firedBy === self) {
                    return;
                }
                date = self._parseFieldValue();
                if (isDate(date)) {
                  self.setDate(date);
                }
                if (!self._v) {
                    self.show();
                }
            };

            self._onInputFocus = function()
            {
                self.show();
            };

            self._onInputClick = function()
            {
                self.show();
            };

            self._onInputBlur = function()
            {
                // IE allows pika div to gain focus; catch blur the input field
                var pEl = document.activeElement;
                do {
                    if (hasClass(pEl, 'pika-single')) {
                        return;
                    }
                }
                while ((pEl = pEl.parentNode));

                if (!self._c) {
                    self._b = sto(function() {
                        self.hide();
                    }, 50);
                }
                self._c = false;
            };

            self._onClick = function(e)
            {
                e = e || window.event;
                var target = e.target || e.srcElement,
                    pEl = target;
                if (!target) {
                    return;
                }
                if (!hasEventListeners && hasClass(target, 'pika-select')) {
                    if (!target.onchange) {
                        target.setAttribute('onchange', 'return;');
                        addEvent(target, 'change', self._onChange);
                    }
                }
                do {
                    if (hasClass(pEl, 'pika-single') || pEl === opts.trigger) {
                        return;
                    }
                }
                while ((pEl = pEl.parentNode));
                if (self._v && target !== opts.trigger && pEl !== opts.trigger) {
                    self.hide();
                }
            };

            self.el = document.createElement('div');
            self.el.className = 'pika-single' + (opts.isRTL ? ' is-rtl' : '') + (opts.theme ? ' ' + opts.theme : '');

            addEvent(self.el, 'mousedown', self._onMouseDown, true);
            addEvent(self.el, 'touchend', self._onMouseDown, true);
            addEvent(self.el, 'change', self._onChange);

            if (opts.keyboardInput) {
                addEvent(document, 'keydown', self._onKeyChange);
            }

            if (opts.field) {
                if (opts.container) {
                    opts.container.appendChild(self.el);
                } else if (opts.bound) {
                    document.body.appendChild(self.el);
                } else {
                    opts.field.parentNode.insertBefore(self.el, opts.field.nextSibling);
                }
                addEvent(opts.field, 'change', self._onInputChange);

                if (!opts.defaultDate) {
                    opts.defaultDate = self._parseFieldValue();
                    opts.setDefaultDate = true;
                }
            }

            var defDate = opts.defaultDate;

            if (isDate(defDate)) {
                if (opts.setDefaultDate) {
                    self.setDate(defDate, true);
                } else {
                    self.gotoDate(defDate);
                }
            } else {
                self.gotoDate(new Date());
            }

            if (opts.bound) {
                this.hide();
                self.el.className += ' is-bound';
                addEvent(opts.trigger, 'click', self._onInputClick);
                addEvent(opts.trigger, 'focus', self._onInputFocus);
                addEvent(opts.trigger, 'blur', self._onInputBlur);
            } else {
                this.show();
            }
        };


        /**
         * public Pikaday API
         */
        Pikaday.prototype = {


            /**
             * configure functionality
             */
            config: function(options)
            {
                if (!this._o) {
                    this._o = extend({}, defaults, true);
                }

                var opts = extend(this._o, options, true);

                opts.isRTL = !!opts.isRTL;

                opts.field = (opts.field && opts.field.nodeName) ? opts.field : null;

                opts.theme = (typeof opts.theme) === 'string' && opts.theme ? opts.theme : null;

                opts.bound = !!(opts.bound !== undefined ? opts.field && opts.bound : opts.field);

                opts.trigger = (opts.trigger && opts.trigger.nodeName) ? opts.trigger : opts.field;

                opts.disableWeekends = !!opts.disableWeekends;

                opts.disableDayFn = (typeof opts.disableDayFn) === 'function' ? opts.disableDayFn : null;

                var nom = parseInt(opts.numberOfMonths, 10) || 1;
                opts.numberOfMonths = nom > 4 ? 4 : nom;

                if (!isDate(opts.minDate)) {
                    opts.minDate = false;
                }
                if (!isDate(opts.maxDate)) {
                    opts.maxDate = false;
                }
                if ((opts.minDate && opts.maxDate) && opts.maxDate < opts.minDate) {
                    opts.maxDate = opts.minDate = false;
                }
                if (opts.minDate) {
                    this.setMinDate(opts.minDate);
                }
                if (opts.maxDate) {
                    this.setMaxDate(opts.maxDate);
                }

                if (isArray(opts.yearRange)) {
                    var fallback = new Date().getFullYear() - 10;
                    opts.yearRange[0] = parseInt(opts.yearRange[0], 10) || fallback;
                    opts.yearRange[1] = parseInt(opts.yearRange[1], 10) || fallback;
                } else {
                    opts.yearRange = Math.abs(parseInt(opts.yearRange, 10)) || defaults.yearRange;
                    if (opts.yearRange > 100) {
                        opts.yearRange = 100;
                    }
                }

                return opts;
            },

            /**
             * return a formatted string of the current selection (using Moment.js if available)
             */
            toString: function(format)
            {
                format = format || this._o.format;
                if (!isDate(this._d)) {
                    return '';
                }
                if (this._o.toString) {
                  return this._o.toString(this._d, format);
                }
                if (hasMoment) {
                  return moment(this._d).format(format);
                }
                return this._d.toDateString();
            },

            /**
             * return a Moment.js object of the current selection (if available)
             */
            getMoment: function()
            {
                return hasMoment ? moment(this._d) : null;
            },

            /**
             * set the current selection from a Moment.js object (if available)
             */
            setMoment: function(date, preventOnSelect)
            {
                if (hasMoment && moment.isMoment(date)) {
                    this.setDate(date.toDate(), preventOnSelect);
                }
            },

            /**
             * return a Date object of the current selection
             */
            getDate: function()
            {
                return isDate(this._d) ? new Date(this._d.getTime()) : null;
            },

            /**
             * set the current selection
             */
            setDate: function(date, preventOnSelect)
            {
                if (!date) {
                    this._d = null;

                    if (this._o.field) {
                        this._o.field.value = '';
                        fireEvent(this._o.field, 'change', { firedBy: this });
                    }

                    return this.draw();
                }
                if (typeof date === 'string') {
                    date = new Date(Date.parse(date));
                }
                if (!isDate(date)) {
                    return;
                }

                var min = this._o.minDate,
                    max = this._o.maxDate;

                if (isDate(min) && date < min) {
                    date = min;
                } else if (isDate(max) && date > max) {
                    date = max;
                }

                this._d = new Date(date.getTime());
                setToStartOfDay(this._d);
                this.gotoDate(this._d);

                if (this._o.field) {
                    this._o.field.value = this.toString();
                    fireEvent(this._o.field, 'change', { firedBy: this });
                }
                if (!preventOnSelect && typeof this._o.onSelect === 'function') {
                    this._o.onSelect.call(this, this.getDate());
                }
            },

            /**
             * clear and reset the date
             */
            clear: function()
            {
                this.setDate(null);
            },

            /**
             * change view to a specific date
             */
            gotoDate: function(date)
            {
                var newCalendar = true;

                if (!isDate(date)) {
                    return;
                }

                if (this.calendars) {
                    var firstVisibleDate = new Date(this.calendars[0].year, this.calendars[0].month, 1),
                        lastVisibleDate = new Date(this.calendars[this.calendars.length-1].year, this.calendars[this.calendars.length-1].month, 1),
                        visibleDate = date.getTime();
                    // get the end of the month
                    lastVisibleDate.setMonth(lastVisibleDate.getMonth()+1);
                    lastVisibleDate.setDate(lastVisibleDate.getDate()-1);
                    newCalendar = (visibleDate < firstVisibleDate.getTime() || lastVisibleDate.getTime() < visibleDate);
                }

                if (newCalendar) {
                    this.calendars = [{
                        month: date.getMonth(),
                        year: date.getFullYear()
                    }];
                    if (this._o.mainCalendar === 'right') {
                        this.calendars[0].month += 1 - this._o.numberOfMonths;
                    }
                }

                this.adjustCalendars();
            },

            adjustDate: function(sign, days) {

                var day = this.getDate() || new Date();
                var difference = parseInt(days)*24*60*60*1000;

                var newDay;

                if (sign === 'add') {
                    newDay = new Date(day.valueOf() + difference);
                } else if (sign === 'subtract') {
                    newDay = new Date(day.valueOf() - difference);
                }

                this.setDate(newDay);
            },

            adjustCalendars: function() {
                this.calendars[0] = adjustCalendar(this.calendars[0]);
                for (var c = 1; c < this._o.numberOfMonths; c++) {
                    this.calendars[c] = adjustCalendar({
                        month: this.calendars[0].month + c,
                        year: this.calendars[0].year
                    });
                }
                this.draw();
            },

            gotoToday: function()
            {
                this.gotoDate(new Date());
            },

            /**
             * change view to a specific month (zero-index, e.g. 0: January)
             */
            gotoMonth: function(month)
            {
                if (!isNaN(month)) {
                    this.calendars[0].month = parseInt(month, 10);
                    this.adjustCalendars();
                }
            },

            nextMonth: function()
            {
                this.calendars[0].month++;
                this.adjustCalendars();
            },

            prevMonth: function()
            {
                this.calendars[0].month--;
                this.adjustCalendars();
            },

            /**
             * change view to a specific full year (e.g. "2012")
             */
            gotoYear: function(year)
            {
                if (!isNaN(year)) {
                    this.calendars[0].year = parseInt(year, 10);
                    this.adjustCalendars();
                }
            },

            /**
             * change the minDate
             */
            setMinDate: function(value)
            {
                if(value instanceof Date) {
                    setToStartOfDay(value);
                    this._o.minDate = value;
                    this._o.minYear  = value.getFullYear();
                    this._o.minMonth = value.getMonth();
                } else {
                    this._o.minDate = defaults.minDate;
                    this._o.minYear  = defaults.minYear;
                    this._o.minMonth = defaults.minMonth;
                    this._o.startRange = defaults.startRange;
                }

                this.draw();
            },

            /**
             * change the maxDate
             */
            setMaxDate: function(value)
            {
                if(value instanceof Date) {
                    setToStartOfDay(value);
                    this._o.maxDate = value;
                    this._o.maxYear = value.getFullYear();
                    this._o.maxMonth = value.getMonth();
                } else {
                    this._o.maxDate = defaults.maxDate;
                    this._o.maxYear = defaults.maxYear;
                    this._o.maxMonth = defaults.maxMonth;
                    this._o.endRange = defaults.endRange;
                }

                this.draw();
            },

            setStartRange: function(value)
            {
                this._o.startRange = value;
            },

            setEndRange: function(value)
            {
                this._o.endRange = value;
            },

            /**
             * refresh the HTML
             */
            draw: function(force)
            {
                if (!this._v && !force) {
                    return;
                }
                var opts = this._o,
                    minYear = opts.minYear,
                    maxYear = opts.maxYear,
                    minMonth = opts.minMonth,
                    maxMonth = opts.maxMonth,
                    html = '',
                    randId;

                if (this._y <= minYear) {
                    this._y = minYear;
                    if (!isNaN(minMonth) && this._m < minMonth) {
                        this._m = minMonth;
                    }
                }
                if (this._y >= maxYear) {
                    this._y = maxYear;
                    if (!isNaN(maxMonth) && this._m > maxMonth) {
                        this._m = maxMonth;
                    }
                }

                for (var c = 0; c < opts.numberOfMonths; c++) {
                    randId = 'pika-title-' + Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 2);
                    html += '<div class="pika-lendar">' + renderTitle(this, c, this.calendars[c].year, this.calendars[c].month, this.calendars[0].year, randId) + this.render(this.calendars[c].year, this.calendars[c].month, randId) + '</div>';
                }

                this.el.innerHTML = html;

                if (opts.bound) {
                    if(opts.field.type !== 'hidden') {
                        sto(function() {
                            opts.trigger.focus();
                        }, 1);
                    }
                }

                if (typeof this._o.onDraw === 'function') {
                    this._o.onDraw(this);
                }

                if (opts.bound) {
                    // let the screen reader user know to use arrow keys
                    opts.field.setAttribute('aria-label', opts.ariaLabel);
                }
            },

            adjustPosition: function()
            {
                var field, pEl, width, height, viewportWidth, viewportHeight, scrollTop, left, top, clientRect, leftAligned, bottomAligned;

                if (this._o.container) return;

                this.el.style.position = 'absolute';

                field = this._o.trigger;
                pEl = field;
                width = this.el.offsetWidth;
                height = this.el.offsetHeight;
                viewportWidth = window.innerWidth || document.documentElement.clientWidth;
                viewportHeight = window.innerHeight || document.documentElement.clientHeight;
                scrollTop = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
                leftAligned = true;
                bottomAligned = true;

                if (typeof field.getBoundingClientRect === 'function') {
                    clientRect = field.getBoundingClientRect();
                    left = clientRect.left + window.pageXOffset;
                    top = clientRect.bottom + window.pageYOffset;
                } else {
                    left = pEl.offsetLeft;
                    top  = pEl.offsetTop + pEl.offsetHeight;
                    while((pEl = pEl.offsetParent)) {
                        left += pEl.offsetLeft;
                        top  += pEl.offsetTop;
                    }
                }

                // default position is bottom & left
                if ((this._o.reposition && left + width > viewportWidth) ||
                    (
                        this._o.position.indexOf('right') > -1 &&
                        left - width + field.offsetWidth > 0
                    )
                ) {
                    left = left - width + field.offsetWidth;
                    leftAligned = false;
                }
                if ((this._o.reposition && top + height > viewportHeight + scrollTop) ||
                    (
                        this._o.position.indexOf('top') > -1 &&
                        top - height - field.offsetHeight > 0
                    )
                ) {
                    top = top - height - field.offsetHeight;
                    bottomAligned = false;
                }

                if (left < 0) {
                    left = 0;
                }

                if (top < 0) {
                    top = 0;
                }

                this.el.style.left = left + 'px';
                this.el.style.top = top + 'px';

                addClass(this.el, leftAligned ? 'left-aligned' : 'right-aligned');
                addClass(this.el, bottomAligned ? 'bottom-aligned' : 'top-aligned');
                removeClass(this.el, !leftAligned ? 'left-aligned' : 'right-aligned');
                removeClass(this.el, !bottomAligned ? 'bottom-aligned' : 'top-aligned');
            },

            /**
             * render HTML for a particular month
             */
            render: function(year, month, randId)
            {
                var opts   = this._o,
                    now    = new Date(),
                    days   = getDaysInMonth(year, month),
                    before = new Date(year, month, 1).getDay(),
                    data   = [],
                    row    = [];
                setToStartOfDay(now);
                if (opts.firstDay > 0) {
                    before -= opts.firstDay;
                    if (before < 0) {
                        before += 7;
                    }
                }
                var previousMonth = month === 0 ? 11 : month - 1,
                    nextMonth = month === 11 ? 0 : month + 1,
                    yearOfPreviousMonth = month === 0 ? year - 1 : year,
                    yearOfNextMonth = month === 11 ? year + 1 : year,
                    daysInPreviousMonth = getDaysInMonth(yearOfPreviousMonth, previousMonth);
                var cells = days + before,
                    after = cells;
                while(after > 7) {
                    after -= 7;
                }
                cells += 7 - after;
                var isWeekSelected = false;
                for (var i = 0, r = 0; i < cells; i++)
                {
                    var day = new Date(year, month, 1 + (i - before)),
                        isSelected = isDate(this._d) ? compareDates(day, this._d) : false,
                        isToday = compareDates(day, now),
                        hasEvent = opts.events.indexOf(day.toDateString()) !== -1 ? true : false,
                        isEmpty = i < before || i >= (days + before),
                        dayNumber = 1 + (i - before),
                        monthNumber = month,
                        yearNumber = year,
                        isStartRange = opts.startRange && compareDates(opts.startRange, day),
                        isEndRange = opts.endRange && compareDates(opts.endRange, day),
                        isInRange = opts.startRange && opts.endRange && opts.startRange < day && day < opts.endRange,
                        isDisabled = (opts.minDate && day < opts.minDate) ||
                                     (opts.maxDate && day > opts.maxDate) ||
                                     (opts.disableWeekends && isWeekend(day)) ||
                                     (opts.disableDayFn && opts.disableDayFn(day));

                    if (isEmpty) {
                        if (i < before) {
                            dayNumber = daysInPreviousMonth + dayNumber;
                            monthNumber = previousMonth;
                            yearNumber = yearOfPreviousMonth;
                        } else {
                            dayNumber = dayNumber - days;
                            monthNumber = nextMonth;
                            yearNumber = yearOfNextMonth;
                        }
                    }

                    var dayConfig = {
                            day: dayNumber,
                            month: monthNumber,
                            year: yearNumber,
                            hasEvent: hasEvent,
                            isSelected: isSelected,
                            isToday: isToday,
                            isDisabled: isDisabled,
                            isEmpty: isEmpty,
                            isStartRange: isStartRange,
                            isEndRange: isEndRange,
                            isInRange: isInRange,
                            showDaysInNextAndPreviousMonths: opts.showDaysInNextAndPreviousMonths,
                            enableSelectionDaysInNextAndPreviousMonths: opts.enableSelectionDaysInNextAndPreviousMonths
                        };

                    if (opts.pickWholeWeek && isSelected) {
                        isWeekSelected = true;
                    }

                    row.push(renderDay(dayConfig));

                    if (++r === 7) {
                        if (opts.showWeekNumber) {
                            row.unshift(renderWeek(i - before, month, year, opts.firstWeekOfYearMinDays));
                        }
                        data.push(renderRow(row, opts.isRTL, opts.pickWholeWeek, isWeekSelected));
                        row = [];
                        r = 0;
                        isWeekSelected = false;
                    }
                }
                return renderTable(opts, data, randId);
            },

            isVisible: function()
            {
                return this._v;
            },

            show: function()
            {
                if (!this.isVisible()) {
                    this._v = true;
                    this.draw();
                    removeClass(this.el, 'is-hidden');
                    if (this._o.bound) {
                        addEvent(document, 'click', this._onClick);
                        this.adjustPosition();
                    }
                    if (typeof this._o.onOpen === 'function') {
                        this._o.onOpen.call(this);
                    }
                }
            },

            hide: function()
            {
                var v = this._v;
                if (v !== false) {
                    if (this._o.bound) {
                        removeEvent(document, 'click', this._onClick);
                    }

                    if (!this._o.container) {
                        this.el.style.position = 'static'; // reset
                        this.el.style.left = 'auto';
                        this.el.style.top = 'auto';
                    }
                    addClass(this.el, 'is-hidden');
                    this._v = false;
                    if (v !== undefined && typeof this._o.onClose === 'function') {
                        this._o.onClose.call(this);
                    }
                }
            },

            /**
             * GAME OVER
             */
            destroy: function()
            {
                var opts = this._o;

                this.hide();
                removeEvent(this.el, 'mousedown', this._onMouseDown, true);
                removeEvent(this.el, 'touchend', this._onMouseDown, true);
                removeEvent(this.el, 'change', this._onChange);
                if (opts.keyboardInput) {
                    removeEvent(document, 'keydown', this._onKeyChange);
                }
                if (opts.field) {
                    removeEvent(opts.field, 'change', this._onInputChange);
                    if (opts.bound) {
                        removeEvent(opts.trigger, 'click', this._onInputClick);
                        removeEvent(opts.trigger, 'focus', this._onInputFocus);
                        removeEvent(opts.trigger, 'blur', this._onInputBlur);
                    }
                }
                if (this.el.parentNode) {
                    this.el.parentNode.removeChild(this.el);
                }
            }

        };

        return Pikaday;
    }));

}

var tables = function(){

    // -- Create a mobile version of each table on the page --------------------
        $(document).find('table').each(function(){

            var newTable = '<table class="mobile_table">';
            var cols = [];
            var newRows = '';
            $(this).find('tr').each(function(i){
                if( i == 0 ){
                    $(this).find('th').each(function(){
                        cols.push( $(this).text() );
                    })
                }else{
                    var id_link = $(this).data('id') ? ' data-id="' + $(this).data('id') + '" ' : ' data-editid="' + $(this).data('editid') + '" ';
                    var species_or_breed = $(this).data('form') == 'edit_breed' ? 'breed' : 'species';
                    var edit_link = $(this).hasClass('js-view') ? ' class="js-view" ' : ' data-form="edit_' + species_or_breed + '" data-table="' + species_or_breed + '" class="js_edit" ';
                    newRows += '<tbody>';
                        $(this).find('td').each(function(i){
                            newRows += '<tr' + edit_link + id_link + '><td>' + '<span>' + cols[i] + '</span>' + $(this).html()  + '</td></tr>';
                        })
                    newRows += '</tbody>';
                }
            })
            newTable += newRows + '</table>';
            $(this).after(newTable);
        });
    // -------------------------------------------------------------------------

}


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
