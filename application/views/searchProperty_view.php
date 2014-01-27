<!-- EXPECTED PARAMETERS: $username, $user_id,$name,$last_name-->
<div id="container" class="principal">
    
    <h2>Search Apartments, Houses and Condos</h2>
   <div id="searchDiv" class="searchDiv">
       <?php 
            $intention = $this->property_model->get_dropdown_enum('property','status');
            $intention_extra = "id = 'property_status' class='property_status'";
            
            $submit = array('id' => 'submit',
                            'name' => 'submit',
                            'value' => 'Search',
                'class' => 'button');
            
            $location = array('id' => 'location',
                                'name' => 'location',
                                'value' => set_value('location'));
            
            $min_price = array('id' => 'min_price',
                                'name' => 'min_price',
                                'value' => set_value('min_price'));
            
            $max_price = array('id' => 'max_price',
                                'name' => 'max_price',
                                'value' => set_value('max_price'));
            
            $bedrooms = array('Studio','1+','2+','3+', '4+');
            $bedrooms_extra = "id = 'bedrooms' class='property_status'";
            
            $property_types = $this->property_model->get_dropdown_enum('property', 'type');
            $property_type_extra = "id = 'property_type' class='property_status'";
       ?>
       
       <?php echo validation_errors(); ?>
       
       <!-- Printing form -->
       <?php echo form_open('portal/searchProperty'); ?>
       <p>Do you want to:</p>
       <br><br><br>
       <p><?php echo form_dropdown('property_status', $intention, 'Rent', $intention_extra) ?></p>
       <br><br><br><br>
        <p style="float:left">Location: 
        <br> 
         <?php echo form_input($location); ?> </p>
        <br><br><br><br><br>
        <p>Min Price:</p>
        <br><br><br>
        <?php echo form_input($min_price); ?>
        <br><br><br>
        <p>Max Price:</p>
        <br><br><br>
        <?php echo form_input($max_price); ?>
        <br><br><br>
        <p>Property Type:</p>
        <br><br><br>
        <p><?php echo form_dropdown('property_type', $property_types, 'Apartment', $property_type_extra); ?></p>
        <br><br><br><br>
        <p>Bedrooms:</p>
        <br><br><br>
        <?php echo form_dropdown('bedrooms',$bedrooms, '1+',$bedrooms_extra); ?>
        <br><br><br>

        
        <?php echo form_submit($submit);?>
        <?php echo form_close(); ?>
        <!-- End Printing form -->
        
   </div>
          
    
</div>