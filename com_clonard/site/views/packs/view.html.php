<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class ClonardViewPacks extends JView
{
	function display($tpl = null)
	{
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel();
		$currentUser =& JFactory::getUser();

		if ($currentUser->usertype == "Administrator")
		{
            $packs = $model->getPacks(2014);
            
            if (JRequest::getVar('layout') == 'edit') {
                $id =& JRequest::getInt('id', 1);
                $pack = $model->getPack($id);
                
                $this->assignRef('pack', $pack);
            }
            
            $this->assignRef('packs', $packs);

            
			parent::display($tpl);
		}
		else
		{
		   $mainframe->redirect("index.php");
           exit();
		}			
	}
}