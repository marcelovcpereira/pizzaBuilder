/*------------------START DECLARATIONS--------------------*/


/* 
 * GLOBAL VARIABLES 
 * used to store user chosen ingredients (array of ingredients)
 */
 var allFlavors = new Array();
 var userFlavor = new Flavor(-1,"Custom","User defined flavor","pizzaColor.png",new Array());
 var traditionalFlavor = null;
 var userLayout = null;


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

    this.clone = function(){
        var cloneIngrs = new Array();
        for(var i = 0; i < this.ingredients.length; i++){
            cloneIngrs[i] = new Ingredient(this.ingredients[i].id,
                                            this.ingredients[i].name,
                                            this.ingredients[i].description,
                                            this.ingredients[i].picturePath);
        }
        return new Flavor(this.id,this.name,this.description,this.picturePath,cloneIngrs);
    }
}


function getFlavorIngredients(flavor){
    var toString = "";
    for(var i = 0; i < flavor.ingredients.length; i++){
        toString += flavor.ingredients[i].name + "<br />";
    }
    return toString;
}
function Pizza(id,name,description,picturePath,sizeID, crustID, edgeID,layoutID,flavors,obs){
    this.id = id;
    this.name = name;
    this.description = description;
    this.picturePath = picturePath;
    this.sizeId = sizeID;
    this.crustId = crustID;
    this.edgeId = edgeID;
    this.layoutId = layoutID;
    this.flavors = flavors;
    this.observation = obs;
}

/* simple Layout Object representation */
function Layout(id,name,description,picturePath,pattern){
    this.id = id;
    this.name = name;
    this.description = description;
    this.picturePath = picturePath;
    this.pattern = pattern;
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
    /* if value is empty, user hover on + - buttons, lets get parent value*/
    if(element.value == ""){
        //Getting List object
        element = $(element).parent();
    }

    /* Getting ingredient Object */
    var ingredient = $(element).children("input[name='ingredient']").val();
    ingredient = JSON.parse(ingredient);

    /* Changing Card HTML to show new ingredient attributes */
    $("#ingredientColumn .caption").html(ingredient.description);
    $("#ingredientColumn h3").html(ingredient.name);
    $("#ingredientColumn img").attr('src','/PizzaBuilder/resources/images/' + ingredient.picturePath);   

}

/*CHANGES FLAVOR CARD*/
function changeFlavorCard(element){   
    /* GETTING HIDDEN FLAVOR OBJECT */
    var flavor = $(element).children("input[name='flavor']").val();
    flavor = JSON.parse(flavor);

    /* Setting card html */
    $("#flavorsColumn .caption").html(flavor.description);
    $("#flavorsColumn h3").html(flavor.name);
    $("#flavorsColumn img").attr('src','/PizzaBuilder/resources/images/' + flavor.picturePath);  

}

/**
 * Seeks the user selected layout, parse hidden json object,
 * sets the layout object to the global variable and re-render the flavors
 */
 function updateLayout(){
    //Gets selected layout
    var selectedLayoutPanel = $("div[name='layoutItem'] div[data-value='true']");
    
    //Gets selected layout id
    var layoutID = selectedLayoutPanel.parent().attr('data-id');
    
    //Selecting layout div that contains hidden object of this layout    
    var flavorItem =  selectedLayoutPanel.parent();
    var flavorDiv = flavorItem.parent();
    var layoutObj = flavorDiv.children("input").val();

    //Setting the global variable
    window.userLayout = JSON.parse(layoutObj);

    //Rendering flavor cards
    renderLayout();

    updateAllFlavors();
}

/**
 * Renders the flavors card accordingly to the selected layout
 */
 function renderLayout(){
    //Hides all flavors
    $(".cardDivWrapper .flavorDiv").addClass("hide");


    //Parse selected layout to find how many flavors will be showed
    var numberOfFlavors = parseLayoutPattern(window.userLayout.pattern);
    var flavorDiv = null;
    //For each flavor, show div
    for(var i = 1; i <= numberOfFlavors; i++){
        $(".flavorDiv[data-value='"+i+"']").removeClass("hide");        
    }
}

