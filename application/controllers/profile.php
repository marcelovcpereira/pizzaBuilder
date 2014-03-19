<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';

/**
 * Controller that handles User profile changes.
 * User favorite pizzas, user comments, order history...
 */
class Profile extends CI_Controller {

    /**
     * Default action of the controller
     */
    public function index() {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }

        $this->configwrapper->append(array('history_title' => 'Profile'));
        $this->templatewrapper->load('profile_view',$this->configwrapper->toArray());
        
    }
    /* Action that adds a default pizza (custom pizzas are currently being added by cart ADD action)
     * as favorite to the current user */
    public function addFavoritePizza($pizzaId=null)
    {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }

        /* If the id is null, go home! We don't need pranksters!!!! =p */
        if($pizzaId !== null)
        {            
            //Get current user
            $user = $this->authwrapper->getUser();
            $userId = $user->getId();

            $this->load->model('user_model');
            //Add the pizza as favorite to the user
            $this->user_model->addFavoritePizza($userId,$pizzaId);

            //Updates current user object with the new favorite pizza
            $user->addFavorite($pizzaId);
            //Save updated user in session
            $this->session->set_userdata('user', serialize($user));

            redirect('profile/favorites');      
        }
        else
        {
            redirect('profile');
        }  
    }

    /* Action that removes a pizza (any) as favorite to the current user */
    public function removeFavoritePizza($pizzaId)
    {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }
        if($pizzaId !== null)
        {
            //Get current user
            $user = $this->authwrapper->getUser();
            $userId = $user->getId();

            $this->load->model('user_model');
            //Remove favorite from user
            $this->user_model->removeFavoritePizza($userId,$pizzaId);

            /* Checks if this is a custom pizza, if so, delete it from table */
            $this->load->model('pizza_model');
            $pizza = $this->pizza_model->fetch($pizzaId);
            if($pizza->getType() == 'user')
            {
                $this->pizza_model->delete($pizza);
            }
            //Updating user object
            $user->removeFavorite($pizzaId);
            //Save updated user in session
            $this->session->set_userdata('user', serialize($user));

            redirect('profile/favorites');      
        }
        else
        {
            redirect('profile');
        }  
    }
    /* Action that shows the user's favorites page. */
    public function favorites()
    {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }

        $this->load->model('user_model');
        //Getting user favorite Pizzas (objects)
        $favorites = $this->user_model->getFavorites($this->authwrapper->getUser()->getId());
        
        $this->configwrapper->append(array('history_title' => 'Profile', 'selected'=>'favorite','favorites'=>$favorites));
        $this->templatewrapper->load('profile_view',$this->configwrapper->toArray());
    }

    
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */