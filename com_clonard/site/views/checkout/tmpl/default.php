<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');

$session =& JFactory::getSession(); 
$total = $session->get('total');
?>

<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active prior">3. Select Books</li>
	<li class="active prior">4. Payment Options</li>
	<li class="active prior">5. Shipping Options</li>
	<li class="active last">6. Order &amp; Pay</li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo (!$total) ? '0' : $total; ?></span><span></div>


<div class="clear"></div>
<!-- Our form -->
 <div id="contactForm">
 
    <fieldset>
	  <legend>6. Order &amp; Pay</legend>
	  <p style="width:100%; height:10px; margin:0px; padding:0px;"> &nbsp; </p>
	  
	  
	  <?php echo $this->html; ?>  
	  
	 <?php echo $this->form; ?>
	  <div class="clear"></div>
	  <p>
	    &nbsp;
	  </p>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>
