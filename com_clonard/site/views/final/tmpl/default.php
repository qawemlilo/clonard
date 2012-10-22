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
    <li class="active prior"><a class="cl-menu" href="index.php?option=com_clonard&view=stepone">1. Parent / Guardian</a></li>
	<li class="active prior">2. Details of Child</a></li>
	<li class="active prior">3. Select Books</li>
	<li class="active last"><a class="cl-menu" href="index.php?option=com_clonard&view=final">4. Order Now</a></li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo (!$total) ? '0' : $total; ?></span><span></div>
<!--
<div id="logoff"><img src="components/com_clonard/images/lock.png" style="height:20px; margin-right: 5px; vertical-align: middle"/><a href="index.php?option=com_content&view=article&id=15&Itemid=30">Logout</a></div>-->

<div class="clear"></div>
<!-- Our form -->
 <div id="contactForm">
 
    <fieldset>
	  <legend>Order Summary</legend>
	  <p style="width:100%; height:10px; margin:0px; padding:0px;"> &nbsp; </p>
	  
	  
	  <?php echo $this->html; ?>  
	  
	  
	    <form name="ch-details" method="POST" action="?option=com_clonard&view=final">
		   <input type="hidden" name="import" value="1" />
	       <p style="text-align:left; margin-left: 15%;"><button type="submit" name="submit" value="child" class="button orange" style="float:left;"><< Add another child</button></p>
		</form>
      <div class="clear"></div>
	  <p> &nbsp; </p>
           <?php echo $this->form; ?>
	  <div class="clear"></div>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>