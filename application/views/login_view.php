<?php
    /**
     * Initializing Form Components Attributes
     * This form has:
     * {form_title}
     * label {username} for input UserName
     * label {password} for input UserPassword
     * {sign_in} (submit button)
     */



    //username input field params
    $usernameParams = array('id' => 'username',
                    'name' => 'username',
                     'value' => set_value('username'), //repopulates the input when validation fails
                     'placeholder' => 'Username', //bootstrap hint inside the input
                     'class' => 'form-control' );  //bootstrap class         

    //Password input field params
    $passwordParams = array('id' => 'password',
                    'name' => 'password',//never set_value() to repopulate a pass 
        'placeholder' => 'Password', //hint inside the input
        'class' => 'form-control'); //bootstrap class


    //Submit button
    $submitParams = array('id' => 'submit',
                  'name' => 'submit',
                  'value' => '{sign_in}',                        
                  'class' => 'btn btn-default');
    
    //Initializing Form bootstrap attribute
    $formParams = array(
      'role' => 'form'
    );
?><!-- End Form Configuration -->

<!------------------------------------------------------------------------
-------------------STARTING THE ACTUAL PAGE TEMPLATE ---------------------
------------------this view has 1 row and 3 columns:----------------------
-|     EMPTY      |        FORM LOGIN            |      EMPTY         |---
------------------------------------------------------------------------->
<!-- FULL LOGIN PAGE DIV CONTAINER -->
<div id="container" class="container">
    <!-- DIV: ROW1 -->
    <div class='row'>
        <!-- Div: First Column -->
        <div class="col-xs-4"></div><!-- Div: First Column -->

        <!-- Div: Second Column: LoginForm -->
        <div class="col-xs-4">
        <!---------------------------------------------------
        ---Print form validation errors, if there is some ---
        ---If there are database errors, print them too -----
        ---------------------------------------------------->
        <?php if(validation_errors() OR isset($error) ){ ?>
            <!-- bootstrap danger alert panel -->
            <div class="alert alert-danger">
                <strong>Error:</strong>

                <!--CodeIgniter Validation Errors-->
                <?php if(validation_errors()) echo validation_errors();  ?>

                <!--Database Errors-->
                <?php if(isset($error))echo $error; ?>
            </div> <!-- bootstrap danger alert panel --> 

        <?php } ?>

        <!-- Open the login form -->
        <?php echo form_open('portal/login', $formParams); ?>  
            <!-- Form Panel -->
            <div class="panel panel-default">
                <!-- Form Heading -->
                <div class="panel-heading">
                    {form_title}
                </div><!-- Form Heading -->

                <!-- Form Body -->
                <div class="panel-body">
                    <!-- username label and input -->
                    <label for="username">{username}</label><?php echo form_input($usernameParams);?></p>

                    <!-- password label and input -->
                    <label for="password">{password}</label><?php echo form_password($passwordParams);?></p>
                    
                    <!-- Print the Form Submit Button -->
                    <?php echo form_submit($submitParams); ?>
                    
                </div><!-- Form Body -->
            </div><!-- Form Panel -->   
        <?php echo form_close(); ?> <!-- Close the login form -->
        </div><!-- Div: Second Column: LoginForm -->

        <!-- Div: Third Column -->
        <div class="col-xs-4"></div><!-- Div: Third Column -->
    </div><!-- DIV: ROW1 -->
</div><!-- FULL LOGIN PAGE DIV CONTAINER -->