<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardController extends JController
{
	function display()
	{
	    $currentUser =& JFactory::getUser();

		if ($currentUser->usertype == "Administrator") 
		    JRequest::setVar('view', 'admin');
			
        elseif(!JRequest::getVar('view'))
              JRequest::setVar('view', 'stepone');
	   
	    parent::display();
	}

}