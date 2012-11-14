<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ClonardModelStepthree extends JModel
{	
	function getRefundables($grade, $year, $choice_subject = false)
	{
	    $db =& JFactory::getDBO();
        
        if($choice_subject) {
		    $query = "SELECT id, title, price FROM jos_clonard_refundables WHERE (choice_subject LIKE '' OR choice_subject='$choice_subject') AND grade=$grade AND academic_year=$year ORDER BY title ASC";
        }
        else {
            $query = "SELECT id, title, price FROM jos_clonard_refundables WHERE choice_subject LIKE '' AND grade=$grade AND academic_year=$year ORDER BY title ASC";
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