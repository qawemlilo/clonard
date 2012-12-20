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
               
               $this->num_packs = $this->num_packs + 1;
               
               $this->addBody($student_details, $books );
		    }
            
            $this->addShipping($student_details, $books);
            $this->session->set('total', $this->subtotal);
		}
		else {
		    $mainframe =& JFactory::getApplication();
            $this->session->set('total', 0);
            $mainframe->redirect('index.php?option=com_clonard&view=steptwo', 'Your basket is currently empty');
        }
        
        return $this->html;
	}

	
    function addBody($child, $books)
	{
	$opt = $child['opt'];
    $gr = $child['grade'];
    $fees = $child['fees'];
    
    $totalcredit = $this->calcRefunds($books);
    
    if(!$gr) $gr = 'R';
	
        $table = '<table class="cart" style="margin-top:20px;"><thead><tr><th align="left">Grade '. $gr;
        $table .= ' Curriculum for '. $child['name']  . ' <small> [ <a style="text-decoration: none; color: red; font-weight: normal" href="index.php?option=com_clonard&view=stepfour&task=edit_pack&s_id='. $child['s_id'].'">Edit</a> ]</small></th>';
        $table .= '<th class="money" align="right"><span class="randv" style="color: #fff; font-weight: normal">R</span><span class="randnum" style="color: #fff; font-weight: normal">' . $fees . '</span></th></tr></thead>';
        
        if ($opt == 'a') {
            $totalMinusRefunds = ($fees - $totalcredit);        
            $discount = $this->calcDiscount($totalMinusRefunds);
            $subtotal = ($totalMinusRefunds - $discount);
            
            $this->subtotal += $subtotal;
            
            $table .= '<tr><td><strong>5% Option</strong></td><td>&nbsp;</td></tr>';
            $table .= '<tr><td>Less total credit</td><td style="border-bottom: 1px solid #000"><span class="randv">R</span><span class="randnum">' . $totalcredit . '</span></td></tr>';
            $table .= '<tr><td>&nbsp;</td><td><strong><span class="randv">R</span><span class="randnum">' . $totalMinusRefunds . '</span></strong></td></tr>';
            $table .= '<tr><td style="color: #1479C4">Less 5% Discount</td><td style="border-bottom: 1px solid #000"><span class="randv" style="color: #1479C4">R</span><span class="randnum" style="color: #1479C4">' . $discount . '</span></td></tr>';
            $table .= '<tr><td><strong>Sub total (excl postage)</strong></td><td><strong><span class="randv">R</span><span class="randnum">' . $subtotal . '</span></strong></td></tr>';
        }
        else {
            $credit = ceil($fees * 0.25);
            $currentFees = ceil($fees * 0.75);
            $subtotal = ($currentFees - $totalcredit);
            
            $this->subtotal += $subtotal;

            $table .= '<tr><td><strong>75/25% Option</strong></td><td>&nbsp;</td></tr>';
            $table .= '<tr><td>Less total credit</td><td style="border-bottom: 1px solid #000"><span class="randv">R</span><span class="randnum">' . $totalcredit . '</span></td></tr>'; 
            $table .= '<tr><td><strong>Sub total</strong></td><td><strong><span class="randv">R</span><span class="randnum">' . ($fees - $totalcredit) . '</span></strong></td></tr>';
            
            $table .= '<tr><td>Amount Due now (excl postage)</td><td><span class="randv">R</span><span class="randnum">' . $subtotal . '</span></td></tr>';
            $table .= '<tr><td style="color: red;">Amount Due Mid Year</td><td><span class="randv" style="color: red;">R</span><span class="randnum" style="color: red;">' . $credit . '</span></td></tr>';
        }
        
        $table .= '</tbody></table>';
        
        $this->html .= $table;	  
	}
    
    
    function addShipping()
	{
        $collection = 0;
        $overnight = $this->calcShipping($this->num_packs, 'overnight');
        $registered_mail = $this->calcShipping($this->num_packs, 'registered');

        if($this->num_packs > 1) {
          $footer = '<table class="cart foo" style="margin-top:20px;"><tr><td align="left"><strong>Total (excl postage)</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $this->subtotal .'</span></strong></td></tr></table>';
        }        
        
        $footer .= '<table class="cart foo" style="margin-top:20px;"><tr><td span="2"><h2 style="margin-left: 0px;">Shipping Options for '. $this->num_packs .' package(s) </h2></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Collect - R0</strong></td><td class="money" align="right" style="width: 30%"><a href="index.php?option=com_clonard&view=checkout&sp=Collect" class="button blue">Select >></a></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Registered Mail - R' . $registered_mail .'</strong></td><td style="width: 30%" class="money" align="right"><a href="index.php?option=com_clonard&view=checkout&sp=Registered" class="button blue">Select >> </a></td></tr></table>';
        
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Overnight Mail - R' . $overnight .'</strong></td><td class="money" style="width: 30%" align="right"><a href="index.php?option=com_clonard&view=checkout&sp=Overnight" class="button blue">Select >></a></td></tr></table><br>';
	
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
    
    
    function calcDiscount($fees)
	{
        $total = ceil($fees * 0.05);
        
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
