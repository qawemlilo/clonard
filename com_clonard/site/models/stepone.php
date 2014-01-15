<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ClonardModelStepone extends JModel
{
    protected $results;
	public $parentID;
	private $parentData;
	
	function createParent(array $arr) {
	    if (!isset($this->results)) 
		{
			$id = $this->getParentID();
			$db =& JFactory::getDBO();
            
			if (!$id) {
			    $query = $this->createInsertQuery($arr);              
				$db->setQuery($query);
				$this->results = $db->query();
				$this->parentID = $db->insertid();
				
				if(!$this->results) {
				   die($db->ErrorMsg());
				}
		    }
			else {
			     $query = $this->createUpdateQuery($arr, $id);
			     $db->setQuery($query);
			     $this->results = $db->query();
                 $this->parentID = $id;
                 
				if(!$this->results) {
				   die($db->ErrorMsg());
				}				 
			}
		}
		
		return $this->results;
    }
	
	function getParentID() {
	    $user = JFactory::getUser();
		$userid = $user->id;
		
	    $db =& JFactory::getDBO();
		$query = "SELECT id FROM jos_clonard_parents WHERE userid={$userid}";
        $db->setQuery($query);
		$id = $db->loadResult();
				
		return $id;
	} 
	
	function createInsertQuery($arr) {
	    $q = "INSERT INTO jos_clonard_parents(";
		$v = " VALUES(";
		
		
	    if (is_array($arr) && !empty($arr)) 
		{
		    foreach($arr as $key=>$value)
			{
			    if($key != 'comments') 
				{
			         $q .= '`' . $key . '`,';
				     $v .= '"' . $value . '",';
				}
			}
			
			$q_str = substr($q, 0, -1) . ')';
			$values = substr($v, 0, -1) . ')';
			
			$q_str .= $values;
            
            return $q_str;
		}

		return false;
	}
	
	function createUpdateQuery($arr, $id) {
	    $query = "";

	    $update = "UPDATE jos_clonard_parents SET";
		
	    if (is_array($arr) && !empty($arr) && isset($id)) 
		{
		    foreach($arr as $key=>$value)
			{
			    if ($key != 'comments')
			        $update .= " $key='$value',";
			}
			
			$where = " WHERE id=$id";
			$query = substr($update, 0, -1) . $where;
			
			return $query;
		}
		
		return false;
	}
	

    function getParentData() {
		if (!isset($this->parentData)) {
		    $user = JFactory::getUser();
			$db =& JFactory::getDBO();

			$userid = $user->id;
			$name = explode(" ", $user->name);
				
			$query = "SELECT * FROM jos_clonard_parents WHERE userid={$userid}";
			$db->setQuery($query);           
			$this->parentData = $db->loadAssoc();
            
            if (!$this->parentData) {
			    $this->parentData['email'] = $user->email;
			    $this->parentData['name'] = $name[0];
                $this->parentData['userid'] = $userid;
			    
                if(count($name) > 1) {
                    $this->parentData['surname'] = end($name);
                }
            }
		}
			
		return $this->parentData;
    }
}