/**
 * Parses the selected Layout Pattern returning
 * the number of flavors it has
 */
 function parseLayoutPattern(pattern){
    return pattern.split(":").length;
}


/**
 * Parse the Div Flavor Objects into the allFlavors global array
 * of flavors.
 * and
 * Updates the title of flavors row
 * (ex: Flavors: Bacon, Ham)
 */
function updateAllFlavors(){
    var flavors = new Array();
    var cardDivWrapper = $("#flavorColumn .cardDivWrapper");
    var flavorDivs = cardDivWrapper.children("div");
    //removing hidden
    flavorDivs = flavorDivs.not("div[class='flavorDiv hide']");
    for(var j = 0; j < flavorDivs.length; j++){
        var input = $(flavorDivs[j]).children("input");
        var number = parseInt($(flavorDivs[j]).children("h3").html());
        var flavorObject = input.val();
        if(flavorObject != ""){
            flavorObject = JSON.parse(flavorObject);
            if(flavorObject.id != "" && flavorObject.id != null && flavorObject.id != 'null'){
                flavors[number] = flavorObject;
            }
        }
    }
    window.allFlavors = new Array();
    /* foreach flavor added, append the flavor name*/
    for(var i = 0; i < flavors.length; i++){
        window.allFlavors[i] = flavors[i];
    }
    //Update rendering of toppings
    updateToppings();

}

/**
 * Updates the HTML of Toppings Span
 */
function updateToppings(){
    var span = $("#flavorColumn h2 span");
    var title = "";
    /* foreach flavor added, append the flavor name*/
    for(var i = 1; i < window.allFlavors.length; i++){
        var element = window.allFlavors[i]; 
        if( element === undefined ){
             
        }else{
            title += window.allFlavors[i].name;
            if(i != window.allFlavors.length-1){
                title += ", ";
            }
        }
    }
    span.html(title);
}


/** SELECTS CARD OF CERTAIN TYPE WHEN CLICKED 
 * Type can be "Size", "Crust" and "Edge"
 */
 function selectCard(elementID,type){
    var deselected = deselectCards(type);
    //Panel is the children of typeItem div (sizeItem, crustItem...)
    var panel = $("#" + elementID).children();
    panel.addClass("cardDivSelected");
    panel.attr('data-value','true');

    /* When the user selects a card, the card name goes to span title*/
    /* h2 = typeItem -> cardDiv -> cardDivWrapper -> typeColumn -> childH2*/
    var h2 = $("#" + elementID).parent().parent().parent().children("h2");
    var span = h2.children("span");
    
    var name = panel.find("h3").html();
    /* capitalize name */
    name = name.charAt(0).toUpperCase() + name.substring(1);
    span.html(name);

    /* When the user selects a card, the next card row is showed
     * if it's the first time (when no cards are selected)
     */
    if(deselected == 0){
        showNextRow(type);
    }   
}

/* DESELECTS ALL SIZE CARDS OF CERTAIN TYPE */
function deselectCards(type){
    var name = type + "Item";
    //Counting selected items
    var hasSelected = $("div[name='"+name+"']").children("div[data-value='true']").length;
    //Deselecting selected items
    $("div[name='"+name+"']").children().removeClass("cardDivSelected").attr('data-value','false');

    //Returning number of deselected divs
    return hasSelected;
}

/**
 * Hides the current row and show the next.
 * (Shows next row when user selects pizza part for the first time)
 */
function showNextRow(currentRow){
    switch(currentRow){
        case 'size':
        toggleBuilderRow('size','hide');
        toggleBuilderRow('crust','show');
        break;
        case 'crust':
        toggleBuilderRow('crust','hide');
        toggleBuilderRow('edge','show');
        break;
        case 'edge':
        toggleBuilderRow('edge','hide');
        toggleBuilderRow('layout','show');
        break;
        case 'layout':
        toggleBuilderRow('layout','hide');
        toggleBuilderRow('flavor','show');
        default: break;
    }
}

