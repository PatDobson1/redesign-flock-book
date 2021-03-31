var tables = function(){

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
                var id = $(this).data('id');
                newRows += '<tbody>';
                    $(this).find('td').each(function(i){
                        newRows += '<tr class="js-view" data-id="' + id  + '"><td>' + '<span>' + cols[i] + '</span>' + $(this).html()  + '</td></tr>';
                    })
                newRows += '</tbody>';
            }
        })
        newTable += newRows + '</table>';
        $(this).after(newTable);
    });

}
