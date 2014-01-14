<?php

/*
  Not working
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );
class ClonardModelThankyou extends JModel
{
	public $orderNumber;
	
	function createOrder($grade, $books, $comments = false)
	{
	    if (!isset($this->$orderNumber)) 
		{
			$db =& JFactory::getDBO();
			$session =& JFactory::getSession();
			$studentID = $session->get('studentID');
			$parentID = $this->getParentID();
            
			if (!empty($studentID) && !empty($parentID))
			{
			    if(!$comments)
			        $query = "INSERT INTO jos_clonard_orders(`parent`,`child`, `grade`, `books`) VALUES($parentID, $studentID, $grade, '$books')"; 
                else
                    $query = "INSERT INTO jos_clonard_orders(`parent`,`child`, `grade`, `books`, `comments`) VALUES($parentID, $studentID, $grade, '$books', '$comments')";	
					
				$db->setQuery($query);
				if ($db->query()) {
				    $this->orderNumber = $db->insertid();
				    $session->set('orderNumber', $this->orderNumber);
					$session->clear('studentID');
			    }
		     }
			 
			 return $this->orderNumber;
		}
    }
	
	
	function getParentID()
	{
	    $user = JFactory::getUser();
		$userid = $user->id;
		
	    $db =& JFactory::getDBO();
		$query = "SELECT id FROM jos_clonard_parents WHERE userid={$userid}";
        $db->setQuery($query);
		$id = $db->loadResult();
		
		return $id;
	}
}