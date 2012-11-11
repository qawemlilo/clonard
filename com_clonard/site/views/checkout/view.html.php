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
        $shipping = JRequest::getString('sp', '', 'GET');
        
        $this->html .= '<table class="cart foo" style="margin-top:20px;"><tr><td span="2"><h2 style="margin-left: 0px;">Order Now</h2></td></tr></table>';
        $this->html .=  '<table class="cart" style="margin-top:20px;"><thead><tr><th align="left">Item</th>';
        $this->html .=  '<th class="money" align="right">Price</th></tr></thead>';
 
        if (is_array($students) && count($students) > 0) 
	{
            foreach($students as $student_id=>$student_details) 
	    {
               $books = $refunds[$student_id];
               $totalRefunds = $this->calcRefunds($books); 
               
               $this->num_packs = $this->num_packs + 1;
               $this->refundstotal = $this->refundstotal + $totalRefunds;
               $this->subtotal = ($this->subtotal + (int)$student_details['amount_due']);
               
               $this->addBody($student_details, $totalRefunds);
	    }
	    
	    $this->shippingtotal = $this->calcShipping($shipping);
            $this->addShipping($shipping);
            
            $total = $this->calcTotal();
            
            $this->html .= '</tbody></table>';
            $this->html .=  '<table class="cart foo" style="margin-top:20px;"><tr><td align="left"><strong>Total</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $total .'</span></strong></td></tr></table>';	
	}
        
        return $this->html;
    }

	
    function addBody($child, $totalrefunds)
    {
        $this->html .= '<tr><td>Grade '. $child['grade'] . ' Carriculum for ' . $child['name'] . ' [<small><a href="index.php?option=com_clonard&view=stepfour&task=edit_pack&s_id=' .$child['s_id'].'" style="color: red">Edit</a></small>]</td><td><span class="randv">R</span><span class="randnum">' . ($child['amount_due'] - $totalrefunds) . '</span></td></tr>';  
    }
    
    
    function addShipping($shipping)
    {
        if($shipping != 'Collect') $shipping = $shipping . ' Mail';
        
        $this->html .= '<tr><td><strong>Shipping - ' . $shipping . ' </strong></td><td><span class="randv">R</span><span class="randnum">' . $this->shippingtotal .'</span></td></tr>';
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
    
 
    function calcTotal()
    {
        $total = 0;
        $total = (($this->subtotal + $this->shippingtotal) - $this->refundstotal);
        
        $this->total = $total;
        
        return $total;
    }
    
    
    function calcShipping($selected_option)
    {
        $total = 0;
        $num_items = $this->num_packs;
    
        if ($selected_option == 'Registered') {
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
        
        elseif ($selected_option == 'Overnight') {
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
        
        elseif ($selected_option == 'Collect') {
            $total = 0; 
        }
    
        return $total;
    }
}

class ClonardViewCheckout extends JView
{
    function display($tpl = null)
    {
	$cart = new Cart();
	$html = $cart->getHTML();
		
	$this->assignRef('html', $html);
	parent::display($tpl);
    }
}