/* Show ingredients/flavor modal Panel */
function showIngredients(element){
    /* Selecting the modal panel */
    var pane = $("#ingredientsPane");
    /* Getting number of flavor card clicked */
    var id = $(element).attr('data-value');

    var flavorObject = $(element).children("input").val();
    if(flavorObject != ""){        
        flavorObject = JSON.parse(flavorObject);
        window.userFlavor = flavorObject;
        /* Making it a Custom Flavor */
        window.userFlavor.name = "Custom";
        window.userFlavor.id = -'-1';
        window.userFlavor.description = "";
        window.userFlavor.picturePath = "pizzaColor.png";
        updateSummary();
    }    

    /* Changing the target of the modal */
    pane.attr('data-value', id);
    /* Toggling modal visibility */
    pane.modal('toggle');
}
/*ADD INGREDIENT TO CUSTOM FLAVOR*/
function addIngredient(element){
    /* Getting ingredient Object */
    var ingredient = $(element).parent().children("input[name='ingredient']").val();
    ingredient = JSON.parse(ingredient);
    /* Adding ingredient to global window.userFlavor */
    window.userFlavor.ingredients.push(ingredient);
    updateSummary();
}

/**
 * Remove selected ingredient from user defined flavor
 * and updates flavor summary
 */
 function removeIngredient(element){
   /* Getting ingredient Object */
    var ingredient = $(element).parent().children("input[name='ingredient']").val();
    ingredient = JSON.parse(ingredient);

    var index = -1;
    /* Seach ingredient on Custom Flavor */
    for(var i = 0; i < window.userFlavor.ingredients.length; i++){
        /* If the ingredient was found */
        if(window.userFlavor.ingredients[i].id == ingredient.id){
            /* Set the index to remove */
            index = i;
            break;
        }
    }
    

    /* Removing the ingredient from array */
    if (index > -1) {
        window.userFlavor.ingredients.splice(index, 1);
    }else{
        alert("You do not have any " + ingredient.name + " to remove");
    }
    updateSummary();
}

/* Updates the HTML to match customFlavor ingredients*/
function updateSummary(){
    var html = "";
    for(var i = 0; i < window.userFlavor.ingredients.length; i++){
        html += window.userFlavor.ingredients[i].name;
        /*If it's not the last ingredient, append comma*/
        if(i != window.userFlavor.ingredients.length-1){
            html += ", ";
        }
    }
    if(html == "") html = "Empty Flavor";
    $("#customFlavorSummary").html(html);
}

/* WHEN CLICKED, A FLAVOR IS SETTED 
 * TO THE GLOBAL TRADITIONAL FLAVOR OBJECT
 */
 function setFlavor(element){
    //Presentation
    /* Clear all flavor li's active*/
    $("li[id^='flavor']").removeClass('activeFlavor');
    
    var id = element.value;
    var li = $("#flavor"+id);
    /*Changing li class to active*/
    $("#flavor"+id).addClass('activeFlavor');
    //Presentation

    /*Setting window.userFlavor*/
    var flavor = $(element).children("input[name='flavor']").val();
    flavor = JSON.parse(flavor);  
    window.traditionalFlavor = new Flavor(flavor.id,
                                            flavor.name,
                                            flavor.description,
                                            flavor.picturePath,
                                            flavor.ingredients);
}

/* Resets window.userFlavor object and updates summary */
function resetSummary(){
    /* reseting custom flavor array of ingredients */
    window.userFlavor.ingredients.length = 0;
    updateSummary();
}

