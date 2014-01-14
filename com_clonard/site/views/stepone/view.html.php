<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ClonardViewStepone extends JView
{
	function display($tpl = null) {
	    $mainframe =& JFactory::getApplication();
	    $model = &$this->getModel();
        $parentData = $model->getParentData();		
		$session =& JFactory::getSession();
        
        if(!$session->has('parent')) {
            $session->set('parent', $parentData);  
	    }
        
        parent::display($tpl);
	}
}