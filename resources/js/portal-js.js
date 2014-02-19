/*------------------START DECLARATIONS--------------------*/

var allFlavors = new Array();
/* GLOBAL CUSTOM FLAVOR VARIABLE 
 * used to store user chosen ingredients (array of ingredients)
 */
 var userFlavor = new Flavor(-1,"Custom","User defined flavor","pizzaColor.png",new Array());
 var traditionalFlavor = null;

 /* simple Ingredient Object representation */
 function Ingredient(id,name,description,picturePath){
    this.id = id;
    this.name = name;
    this.description = description;
    this.picturePath = picturePath;
}
/* simple Flavor Object representation */
function Flavor(id,name,description,picturePath, ingredients){
    this.id = id;
    this.name = name;
    this.description = description;
    this.picturePath = picturePath;
    this.ingredients = ingredients;
}

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
    /* if ID is empty, user hover on + - buttons, lets get parent value*/
    if(id == ""){
        id = element.parentNode.value;
    }
    /* GETTING HIDDEN INPUT VALUES */
    var description = $("#ingredient" + id + " input[name='description']").val();
    var name = $("#ingredient" + id + " input[name='name']").val();
    var picturePath = $("#ingredient" + id + " input[name='picturePath']").val();
    $("#ingredientColumn .caption").html(description);
    $("#ingredientColumn h3").html(name);
    $("#ingredientColumn img").attr('src','/PizzaBuilder/resources/images/' + picturePath);  

}

/*CHANGES FLAVOR CARD*/
function changeFlavorCard(element){
    var id = element.value;
    /* GETTING HIDDEN INPUT VALUES */
    var description = $("#flavor" + id + " input[name='description']").val();
    var name = $("#flavor" + id + " input[name='name']").val();
    var picturePath = $("#flavor" + id + " input[name='picturePath']").val();
    $("#flavorsColumn .caption").html(description);
    $("#flavorsColumn h3").html(name);
    $("#flavorsColumn img").attr('src','/PizzaBuilder/resources/images/' + picturePath);  
}

/* SELECTS SIZE CARD WHEN CLICKED */
function selectSize(elementID){
    deselectSizes();
    var element = $("#" + elementID).children();
    element.addClass("cardDivSelected");
    element.attr('data-value','true');
}

/* DESELECTS ALL SIZE CARDS */
function deselectSizes(){
    var element = $("div[name='sizeItem']").children();
    element.removeClass("cardDivSelected");
    element.attr('data-value','false');
}

/* SELECTS SIZE CARD WHEN CLICKED */
function selectCard(elementID,type){
    deselectCards(type);
    var element = $("#" + elementID).children();
    element.addClass("cardDivSelected");
    element.attr('data-value','true');
}

/* DESELECTS ALL SIZE CARDS */
function deselectCards(type){
    var name = type + "Item";
    //var element = $("div[name='"+name+"']").children();
    $("div[name='"+name+"']").children().removeClass("cardDivSelected").attr('data-value','false');
    //element.removeClass("cardDivSelected");
    //element.attr('data-value','false');
}


/* Show ingredients/flavor modal Panel */
function showIngredients(element){
    /* Selecting the modal panel */
    var pane = $("#ingredientsPane");
    /* Getting number of flavor card clicked */
    //var id = element.id.substring('flavorDiv'.length);
    var id = $(element).attr('data-value');
    /* Changing the target of the modal */
    pane.attr('data-value', id);
    /* Toggling modal visibility */
    pane.modal('toggle');
}
/*ADD INGREDIENT TO CUSTOM FLAVOR*/
function addIngredient(element){
    /*Getting ingredient id (searching value field of list item parent)*/
    var id = element.parentNode.value;
    
    /* Getting ingredient attributes */
    var ingredientId = $("#ingredient" + id + " input[name='id']").val();
    var ingredientName = $("#ingredient" + id + " input[name='name']").val();
    var ingredientDescription = $("#ingredient" + id + " input[name='description']").val();
    var ingredientPicPath = $("#ingredient" + id + " input[name='picturePath']").val();
    
    /* Creating ingredient Object */
    var ingredient = new Ingredient(ingredientId,ingredientName,ingredientDescription,ingredientPicPath);
    /* Adding ingredient to global userFlavor */
    userFlavor.ingredients.push(ingredient);
    updateSummary();

}

