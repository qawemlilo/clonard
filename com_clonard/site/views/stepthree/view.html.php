<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class ClonardViewStepthree extends JView
{
	function display($tpl = null)
	{
	    $model = &$this->getModel();		
		$comms = false;
		$currentUser =& JFactory::getUser();
		$session =& JFactory::getSession();
        $step_completed = JRequest::getVar('step_completed', '', 'post', 'string');
		

		if (isset($_POST['import'])  && $step_completed == 'three')
		{
		    $form = new ApplicationForm();
			$success = $form->processForm();
			
			if ($success) 
			{
			    $grade = $form->grade;
				$books = $form->csv;
				$proceed = $model->createOrder($grade, $books, $comms);
				
			    if ($proceed)
				    header("Location: index.php?option=com_clonard&view=final");
			}
		}
		
	    else {
		    $form = new ApplicationForm();
		    parent::display($tpl);
		}
	}
}