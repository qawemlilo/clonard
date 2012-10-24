<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardController extends JController
{
	function display()
	{
        $mainframe =& JFactory::getApplication();
	    $currentUser =& JFactory::getUser();
        
        if(!JRequest::getVar('view') && $currentUser->usertype != "Administrator") {
              JRequest::setVar('view', 'stepone');
        }
              
        elseif((!JRequest::getVar('view') || JRequest::getVar('view') == 'stepone') && $currentUser->usertype == "Administrator") {
              $mainframe->redirect('index.php?option=com_clonard&view=admin');
        }
	   
	    parent::display();
	}

}