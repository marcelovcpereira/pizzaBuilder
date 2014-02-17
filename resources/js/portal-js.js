/*------------------START DECLARATIONS--------------------*/
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
/*CHANGES INGREDIENT CARD*/
function changeIngredientCard(element){
    var id = element.value;
    var newHTML = $('#hiddenIngredientCard' + id).html();
    $('#ingredientColumn').html(newHTML);
}

/*CHANGES FLAVOR CARD*/
function changeFlavorCard(element){
    var id = element.value;
    var newHTML = $('#hiddenFlavorCard' + id).html();
    $('#flavorsColumn').html(newHTML);
}

/* SELECTS SIZE CARD WHEN CLICKED */
function selectSize(elementID){
    deselectSizes();
    var element = $("#" + elementID);
    element.addClass("cardDivSelected");
    element.attr('value','true');
}

/* DESELECTS ALL SIZE CARDS */
function deselectSizes(){
    var element = $("div[name='sizeItem']");
    element.removeClass("cardDivSelected");
    element.attr('value','false');
}
/* Show ingredients/flavor modal Panel */
function showIngredients(element){
    /* Selecting the modal panel */
    var pane = $("#ingredientsPane");
    /* Getting number of flavor card clicked */
    var id = element.id.substring('flavorDiv'.length);
    /* Changing the target of the modal */
    pane.attr('data-value', id);
    /* Toggling modal visibility */
    pane.modal('toggle');
}
/*------------------END DECLARATIONS--------------------*/

/*------------------START SCRIPT------------------------*/

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

/* SETTING INGREDIENTS LIST ITEMS TO CHANGE CARD ON CLICK */
$("li[id^='ingredient']").mouseover(function(e){
    changeIngredientCard(e.toElement);
});

/* SETTING INGREDIENTS LIST ITEMS TO CHANGE CARD ON CLICK */
$("li[id^='flavor']").mouseover(function(e){
    changeFlavorCard(e.toElement);
});

/* SETTING SIZE CARDS TO SELECT ON CLICK */
$("div[name='sizeItem']").click(function(e){
    selectSize(this.id);    
});

/* SETTING FLAVOR CARDS TO SHOW INGREDIENTS MODAL ON CLICK */
$("div[class^='flavorDiv']").click(function(e){
    e.preventDefault();
    showIngredients(this);
});
/*-----------------END SCRIPT---------------------------*/