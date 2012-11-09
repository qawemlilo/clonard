<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ClonardModelStepthree extends JModel
{	
	function getRefundables($grade, $year)
	{
	    $db =& JFactory::getDBO();
        
		$query = "SELECT id, title, price FROM jos_clonard_refundables WHERE grade=$grade AND academic_year=$year";
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