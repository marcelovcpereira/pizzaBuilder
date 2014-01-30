
/*
 * This function is called by the pizza divs on each 
 * pizza item of the menu (_menu_item_view). It toggles the popover describing
 * the pizza details.
 * OBS:
 * This function uses a variable called 'value' from the divs
 * that uses popover. This artificially putted attribute tells
 * this function if the popover is active or not. That's
 * in order to avoid glitches on popover, or when the user
 * clicks outside them
 */
function popPizzaDetails(id,title){ 
    //Get the html code of the hidden div to show in the popover
    var content = $('#content' + id).html(); 
    //Name of the div clicked (the pizza div)
    var name = 'menuItem' + id;
    //Get the div (OBS: We can't get this div by ID, because all menuItem have
    //the same ID in order to use the same css selector)
    var entity = $("div[name='"+name+"'");
    //Checks if the current clicked pizza popover
    //is already active
    var active = entity.attr('value');
    //If it's not...
    if(active == 'false'){
        //init the popover
        entity.popover({content:content,title:title,html:true,offset:-15});
        //display it
        entity.popover('toggle');
        //Get all popovers and set them to inactive
        $('[data-original-title]').attr('value','false');
        //Activate this popover
        entity.attr('value','true');        
    }else{
        //if it's already active, disable it
        entity.attr('value','false');
    }

}
/**
 * Initializing the functionality of the AddressToggleButton
 */
$('#addressToggle').click(
        function(){
            
            /*
             * TOGGLE SHOWADDRESS (HIDDEN INPUT) VALUE
             *showAddress is a hidden submitted value that indicates to
             *the controller if the address is submitted or not
             */
            //get showAddres old value
            var value = $("input[name='showAddress']").val();
            //Invert value
            (value == 'TRUE') ? value = 'FALSE':value = 'TRUE';
            //set showAddres new value
            $("input[name='showAddress']").val(value);
            
            /* TOGGLE ADDRESS PANEL VISIBILITY */
            //get address panel visibility
            value = $("#addressPanel").css('visibility');
            //Invert visibility
            (value == 'visible') ? value = 'hidden':value = 'visible';
            //set address panel visibility
            $("#addressPanel").css('visibility',value);
        }        
);

/*DISMISS ALL POPOVERS WHEN THERE's A CLICK*/
$('html').on('click', function(e) {
  if (typeof $(e.target).data('original-title') == 'undefined') {
    $('[data-original-title]').popover('hide');
  }
});


