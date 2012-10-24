<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ClonardViewRefunds extends JView
{
	function display($tpl = null)
	{
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel();
		$currentUser =& JFactory::getUser();

		if ($currentUser->usertype == "Administrator")
		{
            $grades = $model->getGrades(2013);
            $currentpage =& JRequest::getVar('grade');
            
            $this->assignRef('grades', $grades);
            $this->assignRef('currentpage', $currentpage);
            
			parent::display($tpl);
		}
		else
		{
		   $mainframe->redirect("index.php");
           exit();
		}			
	}
}