function removeIngredient(element){
    /*Getting ingredient id (searching value field of list item parent)*/
    var id = element.parentNode.value;
    
    /* Getting ingredient attributes */
    var ingredientId = $("#ingredient" + id + " input[name='id']").val();
    var ingredientName = $("#ingredient" + id + " input[name='name']").val();

    var index = -1;
    /* Seach ingredient on Custom Flavor */
    for(var i = 0; i < userFlavor.ingredients.length; i++){
        /* If the ingredient was found */
        if(userFlavor.ingredients[i].id == ingredientId){
            /* Set the index to remove */
            index = i;
            break;
        }
    }
    

    /* Removing the ingredient from array */
    if (index > -1) {
        userFlavor.ingredients.splice(index, 1);
    }else{
        alert("You do not have any " + ingredientName + " to remove");
    }
    updateSummary();
}

/* Updates the HTML to match customFlavor ingredients*/
function updateSummary(){
    var html = "";
    for(var i = 0; i < userFlavor.ingredients.length; i++){
        html += userFlavor.ingredients[i].name;
        /*If it's not the last ingredient, append comma*/
        if(i != userFlavor.ingredients.length-1){
            html += ", ";
        }
    }
    if(html == "") html = "Empty Flavor";
    $("#customFlavorSummary").html(html);
}

/* WHEN CLICKED, A FLAVOR IS SETTED 
 * TO THE HIDDEN DIV
 */
 function setFlavor(element){
    //Presentation
    /* Clear all flavor li's active*/
    $("li[id^='flavor']").removeClass('activeFlavor');
    
    var id = element.value;
    /*Changing li class to active*/
    $("#flavor"+id).addClass('activeFlavor');
    //Presentation

    /*Setting userFlavor*/
    var flavorId = $("#flavor" + id + " input[name='id']").val();
    var flavorName = $("#flavor" + id + " input[name='name']").val();
    var flavorDesc = $("#flavor" + id + " input[name='description']").val();
    var flavorPic = $("#flavor" + id + " input[name='picturePath']").val();
    traditionalFlavor = new Flavor(flavorId,flavorName,flavorDesc,flavorPic,null);
}

/* Resets userFlavor object and updates summary */
function resetSummary(){
    /* reseting custom flavor array of ingredients */
    userFlavor.ingredients.length = 0;
    updateSummary();
}

/* Resets the flavor */
function resetFlavor(){
    /* Clear all flavor li's active*/
    $("li[id^='flavor']").removeClass('activeFlavor');

    /* Clear flavor object*/
    traditionalFlavor = null;
}

/* WHEN CLICKED, THE MODAL IS RESET */
function clearModal(){
    resetSummary();
    resetFlavor();    
}

/* Change modal to initial presentation: 
 * first tab selected 
 * show first ingredient card
 */
 function resetModal(){
    /*If Custom flavor tab is not active, make it */
    if( ! $("#liIngredients").hasClass('active') ){
        /*deactivating flavor tab and content*/
        $("#liFlavors").removeClass('active');
        $("#flavorsContent").removeClass('active');
        /*activating ingredients tab and content*/
        $("#liIngredients").addClass('active');
        $("#ingredientsContent").addClass('active');
    }
    /*Setting the card to show the html of first ingredient*/
    //var html = $("div[id^='hiddenIngredientCard']:first").html();
    //$("#ingredientColumn").html(html);
    var name = $("li[id^='ingredient']:first input[name='name']").val();
    var desc = $("li[id^='ingredient']:first input[name='description']").val();
    var pic = $("li[id^='ingredient']:first input[name='picturePath']").val();

    $("#ingredientColumn .caption").html(desc);
    $("#ingredientColumn h3").html(name);
    $("#ingredientColumn img").attr('src','/PizzaBuilder/resources/images/' + pic);  

    
}


