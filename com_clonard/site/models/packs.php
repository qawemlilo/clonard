<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class ClonardModelPacks extends JModel
{
	function getPacks($year)
	{
		$db =& JFactory::getDBO();
        
        $query = "SELECT * FROM jos_cld_grades WHERE academic_year=$year ORDER BY grade ASC";
	    $db->setQuery($query);
			
		$results = $db->loadObjectList();
		
		return $results;
	}

    
	function newPack($grade, $year, $price)
	{
	  if($this->packExists($grade, $year)){
        return false;
    }
	    $db =& JFactory::getDBO();
		$query = "INSERT INTO jos_cld_grades(`grade`, `academic_year`, `price`) VALUES('$grade', $year, $price)";
        $db->setQuery($query);
		$result = $db->query();

		$insertid = $db->insertid();
        
        return $insertid;
	}
	
	
	private function packExists($grade, $year)
	{
	    $db =& JFactory::getDBO();
		  $query = "SELECT id FROM jos_cld_grades WHERE grade=$grade AND academic_year=$year";
      $db->setQuery($query);
		  $result = $db->loadResult();
      
      return $result;
	}
	
	function updatePack($id, $grade, $year, $price)
	{
	    $db =& JFactory::getDBO();
		$query = "UPDATE jos_cld_grades SET grade='$grade', academic_year=$year, price=$price WHERE id=$id";
        $db->setQuery($query);
		$result = $db->query();

		return $result;
	}
    
    
	function deletePack($id)
	{
	    $db =& JFactory::getDBO();
		$query = "DELETE FROM jos_cld_grades WHERE id=$id";
        $db->setQuery($query);
		$result = $db->query();

		return $result;
	}
    
    
 	function getPack($id)
	{
	    $db =& JFactory::getDBO();
		$query = "SELECT * FROM jos_cld_grades WHERE id=$id";
        $db->setQuery($query);
		$data = $db->loadObject();

		return $data;
	}
}