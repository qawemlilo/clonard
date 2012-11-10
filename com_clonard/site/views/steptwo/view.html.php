<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class ClonardViewSteptwo extends JView
{
    function display($tpl = null)
    {
        $model = &$this->getModel();
        $grades = $model->getGrades(2013);
        $session = JFactory::getSession();
        $students = array();
        $student_id = JRequest::getString('s_id', '', 'GET');
        $errors = array();
        
        if ($session->has('errors')) {
            $errors = $session->get('errors');
        }
        if ($session->has('students')) {
            $students = $session->get('students');
        }
        
        $this->assignRef('cgrades', $grades);
        $this->assignRef('errors', $errors);
        $this->assignRef('s_id', $student_id);
        $this->assignRef('child', $students[$student_id]);

        parent::display($tpl);
    }
}
