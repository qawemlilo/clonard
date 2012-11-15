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
	
	
    
    function save_student() {
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel('steptwo');
        $session =& JFactory::getSession();
        $session->clear('errors');
        
        $child = array();
        $students = array();
        $errors = array();
        $parent = $session->get('parent');
        $student_id = JRequest::getString('s_id', '', 'POST');
        
        if($session->has('students')) {
            $students = $session->get('students');
        }
        
        if(empty($student_id)) {
                $student_id = $this->createUniqueId(6, $students);
        }
        
        $child['name'] = JRequest::getString('name', '', 'POST');
        $child['surname'] = JRequest::getString('surname', '', 'POST');
        $child['dob'] = JRequest::getString('dob', '', 'POST');
        $child['gender'] = JRequest::getWord('gender', '', 'POST');
        $child['grade'] = JRequest::getInt('grade', '', 'POST');	
        $child['gradepassed'] = JRequest::getInt('gradepassed', '', 'POST');	
        $child['afrikaans'] = JRequest::getString('afrikaans', '', 'POST');
	$child['maths'] = JRequest::getString('maths', '', 'POST');
	$child['choice'] = JRequest::getString('choice', '', 'POST');
	$child['parent'] = $model->getParentID();
	   
	if(empty($child['name'])) 
	        $errors['name'] = 'Please fill in the name';
	if(empty($child['surname'])) 
	        $errors['surname'] = 'Please fill in the surname';
	if(empty($child['dob'])) 
	        $errors['dob'] = 'Please fill in the date of birth';
	if(empty($child['gender'])) 
	        $errors['gender'] = 'Please fill in gender';
	if($child['gradepassed'] == -5)	   
	        $errors['gradepassed'] = 'Please fill in last grade passed';
	if($child['grade'] == -5) {  
	        $errors['grade'] = 'Please fill in selected grade';
	}
        if($child['grade'] == 8 || $child['grade'] == 9) {
            if (empty($child['maths']))
			    $errors['maths'] = 'Please fill in maths field';
            if (empty($child['choice']))
			    $errors['choice'] = 'Please fill in optional subject';   
	}
 
	    
        
        if (count($errors) > 0) {
            $child['s_id'] = $student_id;
            $students[$student_id] = $child;
            $session->set('students', $students);
            $session->set('errors', $errors);
           
            $mainframe->redirect('index.php?option=com_clonard&view=steptwo&s_id=' . $student_id, 'Missing feilds error',  'error');      
        }
        else {
            $fees = $model->getFees($child['grade'], 2013, $child['choice']);
            
            if(!$fees) {
                $mainframe->redirect('index.php?option=com_clonard&view=steptwo', 'Database error',  'error');
            }
            
            $child['fees'] = $fees;
            $child['s_id'] = $student_id;
            $students[$student_id] = $child;
            $session->set('students', $students);
            
            if(!empty($child['choice'])) {
                $mainframe->redirect('index.php?option=com_clonard&view=stepthree&s_id=' . $student_id . '&cs=' . $child['choice']);
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=stepthree&s_id=' . $student_id);
            }
        }
    }
    
    
    private function createUniqueId($length = 6, $arr)
	{
        $conso = array("a", "b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
        $vocal = array(1,2,3,4,5,6,7,8,9);
         
        $id = "";
        srand ((double)microtime()*1000000);
        $max = $length/2;
        
        for($i=1; $i<=$max; $i++)
        {
            $id .= $conso[rand(0,20)];
            $id .= $vocal[rand(0,8)];
        }
        
        if (!array_key_exists($id, $arr)) {
            return $id;
        }
        else {
            $this->createUniqueId($length, $arr);
        }
    }
}
