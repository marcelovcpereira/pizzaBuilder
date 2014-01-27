<!--Form fields configuration-->
<?php
    /**
     * Initializing Form Main Components Attributes
     * This form has:
     * {form_title}
     * label {username} for input UserName
     * label {last_name} for input LastName
     * label {email} for input UserEmail
     * label {confirm_email} for input ConfirmUserEmail
     * label {password} for input UserPassword
     * label {confirm_password} for input ConfirmUserPassword
     * {sign_in} (submit button)
     */

    //Name of the new user
    $name = array('id' => 'name',
                        'name' => 'name',
                        'value' => set_value('name'),
                        'placeholder' => 'First name',
                        'class' => 'form-control');
    //Last Name of the new user
    $last_name = array('id' => 'last_name',
                        'name' => 'last_name',
                        'value' => set_value('last_name'),
                        'placeholder' => 'Last name',
                        'class' => 'form-control');
    //Email of the new user
    $email = array('id' => 'email',
                        'name' => 'email',
                        'value' => set_value('email'),
                        'placeholder' => 'Email Address',
                        'class' => 'form-control');
    //Email confirmation of the new user
    $email_confirm = array('id' => 'email_confirm',
                        'name' => 'email_confirm',
                        'value' => set_value('email_confirm'),
                        'placeholder' => 'Confirm Email',
                        'class' => 'form-control');
    //Password of the new user
    $password = array('id' => 'password',
                        'name' => 'password',
                        'placeholder' => 'Password',
                        'class' => 'form-control');
    //Password confirmation of the new user
    $password_confirm = array('id' => 'password_confirm',
                        'name' => 'password_confirm',
                        'placeholder' => 'Confirm password',
                        'class' => 'form-control');
    //Submit button
    $submit = array('id' => 'submit',
                    'name' => 'submit',
                    'value' => 'Sign Up',
        'class' => 'btn btn-default pull-right');
    
    //Initializing Form bootstrap attribute
    $formParams = array(
      'role' => 'form'
    );
    
    //Hidden input that tells the controller if the user submitted address info
    $hiddens = array(
        'showAddress' => 'FALSE'       
    );
    

    //-------------address info:optional---------------//
    $addr_name = array(
        'id' => 'addr_name',
        'name' => 'addr_name',
        'value' => set_value('addr_name'),
                        'placeholder' => 'Street Name',
                        'class' => 'form-control'
    );

    $addr_type = $this->address_model->get_dropdown_enum('address','type');
    $addr_dropdownParams = "id='addr_type'";

    $addr_number = array(
        'id' => 'addr_number',
        'name' => 'addr_number',
        'value' => set_value('addr_number'),
                        'placeholder' => 'Number',
                        'class' => 'form-control'
    );
    $addr_addition = array(
        'id' => 'addr_addition',
        'name' => 'addr_addition',
        'value' => set_value('addr_addition'),
                        'placeholder' => 'Block, apartment, etc',
                        'class' => 'form-control'
    );
    $addr_city = array(
        'id' => 'addr_city',
        'name' => 'addr_city',
        'value' => set_value('addr_city'),
                        'placeholder' => 'City name',
                        'class' => 'form-control'
    );
    $addr_state = array(
        'id' => 'addr_state',
        'name' => 'addr_state',
        'value' => set_value('addr_state'),
                        'placeholder' => 'State name',
                        'class' => 'form-control'
    );
    $addr_country = array(
        'id' => 'addr_country',
        'name' => 'addr_country',
        'value' => set_value('addr_country'),
                        'placeholder' => 'Country name',
                        'class' => 'form-control'
    );

    $addr_postal = array(
        'id' => 'addr_postal',
        'name' => 'addr_postal',
        'value' => set_value('addr_postal'),
                        'placeholder' => 'zip or postal code',
                        'class' => 'form-control'
    );
    //-------------address---------------//


?>
<!-- End of fields configuration -->
  
