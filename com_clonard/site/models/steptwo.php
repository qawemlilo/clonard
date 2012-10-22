<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );
class ClonardModelSteptwo extends JModel
{
    protected $results;
	public $studentID;
	public $studentData;
	
	function createStudent(array $arr)
	{
	    if (!isset($this->results)) 
		{
			$db =& JFactory::getDBO();
			$session =& JFactory::getSession();

			if (!$session->get('studentID'))
			{
			    $query = $this->createInsertQuery($arr);
				$db->setQuery($query);
				$this->results = $db->query();
				$this->studentID = $db->insertid();
				$session->set('studentID', $this->studentID); 
		    }
			else {
			     $query = $this->createUpdateQuery($arr, $session->get('studentID'));
			     $db->setQuery($query);
			     $this->results = $db->query();
                 $this->studentID = $session->get('studentID');				 
			}
		}
		
		return $this->results;
    }

	
	function createInsertQuery($arr)
	{
	    $grades = array(
		    'Grade n'=>0,
		    'Grade R'=>0, 
			'Grade 1'=>1, 
			'Grade 2'=>2, 
			'Grade 3'=>3, 
			'Grade 4'=>4, 
			'Grade 5'=>5, 
			'Grade 6'=>6, 
			'Grade 7'=>7, 
			'Grade 8'=>8, 
			'Grade 9'=>9
		);
		
	    $q = "INSERT INTO jos_clonard_students(";
		$v = " VALUES(";
		
		
	    if (is_array($arr) && !empty($arr)) 
		{
		    foreach($arr as $key=>$value)
			{
			    if ($key == 'grade' || $key == 'gradepassed')
                {				
				    $g = $grades[$value];
					
					$q .= '`' . $key . '`,';
					$v .= $g . ',';
				}
				else {
			        $q .= '`' . $key . '`,';
				    $v .= '"' . $value . '",';
				}
			}
			
			$q_str = substr($q, 0, -1) . ')';
			$values = substr($v, 0, -1) . ')';
			
			return $q_str .= $values;
		}

		return false;
	}
	
	function createUpdateQuery($arr, $id)
	{
	    $grades = array(
		    'Grade n'=>0,
		    'Grade R' =>0, 
			'Grade 1'=>1, 
			'Grade 2'=>2, 
			'Grade 3'=>3, 
			'Grade 4'=>4, 
			'Grade 5'=>5, 
			'Grade 6'=>6, 
			'Grade 7'=>7, 
			'Grade 8'=>8, 
			'Grade 9'=>9
		);
		
	    $query = "";

	    $update = "UPDATE jos_clonard_students SET";
		
	    if (is_array($arr) && !empty($arr) && isset($id)) 
		{
		    foreach($arr as $key=>$value)
			{
			    if ($key == 'grade' || $key == 'gradepassed')
                {				
				    $g = $grades[$value];
					$update .= " $key=$g,";
				}
				else
			        $update .= " $key='$value',";
			}
			
			$where = "WHERE id=$id";
			$query = substr($update, 0, -1) . $where;
			
			return $query;
		}
		
		return false;
	}
	
	
	function getStudentData($id)
	{
	    $session =& JFactory::getSession();
		$db =& JFactory::getDBO();
		
		if (!isset($this->studentData) && $session->has('studentID'))
		{
		    if (empty($_GET['student'])) return false;
			
			$studentID = $session->get('studentID');
			$id = $session->get('parentID');
			
			$query = "SELECT * FROM jos_clonard_students WHERE id=$studentID AND parent=$id";
			$db->setQuery($query);
			
			$this->studentData = $db->loadAssoc();
		}
		
		return $this->studentData;
	}
}