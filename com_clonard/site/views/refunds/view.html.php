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
            $grade =& JRequest::getInt('grade', 0);
            $grades = $model->getGrades(2014);
            $refundables = $model->getRefunds($grade, 2013);
            
            if (JRequest::getVar('layout') == 'edit') {
                $id =& JRequest::getInt('id');
                $refund = $model->getRefund($id);
                
                $this->assignRef('refund', $refund);
            }
            
            $this->assignRef('grades', $grades);

            $this->assignRef('grade', $grade);
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