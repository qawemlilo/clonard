<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class ClonardViewStepthree extends JView
{
	function display($tpl = null)
	{
	    $model = &$this->getModel();
        $session =& JFactory::getSession(); 
        $students = $session->get('students');
        $child_id = JRequest::getVar('s_id', '', 'get', 'string');
        $child = $students[$child_id];

        $refunds = $model->getRefundables($child['grade'], 2013);
        
        $this->assignRef('currentChild', $child);
        $this->assignRef('refunds', $refunds);
        $this->assignRef('s_id', $child_id);

		parent::display($tpl);
	}
}