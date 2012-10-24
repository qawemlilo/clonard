<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardController extends JController
{
	function display()
	{
	    $currentUser =& JFactory::getUser();
        
        if(!JRequest::getVar('view'))
              JRequest::setVar('view', 'stepone');
              
		elseif ($currentUser->usertype == "Administrator") 
		    JRequest::setVar('view', 'admin');
	   
	    parent::display();
	}

}