<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


class ClonardControllerStepone extends JController
{
	function display()
	{
        $mainframe =& JFactory::getApplication();
	    $currentUser =& JFactory::getUser();
        
        if($currentUser->get('guest')) {
            $uri = JFactory::getURI();
            $return = $uri->toString();
            $url = 'index.php?option=com_user&view=login';
            $url .= '&return='.base64_encode($return);
            
            $mainframe->redirect($url, JText::_('You must login first') );        
        }
        
        if($currentUser->usertype == "Administrator") {
            $mainframe->redirect('index.php?option=com_clonard&view=admin');
        }
	   
	    parent::display();
	}
    
    
    function save() {
        $currentUser =& JFactory::getUser();
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel('stepone');
        $session =& JFactory::getSession();
        $session->clear('errors');
        
	    $parent = array();
	    $errors = array();
	   
        $other = JRequest::getString('province2', '', 'POST');
        $parent['userid'] = $currentUser->id;
        $parent['title'] = JRequest::getWord('title', '', 'POST');	   
	    $parent['name'] = JRequest::getString('name', '', 'POST');
	    $parent['surname'] = JRequest::getString('surname', '', 'POST');
	    $parent['email'] = JRequest::getString('email', '', 'POST');
	    $parent['phone'] = JRequest::getInt('phone', '', 'POST');
	    $parent['cell'] = JRequest::getInt('cell', '', 'POST');
	    $parent['fax'] = JRequest::getInt('fax', '', 'POST');
	    $parent['address'] = JRequest::getString('address', '', 'POST');
	    $parent['code'] = JRequest::getString('code', '', 'POST');  
	    $parent['postaladd'] = JRequest::getString('postaladd', '', 'POST');
	    $parent['postalcode'] = JRequest::getString('postalcode', '', 'POST'); 
        $parent['comments'] = JRequest::getString('comments', '', 'POST');
        $parent['city'] = JRequest::getString('city', '', 'POST');
        $parent['province'] = JRequest::getString('province', '', 'POST');
        
	    if($parent['province'] == "other") 
	    {
		    if (empty($other)  || strlen($other) < 4) 
		        $errors['province2'] = 'Invalid province';
			   
		    $parent['province'] = $other;
	    }
	    else
	    {
	      if(empty($parent['province']) || strlen($parent['province']) < 4)   
	       $errors['province'] = 'Invalid province number';
	    }
		   
	   
	    if(empty($parent['title'])) 
	        $errors['title'] = 'Please fill in the title';
	    if(empty($parent['name'])) 
	        $errors['name'] = 'Please fill in the name';
	    if(empty($parent['surname'])) 
	        $errors['surname'] = 'Please fill in the name';
	    if(empty($parent['email']) || !preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $parent['email'])) 
	        $errors['email'] = 'Invalid email address';
	    if(empty($parent['phone']) || strlen($parent['phone']) < 9) 
	        $errors['phone'] = 'Invalid telephone number';
	    if (empty($parent['address']) || strlen($parent['address']) < 8) 
	        $errors['address'] = 'Invalid telephone number';
	    if (empty($parent['code']) || strlen($parent['code']) < 4) 
	        $errors['code'] = 'Invalid telephone number';
	    if (empty($parent['postaladd']) || strlen($parent['postaladd']) < 8) 
	        $errors['postaladd'] = 'Invalid telephone number';
	    if (empty($parent['postalcode']) || strlen($parent['postalcode']) < 4) 
	        $errors['postalcode'] = 'Invalid telephone number';  
	    if (empty($parent['city']) || strlen($parent['city']) < 4) 
	        $errors['city'] = 'Invalid telephone number';
	    if (!empty($parent['comments'])) 
	        $this->set('comments', $parent['comments']);
 
	    $session->set('parent', $parent);
        
        if (count($errors) > 0) {
            $session->set('errors', $errors);
            $session->set('stepone', false);
           
            $mainframe->redirect('index.php?option=com_clonard&view=stepone', 'Missing feilds error',  'error');      
        }
        else {
            $session->set('stepone', 'complete');
            $session->set('new', 'yes');
            $session->get('total', 0);
            
            $success = $model->createParent($parent);
            
            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=steptwo');
            }
            else {
                $errors['database'] = 'Database error';
                $session->set('errors', $errors);
                $session->set('stepone', false);
                
                $mainframe->redirect('index.php?option=com_clonard&view=stepone', 'Database error',  'error');
            }
        }
    }
}
