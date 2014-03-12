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
                        'class' => 'form-control',
                        'tabindex' => '1');
    //Last Name of the new user
    $last_name = array('id' => 'last_name',
                        'name' => 'last_name',
                        'value' => set_value('last_name'),
                        'class' => 'form-control',
                        'tabindex' => '2');
    //Email of the new user
    $email = array('id' => 'email',
                        'name' => 'email',
                        'value' => set_value('email'),
                        'class' => 'form-control',
                        'tabindex' => '3');
    //Email confirmation of the new user
    $email_confirm = array('id' => 'email_confirm',
                        'name' => 'email_confirm',
                        'value' => set_value('email_confirm'),
                        'class' => 'form-control',
                        'tabindex' => '4');
    //Password of the new user
    $password = array('id' => 'password',
                        'name' => 'password',
                        'class' => 'form-control',
                        'tabindex' => '5');
    //Password confirmation of the new user
    $password_confirm = array('id' => 'password_confirm',
                        'name' => 'password_confirm',
                        'class' => 'form-control',
                        'tabindex' => '6');
    //Submit button
    $submit = array('id' => 'submit',
                    'name' => 'submit',
                    'value' => 'Register',
        'class' => 'btn btn-default');
    
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
    $CI = &get_instance();
    $addr_type = $CI->address_model->get_dropdown_enum('address','type');
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
<?php 
    require_once 'ci__history.php';
?>
<!-- End of fields configuration -->
<div id="registerContainer" class='container'>
    <div name="errorsDiv" class="row">
        <div class='col-lg-12'>
            <?php if(validation_errors() OR isset($error) ): ?>
                <!-- bootstrap danger alert panel -->
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <strong>Fix the form errors below</strong>

                    <!--CodeIgniter Validation Errors-->
                    <?php

                        /*if(validation_errors())
                        {
                            //echo validation_errors();
                            echo form_error('name');
                            echo form_error('last_name');
                            echo form_error('email');
                            echo form_error('email_confirm');
                            echo form_error('password');
                            echo form_error('password_confirm');
                        }*/

                    ?>

                    <!--Database Errors-->
                    
                </div> <!-- bootstrap danger alert panel -->
            <?php endif; ?>
        </div><!-- Div: First Column -->
    </div>
    <!-- DIV: ROW1 -->
    <div class='row'>
        <!-- Div: First Column: empty -->
        <div class='col-xs-3'>            
        </div><!-- Div: First Column -->
        
        <!-- Open the Form -->
        <?php echo form_open('auth/register', $formParams, $hiddens); ?>
        
        <!-- Div: Second Column: Register Form -->
        <div class='col-xs-6'>
            <!--DIV: the user data form as a Bootstrap Panel-->
            <div class="panel panel-default">
                <!--Prints the panel heading -->
                <div class='panel-heading'>
                    {form_title}                    
                </div>
                
                <!--DIV: The form panel body -->
                <div class='panel-body'>
                    
                        <div class="row">
                            <div class="col-lg-6">
                                <label for='name'>{name}</label>
                                <?php echo form_input($name);
                                      echo form_error('name');
                                ?>

                                
                                <label for='email'>{email}</label>
                                <?php echo form_input($email);
                                    echo form_error('email');
                                ?>
                                
                                <label for='password'>{password}</label>
                                <?php echo form_password($password);
                                    echo form_error('password');
                                ?>
                                
                                <br>
                                
                                <!-- TOGGLE SHOW ADDRESS -->
                                <!--<a id="addressToggle" href='#'><span class='label label-default pull-left'>{show_address_toggle}</span></a>                                
                                <span>(optional)</span>-->
                            </div>
                            <div class="col-lg-6">
                                <label for='last_name'>{last_name}</label>
                                <?php echo form_input($last_name);
                                    echo form_error('last_name');
                                ?>

                                <label for='confirm_email'>{confirm_email}</label>
                                <?php echo form_input($email_confirm);
                                    echo form_error('email_confirm');
                                ?>

                                <label for='confirm_password'>{confirm_password}</label>
                                <?php echo form_password($password_confirm);
                                    echo form_error('password_confirm');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- SUBMIT BUTTON -->
                                <?php echo form_submit($submit);?>
                            </div>
                        </div>
                </div><!--DIV: The form panel body -->
            </div><!--DIV: the user data form as a Bootstrap Panel-->
                
            <br>
                      
        </div><!-- Div: Second Column:  -->
        <!-- Div: Third Column -->
        <div class="col-xs-3">
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
