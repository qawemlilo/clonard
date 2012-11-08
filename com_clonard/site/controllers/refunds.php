<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ClonardControllerRefunds extends JController
{
    function save_book() {
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('refunds');
        
        $title = JRequest::getVar('title', '', 'post', 'string');
        $grade = JRequest::getInt('grade', '', 'post');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if(empty($title) || (empty($grade) && $grade !== 0) || empty($year) || empty($price)) {
            $mainframe->redirect($refer, "Error! Please fill in all the fields", "error");
        }
        else {
            $success = $model->newRefund($grade, $title, $price, $year);
            
            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $grade, "Refundable item saved!");
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
        $grade = JRequest::getInt('grade', '', 'post');
        $id = JRequest::getInt('id', '', 'post');
        $year = JRequest::getInt('academic_year', '', 'post');
        $price = JRequest::getInt('price', '', 'post');     
        
        if(empty($id) || empty($title) || (empty($grade) && $grade !== 0) || empty($year) || empty($price)) {
            $mainframe->redirect($refer, "Error! Please fill in all the fields", "error");
        }
        else {
            $success = $model->updateRefund($id, $title, $grade, $price);

            if ($success) {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $grade, "Refundable item updated!");
            }
            else {
                $mainframe->redirect('index.php?option=com_clonard&view=refunds&grade=' . $grade, "An unexpected error occured", "error");
            }
        }
    }
    
    
    function remove_book() {
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