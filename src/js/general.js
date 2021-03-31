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
