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
