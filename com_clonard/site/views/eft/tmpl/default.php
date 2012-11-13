<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');

$session =& JFactory::getSession(); 
$total = $session->get('total');
?>

<div id="form-cont">
<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo (!$total) ? '0' : $total; ?></span><span></div>

<div class="clear"></div>
<!-- Our form -->
 <div id="contactForm">
    <fieldset>
	  <legend>Electronic Funds Transfer (EFT)</legend>
	  <p style="width:100%; height:0px; margin:0px; padding:0px;"> &nbsp; </p>
	  <p style="padding-left: 10px;"><strong>Total: R <?php echo $total; ?> .00</strong></p>
	  <div style="padding-left: 10px;"><p>As per your quote please make payment into the following bank account</p>
     <p><strong>BANK DETAILS:</strong></p>
     <p><strong>Clonard Education CC</strong> <br> 
       <strong>STANDARD BANK</strong> <br> 
       <strong>Current Account No:</strong> 051958910 <br> 
       <strong>Kloof Branch:</strong> 045526 <br> 
       <strong>Swift Code (International Customers):</strong> SBZAZAJJ
     </p>
     <p><strong>REFERENCE:</strong> Parent\'s Name and Surname (same as log in details)</p>
     <p>Please fax or email proof of payment to: <a href="mailto:orders@clonard.co.za">orders@clonard.co.za</a> / 086 741 9154</p></div>
      <p style="width:100%; height:10px; margin:0px; padding:0px;"> &nbsp; </p>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>