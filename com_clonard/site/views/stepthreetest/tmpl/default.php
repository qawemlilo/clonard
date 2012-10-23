<?php 
defined('_JEXEC') or die('Restricted access'); 

include_once('components/com_clonard/inc/books.php');

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');

$session =& JFactory::getSession(); 
$children = $session->get('children');
$current = $session->get('current');
$currentChild = $children[$current]; 
$total = $session->get('total');

$books = new Books;

if($currentChild['grade'] == 'Grade 0')
   $Fixzero = 'Grade R';
else
   $Fixzero = $currentChild['grade'];

$books_html = $books->getHTML($currentChild['grade']);
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

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo (!$total) ? '0' : $total; ?></span><span></div>
<!--
<div id="logoff"><img src="components/com_clonard/images/lock.png" style="height:20px; margin-right: 5px; vertical-align: middle"/><a href="index.php?option=com_content&view=article&id=15&Itemid=30">Logout</a></div>-->

<div class="clear"></div>
<!-- Our form -->
 <form id="contactForm" name="stepthree" method="POST" action="?option=com_clonard&view=stepthree">
    <fieldset>
	  <legend><?php echo $currentChild['grade'] . " Curriculum for " . $currentChild['name'];?></legend>
	  
	  <?php if($currentChild['grade'] != 'Grade R') { ?> <p id="responseP" class="f-notice showp" style="display:block">Please select any books which you have in your possession for which you require a credit.</p> <?php } ?>
      
      <input type="hidden" name="import" value="1" />
      <input type="hidden" name="step_completed" value="three" />
      <?php echo $books_html; ?>	  
   
         
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