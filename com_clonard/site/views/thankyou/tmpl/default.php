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

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Thank you<span></div>

<div class="clear"></div>
<!-- Our form -->
 <div id="contactForm">
    <fieldset>
	  <legend>Thank you</legend>
	  <p style="width:100%; height:0px; margin:0px; padding:0px;"> &nbsp; </p>
      <h2 style="margin-left: 0px; margin-bottom: 30px; width: 90%; text-align: center;">Payment made successfully, thank you.</h2>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>