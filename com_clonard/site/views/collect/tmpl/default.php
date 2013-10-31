<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');

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
	  <legend>Payment upon collection</legend>
	  <p style="width:100%; height:0px; margin:0px; padding:0px;"> &nbsp; </p>
	  <p style="padding-left: 10px;"><strong>Total: R <?php echo $total; ?></strong></p>
	  <div style="padding-left: 10px;">
        <p>As per your quote please make payment upon collection</p>
      </div>
      <p style="width:100%; height:10px; margin:0px; padding:0px;"> &nbsp; </p>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>