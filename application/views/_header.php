<!DOCTYPE html>
<html lang="en">
<head>
        
        <!-- Loading Bootstrap Template -->
        <?php echo link_tag( base_url()  . 'resources/css/bootstrap.css'); ?>
        <!-- Loading OWN CSS -->
        <?php echo link_tag(base_url().'resources/css/portal-template.css'); ?>
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <meta charset="utf-8">
	
        <title>{header_title}</title>

	
</head>
<body>
    <!-- ROW1: Contains NAVBAR -->
    <div class="row">
        <!-- Div:NAVBAR -->
	<div class="navbar navbar-default" role="navigation">
            
            <!-- BAVBAR Header -->
            <div class="navbar-header pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>                    
                <a class="navbar-brand" href="<?php echo site_url(); ?>">{product_name}</a>                        
                    
            </div><!-- BAVBAR Header -->
           
            <!-- NAVBAR MENU -->
            <div class="collapse navbar-collapse">
                <!-- MAIN MENU -->
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo site_url(); ?>">{home}</a></li>
                    <li><a href="<?php echo site_url() . 'menu'; ?>">{menu}</a></li>
                    <li><a href="<?php echo site_url() . 'about'; ?>">{about}</a></li>
                </ul><!-- MAIN MENU -->
                
                <?php /*    --Uncomment in v0.2
                <!-- ACCOUNT BUTTON -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- AccountItem -->
                    <li class="dropdown">
                        <!-- AccountLink and AccountCaret -->
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            {account}<b class="caret"></b>
                        </a>
                        <!-- AccountSubMenu -->
                        <ul class="dropdown-menu">
                            
                            <!-- if the user is not logged in, Show Login and Signup -->
                            <?php if(!$this->session->userdata('user')){ ?>
                                <!-- SubItem Login -->
                                <li><a href="<?php echo site_url() . 'login'; ?>">{login}</a></li>
                                <!-- SubItem SignUP -->
                                <li><a href="<?php echo site_url() . 'register'; ?>">{sign_up}</a></li>

                            <?php }else{ ?>
                                <!-- SubItem Logout -->
                                <li><a href="<?php echo site_url() . 'logout'; ?>">{logout}</a></li>
                            <?php } /*End if the user is logged in*/ ?>
                            
                <?php /*    --Uncomment in v0.2            
                        </ul><!-- AccountSubMenu -->
                    </li><!-- AccountItem -->
                </ul><!-- ACCOUNT BUTTON -->
                */ ?>
                
            </div><!-- NAVBAR MENU -->
            
            
            
            
	</div><!-- Div:NAVBAR -->
    </div><!-- ROW1: Constains NAVBAR -->