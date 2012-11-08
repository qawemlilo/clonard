<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class ClonardViewSteptwo extends JView
{
	function display($tpl = null)
	{
	    $model = &$this->getModel();
        $cgrades = $model->getGrades(2013);
        
        $this->assignRef('cgrades', $cgrades);
		parent::display($tpl);
	}
}