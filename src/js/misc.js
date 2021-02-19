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
