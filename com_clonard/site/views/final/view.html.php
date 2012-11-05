<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/*
function sendMail($cart){
$to  = 'qawemlilo@gmail.com';

$subject = 'New Order from website';

$message="
<html>
<head>
  <title>New Order</title>
</head>
<body>
  $cart
</body>
</html>
";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Clonard Website <qawemlilo@gmail.com>' . "\r\n";

mail($to, $subject, $message, $headers);
}
*/

class ApplicationForm
{
    public $session;
	public $html = '';
    public $app;
	public $shipping = 0;
    public $shippingcost = 0;
	
    function __construct()
	{
	    $this->session = JFactory::getSession();
        $this->app =& JFactory::getApplication();
	}
	
    function processForm()
    {			
		$cart = $this->session->get('cart');
		
		if (isset($_POST['import'])) 
		{
		    $this->session->set('new', 'yes');
			$this->app->redirect("index.php?option=com_clonard&view=steptwo");
		}
	}
	
    function addBody($child)
	{
	
	  if(!$child['name'] || !$child['fees'])  
	      return;
		  
      $this->shipping += 1;
	  
      $table .= '<table class="cart"><thead><tr><th align="left">'. $child['grade'] .' Curriculum for '. $child['name']  . '</th><th class="money" align="left">Price</th></tr><thead>';
		 
	  $table .= '<tbody><tr><td>Tuition</td><td><span class="randv">R</span><span class="randnum">' . $child['fees'] . '</span></td></tr>';
	  
	  if (is_array($child['books']) && !empty($child['books'])) 
	  {
	      $table .= '<tr><td><strong>Less books not required:</strong></td><td>&nbsp;</td></tr>';
	      foreach($child['books'] as $book=>$price) 
		  {		   
              $table .= '<tr><td><span>' . $book . '</span></td><td><span class="randv">R</span><span class="randnum">' . $price . '</span></td></tr>';
	      }
      }		  
	  
	  $table .= '</tbody></table>';
	  
	  $this->html .= $table;	  
	}

/*
	function getParentHTML()
	{
		$parent = $this->session->get('parent');
		$name = $parent['title'] ." " . $parent['name'] ." " .$parent['surname'];
		
		$p = "<p>----------------------------------------------------<br /> <strong>NEW ORDER</strong>"; 
		$p .= "<br />----------------------------------------------------</p>";
		
		$p .= "<p><strong>Contact Details</strong></p>";

		if (!empty($name))
		    $p .= "<p><strong>Name:</strong> \t" . $name . "</p>";				
		if (!empty($parent['phone']))
		    $p .= "<p><strong>Phone:</strong> \t 0" . $parent['phone'] . "</p>";
		if (!empty($parent['cell']))
		    $p .= "<p><strong>Cell:</strong> \t 0" . $parent['cell'] . "</p>";
		if (!empty($parent['email']))
		    $p .= "<p><strong>Email:</strong> \t " . $parent['email'] ."</p>";
		if (!empty($parent['city']))
		    $p .= "<p><strong>City:</strong> \t 0" . $parent['city'] . "</p>";
		if (!empty($parent['province']))
		    $p .= "<p><strong>Province:</strong> \t" . $parent['province'] . "</p>";
		if (!empty($parent['address']))
		    $p .= "<p><strong>Postal Address:</strong> \t" . $parent['address'] . "</p>";
		if (!empty($parent['code']))
		    $p .= "<p><strong>Postal Code:</strong> \t" . $parent['code'] . "</p>";
		if (!empty($parent['postaladd']))
		    $p .= "<p><strong>Delivery Address:</strong> \t" . $parent['postaladd'] . "</p>";
		
		$p .= "<p> &nbsp; </p>";
		
		return $p;
	}
*/
	
