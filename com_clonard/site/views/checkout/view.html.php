<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Cart {

    public $html = '';
    public $form = '';
    public $num_packs = 0;
    
    public $subtotal = 0;
    public $shippingtotal = 0;
    
    public $session;
	
    
    function __construct() {
        $this->session = JFactory::getSession();
    }
    
    
    function getHTML() {
        //Check if calculations have been done
        if($this->num_packs > 0) {
            return false;
        }
        
	   $students = $this->session->get('students');
        $refunds = $this->session->get('refunds');
        $parent = $this->session->get('parent');
        $shipping = JRequest::getString('sp', '', 'GET');
        
        
        $this->html .= '<h2 style="margin-left: 15%;">Order &amp; Pay</h2>';
        $this->html .=  '<table class="cart" style="margin-top:5px;"><thead><tr><th align="left">Item</th>';
        $this->html .=  '<th class="money" align="right">Price</th></tr></thead>';
        
        $this->form .= "<FORM METHOD=\"POST\" ACTION=\"https://www.monsterpay.com/secure/\" id=\"payform\" >";
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="ButtonAction" VALUE="checkout">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="MerchantIdentifier" VALUE="79YW25SUQC">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="CurrencyAlphaCode" VALUE="ZAR">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="ShippingRequired" VALUE="1">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="BuyerInformation" VALUE="1">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="Title" VALUE="' . $parent['title'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="FirstName" VALUE="' . $parent['name'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="LastName" VALUE="' . $parent['surname'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="Email" VALUE="' . $parent['email'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="MobileNumber" VALUE="' . $parent['cell'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="HomeNumber" VALUE="' . $parent['phone'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="PostalCode" VALUE="' . $parent['code'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="Address1" VALUE="' . $parent['postaladd'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="City" VALUE="' . $parent['city'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="State" VALUE="' . $parent['province'] . '">';
 
        if (is_array($students) && count($students) > 0) {
	        $counter = 0;
	    
            foreach($students as $student_id=>$student_details) {
                 $books = $refunds[$student_id];
                 $refundTotal = $this->calcRefunds($books);
                 
                 $itemtotal = $this->calcDiscount($student_details['fees'], $refundTotal, $student_details['opt']);
                 
                 $this->num_packs = $this->num_packs + 1;
                 $this->subtotal += $itemtotal;
                             
                 $this->addBody($student_details, $itemtotal);
                 
                 $gr = $student_details['grade'];
                 if(!$gr) $gr = 'R';
                 
                 $this->addFormItem('Grade ' . $gr . ' Pack', $itemtotal, $counter);   
                 
                 $counter = $counter + 1;
	        }
	    
	        $this->shippingtotal = $this->calcShipping($shipping);
            $this->addShipping($shipping);
            
            $this->addFormItem('Shipping - ' . $this->num_packs . ' Packs', $this->shippingtotal, $this->num_packs);
            
            $total = ($this->subtotal + $this->shippingtotal);
            
            $this->session->set('total', $total);
            
            $this->html .= '</tbody></table>';
            $this->html .=  '<table class="cart foo" style="margin-top:20px;"><tr><td align="left"><strong>Total</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $total .'</span></strong></td></tr></table>';	
	    }
        
        return $this->html;
    }

	
    function addBody($child, $amount_due) {
        $gr = $child['grade'];
        
        if(!$gr) $gr = 'R';
        
        $this->html .= '<tr><td>Grade '. $gr . ' Curriculum for ' . $child['name'];
        $this->html .=  ' [<small><a href="index.php?option=com_clonard&view=stepfour&task=edit_pack&s_id=' .$child['s_id'].'" style="color: red">Edit</a></small>]';
        $this->html .= '</td><td><span class="randv">R</span><span class="randnum">' . $amount_due . '</span></td></tr>';  
    }
    
    
    function addShipping($shipping) {
        if($shipping != 'Collect') $shipping = 'Courier';
        
        $this->html .= '<tr><td><strong>Shipping - ' . $shipping . ' </strong></td>';
        $this->html .= '<td><span class="randv">R</span><span class="randnum">' . $this->shippingtotal .'</span></td></tr>';
    }
    
    
    function addFormItem($item, $price, $counter) {
	if ($counter === 0) {    
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDSKU" VALUE="PRO_00'. ($counter+1) .'">';
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDDesc" VALUE="' . $item . '">';
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDPrice" VALUE="'. $price .'.00">';
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDQty" VALUE="1">';
	}
	else {
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDSKU'. $counter .'" VALUE="PRO_00'. ($counter+1) .'">';
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDDesc'. $counter.'" VALUE="' . $item . '">';
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDPrice'. $counter .'" VALUE="'. $price .'.00">';
	    $this->form .= '<INPUT TYPE="HIDDEN" NAME="LIDQty'. $counter .'" VALUE="1">';	
	}
    }
    
    
    function getForm() {
        $this->form .= '<table class="cart foo" style="margin-top:20px; border-bottom: 0px;"><tr><td align="left" span="2"><strong>Please Note:</strong><ul  style="margin-left: 0px"><li>Collect - Once payment has been received we will contact you to arrange collection.</li></ul></td></tr>';
        
        $this->form .= '<tr><td span="2"><img src="components/com_clonard/images/loading.gif" class="progress" style="display:none" /> <br><a class="button blue" id="payoncollection" href="index.php?option=com_clonard&view=collect" style="margin-bottom:5px;margin-top:10px; width:280px; padding-right:0px padding-left:0px">Pay on Collection >></a> <br>'; 
        
        $this->form .= '<a class="button blue" id="paywitheft" href="index.php?option=com_clonard&view=eft" style="margin-bottom:5px; width:280px; padding-right:0px padding-left:0px">Pay via EFT >></a> <br>';
        
        $this->form .= '<a VALUE="Buy Now" class="button blue" id="paywithcard" name="submit" style="width:280px; padding-right:0px padding-left:0px">Pay via CREDIT CARD >></a></td></tr></table>';
       
        $this->form .= '</p></FORM>';
        
        
        return $this->form;
    }    
    
    
    function calcRefunds($refunds) {
        $total = 0;
        
        if(is_array($refunds) && count($refunds) > 0) {
            foreach($refunds as $refund) {
                $total = $total + (int)$refund->price;
            }
        }
        
        return $total;
    }
    
    
    function calcDiscount($fees, $refundAmount, $opt) {
        if ($opt == 'a') {
            $feesMinusRefunds = ($fees - $refundAmount);
            $stotal =  ($feesMinusRefunds - ceil($feesMinusRefunds * 0.05));   
        }
        else {
            $feesMinusRefunds = ($fees - $refundAmount);
            $stotal =  ceil($feesMinusRefunds * 0.5);
        }
        
        
        return $stotal;
    }
    
    
    function calcShipping($selected_option) {
        $total = 0;
        $num_items = $this->num_packs;
        $onepack = 150;
        $twopacks = 190;
    
        if ($selected_option == 'Registered') {
            switch($num_items) {
                case 1:
                    $total = $onepack;
                break;
            
                case 2:
                    $total = $twopacks;
                break;
            
                default:
                    if ($num_items > 2) {
                        $extra_items = ($num_items - 2);
                        $extra_items_total = ($extra_items * $onepack);
                    
                        $total = $extra_items_total + $twopacks;
                    }
            }
        }
        
        elseif ($selected_option == 'Collect') {
            $total = 0; 
        }
    
        return $total;
    }
}


class ClonardViewCheckout extends JView {

    function display($tpl = null) {
        $model =& $this->getModel();
        $session = JFactory::getSession();
        $students = $session->get('students');
        $orderIds = array();
        
	    $cart = new Cart();
	    $html = $cart->getHTML();
	    $form = $cart->getForm();
	      
	    foreach ($students as $id=>$data) {
            $result = $model->createStudent($data);

            if($result) {
                $ordercreated = $model->createOrder($data, $result); 
                
                if (!$ordercreated) {
                    die('Order not created');
                }
                else {
                    $orderIds[] = $ordercreated; 
                }
                                
            }
            else {
                die('Student not created');
            }
        }
		
	    $this->assignRef('html', $html);
	    $this->assignRef('form', $form);
        $this->assignRef('orders', $orderIds);
	          
	    parent::display($tpl);
    }
}


