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
        
        
        function add_opt() {
            $mainframe =& JFactory::getApplication();
            $session =& JFactory::getSession();
            $s_id = JRequest::getVar('s_id', '', 'get');
            
            $students = $session->get('students');
            
            $students[$s_id]['amount_due'] = $students[$s_id]['fees'];
            
            $session->set('students', $students);
            
            $mainframe->redirect('index.php?option=com_clonard&view=final'); 
        }
}
