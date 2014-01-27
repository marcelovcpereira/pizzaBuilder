<!-- EXPECTED PARAMETERS: $username, $user_id,$name,$last_name-->
<div id="container" class="principal">
    
    
    <?php if (isset($user)){ ?>
    <!--If the user IS specified (the user whose profile is being seen -->        
        <h2><?php echo $user->getName().' '.$user->getLastName(); ?></h2>
        
        <div id="profileDiv" class="perfil3colunas">
            
            <div class="coluna">
                <div class="title">Personal</div>
                <p>
                    <?php 
                        echo $user->getName() . $user->getLastName() ;
                        echo br(1);
                        echo $user->getUsername();
                    ?>
                </p>
            </div>
            
            <div class="coluna">
                <div class="title">Address</div>
                <p>
                    <?php 
                        $address = $user->getAddress();
                        echo $address->getType() . ' ' . $address->getName() . 
                                ', ' . $address->getNumber(); 
                        
                        echo "<br>" . $address->getCity() . ', ';
                        echo $address->getState() . ' - ';
                        echo $address->getCountry();
                        echo "<br>Postal Code: " . $address->getPostalCode();
                        echo "<br>" . $address->getAdditionalInfo();
                    ?>
                </p>
            </div>
            
        </div>
        
    <?php }else{ ?>
    <!--If the user is NOT specified -->        
    
    <div class="errorDiv">No user found.</div>
        
        
    <?php } ?>
          
    
</div>