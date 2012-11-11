<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Cart
{

	private $html = '';
    
	public $num_packs = 0;
    
    public $subtotal = 0;
    public $refundstotal = 0;
    public $shippingtotal = 0;
    
    public $total = 0;
    
    public $session;
	
    
    function __construct()
	{
	    $this->session = JFactory::getSession();
	}
    
    
	function getHTML()
	{
        //Check if calculations have been done
        if($this->num_packs > 0) {
            return false;
        }
        
	$students = $this->session->get('students');
        $refunds = $this->session->get('refunds');
 
        if (is_array($students) && count($students) > 0) 
		{
            foreach($students as $student_id=>$student_details) 
			{
               $books = $refunds[$student_id];
               $totalRefunds = $this->calcRefunds($books); 
               
               $this->num_packs = $this->num_packs + 1;
               $this->refundstotal = $this->refundstotal + $totalRefunds;
               $this->subtotal = ($this->subtotal + (int)$student_details['amount_due']);
               
               $this->addBody($student_details, $books );
		    }
            
            $this->addShipping($student_details, $books);
		}
        
        return $this->html;
	}

	
    function addBody($child, $books)
	{
	$opt = $child['opt'];
	$totalcredit = $this->calcRefunds($books);
	
        $table = '<table class="cart" style="margin-top:20px;"><thead><tr><th align="left">Grade '. $child['grade'];
        $table .= ' Curriculum for '. $child['name']  . '  [<a style="text-decoration: none; color: red; font-weight: normal" href="index.php?option=com_clonard&view=stepfour&task=edit_pack&s_id='. $child['s_id'].'">Edit</a>]</th>';
        $table .= '<th class="money" align="right"><span class="randv" style="color: #fff;">R</span><span class="randnum" style="color: #fff;">' . $child['fees']. '</span></th></tr></thead>';
        
        if ($opt == 'a') {
            $table .= '<tbody><tr><td span="2"><strong>Option A - 5% discount full payment</strong></td></tr>';
            $table .= '<tr><td style="color: #1479C4">5% Discount</td><td><span class="randv" style="color: #1479C4">R</span><span class="randnum" style="color: #1479C4">' . ceil($child['fees'] * 0.05) . '</span></td></tr>';
            $table .= '<tr><td>Amount due</td><td><span class="randv">R</span><span class="randnum">' . $child['amount_due'] . '</span></td></tr>';
        }
        else {
            $table .= '<tbody><tr><td span="2"><strong>Option B - payment plan</strong></td></tr>';
            $table .= '<tr><td style="color: red;">Amount due at mid year</td><td><span class="randv" style="color: red;">R</span><span class="randnum" style="color: red;">' . ceil($child['fees'] * 0.25) . '</span></td></tr>';
            $table .= '<tr><td>Amount due now</td><td><span class="randv">R</span><span class="randnum">' . $child['amount_due'] . '</span></td></tr>';        
        }
        
        $table .= '<tr><td><strong style="margin-right: 5px">Less total credit</strong></td><td>&nbsp;</td></tr>';
        
        $table .= '<tr><td><span>Total Credit</span> <a style="color: red;" href="index.php?option=com_clonard&view=stepthree&et=1&s_id=' .$child['s_id'].'">Edit</a></td><td><span class="randv">R</span><span class="randnum">' . $totalcredit . '</span></td></tr>';
        
        $table .= '</tbody></table>';
        
        $this->html .= $table;	  
	}
    
    
    function addShipping()
	{
        $collection = 0;
        $overnight = $this->calcShipping($this->num_packs, 'overnight');
        $registered_mail = $this->calcShipping($this->num_packs, 'registered');


        $footer = '<table class="cart foo" style="margin-top:20px;"><tr><td align="left"><strong>Sub Total</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . ($this->subtotal - $this->refundstotal) .'</span></strong></td></tr></table>';	
        
        $footer .= '<table class="cart foo" style="margin-top:20px;"><tr><td span="2"><h2 style="margin-left: 0px;">Shipping Options for '. $this->num_packs .' package(s) </h2></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Collect - R0</strong></td><td class="money" align="right" style="width: 30%"><a href="index.php?option=com_clonard&view=final" class="button blue">Select >></a></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Registered Mail - R' . $registered_mail .'</strong></td><td style="width: 30%" class="money" align="right"><a href="index.php?option=com_clonard&view=final" class="button blue">Select >> </a></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Overnight Mail - R' . $overnight .'</strong></td><td class="money" style="width: 30%" align="right"><a href="index.php?option=com_clonard&view=final" class="button blue">Select >></a></td></tr></table><br>';
	
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
    
    
    function calcShipping($num_items, $selected_option)
	{
        $total = 0;
    
        if ($selected_option == 'registered') {
            switch($num_items) {
                case 1:
                    $total = 90;
                break;
            
                case 2:
                    $total = 130;
                break;
            
                default:
                    if ($num_items > 2) {
                        $extra_items = ($num_items - 2);
                        $extra_items_total = ($extra_items * 90);
                    
                        $total = $extra_items_total + 130;
                    }
            }
        } 
        
        elseif ($selected_option == 'overnight') {
            switch($num_items) {
                case 1:
                    $total = 380;
                break;
            
                case 2:
                    $total = 480;
                break;
            
                default:
                    if($num_items > 2) {
                        $extra_reg_items = ($num_items - 2);
                        $extra_reg_total = ($extra_reg_items * 380);
                    
                        $total = $extra_reg_total + 480;
                    }
            }  
        }
        
        elseif ($selected_option == 'noshipping') {
            $total = 0; 
        }
    
        return $total;
	}
}

class ClonardViewFinal extends JView
{
	function display($tpl = null)
	{
		$cart = new Cart();
		$html = $cart->getHTML();
		
		$this->assignRef('html', $html);
		parent::display($tpl);
	}
}
