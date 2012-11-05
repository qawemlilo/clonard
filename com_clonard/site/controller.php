<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardController extends JController
{
	function display()
	{
        $mainframe =& JFactory::getApplication();
	    $currentUser =& JFactory::getUser();
        
        if(!JRequest::getVar('view') && $currentUser->usertype != "Administrator") {
              JRequest::setVar('view', 'stepone');
        }
              
        elseif((!JRequest::getVar('view') || JRequest::getVar('view') == 'stepone') && $currentUser->usertype == "Administrator") {
              $mainframe->redirect('index.php?option=com_clonard&view=admin');
        }
	   
	    parent::display();
	}
    
    function save_book() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('refunds');
        
        $title = JRequest::getVar('title', '', 'post', 'string');
        $id = JRequest::getInt('gradeid', '', 'post');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if(empty($title) || empty($id) || empty($year) || empty($price)) {
            $mainframe->redirect($refer, "Error! Please fill in all the fields", "error");
        }
        else {
            $success = $model->newRefund($id, $title, $price, $year);
            
            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $id, "Refundable item saved!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $id, "An unexpected error occured", "error");
            }
        }
    }
    
 
    function edit_book() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('refunds');
        
        $title = JRequest::getVar('title', '', 'post', 'string');
        $gradeid = JRequest::getInt('gradeid', '', 'post');
        $id = JRequest::getInt('id', '', 'post');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if(empty($id) || empty($title) || empty($gradeid) || empty($year) || empty($price)) {
            $mainframe->redirect($refer, "Error! Please fill in all the fields", "error");
        }
        else {
            $success = $model->updateRefund($id, $title, $gradeid, $price);

            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $gradeid, "Refundable item updated!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $gradeid, "An unexpected error occured", "error");
            }
        }
    }
    
    
    function edit_pack() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('packs');
        
        $grade = JRequest::getVar('grade', '', 'post');
        $id = JRequest::getInt('id', '', 'post');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if(empty($id) || empty($grade) || empty($year) || empty($price)) {
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
        
        if(empty($grade) || empty($year) || empty($price)) {
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
    
    
    
    function remove() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('refunds');
        
        $gradeid = JRequest::getInt('grade', '', 'get');
        $id = JRequest::getInt('id', '', 'get');

        if(empty($id) || empty($gradeid)) {
            $mainframe->redirect($refer, "Error! Missing fields", "error");
        }
        else {
            $success = $model->deleteRefund($id);

            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $gradeid, "Refundable item deleted!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $gradeid, "An unexpected error occured", "error");
            }
        }
    }
}