/* SELECTS THE CHOSEN FLAVOR AND PUTS ITS HTML
 * ON THE FLAVOR CARD
 */
 function saveFlavor(){
    /* Selecting the modal panel */
    var pane = $("#ingredientsPane");
    /*Getting the card target id*/
    var targetID = pane.attr('data-value');
    /*Selecting the target div*/
    var target = $("#flavorCard" + targetID);

    var divHtml = null;

    /*Check if a custom flavor is selected*/
    if( $("#liIngredients").hasClass('active') ){
        /* If user have chosen at least 1 ingredient */
        if(userFlavor.ingredients.length > 0){
            /* Setting card html */
            $("#flavorCard" + targetID + " .caption").html(userFlavor.description);
            $("#flavorCard" + targetID + " h3").html(userFlavor.name);
            $("#flavorCard" + targetID + " img").attr('src','/PizzaBuilder/resources/images/' + userFlavor.picturePath);
            /* Adding userFlavor to flavors array*/
            allFlavors[targetID] = userFlavor;
        }else{
            return alert("You have not chosen any ingredients");
        }

    }
    /*Else, is a traditional flavor*/
    else{
        if(traditionalFlavor != null){
            /* Setting card html */
            $("#flavorCard" + targetID + " .caption").html(traditionalFlavor.description);
            $("#flavorCard" + targetID + " h3").html(traditionalFlavor.name);
            $("#flavorCard" + targetID + " img").attr('src','/PizzaBuilder/resources/images/' + traditionalFlavor.picturePath);
            
            /* Adding userFlavor to flavors array*/
            allFlavors[targetID] = traditionalFlavor;
            
        }else{
            return alert("You didn't select any flavor");
        }        
    }
    pane.modal('toggle');
}


/*------------------END DECLARATIONS--------------------*/

/*------------------START SCRIPT------------------------*/
$("document").ready(function() {

  /* SETTING MODAL INGREDIENTS LIST ITEMS TO CHANGE CARD ON HOVER */
  $("li[name='ingredientListItem']").mouseover(function(e){
    changeIngredientCard(e.currentTarget);
});

  /* SETTING MODAL FLAVOR LIST ITEMS TO CHANGE CARD ON HOVER */
  $("li[name='flavorListItem']").mouseover(function(e){
    changeFlavorCard(e.currentTarget);
});

  /* SETTING FLAVOR LIST ITEMS TO SET HIDDEN FLAVOR ON CLICK */
  $("li[id^='flavor']").click(function(e){
    setFlavor(e.currentTarget);
});

  /* SETTING SIZE CARDS TO SELECT ON CLICK */
  $("div[name='sizeItem']").click(function(e){
    selectCard(this.id,'size');    
});
  /* SETTING CRUST CARDS TO SELECT ON CLICK */
  $("div[name='crustItem']").click(function(e){
    selectCard(this.id,'crust');    
});
  /* SETTING EDGE CARDS TO SELECT ON CLICK */
  $("div[name='edgeItem']").click(function(e){
    selectCard(this.id,'edge');    
});

  /* SETTING FLAVOR CARDS TO SHOW INGREDIENTS MODAL ON CLICK */
  $("div[class^='flavorDiv']").click(function(e){
    e.preventDefault();
    clearModal();
    resetModal();
    showIngredients(this);
});
  /*SETTING 'SAVE FLAVOR' BUTTON TO SAVE FLAVOR WHEN CLICKED*/
  $("#saveFlavorButton").click(function(e){
    e.preventDefault();
    saveFlavor();
});
  /*SETTING 'RESET' BUTTON TO RESET MODAL WHEN CLICKED*/
  $("#resetModalButton").click(function(e){
    e.preventDefault();
    clearModal();
});
  /*SETTING ALL THE + BUTTONS TO ADD INGREDIENT WHEN CLICKED*/
  $("button[id^='addIngredient']").click(function(e){
    addIngredient(this);
});

  /*SETTING ALL THE - BUTTONS TO REMOVE INGREDIENT WHEN CLICKED*/
  $("button[id^='removeIngredient']").click(function(e){
    removeIngredient(this);
});

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
 });



/*-----------------END SCRIPT---------------------------*/