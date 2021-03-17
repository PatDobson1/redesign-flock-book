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
