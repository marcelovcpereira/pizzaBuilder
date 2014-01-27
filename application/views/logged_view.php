<!-- EXPECTED VARIABLES: $username, $user_id, $name, $last_name -->

<div id="container" >
    <div class="loggedDiv">
    <?php if (isset($user)){ ?>
    
        <?php
                $message = "You're successfully logged in {$user->getUsername()}, redirecting you to your profile.";
          
                echo anchor('portal/profile/'.$user->getId(),$message);
            
                header('Refresh:2;url='.  base_url() .'portal/profile/'.$user->getId());
            }
                 
        ?>
    </div>
          
    
</div>


