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

    
	function newRefund($grade, $title, $price, $year, $choice_subject)
	{
	    $db =& JFactory::getDBO();
		$query = "INSERT INTO jos_clonard_refundables(`grade`, `title`, `price`, `academic_year`, `choice_subject`) VALUES($grade, '$title', $price, $year, '$choice_subject')";
        $db->setQuery($query);
		$result = $db->query();

		$insertid = $db->insertid();
        
        return $insertid;
	}
	
	function updateRefund($id, $title, $grade, $price, $choice_subject)
	{
	    $db =& JFactory::getDBO();
		$query = "UPDATE jos_clonard_refundables SET title='$title', grade=$grade, price=$price, choice_subject='$choice_subject' WHERE id=$id";
        $db->setQuery($query);
		$result = $db->query();

		return $result;
	}
    
    
	function deleteRefund($id)
	{
	    $db =& JFactory::getDBO();
		$query = "DELETE FROM jos_clonard_refundables WHERE id=$id";
        $db->setQuery($query);
		$result = $db->query();

		return $result;
	}
    
    
	
	function getRefunds($grade, $year = 2013)
	{
	    $db =& JFactory::getDBO();
		$query = "SELECT id, title, price, academic_year, choice_subject FROM jos_clonard_refundables WHERE grade=$grade AND academic_year=$year ORDER BY title ASC";
        $db->setQuery($query);
		$data = $db->loadObjectList();

		return $data;
	}
    
 	function getRefund($id)
	{
	    $db =& JFactory::getDBO();
		$query = "SELECT * FROM jos_clonard_refundables WHERE id=$id";
        $db->setQuery($query);
		$data = $db->loadObject();

		return $data;
	}
}