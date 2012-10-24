<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class ClonardModelRefunds extends JModel
{
	function getGrades($year)
	{
		$db =& JFactory::getDBO();
        
        $query = "SELECT id, grade, price FROM jos_cld_grades WHERE academic_year=$year";
	    $db->setQuery($query);
			
		$results = $db->loadObjectList();
		
		return $results;
	}

    
	function newRefund($gradeid, $title, $price, $year)
	{
	    $db =& JFactory::getDBO();
		$query = "INSERT INTO jos_clonard_students(gradeid, title, price, academic_year) VALUES('$gradeid','$title', '$price','$year')";
        $db->setQuery($query);
		$result = $db->query();

		$insertid = $db->insertid();
        
        return $insertid;
	}
	
	function updateRefunds($id, $title, $gradeid, $price)
	{
	    $db =& JFactory::getDBO();
		$query = "UPDATE jos_clonard_students SET title='$title', gradeid='$gradeid' price='$price' WHERE id=$id";
        $db->setQuery($query);
		$result = $db->loadResult();

		return $result;
	}
	
	function getRefunds($gradeid, $year)
	{
	    $db =& JFactory::getDBO();
		$query = "SELECT id, title, price, academic_year FROM jos_clonard_refundables WHERE gradeid='$gradeid' AND academic_year='$year'";
        $db->setQuery($query);
		$data = $db->loadObjectList();

		return $data;
	}
}