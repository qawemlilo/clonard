<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');
$provs = array("Eastern Cape", "Free State", "Gauteng", "KwaZulu Natal", "Limpopo", "Mpumalanga", "Northern Cape", "North West", "North West");

$errors = array();
$session = JFactory::getSession(); 

if ($session->has('errors')) {
    $errors = $session->get('errors');
}

$parent = $session->get('parent');

?>
<script type="text/javascript">
jQuery.noConflict();
(function($) {
   $(function () {
	  $("#filladd").click(function () {
	      var v1 = $("#address").val(), v2 = $("#code").val();

		  if ($("#postaladd").val()) {
		      $("#postaladd").val('');
			  $("#pcode").val('');
		  }
		  else {
		      $("#postaladd").val(v1);
			  $("#pcode").val(v2);
		  }
	  });	  
   });
 })(jQuery);
</script>
<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active"><a class="cl-menu" href="index.php?option=com_clonard&view=stepone">1. Parent / Guardian</a></li>
    <li class="inactive">2. Details of Child</li>
	<li class="inactive">3. Select Books</li>
	<li class="inactive last"><a class="cl-menu" href="index.php?option=com_clonard&view=final">4. Order Now</a></li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount">0</span><span></div>

<div class="clear"></div>
<!-- Our form -->
  <form id="contactForm" name="ch-details" method="POST" action="index.php?option=com_clonard&view=stepone">
 
    <fieldset>
	  <legend>Details of Parent / Guardian</legend>
	  
	  <p class="f-error<?php if (count($errors) > 0) echo ' showp'; else echo ' hidep' ?>"> <strong>Please correct fields highlighted with red borders. </strong></p> 
	  <h2>Personal Details</h2>
	  <p>
	  
	    <input type="hidden" name="import" value="1" />
        <input type="hidden" name="task" value="save" />
		
	    <label for="title">Title:<span class="req">*</span></label>
		<select name="title" <?php if(isset($errors['title'])) echo 'class="error"'; ?>>
		  <option value="">Select Title</option>
		  <option value="Mr" <?php if($parent['title'] == "Mr") echo 'selected="selected"' ; ?>>Mr</option>
		  <option value="Mrs" <?php if($parent['title'] == "Mrs") echo 'selected="selected"' ; ?>>Mrs</option>
		  <option value="Miss" <?php if($parent['title'] == "Miss") echo 'selected="selected"' ; ?>>Miss</option>
		  <option value="Dr" <?php if($parent['title'] == "Dr") echo 'selected="selected"' ; ?>>Dr</option>
		  <option value="Prof" <?php if($parent['title'] == "Prof") echo 'selected="selected"' ; ?>>Prof</option>
		  <option value="Rev" <?php if($parent['title'] == "Rev") echo 'selected="selected"' ; ?>>Rev</option>
		</select>
	  </p>	 
	  
	  <p>
	    <label for="name">First Name:<span class="req">*</span></label>
		<input type="text" id="name" class="txt<?php if(isset($errors['name'])) echo ' error'; ?>" size="22" value="<?php echo $parent['name']; ?>" name="name">
	  </p>
	  
	  <p>
	    <label for="surname">Surname:<span class="req">*</span></label>
		<input type="text" id="surname" class="txt<?php if(isset($errors['surname'])) echo ' error'; ?>" size="22" value="<?php echo $parent['surname']; ?>" name="surname">
	  </p>
	  
	  <p>
	    <label for="email">Email:<span class="req">*</span></label>
		<input type="text" id="email" class="txt<?php if(isset($errors['email'])) echo ' error'; ?>" size="22" value="<?php echo $parent['email']; ?>" name="email" />
	  </p>

	  <p>
	    <label for="fax">Fax:</label>
		<input type="text" id="fax" class="txt<?php if(isset($errors['fax'])) echo ' error'; ?>" size="22" value="<?php if($parent['fax']) echo 0 . $parent['fax']; ?>" name="fax" /> <span style="color:#88888F">e.g 0317646480</span>
	  </p>
	  
	  <p>
	    <label for="phone">Tel:<span class="req">*</span></label>
		<input type="text" id="tel" class="txt<?php if(isset($errors['phone'])) echo ' error'; ?>" size="22" value="<?php if($parent['phone']) echo 0 . $parent['phone']; ?>" name="phone" /> <span style="color:#88888F">e.g 0317646480</span>
	  </p>
	  
	  <p>
	    <label for="cell">Cell:</label>
		<input type="text" id="cell" class="txt<?php if(isset($errors['cell'])) echo ' error'; ?>" size="22" value="<?php if($parent['cell']) echo 0 . $parent['cell']; ?>" name="cell" /> 
	  </p>
	  
	  <p>
	    <label for="city">City:<span class="req">*</span></label>
		<input type="text" id="city" class="txt<?php if(isset($errors['city'])) echo ' error'; ?>" size="22" value="<?php if($parent['city']) echo $parent['city']; ?>" name="city" /> 
	  </p>
	  
	  <p>
	    <label for="province">Province:<span class="req">*</span></label>
		<select name="province" <?php if(isset($errors['province'])) echo 'class="error"'; ?>>
		  <option value="">Select Province</option>
		  <option value="Eastern Cape" <?php if($parent['province'] == "Eastern Cape") echo 'selected="selected"' ; ?>>Eastern Cape</option>
		  <option value="Free State" <?php if($parent['province'] == "Free State") echo 'selected="selected"' ; ?>>Free State</option>
		  <option value="Gauteng" <?php if($parent['province'] == "Gauteng") echo 'selected="selected"' ; ?>>Gauteng</option>
		  <option value="KwaZulu Natal" <?php if($parent['province'] == "KwaZulu Natal") echo 'selected="selected"' ; ?>>KwaZulu Natal</option>
		  <option value="Limpopo" <?php if($parent['province'] == "Limpopo") echo 'selected="selected"' ; ?>>Limpopo</option>
		  <option value="Mpumalanga" <?php if($parent['province'] == "Mpumalanga") echo 'selected="selected"' ; ?>>Mpumalanga</option>
		  <option value="Northern Cape" <?php if($parent['province'] == "Northern Cape") echo 'selected="selected"' ; ?>>Northern Cape</option>
		  <option value="North West" <?php if($parent['province'] == "North West") echo 'selected="selected"' ; ?>>North West</option>
		  <option value="Western Cape" <?php if($parent['province'] == "North West") echo 'selected="selected"' ; ?>>Western Cape</option>
		  <option value="other" <?php if(!in_array($parent['province'], $provs)) echo 'selected="selected"' ; ?>>Other</option>
		</select>
	  
	    Other:
		<input type="text" id="province2" style="width: 120px" class="txt<?php if(isset($errors['province2'])) echo ' error'; ?>" size="22" value="<?php if(!in_array($parent['province'], $provs)) echo $parent['province']; ?>" name="province2" /> 
	  </p>
	   
	  <h2>Postal Address</h2>

	  <p>
	    <label for="address">Postal Address:<span class="req">*</span></label>
		<textarea tabindex="4" rows="5" <?php if(isset($errors['address'])) echo 'class="error"'; ?> cols="40" id="address" name="address"><?php echo $parent['address']; ?></textarea>
	  </p>
	  
	  <p>
	    <label for="address">Postal Code:<span class="req">*</span></label>  
		<input type="text" id="code" class="txt<?php if(isset($errors['code'])) echo ' error'; ?>" size="4" value="<?php if($parent['code']) echo $parent['code']; ?>" name="code" style="width:60px" /> <span style="color:#88888F">e.g 4001</span>
	  </p>
	  
	  <h2>Delivery Address</h2>
	 
	  <p>
	    <label for="postaladd">Delivery Address:<span class="req">*</span></label>
		<input type="checkbox" id="filladd" value="" /> <span>Same as Postal Address</span><br />
		<textarea tabindex="4" rows="5" <?php if(isset($errors['postaladd'])) echo 'class="error"'; ?> cols="40" id="postaladd" name="postaladd"><?php echo $parent['postaladd']; ?></textarea>
	  </p>

	  <p>
	    <label for="postalcode">Code:<span class="req">*</span></label>  
		<input type="text" id="pcode" class="txt<?php if(isset($errors['postalcode'])) echo ' error'; ?>" size="4" value="<?php if($parent['postalcode']) echo $parent['postalcode']; ?>" name="postalcode" style="width:60px" /> <span style="color:#88888F">e.g 4001</span>
	  </p>
	  
	  <h2>Additional Information</h2>
	  <p>
	    <label for="comments">Comment(s):</label>
		<textarea tabindex="4" rows="5" <?php if(isset($errors['comments'])) echo 'class="error"'; ?> cols="40" id="comments" name="comments"><?php if(isset($parent['comments'])) echo $parent['comments']; ?></textarea>
	  </p>
	  
	  <p> &nbsp; </p> 
	  
	  <p>
	    <button type="submit" value="submit" class="button blue" id="submit" name="submit">Details of Children >></button>
	  </p>
	  <div class="clear"></div>
	</fieldset>
 </form>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>
