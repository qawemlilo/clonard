<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');

?>

<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active prior">3. Select Books</li>
	<li class="active prior">4. Payment Options</li>
	<li class="active">5. Shipping Options</li>
	<li class="active last">6. Order Now</li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount">0</span><span></div>


<div class="clear"></div>
<!-- Our form -->
 <div id="contactForm">
 
    <fieldset>
	  <legend>Shipping Option</legend>
	  <p style="width:100%; height:10px; margin:0px; padding:0px;"> &nbsp; </p>
	  
	  
	  <?php echo $this->html; ?>  
	  
	  
	    <form name="ch-details" method="POST" action="index.php?option=com_clonard&view=steptwo">
		   <input type="hidden" name="import" value="1" />
	       <p style="text-align:left; margin-left: 15%;"><button type="submit" name="submit" value="child" class="button blue" style="float:left;">Pay via MonsterPay >></button> &nbsp;  <button type="submit" name="submit" value="child" class="button blue" style="float:left;">Pay via EFT >></button></p>
		</form>
	  <div class="clear"></div>
	  <p>
	    &nbsp;
	  </p>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>
