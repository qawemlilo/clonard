<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardControllerStepfour extends JController
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
            
            parent::display();
        }
}