/* Resets the flavor */
function resetFlavor(){
    /* Clear all flavor li's active*/
    $("li[id^='flavor']").removeClass('activeFlavor');

    /* Clear flavor object*/
    window.traditionalFlavor = null;
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
    var ingredient = $("li[name='ingredientListItem']:first").children("input").val();
    ingredient = JSON.parse(ingredient);
    $("#ingredientColumn .caption").html(ingredient.description);
    $("#ingredientColumn h3").html(ingredient.name);
    $("#ingredientColumn img").attr('src','/PizzaBuilder/resources/images/' + ingredient.picturePath);  
    
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
        if(window.userFlavor.ingredients.length > 0){
            /* Setting card html */
            $("#flavorCard" + targetID + " .caption").html(getFlavorIngredients(window.userFlavor));
            $("#flavorCard" + targetID + " h3").html(window.userFlavor.name);
            $("#flavorCard" + targetID + " img").attr('src','/PizzaBuilder/resources/images/' + window.userFlavor.picturePath);
            /* Adding window.userFlavor to flavors array*/
            window.allFlavors[parseInt(targetID)] = window.userFlavor;
            /* Saving json object in hidden input */
            $(".flavorDiv[data-value='"+ targetID +"']").children("input").val(
                JSON.stringify(window.userFlavor)
            );
        }else{
            return alert("You have not chosen any ingredients");
        }

    }
    /*Else, is a traditional flavor*/
    else{
        if(window.traditionalFlavor != null){
            /* Setting card html */
            $("#flavorCard" + targetID + " .caption").html(getFlavorIngredients(window.traditionalFlavor));
            $("#flavorCard" + targetID + " h3").html(window.traditionalFlavor.name);
            $("#flavorCard" + targetID + " img").attr('src','/PizzaBuilder/resources/images/' + window.traditionalFlavor.picturePath);
            
            /* Adding window.userFlavor to flavors array*/
            window.allFlavors[parseInt(targetID)] = window.traditionalFlavor; //CLONE HERE
            /* Saving json object in hidden input */
            $(".flavorDiv[data-value='"+ targetID +"']").children("input").val(
                JSON.stringify(window.traditionalFlavor)
            );
        }else{
            return alert("You didn't select any flavor");
        }        
    }
    /* Updates the title with flavors name */
    updateToppings();
    pane.modal('toggle');
}

function toggleBuilderRow(type, option){
    var row = $("#" + type + "Column").find(".cardDivWrapper");
    var time = 200;
    var fx = "easeOutSine";
    var cssClass = "hiddenRow";
    //var invisible = row.hasClass('hide');
    var invisible = !row.is(':visible');

    if(option === undefined ){

        if(invisible){
            row.show(time);
            //row.removeClass('hide');
            //row.css('display','inline-block');
            invisible = false;
        }else{
            row.hide(time);
            //row.addClass('hide');
            invisible = true;
        }
    }else{  

        if(option == 'hide'){
            row.hide(time);
            //row.addClass('hide');
            invisible = true;
        }else{
            row.show(time);
            //row.removeClass('hide');
            //row.css('display','inline-block');
            invisible = false;
        }

    }

    /* Swapping PLUS/MINUS sign icon */
    var i = $("#" + type + "Column").find("h2 i");
    if(!invisible){
        i.removeClass("glyphicon-plus-sign");
        i.addClass("glyphicon-minus-sign");
    }else{
        i.removeClass("glyphicon-minus-sign");
        i.addClass("glyphicon-plus-sign");
    }
}

/* Checks if the user completed all options
 * of pizzaBuilder
 */
 function checkPizzaBuilder(){
    updateLayout();
    //Checking if user selected a size
    var sizeID = checkPizzaPart('size');
    var msg = "Fix the following:\n";
    var error = false;
    if(sizeID == -1){
        msg += "Choose a size\n";
        error = true;
    }
    
    //Checking if user selected a crust type
    var crustID = checkPizzaPart('crust');
    if(crustID == -1){
        msg += "Choose a crust type\n";
        error = true;
    }

    //Checking if user selected an edge
    var edgeID = checkPizzaPart('edge');
    if(edgeID == -1){
        msg += "Choose an edge\n";
        error = true;
    } 

    //Checking if user selected a layout
    var layoutID = checkPizzaPart('layout');
    if(layoutID == -1){
        msg += "Choose a layout\n";
        error = true;
    }else{
        //User selected a layout, let's check flavors...

        //Count how many flavors user should choose
        var numberOfFlavors = parseLayoutPattern(window.userLayout.pattern);

        /* in window.allflavors array:
         * its flavors are placed based on numberofflavors.
         * (ex: if user select 3-flavor layout, then the flavors
         * are going to be indexed: 1,2,3). That causes the 0 index
         * to be empty, but valid, so window.allFlavors.length does not
         * tell us exactly how much flavors this array has,
         * so if there's any element at the array, remove 1 (0 index)
         */
        var chosenFlavors = window.allFlavors.length;
        if(chosenFlavors > 0){
            chosenFlavors = chosenFlavors - 1;
        }

        /* If user did not select all flavors slots */
        if(chosenFlavors < numberOfFlavors){
            msg += "Your layout needs " + numberOfFlavors + " topping(s), you have selected " + 
                chosenFlavors + "\n";
            error = true;
        }
    }
    /** If some attribute is missing, show errors
     * Else create pizza and submit
     */
    if(error){
        alert(msg);
    }else{
        createPizzaFromBuilder(sizeID,crustID,edgeID,layoutID);
    }   

    return !error; 
}

