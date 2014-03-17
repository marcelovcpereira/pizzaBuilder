<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';

class Profile extends CI_Controller {

    /**
     * Default page of the Menu
     */
    public function index() {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }

        $this->configwrapper->append(array('history_title' => 'Profile'));
        $this->templatewrapper->load('profile_view',$this->configwrapper->toArray());
        
    }

    public function addFavoritePizza($pizzaId=null)
    {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }

        if($pizzaId !== null)
        {            
            $user = $this->authwrapper->getUser();
            $userId = $user->getId();

            $this->load->model('user_model');
            $this->user_model->addFavoritePizza($userId,$pizzaId);

            $user->addFavorite($pizzaId);
            $this->session->set_userdata('user', serialize($user));

            redirect('profile/favorites');      
        }
        else
        {
            redirect('profile');
        }  
    }

    public function removeFavoritePizza($pizzaId)
    {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }
        if($pizzaId !== null)
        {
            $user = $this->authwrapper->getUser();
            $userId = $user->getId();

            $this->load->model('user_model');
            $this->user_model->removeFavoritePizza($userId,$pizzaId);

            $user->removeFavorite($pizzaId);
            $this->session->set_userdata('user', serialize($user));

            redirect('profile/favorites');      
        }
        else
        {
            redirect('profile');
        }  
    }

    public function favorites()
    {
        /* If the user is not logged, send him to home */
        if (!$this->authwrapper->isLogged()) {
            redirect();
        }
        $this->load->model('user_model');
        $favorites = $this->user_model->getFavorites($this->authwrapper->getUser()->getId());
        $this->configwrapper->append(array('history_title' => 'Profile', 'selected'=>'favorite','favorites'=>$favorites));
        $this->templatewrapper->load('profile_view',$this->configwrapper->toArray());
    }

    
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */