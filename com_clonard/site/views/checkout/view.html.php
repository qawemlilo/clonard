<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Cart
{

    public $html = '';
    public $form = '';
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
        $parent = $this->session->get('parent');
        $shipping = JRequest::getString('sp', '', 'GET');
        
        
        $this->html .= '<h2 style="margin-left: 15%;">Order &amp; Pay</h2>';
        $this->html .=  '<table class="cart" style="margin-top:5px;"><thead><tr><th align="left">Item</th>';
        $this->html .=  '<th class="money" align="right">Price</th></tr></thead>';
        
        $msg = "'You will now be taken to MonsterPay Secure website to make payment, please dont close this window'";
        $this->form .= "<FORM METHOD=\"POST\" ACTION=\"https://www.monsterpay.com/secure/\" onSubmit=\"alert({$msg}); return true;\">";
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="ButtonAction" VALUE="checkout">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="MerchantIdentifier" VALUE="79YW25SUQC">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="CurrencyAlphaCode" VALUE="ZAR">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="ShippingRequired" VALUE="1">';
        $form .= '<INPUT TYPE="HIDDEN" NAME="BuyerInformation" VALUE="1">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="Title" VALUE="' . $parent['title'] . '">';
        $form .= '<INPUT TYPE="HIDDEN" NAME="FirstName" VALUE="' . $parent['name'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="LastName" VALUE="' . $parent['surname'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="Email" VALUE="' . $parent['email'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="MobileNumber" VALUE="' . $parent['cell'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="HomeNumber" VALUE="' . $parent['phone'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="PostalCode" VALUE="' . $parent['code'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="Address1" VALUE="' . $parent['postaladd'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="City" VALUE="' . $parent['city'] . '">';
        $this->form .= '<INPUT TYPE="HIDDEN" NAME="State" VALUE="' . $parent['province'] . '">';
 
        if (is_array($students) && count($students) > 0) 
	{
	    $counter = 0;
	    
            foreach($students as $student_id=>$student_details) 
	    {
               $books = $refunds[$student_id];
               $totalRefunds = $this->calcRefunds($books); 
               
               $this->num_packs = $this->num_packs + 1;
               $this->refundstotal = $this->refundstotal + $totalRefunds;
               $this->subtotal = ($this->subtotal + (int)$student_details['amount_due']);
                           
               $this->addBody($student_details, $totalRefunds);
               
               $this->addFormItem('Grade ' . $student_details['grade'] . ' Pack', ((int)$student_details['amount_due'] - (int)$totalRefunds), $counter);   
               
               $counter = $counter + 1;
	    }
	    
	    $this->shippingtotal = $this->calcShipping($shipping);
            $this->addShipping($shipping);
            
            $this->addFormItem('Shipping - ' . $this->num_packs . ' Packs', $this->shippingtotal, $this->num_packs);
            
            $total = $this->calcTotal();
            
            $this->session->set('total', $total);
            
            $this->html .= '</tbody></table>';
            $this->html .=  '<table class="cart foo" style="margin-top:20px;"><tr><td align="left"><strong>Total</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $total .'</span></strong></td></tr></table>';	
	}
        
        return $this->html;
    }

	
    function addBody($child, $totalrefunds)
    {
        $this->html .= '<tr><td>Grade '. $child['grade'] . ' Carriculum for ' . $child['name'];
        $this->html .=  ' [<small><a href="index.php?option=com_clonard&view=stepfour&task=edit_pack&s_id=' .$child['s_id'].'" style="color: red">Edit</a></small>]';
        $this->html .= '</td><td><span class="randv">R</span><span class="randnum">' . ($child['amount_due'] - $totalrefunds) . '</span></td></tr>';  
    }
    
    
    function addShipping($shipping)
    {
        if($shipping != 'Collect') $shipping = $shipping . ' Mail';
        
        $this->html .= '<tr><td><strong>Shipping - ' . $shipping . ' </strong></td>';
        $this->html .= '<td><span class="randv">R</span><span class="randnum">' . $this->shippingtotal .'</span></td></tr>';
    }
    
    
    function addFormItem($item, $price, $counter)
    {
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
    
    
    function getForm()
    {
        $this->form .= '<table class="cart foo" style="margin-top:20px; border-bottom: 0px;"><tr><td align="left" span="2"><strong>Please Note:</strong><ul  style="margin-left: 0px"><li>Collect - Once payment has been received we will contact you to arrange collection.</li><li>Overnight Delivery or Courier - Please contact us on <a href="mailto:orders@clonard.co.za">orders@clonard.co.za</a> for prices.</li></td></tr>';
        
        $this->form .= '<tr><td span="2"><BUTTON TYPE="SUBMIT" class="button blue" id="pay" onclick="location.href=\'index.php?option=com_clonard&view=eft\'; return false">Pay via EFT >></BUTTON> <BUTTON TYPE="SUBMIT" VALUE="Buy Now" class="button blue" id="pay" name="submit">Pay via CREDIT CARD >></BUTTON></td></tr></table>';
       
        $this->form .= '</p></FORM>';
        
        
        return $this->form;
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
        $model =& $this->getModel();
        $session = JFactory::getSession();
        $students = $session->get('students');
        
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
            }
            else {
                die('Student not created');
            }
        }
		
	      $this->assignRef('html', $html);
	      $this->assignRef('form', $form);
	      
	      parent::display($tpl);
    }
}