<!------------------------------------------------------------------------
-------------------STARTING THE ACTUAL PAGE TEMPLATE ---------------------
------------------this view has 1 row and 3 columns:----------------------
-|   EMPTY OR ERROR   |        FORM REGISTER       |   EMPTY OR ADDR  |---
------------------------------------------------------------------------->  
<!-- FULL Register PAGE DIV CONTAINER -->
<div id="container" class='container'>
    <!-- DIV: ROW1 -->
    <div class='row'>
        <!-- Div: First Column: ERRORS -->
        <div class='col-xs-4'>
            <!---------------------------------------------------
            ---Print form validation errors, if there is some ---
            ---If there are database errors, print them too -----
            ---------------------------------------------------->
            <?php if(validation_errors() OR isset($error) ){ ?>
                <!-- bootstrap danger alert panel -->
                <div class="alert alert-danger">
                    <strong>Error:</strong>

                    <!--CodeIgniter Validation Errors-->
                    <?php if(validation_errors()) echo validation_errors()."val";  ?>

                    <!--Database Errors-->
                    <?php if(isset($error))echo $error; ?>
                </div> <!-- bootstrap danger alert panel -->
            <?php } ?>
        </div><!-- Div: First Column -->
        
        <!-- Open the Form -->
        <?php echo form_open('portal/register', $formParams, $hiddens); ?>
        
        <!-- Div: Second Column: Register Form -->
        <div class='col-xs-4'>
            <!--DIV: the user data form as a Bootstrap Panel-->
            <div class="panel panel-default">
                <!--Prints the panel heading -->
                <div class='panel-heading'>
                    {form_title}                    
                </div>
                
                <!--DIV: The form panel body -->
                <div class='panel-body'>
                    
                        <label for='name'>{name}</label>
                        <?php echo form_input($name);?>
                        
                        <label for='last_name'>{last_name}</label>
                        <?php echo form_input($last_name);?>
                        
                        <label for='email'>{email}</label>
                        <?php echo form_input($email);?>
                        
                        <label for='confirm_email'>{confirm_email}</label>
                        <?php echo form_input($email_confirm);?>
                        
                        <label for='password'>{password}</label>
                        <?php echo form_password($password);?>
                        
                        <label for='confirm_password'>{confirm_password}</label>
                        <?php echo form_password($password_confirm);?>
                        <br>
                        
                        <!-- TOGGLE SHOW ADDRESS -->
                        <a id="addressToggle" href='#'><span class='label label-default pull-left'>{show_address_toggle}</span></a>
                        
                        <!-- SUBMIT BUTTON -->
                        <?php echo form_submit($submit);?>
                </div><!--DIV: The form panel body -->
            </div><!--DIV: the user data form as a Bootstrap Panel-->
                
            <br>
                      
        </div><!-- Div: Second Column:  -->
        <!-- Div: Third Column -->
        <div class="col-xs-4">
            <!-- Prints the user ADDRESS form -->
                <div id="addressPanel" class="panel panel-default"> 
                    <!-- DIV: ADDRESS FORM: TITLE -->
                    <div class='panel-heading'>{address_panel}</div><!-- DIV: ADDRESS FORM: TITLE -->

                    <!-- DIV: ADDRESS FORM: BODY-->
                    <div class='panel-body'>
                        <!-- Prints the dropdown box with ADDRESS TYPE VALUES -->
                        <label for='addr_type'>{address_type}</label><br>
                        <?php echo form_dropdown('addr_type', $addr_type, 'Avenue', $addr_dropdownParams); ?>
                        <br>
                        
                        <!-- Address Name: Label and Input -->
                        <label for='addr_name'>{address}</label>
                        <?php echo form_input($addr_name);?>
                        
                        <!-- Address Number: Label and Input -->
                        <label for='addr_number'>{number}</label>
                        <?php echo form_input($addr_number);?>

                        <!-- Address Complement: Label and Input -->
                        <label for='addr_addition'>{add_info}</label>
                        <?php echo form_input($addr_addition);?>

                        <label for='addr_city'>{city}</label>
                        <?php echo form_input($addr_city);?>

                        <label for='addr_state'>{state}</label>
                        <?php echo form_input($addr_state);?>

                        <label for='addr_country'>{country}</label>
                        <?php echo form_input($addr_country);?>

                        <label for='addr_postal'>{zip}</label>
                        <?php echo form_input($addr_postal);?>
                    </div><!-- DIV: ADDRESS FORM: BODY-->
                </div><!-- Prints the user ADDRESS form -->
        </div><!-- Div: Third Column -->
        
        <!--The form will wrap the two right-most columns of the page -->
        <?php   echo form_close(); ?> <!-- closing form -->  
        
    </div><!-- DIV: ROW1 -->
</div><!-- FULL Register PAGE DIV CONTAINER -->
