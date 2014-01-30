<?php
//Some variable initialization
//Images folder
$_images = site_url() . 'resources/images/';

if (!isset($pizza)) {
    die("empty pizza item");
}
//Creating variables to the layout
$_id = $pizza->getId();
$_name = $pizza->getName();
$_description = $pizza->getDescription();
$_pic = $_images . $pizza->getPicturePath();
$_imgAlt = $_name . ' Image';
?>

<!-- Menu Item -->
<div name="menuItem<?php echo $_id ?>" id="menuItem" class="col-sm-6 col-md-4 col-lg-3" 
     value="false" 
     data-toggle="popover">    
    <a href="javascript:popPizzaDetails('<?php echo $_id; ?>','<?php echo $_name ?>')" >
        <!-- PANEL -->
        <div class="panel panel-default">
            
            <!-- PANEL BODY -->
            <div class="panel-body thumbnail">
                <img class="img-circle" src="<?php echo $_pic; ?>" 
                     alt="<?php echo $_imgAlt ?>">            
            </div><!-- PANEL BODY -->
 
            <!-- PANEL FOOTER -->
            <div class="panel panel-footer"> 
                <div class="pizzaText">
                    <!-- PIZZA NAME -->
                    <h3><?php echo $_name ?></h3>

                    <!-- DESCRIPTION -->
                    <span class="caption">
                        <?php echo $_description ?>
                    </span>
                    <br>
                    
                </div>
                
                <!-- HIDDEN DETAILS DIV -->
                <div id="content<?php echo $_id ?>" class="sr-only">
                    <?php 
                        echo $_description;
                    ?>
                </div><!-- HIDDEN DETAILS DIV -->
                
            </div><!-- PANEL FOOTER -->

            <div class="botao">
                <!-- BUTTON  --> 
                    <button type="button" class="btn btn-warning">Add</button>
                </div>
        </div><!-- PANEL -->
    </a>
</div><!-- Menu Item -->
