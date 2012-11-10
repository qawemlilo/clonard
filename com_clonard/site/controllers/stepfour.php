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
                $amount_due =  0.95;               
            }
            elseif($opt == 'b') {
                $opt = 'B - Part Payment';
                $amount_due =  0.75; 
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=stepthree&s_id=' . $s_id, 'Payment option not provide', 'error');
            }
            
            $students[$s_id]['opt'] = $opt;
            $students[$s_id]['amount_due'] = ceil($amount_due * $students[$s_id]['fees']);
            
            $session->set('students', $students);
            
            $mainframe->redirect('index.php?option=com_clonard&view=final'); 
        }
}
