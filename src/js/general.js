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
