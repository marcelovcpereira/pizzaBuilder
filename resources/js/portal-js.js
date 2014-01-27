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