/**
 * Checks if the user has selected a specific part
 * for the pizza (size, crust, edge, layout...).
 * Returns the id of chosen part or -1 if no item is 
 * selected.
 */
 function checkPizzaPart(part){
    var panel = $("div[name='"+part+"Item']").children("div[data-value='true']");
    var id = -1;
    if(panel.length >0){
        id = panel.parent().attr('data-id');
    }    
    return id;
}


function createPizzaFromBuilder(sizeID,crustID,edgeID,layoutID){
    var flavors = window.allFlavors.slice(1);
    var obs = $(".obsTextArea textarea").val();
    var id = -1;
    var name = "";
    var description = "";
    var picturePath = "";

    var editingPizza = $("#editingFlavorDiv");
    if(editingPizza.length == 1){
        editingPizza = editingPizza.children("input[name='pizza']").val();
        editingPizza = JSON.parse(editingPizza);
        id = editingPizza.id;
        name = editingPizza.name;
        description = editingPizza.description;
        picturePath = editingPizza.picturePath;
    }

    var pizza = new Pizza(id,name,description,picturePath,sizeID,crustID,edgeID,layoutID,flavors,obs);
    
    var jsonString = JSON.stringify(pizza);
    
    $("#pizzaBuilderForm input[name='userPizza']").val(jsonString);
    document.getElementById("pizzaBuilderForm").submit();

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
  /*SETTING BUILDER SIZE ROW TO TOGGLE SIZE CARDS VISIBILITY WHEN CLICKED*/
  $("#sizeColumn h2").click(function(e){
    toggleBuilderRow('size');
});
  /* SETTING CRUST CARDS TO SELECT ON CLICK */
  $("div[name='crustItem']").click(function(e){
    selectCard(this.id,'crust');    
});
  /*SETTING BUILDER CRUST ROW TO TOGGLE CRUST CARDS VISIBILITY WHEN CLICKED*/
  $("#crustColumn h2").click(function(e){
    toggleBuilderRow('crust');
});
  /* SETTING EDGE CARDS TO SELECT ON CLICK */
  $("div[name='edgeItem']").click(function(e){
    selectCard(this.id,'edge');    
});
  /*SETTING BUILDER EDGE ROW TO TOGGLE EDGE CARDS VISIBILITY WHEN CLICKED*/
  $("#edgeColumn h2").click(function(e){
    toggleBuilderRow('edge');
});
  /* SETTING LAYOUT CARDS TO BEHAVE ON CLICK */
  $("div[name='layoutItem']").click(function(e){
    selectCard(this.id,'layout'); 
    updateLayout();   
});
  /*SETTING BUILDER EDGE ROW TO TOGGLE EDGE CARDS VISIBILITY WHEN CLICKED*/
  $("#layoutColumn h2").click(function(e){
    toggleBuilderRow('layout');
});

  /*SETTING BUILDER FLAVOR ROW TO TOGGLE VISIBILITY WHEN CLICKED*/
  $("#flavorColumn h2").click(function(e){
    toggleBuilderRow('flavor');
});
  /*SETTING BUILDER FLAVOR ROW TO TOGGLE VISIBILITY WHEN CLICKED*/
  $("#obsColumn h2").click(function(e){
    toggleBuilderRow('obs');
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
  $("#builderDiv button").click(function(e){
    checkPizzaBuilder();
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