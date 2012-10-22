<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AppSession {

    public $session;
	
    function __construct()
	{
	    $this->session =& JFactory::getSession();
		$this->session->clear('errors');
	}	
	
    function set($item, $value) 
	{    
	    return $this->session->set($item, $value);
	}	
	
    function get($item) 
	{    
	    $this->session->get($item);
	}
}



class ApplicationForm
{
    public $data;
	
    function __construct()
	{
	    $this->AppSession = new AppSession();
	}
	
	
    function processForm() 
	{
	   $parent = array();
	   $errors = array();
	   $other = JRequest::getString('province2', '', 'POST');

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

	   if ($parent['province'] == "other") 
	   {
		   if (empty($other)  || strlen($other) < 4) 
		       $errors['province2'] = 'Invalid province';
			   
		   $parent['province'] = $other;
	   }
	   else
	   {
	      if (empty($parent['province']) || strlen($parent['province']) < 4)   
	       $errors['province'] = 'Invalid province number';
	   }
		   
	   
	   if (empty($parent['title'])) 
	       $errors['title'] = 'Please fill in the title';
	   if (empty($parent['name'])) 
	       $errors['name'] = 'Please fill in the name';
	   if (empty($parent['surname'])) 
	       $errors['surname'] = 'Please fill in the name';
	   if (empty($parent['email']) || !preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $parent['email'])) 
	       $errors['email'] = 'Invalid email address';
	   if (empty($parent['phone']) || strlen($parent['phone']) < 9) 
	       $errors['phone'] = 'Invalid telephone number';
	   //if (empty($parent['fax']) || strlen($parent['fax']) < 9) 
	       //$errors['fax'] = 'Invalid fax number';
	   //if (empty($parent['cell']) || strlen($parent['cell']) < 9) 
	      // $errors['cell'] = 'Invalid telephone number';
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
 
	   $this->set('parent', $parent);
	   
       if (count($errors) < 1) {
	       $this->set('stepone', 'complete');
		   $this->data = $parent;
		   $this->set('new', 'yes');
			   
           return true;	
	   }	   
	   
       else {
	       $this->set('errors', $errors);
		   $this->set('stepone', false);
		   return false;	
	   }			
	} 
	

    function get($item) 
	{    
	    $this->AppSession->session->get($item);
	}

	
    function set($item, $value) 
	{    
	    $this->AppSession->session->set($item, $value);
	}	
}

class ClonardViewStepone extends JView
{
	function display($tpl = null)
	{
	    global $mainframe;
	    $model = &$this->getModel();
        $cache = $model->getParentData();		
		
		$currentUser =& JFactory::getUser();
		$session =& JFactory::getSession();
        $step_completed = JRequest::getVar('step_completed', '', 'post', 'string');
		
		if($currentUser->get('guest')) 
		{
			$uri = JFactory::getURI();
			$return  = $uri->toString();

			$url = 'index.php?option=com_user&view=login';
			$url .= '&return='.base64_encode($return);;

			//$url	= JRoute::_($url, false);
			$mainframe->redirect($url, JText::_('You must login first') );
			exit();
		}
		
		if (isset($_POST['import']) && $step_completed == 'one')
		{
		    $form = new ApplicationForm();
		    $success = $form->processForm(); 
			if ($success) 
			{
			    $data = $form->data;
				$proceed = $model->createParent($data);
				
			    if ($proceed)
				    header("Location: index.php?option=com_clonard&view=steptwo");
            }
			
            parent::display($tpl);		  
		}
		else 
		{    
		    $form = new ApplicationForm();
			
		    if (!$currentUser->get('guest') && !$session->has('parent')) 
			    $form->set('parent', $cache);
		    parent::display($tpl);
	   }
	}
}