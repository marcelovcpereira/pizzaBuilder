/**
 * Initializing the functionality of the AddressToggleButton
 */
$('#addressToggle').click(
        function() {

            /*
             * TOGGLE SHOWADDRESS (HIDDEN INPUT) VALUE
             *showAddress is a hidden submitted value that indicates to
             *the controller if the address is submitted or not
             */
            //get showAddres old value
            var value = $("input[name='showAddress']").val();
            //Invert value
            (value == 'TRUE') ? value = 'FALSE' : value = 'TRUE';
            //set showAddres new value
            $("input[name='showAddress']").val(value);

            /* TOGGLE ADDRESS PANEL VISIBILITY */
            //get address panel visibility
            value = $("#addressPanel").css('visibility');
            //Invert visibility
            (value == 'visible') ? value = 'hidden' : value = 'visible';
            //set address panel visibility
            $("#addressPanel").css('visibility', value);
        }
);

/* Changes pizza card to details and back*/
function flipPizzaCard(id) {   
    //Visible div containing the data that will be replaced
    var visible = $("#menuItem" + id);
    
    //Hidden div containing the content to show
    var hidden = $("#content" + id);
    
    //Saving contents in temp variables
    var visibleContent = visible.html();
    var hiddenContent = hidden.html();
    
    //Fade div out to change content
    visible.fadeOut('fast', function(){
            //Swap contents
            visible.html(hiddenContent);
            hidden.html(visibleContent);
            //Fade in to show the new content
            visible.fadeIn('fast');
        });
}

/*DISMISS ALL POPOVERS WHEN THERE's A CLICK*/
$('html').on('click', function(e) {
    if (typeof $(e.target).data('original-title') == 'undefined') {
        $('[data-original-title]').popover('hide');
    }
});


