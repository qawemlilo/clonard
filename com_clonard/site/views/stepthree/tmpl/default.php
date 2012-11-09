<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');


$currentChild = $this->currentChild; 

?>

<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active prior">1. Parent / Guardian</li>
	<li class="active prior">2. Details of Child</li>
	<li class="active">3. Select Books</li>
	<li class="inactive last">4. Order Now</li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount">0</span><span></div>

<div class="clear"></div>
<!-- Our form -->
 <form id="contactForm" name="stepthree" method="POST" action="index.php?option=com_clonard&view=stepthree">
    <fieldset>
	  <legend>Grade <?php echo $currentChild['grade'] . " Curriculum for " . $currentChild['name'];?></legend>
	  
	  <?php if($currentChild['grade'] != 'Grade R') { ?> <p id="responseP" class="f-notice showp" style="display:block">Please select any books which you have in your possession for which you require a credit.</p> <?php } ?>
      
      <input type="hidden" name="import" value="1" />
      <input type="hidden" name="s_id" value="<?php echo $this->s_id;?>" />
      <input type="hidden" name="task" value="save_books" />
      <h2>Refundable Items</h2>
      <table class="booktable">
      <?php 
        if (is_array($this->refunds) && count($this->refunds) > 0) :
            foreach($this->refunds as $refund) { ?>
	           <tr>
                 <td><input type="checkbox" name="books[]" class="bookcheck" <?php if($refund->price == 0) echo 'disabled="disabled"';  ?> value="<?php echo $refund->id;  ?>" /></td>
                 <td><span class="pricetag" >- R <?php echo $refund->price;  ?> . 00</span></td>
                 <td><span class="booktitle"><?php echo $refund->title;  ?></span></td>
               </tr>
      <?php
            }
        endif;
      ?>      
      </table>
         
	  <div class="clear"></div> 

     <div class="clear"></div> 	  
	  <p>  	   
		   <button type="submit" name="submit" value="order" class="button blue" id="submit">Order Summary >></button>
	  </p>
	  <div class="clear"></div>
	</fieldset>
 </form>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>