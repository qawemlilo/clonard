<?php

/*
  Not working
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ClonardModelCheckout extends JModel
{	
    function createOrder($child, $id){
	    $db =& JFactory::getDBO();
	    $session =& JFactory::getSession();
	    $refunds = $session->get('refunds');
	    $parent = $session->get('parent');
        $parentId = $this->getParentID();
	    $comments = $parent['comments'];
	    $s_id = $child['s_id'];
	    $books = '';
	    $books_arr = array();
	    
	    if (isset($refunds[$s_id]) && is_array($refunds[$s_id]) && count($refunds[$s_id]) > 0) {
                foreach($refunds[$s_id] as $book){
                    $books_arr[] = $book->title;
                }
              
                $books = implode(',', $books_arr);
            }
            
            $orderNumber = false;
            
            if ($id) {
                if (!$comments)
                    $query = "INSERT INTO jos_clonard_orders(`parent`,`child`, `grade`, `books`, `payment_option`) VALUES({$parentId}, $id, {$child['grade']}, '$books', '{$child['opt']}')";
                else
                    $query = "INSERT INTO jos_clonard_orders(`parent`,`child`, `grade`, `books`, `comments`, `payment_option`) VALUES({$parentId}, $id, {$child['grade']}, '$books', '$comments', '{$child['opt']}')";
                    
                $db->setQuery($query);
                
                if ($db->query()) {
                    $orderNumber = $db->insertid();
                }
                else {
                    die($db->ErrorMsg());
                }
            }
            
            return $orderNumber;
      }
      
      
      
      
      function createStudent($child) {
          $db =& JFactory::getDBO();
          $insertid = false;
			
          if (is_array($child)) {
              $query = $this->buildQuery('insert', $child);
              $db->setQuery($query);
              $results = $db->query();
          
              if(!$results){
                  die($db->ErrorMsg());
              }
          
              $insertid = $db->insertid();
          }
      
          return $insertid;

    }
    
    
    
  
    function buildQuery($method,  array $child) {
      $query = "";
      
      if($method == 'update') {
		      $query .= "UPDATE jos_clonard_students SET ";
		      $query .= "grade={$child['grade']}";
          $query .= ", gradepassed={$child['gradepassed']}";
          $query .= ", name='{$child['name']}'";
          $query .= ", surname='{$child['surname']}'";
          $query .= ", dob='{$child['dob']}'";
          $query .= ", gender='{$child['gender']}'";
          $query .= ", afrikaans='{$child['afrikaans']}'";
          $query .= ", maths='{$child['maths']}'";
          $query .= ", choice='{$child['choice']}'";
          
          $query .= " WHERE id={$child['id']}";      
      }
      elseif ($method == 'insert') {
          $query .= "INSERT INTO jos_clonard_students(`parent`, `grade`, `gradepassed`, `name`, `surname`, `dob`, `gender`, `afrikaans`, `maths`, `choice`) ";
          $query .= "VALUES ({$child['parent']}, {$child['grade']}, {$child['gradepassed']}, '{$child['name']}', '{$child['surname']}', '{$child['dob']}', '{$child['gender']}', '{$child['afrikaans']}', '{$child['maths']}', '{$child['choice']}')";      
      }
      
      return $query;
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
