<?php 
    require_once 'ci__history.php';

    //Name input
    $nameParams = array('id' => 'name',
                    'name' => 'name',
                     'value' => set_value('name'), //repopulates the input when validation fails
                     'placeholder' => 'Your name', //bootstrap hint inside the input
                     'class' => 'form-control' );  //bootstrap class         

    //Email input
    $emailParams = array('id' => 'email',
                    'name' => 'email',//never set_value() to repopulate a pass 
        'placeholder' => 'Your email', //hint inside the input
        'class' => 'form-control'); //bootstrap class


    //Submit button
    $submitParams = array('id' => 'submit',
                  'name' => 'submit',
                  'value' => 'Send',                        
                  'class' => 'btn btn-default');

    $messageParams = array('id' => 'message',
                    'name' => 'message',
                    'value' => set_value('message'),
                    'placeholder' => 'Enter your message',
                    'class' => 'form-control');

    $hidden = array('secret'=>'');
    
    //Initializing Form bootstrap attribute
    $formParams = array(
      'role' => 'form'
    );
?>

<!-- ROW1: Contains NEWS DIV -->
<div id="contactContainer" class="container">
    <div id="contactRow" class="row">
            <div class="col-lg-12">  
                <?php if(isset($status)): ?>
                    
                    <div name="statusDiv" class="alert alert-success">
                        <i class="glyphicon glyphicon-ok"></i>
                        <strong><?php echo $status; ?></strong>
                    </div>
                    

                <?php endif; ?>

                <?php   echo form_open('contact', $formParams); 
                    if(validation_errors() || isset($error) ){ ?>
                            <!-- bootstrap danger alert panel -->
                            <div name="errorsDiv" class="alert alert-danger">
                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                <strong>Fix the form errors below</strong>
                            </div> <!-- bootstrap danger alert panel -->
                        <?php echo validation_errors()? validation_errors():$error . "<br/>";
                        }
                ?>  
                <!-- Form Panel -->   
                <div id="contactDiv" class="panel panel-default">
                    <!-- Form Heading -->
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-envelope pull-left"></i><h2>Send us your opinion</h2>
                    </div><!-- Form Heading -->
                    <!-- Form Body -->
                    <div class="panel-body">
                        <?php 

                            
                            
                            echo form_input($nameParams);
                            
                            echo form_input($emailParams);

                            echo form_textarea($messageParams);

                            echo form_hidden($hidden);

                            echo form_submit($submitParams); 
                        ?>
                    </div><!-- Form Body -->
                
   
                </div><!-- Form Panel -->   
                <?php echo form_close(); ?> <!-- Close the login form -->
            </div>
    </div><!-- ROW1: Contains NEWS DIV -->
</div>