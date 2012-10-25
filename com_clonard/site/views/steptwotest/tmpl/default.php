<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/ui-lightness/jquery-ui-1.8.16.custom.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');
$document->addScript('components/com_clonard/js/jquery-ui-1.8.16.custom.min.js');
$document->addScript('components/com_clonard/js/clonard2.js');


$errors = array();

$session = JFactory::getSession(); 

if ($session->has('errors')) $errors = $session->get('errors');

$children = $session->get('children');
$currentChild = $children[$session->get('current')]; 

$total = $session->get('total');
if(!$total) $total = 0;
echo '<script type="text/javascript">var CART={}; CART.total='. $total .';</script>'
?>

<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active prior"><a class="cl-menu" href="index.php?option=com_clonard&view=stepone">1. Parent / Guardian</a></li>
    <li class="active">2. Details of Child</li>
	<li class="inactive">3. Select Books</li>
	<li class="inactive last"><a class="cl-menu" href="index.php?option=com_clonard&view=final">4. Order Now</a></li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo $total; ?></span><span></div>
<!--
<div id="logoff"><img src="components/com_clonard/images/lock.png" style="height:20px; margin-right: 5px; vertical-align: middle"/><a href="index.php?option=com_content&view=article&id=15&Itemid=30">Logout</a></div> -->

<div class="clear"></div>
<!-- Our form -->
 <form id="contactForm" name="steptwo" method="POST" action="index.php?option=com_clonard&view=steptwo<?php if($_GET['id']) echo "&id=".$_GET['id']; if($_GET['student']) echo "&student=".$_GET['student'];?>">
 
    <fieldset>
	  <legend>Details of Child</legend>
	  
	  <p class="f-error<?php if (count($errors) > 0) echo ' showp'; else echo ' hidep' ?>"> <strong>Please correct fields highlighted with red borders. </strong></p>
	  <h2>Students Details</h2>
	  
	  <p class="feilds">
	    <input type="hidden" name="import" value="1" />
        <input type="hidden" name="step_completed" value="two" />
	    <label for="name">First Name:<span class="req">*</span></label>
		<input type="text" id="name" name="name" class="<?php if(isset($errors['name'])) echo 'txt error'; else echo 'txt'; ?>" size="22" value="<?php echo $currentChild['name']; ?>" />
	  </p>
	  
	  <p class="feilds">
	    <input type="hidden" name="import" value="1" />
	    <label for="surname">Surname:<span class="req">*</span></label>
		<input type="text" id="surname" name="surname" class="<?php if(isset($errors['surname'])) echo 'txt error'; else echo 'txt'; ?>" size="22" value="<?php echo $currentChild['surname']; ?>" />
	  </p>
	  
	  <p class="feilds">
	    <label for="dob">Date of Birth:<span class="req">*</span></label>
		<input type="text" name="dob" id="dob" class="<?php if(isset($errors['dob'])) echo 'txt error'; else echo 'txt'; ?>" size="22" value="<?php echo $currentChild['dob']; ?>" />
	  </p>
	  
	  <p class="feilds">
	    <label for="gender">Gender:<span class="req">*</span></label>
		<select name="gender" <?php if(isset($errors['gender'])) echo 'class="error"'; ?>>
		  <option value="">Gender</option>
		  <option value="boy" <?php if($currentChild['gender'] == 'boy') echo 'selected="selected"' ; ?>>Boy</option>
		  <option value="girl" <?php if($currentChild['gender'] == 'girl') echo 'selected="selected"' ; ?>>Girl</option>
		</select>
	  </p> 
	  
	  <h2>Education Details</h2>
	  
	  <p class="feilds">
	    <label for="gradepassed">Current Grade:<span class="req">*</span></label>
		<select name="gradepassed" id="gradepassed" <?php if(isset($errors['gradepassed'])) echo 'class="error"'; ?>>
		  <option value="Grade n">Going to grade R</option>
		  <?php
              foreach ($this->cgrades as $cgrade) {
          ?>
                  <option value="<?php echo $cgrade->id; ?>" <?php if($currentChild['gradepassed'] == $cgrade->id) echo 'selected="selected"' ; ?>>
                    Grade <?php echo $cgrade->grade;  ?>
                  </option>
          <?php
              }          
          ?>              
		</select>
	  </p>	
	  
	  <p class="feilds">
	    <label for="grade">Grade Ordered:<span class="req">*</span></label>
		<select name="grade" id="grade" <?php if(isset($errors['grade'])) echo 'class="error"'; ?>>
		  <option value="">Grade</option>
		  <?php
              foreach ($this->cgrades as $cgrade) {
          ?>
                  <option value="<?php echo $cgrade->id; ?>" <?php if($currentChild['grade'] == $cgrade->id) echo 'selected="selected"' ; ?>>
                    <?php echo "$cgrade->grade - (R{$cgrade->price})";  ?>
                  </option>
          <?php
              }          
          ?> 
		</select>
	  </p>
	  <!--     Compulsory  Subjects  -->  
	  
	  <h2 class="shead one two three four">Subjects</h2>

	  <p class="feilds one">
	    <label for="Literacy">Literacy</label>
		<input name="Literacy" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds one">
	    <label for="Numeracy">Numeracy</label>
		<input name="Numeracy" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds one">
	    <label for="skills">Life Skills</label>
		<input name="skills" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds two three four">
	    <label for="english">English</label>
		<input name="english" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds two three four">
	    <label for="afrikaans">Afrikaans:</label>
		<select name="afrikaans" id="afrikaans" <?php if(isset($errors['afrikaans'])) echo 'class="error"'; ?>>
		  <option value="">Choose</option>
		  <option value="first" <?php if($currentChild['afrikaans'] == "first") echo 'selected="selected"' ; ?>>First Language</option>
		  <option value="second" <?php if($currentChild['afrikaans'] == "second") echo 'selected="selected"' ; ?>>Second Language</option>
          <option value="no" <?php if($currentChild['afrikaans'] == "no") echo 'selected="selected"' ; ?>>No Afrikaans</option>
		</select>
	  </p>
	  
	  <p class="feilds two">
	    <label for="mathematics">Mathematics</label>
		<input name="mathematics" type="text" class="yes" />
	  </p>

	  <p class="feilds two">
	    <label for="naturalsciences">Science/Biology</label>
		<input name="naturalsciences" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds two">
	    <label for="geography">Geography</label>
		<input name="geography" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds two">
	    <label for="history">History</label>
		<input name="history" type="text" class="yes" />
	  </p>
	  
	  <p class="feilds four">
	    <label for="maths">Maths:<span class="req">*</span></label>
		<select name="maths" id="maths" <?php if(isset($errors['maths'])) echo 'class="error"'; ?>>
		  <option value="">Choose Type</option>
		  <option value="core" <?php if($currentChild['maths'] == "core") echo 'selected="selected"' ; ?>>Maths Core</option>
		  <option value="advanced" <?php if($currentChild['maths'] == "advancedd") echo 'selected="selected"' ; ?>>Maths Advanced</option>
		</select>
	  </p>	

	  <p class="feilds three">
	    <label for="naturalsciences">Physical Science</label>
		<input type="text" class="yes" />
	  </p>

	  <p class="feilds three">
	    <label for="Biology">Biology</label>
		<input type="text" class="yes" />
	  </p>	

	  <p class="feilds three">
	    <label for="Geography">Geography</label>
		<input type="text" class="yes" />
	  </p>	  
	  
	  <p class="feilds four">
	    <label for="nsciences">Natural Science</label>
		<input type="text" class="yes" />
	  </p>
	  
	  <p class="feilds four">
	    <label for="ecoman"><span style="color:black">*</span> E &amp; M Sciences</label>
		<input type="text" class="yes" />
	  </p>
	  	  
	  <!--     Compulsory Non-Exam Subjects  --> 

	  <h2 class="shead two three four">Non Exam Subjects</h2>	

	  <p class="feilds two three">
	    <label for="lifeorientation">Life Orientation</label>
		<input type="text" class="yes" />
	  </p>
	  
	  <p class="feilds two">
	    <label for="technology">Technology</label>
		<input type="text" class="yes" />
	  </p>
	  
	  <p class="feilds three">
	    <label for="aandc">Arts &amp; Culture</label>
		<input type="text" class="yes" />
	  </p>
	  	
	  <p class="feilds three">
	    <label for="Technology">Technology</label>
		<input type="text" class="yes" />
	  </p>
	  
	  <p class="feilds three">
	    <label for="econ"><span style="color:black">*</span> E &amp; M Sciences</label>
		<input type="text" class="yes" />
	  </p>

	  <p class="feilds four">
	    <label for="socsci">Social Sciences</label>
		<input type="text" class="yes" />
	  </p>
	  
	  <p class="feilds four">
	    <label for="Tech">Technology</label>
		<input type="text" class="yes" />
	  </p>
	  
	  <p class="feilds four">
	    <label for="Tech">Technology</label>
		<input type="text" class="yes" />
	  </p>
	  
	  
	  <p class="feilds four">
	    <label for="artsc">Arts &amp; Culture</label>
		<input type="text" class="yes" />
	  </p>

	  <!--     Choice Subject  --> 

	  <h2 class="shead four">Choice Subject</h2>	
	  
	  <p class="feilds four">
	    <label for="choice">Choice Subject:<span class="req">*</span></label>
		<select name="choice" id="subject" <?php if(isset($errors['choice'])) echo 'class="error"'; ?>>
		  <option value="">Choose Subject</option>
		  <option value="Geography" <?php if($currentChild['choice'] == 'Geography') echo 'selected="selected"' ; ?>>Geography</option>
		  <option value="History" <?php if($currentChild['choice'] == 'History') echo 'selected="selected"' ; ?>>History</option>
		  <option value="Accounting" <?php if($currentChild['choice'] == 'Accounting') echo 'selected="selected"' ; ?>>Accounting</option>
		  <option value="Home Economics" <?php if($currentChild['choice'] == 'Home Economics') echo 'selected="selected"' ; ?>>Home Economics</option>
		  <option value="Agriculture" <?php if($currentChild['choice'] == 'Agriculture') echo 'selected="selected"' ; ?>>Agriculture</option>
		  <option value="Physical Science" <?php if($currentChild['choice'] == 'Physical Science') echo 'selected="selected"' ; ?>>Physical Science</option>
		</select>
	  </p>
	  
	  <p style="margin-left: 90px;" class="one two three four"><i>All subjects are compulsory</i></p>
	  
	  <p class="three four" style="margin-left: 90px;"><span style="color:black">*</span> Economics &amp; Management Sciences</p>
      
     <p> &nbsp; </p>	  
	   
	  <p>
	       <button class="button white" type="button" onclick="location.href='?option=com_clonard&view=stepone'; return false"><< Back</button>	   
		   <button type="submit" value="submit" class="button blue"  id="submit">Select Books >></button>
	  </p>
	  <div class="clear"></div>
	</fieldset>
 </form>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
 </div>