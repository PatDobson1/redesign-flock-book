
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
                var gender = $('select[name=gender_filter]').val();
                var year = $('select[name=year_filter]').val();
                if( $('.livestock_table').is(':visible') ){
                    $('.livestock_table').find('tr').each(function(i){
                        $(this).show();
                        var displayed_year = $(this).find('td:nth-child(3)').text();
                        displayed_year = displayed_year.slice(0,4);
                        if( breed != 'null' && $(this).find('td:nth-child(6)').text() != breed && i > 0){
                            $(this).hide();
                        }
                        if( species != 'null' && $(this).find('td:nth-child(4)').text() != species && i > 0 ){
                            $(this).hide();
                        }
                        if( gender != 'null' && $(this).find('td:nth-child(5)').text() != gender && i > 0 ){
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
                        var displayed_breed = ($(this).find('tr:nth-child(6) td').text()).slice(5);
                        var displayed_species = ($(this).find('tr:nth-child(4) td').text()).slice(7);
                        var displayed_gender = ($(this).find('tr:nth-child(5) td').text()).slice(6);
                        if( breed != 'null' && displayed_breed != breed){
                            $(this).hide();
                        }
                        if( species != 'null' && displayed_species != species ){
                            $(this).hide();
                        }
                        if( gender != 'null' && displayed_gender != gender ){
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
                if( $(this).hasClass('js_dontHide') ){
                    $(form).slideDown(500,function(){
                        $('body').animate({
                            scrollTop: $(form).offset().top
                        }, 500);
                    });
                }else{
                    $(this).slideUp(300,function(){
                        $(form).slideDown(500,function(){
                            $('body').animate({
                                scrollTop: $(form).offset().top
                            }, 500);
                        });
                    });
                }
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
                        if( type === 'reminder' ){
                            if( returnedData.remindMe_before != null ){
                                var before = returnedData.remindMe_before.split(',');
                                $.each(before, function(index,item){
                                    if( item === '1 Month' ){ $('#before_1m').prop('checked', true) }
                                    if( item === '1 Week' ){ $('#before_1w').prop('checked', true) }
                                    if( item === '1 Day' ){ $('#before_1d').prop('checked', true) }
                                })
                            }
                            if( returnedData.remindMe_after != null ){
                                var after = returnedData.remindMe_after.split(',');
                                $.each(after, function(index,item){
                                    if( item === 'Monthly' ){ $('#after_m').prop('checked', true) }
                                    if( item === 'Weekly' ){ $('#after_w').prop('checked', true) }
                                    if( item === 'Daily' ){ $('#after_d').prop('checked', true) }
                                })
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

        // -- Reminder links ---------------------------------------------------
            $(document).on('click','.js-complete',function(e){
                e.stopPropagation();
                var status = $(this).data('state');
                var id = $(this).data('id');
                var $modal_content;
                var form_action = 'reminder-change';
                if(status == 'delete'){
                    form_action = 'reminder-delete';
                    modal_content = '<h2>Delete reminder</h2>' +
                                     '<p>Are you sure you want to delete this reminder?</p>' +
                                     '<p>Deleting is permanent and cannot be undone.</p>';
                }
                if( status == 'not-complete' ){
                    modal_content = '<h2>Mark reminder as complete</h2>' +
                                     '<p>Are you sure you want to mark this reminder as complete?</p>' +
                                     '<p>( you can change it later )</p>';
                 }else if( status == 'complete' ){
                    modal_content = '<h2>Mark reminder as not complete</h2>' +
                                      '<p>Are you sure you want to mark this reminder as not complete?</p>' +
                                      '<p>Any email reminders you set will be reinstated.</p>' +
                                      '<p>( you can change it later )</p>';
                 }
                 modal_content +=  '<form class="js_form" data-action="' + form_action + '">' +
                                    '<input type="hidden" name="id" value="' + id + '" />' +
                                    '<input type="submit" value="Confirm" class="form_btn" />' +
                                    '</form>' +
                                    '<button class="js_closeModal btn_right" />Cancel</button>';
                 openModal(modal_content);
            });
        // ---------------------------------------------------------------------

        // -- Process form submit ----------------------------------------------
            var processSubmit = function(data){
                var returnedData = JSON.parse(data);
                switch(returnedData.action){

                    // -- Settings ---------------------------------------------
                        case 'passwordChanged':
                            $('.change_password').slideUp(500,function(){
                                displayMessage("Your password has been changed");
                                $('form')[0].reset();
                            });
                        break;
                    // ---------------------------------------------------------

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
                            tables();
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

                    // -- Reminders --------------------------------------------
                        case 'reminderAdded':
                            $('.add_reminder').slideUp();
                            $('.js_showForm').show();
                            var colour = '';
                            switch(true){
                                case returnedData.priority > 3:
                                    colour = 'red';
                                break;
                                case returnedData.priority == 3:
                                    colour = 'amber';
                                break;
                                case returnedData.priority > 0 && returnedData.priority < 3:
                                    colour = 'green';
                                break;
                            }
                            var priority = '<p class="priority ' + colour + '">';
                            for( var i=0; i<5; i++ ){
                                if( i < returnedData.priority ){
                                    priority += '<span>' + (i+1) + '</span>';
                                }else{
                                    priority += '<span class="blank"></span>';
                                }
                            }
                            var newTable = '<h3>New</h3><table class="reminder_table"><tbody><tr><th>Due date</th><th width="100px">Priority</th><th>Description</th></tr><tr><td class="cen">' + returnedData.reminder_date + '</td><td class="left">' + priority + '</td><td class="left">' + returnedData.description + '</td></tr></table>';
                            var newMobileTable = '<table class="mobile_table  mobile_reminders"><tbody><tr><td><span>Due date</span>' + returnedData.reminder_date + '</td></tr><tr><td><span>Priority</span>' + priority + '</td></tr><tr><td><span>Description</span>' + returnedData.description + '</td></tr><tr><td></td></tr></tbody></table>';
                            $('.card h2').after(newTable).after(newMobileTable);
                            $('form')[0].reset();
                            displayMessage("Reminder added");
                        break;
                        case 'reminderEdited':
                            $('.edit_reminder').slideUp();
                            $('.js_edit_btn').slideDown();
                            displayMessage("Reminder edited");
                            var payload = {
                                id: returnedData.id,
                                class_name: 'reminderEdited',
                                return_action: 'reminderEdited'
                            }
                            callClass(payload,'');
                        break;
                        case 'reminderChanged':
                            var changedTr = $('tr[data-id=' + returnedData.id + ']').clone();
                            $('tr[data-id=' + returnedData.id + ']').remove();
                            var newTable = '<h3>Changed</h3><table class="reminder_table change_table"><tbody><tr><th>Due date</th><th width="100px">Priority</th><th>Description</th></tr><tr>' + changedTr[0].outerHTML + '</tr></table>';
                            if( $('.change_table').length ){
                                $('.change_table').append(changedTr[0].outerHTML);
                            }else{
                                $('.reminders_card h2').after(newTable);
                            }
                            $('.change_table tr td:last-child').empty();
                            displayMessage("Reminder changed");
                        break;
                        case 'reminderDeleted':
                            $('tr[data-id=' + returnedData.id + ']').remove();
                            displayMessage("Reminder deleted");
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

        // -- Clear date input -------------------------------------------------
            $(document).on('click','.js-clearDate',function(){
                $(this).prev().val('');
            })
        // ---------------------------------------------------------------------

    }

// -----------------------------------------------------------------------------
