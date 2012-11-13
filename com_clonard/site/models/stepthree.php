<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ClonardModelStepthree extends JModel
{	
	function getRefundables($grade, $year, $choice_subject = false)
	{
	    $db =& JFactory::getDBO();
        
        if($choice_subject) {
		    $query = "SELECT id, title, price FROM jos_clonard_refundables WHERE (choice_subject IS NULL OR LEN(choice_subject) = 0 OR choice_subject='$choice_subject') AND grade=$grade AND academic_year=$year";
        }
        else {
            $query = "SELECT id, title, price FROM jos_clonard_refundables WHERE (choice_subject IS NULL OR LEN(choice_subject) = 0) AND grade=$grade AND academic_year=$year";
        }
        $db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;
	}
    
	function getSelectedRefunds($booksIds)
	{
	    $db =& JFactory::getDBO();
        $books_csv = implode(',', $booksIds);

		$query = "SELECT id, title, price FROM jos_clonard_refundables WHERE id IN ($books_csv)";
        $db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;
	}
}