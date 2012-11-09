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
            $model =& $this->getModel('stepthree');
            $session =& JFactory::getSession();
            
            $students = $session->get('students');
            
            $opt = JRequest::getString('opt', '', 'GET');
            $s_id = JRequest::getString('s_id', '', 'GET');
            
            if ($opt == 'a') {
                $opt = 'A - 5% Discount';
            }
            elseif($opt == 'b') {
                $opt = 'B - Part Payment';
            }
            
            $students[$s_id]['opt'] = $opt;
            
            $session->set('students', $students);
            
            $mainframe->redirect('index.php?option=com_clonard&view=final'); 
        }
}
