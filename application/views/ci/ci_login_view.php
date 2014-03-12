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
                     'placeholder' => 'Enter your email', //bootstrap hint inside the input
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

<?php 
    require_once 'ci__history.php';
?>

<!-- FULL LOGIN PAGE DIV CONTAINER -->
<div id="loginContainer" class="container">
    <div class="row">
      <div class="col-lg-12">
          <?php if(validation_errors()){ ?>
            <!-- bootstrap danger alert panel -->
            <div name="errorsDiv" class="alert alert-danger">
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                <strong>Fix the form errors below</strong>
            </div> <!-- bootstrap danger alert panel --> 

          <?php }elseif(isset($error)){ ?>
                <!-- bootstrap danger alert panel -->
            <div name="errorsDiv" class="alert alert-danger">
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                <strong><?php echo $error; ?></strong>
            </div> <!-- bootstrap danger alert panel --> 
          <?php } ?>
      </div>
    </div>
    <!-- DIV: ROW1 -->
    <div class='row'>
        <!-- Div: First Column -->
        <div class="col-xs-4"></div><!-- Div: First Column -->

        <!-- Div: Second Column: LoginForm -->
        <div class="col-xs-4">
        

        <!-- Open the login form -->
        <?php echo form_open('auth', $formParams); ?>  
            <!-- Form Panel -->
            <div class="panel panel-default">
                <!-- Form Heading -->
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-user"> </i>
                </div><!-- Form Heading -->

                <!-- Form Body -->
                <div class="panel-body">
                    <!-- username label and input -->
                   <!-- <label for="username">{username}</label>-->
                   <?php echo form_input($usernameParams);
                        echo form_error('username');
                   ?>

                    <!-- password label and input -->
                    <!--<label for="password">{password}</label>-->
                    <?php echo form_password($passwordParams);
                      echo form_error('password');
                    ?>
                    
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