<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardControllerSteptwo extends JController
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
        
        if ($currentUser->usertype == "Administrator") {
            $mainframe->redirect('index.php?option=com_clonard&view=admin');
        }
	   
	    parent::display();
	}
    
    function save() {
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel('stepone');
        $session =& JFactory::getSession();
        $session->clear('errors');
        
        $child = array();
	    $children = array();
	    $errors = array();
	   
	    if($session->has('children'))
		   $children = $session->get('children');
	   
	    $child['name'] = JRequest::getString('name', '', 'POST');
	    $child['surname'] = JRequest::getString('surname', '', 'POST');
	    $child['dob'] = JRequest::getString('dob', '', 'POST');
	    $child['gender'] = JRequest::getWord('gender', '', 'POST');
        $child['grade'] = JRequest::getString('grade', '', 'POST');	
        $child['gradepassed'] = JRequest::getString('gradepassed', '', 'POST');	
        $child['afrikaans'] = JRequest::getString('afrikaans', '', 'POST');
	    $child['maths'] = JRequest::getString('maths', '', 'POST');
	    $child['choice'] = JRequest::getString('choice', '', 'POST');
	    $child['parent'] = JRequest::getInt('id', '', 'GET');
	   
	    if(empty($child['name'])) 
	        $errors['name'] = 'Please fill in the name';
	    if(empty($child['surname'])) 
	        $errors['surname'] = 'Please fill in the surname';
	    if(empty($child['dob'])) 
	        $errors['dob'] = 'Please fill in the date of birth';
	    if(empty($child['gender'])) 
	        $errors['gender'] = 'Please fill in gender';
	    if(empty($child['gradepassed']))	   
	        $errors['gradepassed'] = 'Please fill in last grade passed';
	    if(empty($child['grade'])) {  
	        $errors['grade'] = 'Please fill in selected grade';
	    }
        
        if($child['grade'] == '8' || $child['grade'] == '9') {
            if (empty($child['maths']))
			    $errors['maths'] = 'Please fill in maths field';
            if (empty($child['choice']))
			    $errors['choice'] = 'Please fill in optional subject';   
	    }
 
	    $id = $session->get('current');
        
        if (count($errors) > 0) {
            $session->set('errors', $errors);
            $session->set('stepone', false);
           
            $mainframe->redirect('index.php?option=com_clonard&view=stepone', 'Missing feilds error',  'error');      
        }
        else {
            $session->set('stepone', 'complete');
            $session->set('new', 'yes');
            
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