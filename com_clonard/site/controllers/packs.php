<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardControllerPacks extends JController
{
    function edit_pack() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('packs');
        
        $grade = JRequest::getInt('grade', '', 'post');
        $id = JRequest::getInt('id', '', 'post');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if(empty($id) || (empty($grade) && $grade !== 0) || empty($year) || empty($price)) {
            $mainframe->redirect($refer, "Error! Please fill in all the fields", "error");
        }
        else {
            $success = $model->updatePack($id, $grade, $year, $price);

            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=packs', "Package updated!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=packs', "An unexpected error occured", "error");
            }
        }
    }
    
    
    function save_pack() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('packs');
        
        $grade = JRequest::getVar('grade', '', 'post', 'string');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if((empty($grade) && $grade !== 0) || empty($year) || empty($price)) {
            $mainframe->redirect($refer, "Error! Please fill in all the fields", "error");
        }
        else {
            $success = $model->newPack($grade, $year, $price);
            
            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=packs', "Pack saved!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=packs', "An unexpected error occured", "error");
            }
        }
    }
    
    function remove_pack() {
        $mainframe =& JFactory::getApplication();
        $model =& $this->getModel('packs');
        
        $id = JRequest::getInt('id', '', 'get');

        if(empty($id)) {
            $mainframe->redirect('index.php?option=com_clonard&view=packs', "Error! Missing fields", "error");
        }
        else {
            $success = $model->deletePack($id);

            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=packs', "Package deleted!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=packs', "An unexpected error occured", "error");
            }
        }
    }
}