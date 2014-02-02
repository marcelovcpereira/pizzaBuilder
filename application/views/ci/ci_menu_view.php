<!-- Foreach pizza of the menu, load itemView -->
<?php
    $counter = 0;    
    foreach($pizzas as $pizza)
    { 
        //if this is the first column of the view
        //print the div opening new row in bootstrap
        if($counter === 0)
        {
            echo "<div class='row'>";
        }
        
        //Loads the pizza as an menu Item
        $this->load->view('ci/ci__menu_item_view',array('pizza'=>$pizza));  
        
        //If this is the fourth element, close the row
        if($counter === 3)
        {
            echo "</div>";
        }
        
        //counter that has 4 values (1,2,3,4)
        $counter = ($counter + 1)%4;
    }
?> 
