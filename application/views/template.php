<?php
	if(!isset($params))
	{
		$params = array();
	}
	
    $this->load->view('_header');
    $this->load->view($page,$params);
    $this->load->view('_footer');
?>