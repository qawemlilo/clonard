<?php

/*
  Not working
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class ClonardModelCheckout extends JModel
{
	function getParentID()
	{
	    $user = JFactory::getUser();
		$email = $user->email;
		
	    $db =& JFactory::getDBO();
		$query = "SELECT id FROM jos_clonard_parents WHERE email='$email'";
        $db->setQuery($query);
		$id = $db->loadResult();
		
		return $id;
	}
}
