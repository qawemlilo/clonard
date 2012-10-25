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
            $gradeid =& JRequest::getInt('grade', 1);
            $grades = $model->getGrades(2013);
            $refundables = $model->getRefunds($gradeid, 2013);
            
            if (JRequest::getVar('layout') == 'edit') {
                $id =& JRequest::getInt('id', 1);
                $refund = $model->getRefund($id);
                
                $this->assignRef('refund', $refund);
            }
            
            $this->assignRef('grades', $grades);

            $this->assignRef('gradeid', $gradeid);
            $this->assignRef('refundables', $refundables);
            
			parent::display($tpl);
		}
		else
		{
		   $mainframe->redirect("index.php");
           exit();
		}			
	}
}