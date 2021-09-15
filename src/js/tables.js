var tables = function(){

    // -- Create a mobile version of each table on the page --------------------
        $(document).find('table').each(function(){

            var newClass = $(this).data('classname') ? ' mobile_' + $(this).data('classname') : '';
            var newTable = '<table class="mobile_table ' + newClass +'">';
            var cols = [];
            var newRows = '';
            $(this).find('tr').each(function(i){
                if( i == 0 ){
                    $(this).find('th').each(function(){
                        cols.push( $(this).text() );
                    })
                }else{
                    var id_link = $(this).data('id') ? ' data-id="' + $(this).data('id') + '" ' : ' data-editid="' + $(this).data('editid') + '" ';
                    newRows += '<tbody>';
                        $(this).find('td').each(function(i){
                            newRows += '<tr class="js-view"' + id_link + '><td>' + '<span>' + cols[i] + '</span>' + $(this).html()  + '</td></tr>';
                        })
                    newRows += '</tbody>';
                }
            })
            newTable += newRows + '</table>';
            $(this).after(newTable);
        });
    // -------------------------------------------------------------------------

}
