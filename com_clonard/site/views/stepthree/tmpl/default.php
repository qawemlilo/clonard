<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');

$session =& JFactory::getSession(); 
$currentChild = $this->currentChild; 
$et = JRequest::getString('et', '', 'GET');
$total = $session->get('total');
?>

<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active prior">1. Parent / Guardian</li>
	<li class="active prior">2. Details of Child</li>
	<li class="active">3. Select Books</li>
	<li class="inactive last">4. Payment Options</li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo (!$total) ? '0' : $total; ?></span><span></div>

<div class="clear"></div>
<!-- Our form -->
 <form id="contactForm" name="stepthree" method="POST" action="index.php?option=com_clonard&view=stepthree">
    <fieldset>
      <?php 
        $gr = $currentChild['grade'];
        
        if(!$gr) $gr = 'R';
      ?>
	  <legend>Grade <?php echo $gr . " Curriculum for " . $currentChild['name'];?></legend>
	  
	 <p id="responseP" class="f-notice showp" style="display:block">Please select any books which you have in your possession for which you require a credit.</p>
      
      <input type="hidden" name="import" value="1" />
      <input type="hidden" name="s_id" value="<?php echo $this->s_id;?>" />
      <input type="hidden" name="task" value="save_books" />
      <h2 style="margin-left: 0px">Pack Items</h2>
      <table class="booktable booktable2">
      <?php 
        if (is_array($this->refunds) && count($this->refunds) > 0) : ?>
            <thead>
              <tr>
                <th style="padding: 5px; font-size:16px;">
                  Pack Items
                </th>
                <th span="2" style="border-left: 1px solid #999; padding: 5px; font-size:16px;">
                  Credit Available
                </th>
              <tr>
            </thead>
            <tbody>            
       <?php  foreach($this->refunds as $refund) { ?>
	           <tr> 
	               <td><span class="booktitle"><?php echo $refund->title;  ?></span></td>
                 <td><span class="pricetag" > R <?php echo $refund->price;  ?></span></td>
                 <td align="center"><input type="checkbox" name="books[]" class="bookcheck" <?php if($refund->price == 0) echo 'disabled="disabled"';  ?> value="<?php echo $refund->id;  ?>" /></td>
               </tr>
      <?php
            } ?>
             </tbody>
      <?php  
         endif;
      ?>      
      </table>
         
	  <div class="clear"></div> 

     <div class="clear"></div> 	  
	  <p>  	   
		   <button type="submit" name="submit" value="order" class="button blue" id="submit"> <?php if($et) echo 'Save'; else echo 'Payment Option >>'; ?></button>
	  </p>
	  <div class="clear"></div>
	</fieldset>
 </form>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>
