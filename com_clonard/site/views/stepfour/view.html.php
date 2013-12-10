<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Cart {
    private $html = '';
    public $session;
	
    
    function __construct()
    {
        $this->session = JFactory::getSession();
    }
    
    
    function getHTML()
    {
        
            $students = $this->session->get('students');
            $refunds = $this->session->get('refunds');
            $student_id = JRequest::getString('s_id', '', 'GET');
            
            $books = $refunds[$student_id];
            $student = $students[$student_id];
            
            $this->addBody($student, $books);
            $this->addMyOptions($student_id);
        
            return $this->html;
    }

	
    function addBody($child, $books)
    {
	    $boookstotal = $this->calcRefunds($books);
	    $gr = $child['grade'];
        
        if(!$gr) $gr = 'R'; 
        
        $table = '<table class="cart" style="margin-top:20px;"><thead>';
        $table .= '<tr><th align="left">Grade '. $gr .' Curriculum for ' . $child['name'] . '  [<a style="text-decoration: none; color: red; font-weight: normal" href="index.php?option=com_clonard&view=steptwo&s_id=' . $child['s_id'] . '">Edit</a>]  [<a style="text-decoration: none; color: red; font-weight: normal" href="index.php?option=com_clonard&view=stepthree&task=remove&s_id=' . $child['s_id'] . '">Remove</a>]';
        $table .= '</th><th class="money" align="left">Credit</th></tr><thead>';
        
        $table .= '<tbody>';
        
        if (is_array($books) && count($books) > 0) {
            $table .= '<tr><td><strong style="margin-right: 5px">Refundable Pack Items:</strong>';
            $table .= '<a style="color: red;" href="index.php?option=com_clonard&view=stepthree&et=1&s_id=' .$child['s_id'].'">Edit</a></td><td>&nbsp;</td></tr>';
            
            foreach($books as $book)
            {
                $table .= '<tr><td><span>' . $book->title . '</span></td><td><span class="randv">R</span>';
                $table .= '<span class="randnum">' . $book->price . '</span></td></tr>';
            }
           
        }
        
        $table .= '</tbody></table>';
        
        $table .= '<table class="cart foo" style="margin-top:20px;">';
        $table .= '<tr><td align="left"><strong>Total Credit</strong></td><td class="money" align="left">';
        $table .= '<strong><span class="randv">R</span><span class="randnum">' . $boookstotal .'</span></strong></td></tr></table>';	
        
        $this->html .= $table;	  
    }
    
    
    function addMyOptions($s_id)
    {
        
        $footer = '<table class="cart foo" style="margin-top:20px;"><tr><td span="2"><h2 style="margin-left: 0px;">Payment Options</h2></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Option A - Pay in Full and receive a <span style="font-size:16px; color:#000;">5% Discount</span></strong></td><td class="money" align="right" style="width: 30%"><a href="index.php?option=com_clonard&view=stepfour&task=add_opt&opt=a&s_id='.$s_id.'" class="button blue">Select >></a></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Option B - Payment Plan</strong>';
        $footer .= '<br><strong>50% due now</strong><br >';
        $footer .= '(Please ensure you have read the payment information in the <a href="http://www.clonard.co.za/index.php?option=com_content&view=article&id=25&Itemid=36" target="_blank">Terms and Conditions</a>.<br><span style="color: red">Payment Option B is subject to credit approval and is at Clonards discretion. A R250 Admin Fee is levied on all payment plans.</span>)</td>';
        $footer .= '<td class="money" align="right" style="width: 30%"><a href="index.php?option=com_clonard&view=stepfour&task=add_opt&opt=b&s_id='. $s_id .'" class="button blue">Select >></a></td></tr></table>';
        
        $this->html .= $footer;
    }
        
    
    
    function calcRefunds($refinds)
    {
        $total = 0;
        
        if(is_array($refinds) && count($refinds) > 0) {
            foreach($refinds as $refind) {
                $total = $total + (int)$refind->price;
            }
        }
        
        return $total;
    }
}


class ClonardViewStepfour extends JView
{
	function display($tpl = null)
	{
		$cart = new Cart();
		$html = $cart->getHTML();
		
		$this->assignRef('html', $html);
		parent::display($tpl);
	}
}
