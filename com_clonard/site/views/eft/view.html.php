<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class ApplicationForm
{
    public $session;
	
    function __construct()
	{
	    $this->session = JFactory::getSession();
	}

	function getHTML()
	{
        
		$html = '<div style="padding-left: 10px;"><p>As per your quote please make payment into the following bank account</p>';
        $html .= '<p><strong>BANK DETAILS:</strong></p>';
        $html .= '<p><strong>Clonard Education CC</strong> <br> <strong>STANDARD BANK</strong> <br> <strong>Current Account No:</strong> 051958910 <br> <strong>Kloof Branch:</strong> 045526 <br> <strong>Swift Code (International Customers):</strong> SBZAZAJJ</p>';
        $html .= '<p><strong>REFERENCE:</strong> Parent\'s Name and Surname (same as log in details)</p>';
        $html .= '<p>Please fax or email proof of payment to: <a href="mailto:orders@clonard.co.za">orders@clonard.co.za</a> / 086 741 9154</p></div>';
		return $html;
	}
}

class ClonardViewEft extends JView
{
	function display($tpl = null)
	{
		$currentUser =& JFactory::getUser();
		
		if($currentUser->get('guest')) 
		{
		    header("Location: index.php?option=com_clonard&view=stepthree");
			exit();
		}
        
        $form = new ApplicationForm();
		$html = $form->getHTML();
		
		$this->assignRef('html', $html);
		parent::display($tpl);
	}
}