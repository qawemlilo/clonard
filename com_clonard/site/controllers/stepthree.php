<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardControllerStepthree extends JController
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
    
    function save_books() {
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel('stepthree');
        $session =& JFactory::getSession();
	   
	    if($session->has('refunds')) {
		   $refunds = $session->get('refunds');
        }
        else {
           $refunds = array();
        }
        
        $student_id = JRequest::getString('s_id', '', 'POST');
        $books = JRequest::getVar('books', NULL, 'post', 'array');
        
        $refund = array();

	    if($books && is_array($books) && count($books) > 0) {
            $result = $model->getSelectedRefunds($books);
            
            if($result) {
                $refund = $result; 
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=stepfour&s_id=' . $student_id, 'Database error, please try again',  'error'); 
            }
	    }
        

        $refunds[$student_id] = $refund;
        $session->set('refunds', $refunds);
        $mainframe->redirect('index.php?option=com_clonard&view=stepfour&s_id=' . $student_id);      
    }
    
    
    function remove() {
        $mainframe =& JFactory::getApplication();
        $session =& JFactory::getSession();
	   
	    $refunds = $session->get('refunds');
        $students = $session->get('students');
        
        $student_id = JRequest::getString('s_id', '', 'GET');
        
        unset($students[$student_id]);
        unset($refunds[$student_id]);
        
        $session->set('students', $students);
        $session->set('refunds', $refunds);
        
        $mainframe->redirect('index.php?option=com_clonard&view=stepfour&s_id=' . $student_id , 'Item removed!');      
    }
}