	function getHTML()
	{
		$cart = $this->session->get('cart');
		$total = $this->getTotal();
		$shipping = 0;
 
        if (is_array($cart) && !empty($cart)) 
		{
            foreach($cart as $key=>$child) 
			{
	           $this->addBody($child);
		    }
		}
		
		if ($this->shipping == 1) {
		    $shipping = 80;
		} elseif ($this->shipping > 1) {
			$remainder = ($this->shipping - 2);			
			$remainder_total = ($remainder * 80);
			
		    $shipping = (110 + $remainder_total);
		} else {
            $this->session->destroy();
            header("Location: index.php?option=com_clonard&view=steptwo");
        }
		
        $this->shippingcost = $shipping;
		$grandtotal = $total + $shipping;
		
		$this->session->set('total', $grandtotal);

        $footer = '<table class="cart foo" style="margin-top:20px;"><tr><td align="left"><strong>Sub Total</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $total .'</span></strong></td></tr></table>';	
		
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Shipping: '. $this->shipping.' package(s)<strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $shipping .'</span></strong></td></tr></table>';	
      		
        $footer .= '<table class="cart foo"><tr><td align="left"><strong>Total</strong></td><td class="money" align="left"><strong><span class="randv">R</span><span class="randnum">' . $grandtotal .'</span></strong></td></tr></table>';	
        
		$html = $this->html .= $shipping_table . $footer;
		return $html;
	}
		
	
	function getForm()
	{		
		$parent = $this->session->get('parent');		
        $msg = "'You will now be taken to MonsterPay Secure website to make payment, please dont close this window'";
        $form = "<FORM METHOD=\"POST\" ACTION=\"https://www.monsterpay.com/secure/\" onSubmit=\"alert({$msg}); return true;\">";
		$form .= '<INPUT TYPE="HIDDEN" NAME="ButtonAction" VALUE="checkout">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="MerchantIdentifier" VALUE="79YW25SUQC">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="CurrencyAlphaCode" VALUE="ZAR">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="ShippingRequired" VALUE="1">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="BuyerInformation" VALUE="1">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="Title" VALUE="' . $parent['title'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="FirstName" VALUE="' . $parent['name'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="LastName" VALUE="' . $parent['surname'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="Email" VALUE="' . $parent['email'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="MobileNumber" VALUE="' . $parent['cell'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="HomeNumber" VALUE="' . $parent['phone'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="PostalCode" VALUE="' . $parent['code'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="Address1" VALUE="' . $parent['postaladd'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="City" VALUE="' . $parent['city'] . '">';
		$form .= '<INPUT TYPE="HIDDEN" NAME="State" VALUE="' . $parent['province'] . '">';
		
		$cart = $this->session->get('cart');
		$total = $this->getTotal();
		
		$shipping = 0;		
		$c = 0;
		
		$basket = array();
 
        if (is_array($cart) && !empty($cart)) 
		{
		    foreach($cart as $key=>$child) 
			{		
			    $i = $c + 1;
				
				$LIDQty = $c === 0 ? "LIDQty" : "LIDQty" . $c;
				
				$LIDSKU = $c === 0 ? "LIDSKU" : "LIDSKU" . $c;
				$VALUE = "PRO_00" . $i;
				
				$LIDDesc = $c === 0 ? "LIDDesc" : "LIDDesc" . $c;
				$VALUE2 = $child['grade'] . " Package";

				$LIDPrice = $c === 0 ? "LIDPrice" : "LIDPrice" . $c;
				$VALUE3 = ($child['fees'] - $child['credit']) . ".00";
				
			    $basket[] = array(
				    array("NAME"=>$LIDSKU, "VALUE"=>$VALUE),
					array("NAME"=>$LIDDesc, "VALUE"=>$VALUE2),
					array("NAME"=>$LIDPrice, "VALUE"=>$VALUE3),
					array("NAME"=>$LIDQty, "VALUE"=>1)
				);
				
                $c += 1;			
		    }
		
		    $num_packeges = count($basket);
		
		    $this->session->set('shipping', $this->shippingcost);
		    $total += $this->shippingcost;
		    $this->session->set('total', $total);

		    if (!empty($basket))
		    {
			    foreach ($basket as $product)
			    {
			        foreach ($product as $field)
				    {
				        $form .= '<INPUT TYPE="HIDDEN" NAME="'. $field['NAME'] .'" VALUE="'. $field['VALUE'] .'">';
				    }			    
			    }
		    }
			
			$num_s = $num_packeges + 1;
			$packs = $num_packeges > 1 ? $num_packeges . " packages" : $num_packeges . " package";
		
		    $form .= '<INPUT TYPE="HIDDEN" NAME="LIDSKU'. $num_packeges .'" VALUE="PRO_00'. $num_s .'">';
		    $form .= '<INPUT TYPE="HIDDEN" NAME="LIDDesc'. $num_packeges .'" VALUE="Shipping ' . $packs . '">';
		    $form .= '<INPUT TYPE="HIDDEN" NAME="LIDPrice'. $num_packeges .'" VALUE="'. $this->shippingcost .'.00">';
			$form .= '<INPUT TYPE="HIDDEN" NAME="LIDQty'. $num_packeges .'" VALUE="1">';
            
            $form .= '<p><strong style="margin-left: 10px">Please Note:</strong><ul><li>Collect-Once payment has been received we will contact you to arrange collection.</li><li>Overnight Delivery or Courier - Please contact us on <a href="mailto:orders@clonard.co.za">orders@clonard.co.za</a> for prices.</li></p>';
			
			$form .= '<p style="text-align:right; padding-right: 35px; background: url(components/com_clonard/images/lock.png) no-repeat; background-position: right center;">';
            $form .= '<BUTTON TYPE="SUBMIT" class="button blue" id="pay" onclick="location.href=\'index.php?option=com_clonard&view=eft\'; return false">Pay via EFT >></BUTTON> <BUTTON TYPE="SUBMIT" VALUE="Buy Now" class="button blue" id="pay" name="submit">Pay via CREDIT CARD >></BUTTON>';
			$form .= '</p></FORM>';
		
		    return $form;
		}
		else
		    return false;
	}
	
	
    function getTotal()
	{
		$cart = $this->session->get('cart');
		$fees = 0;
		$credit = 0;
		$total = 0;
		
		foreach($cart as $student) {
		    if (!empty($student['fees'])) {
  		        $fees += $student['fees']; 
			}
		    if (!empty($student['credit'])){
		       $credit += $student['credit'];
		    }
		}
		
		$total = ($fees - $credit);
		$this->session->set('total', $total);
		
		return $total;
	}
}

class ClonardViewFinal extends JView
{
	function display($tpl = null)
	{
		$currentUser =& JFactory::getUser();
        $step_completed = JRequest::getVar('step_completed', '', 'post', 'string');
		
		if($currentUser->get('guest')) 
		{
		    header("Location: index.php?option=com_clonard&view=stepthree");
			exit();
		}
        
 	    $form = new ApplicationForm();
		$form->processForm();
		
		$html = $form->getHTML();
		//$phtml = $form->getParentHTML();
		$form = $form->getForm();
		$shipping = $form->shipping;
		
		//$comhtml = $phtml . $html;
		//sendMail($comhtml);
		
		$this->assignRef('html', $html);
		$this->assignRef('form', $form);
		$this->assignRef('shipping', $shipping);
		parent::display($tpl);
	}
}