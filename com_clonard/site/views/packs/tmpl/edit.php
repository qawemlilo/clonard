<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();

$document->addStyleSheet('components/com_clonard/css/bootstrap.min.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');

$gradedd = '<select name="gradeid" id="gradeid">';

?>

<div class="row">
  <div class="subnav">
  <ul class="nav nav-pills" style="padding-left:20px;  margin-bottom: 10px;">
    <li>
      <a href="index.php?option=com_clonard&view=admin"><i class="icon-home"></i> Orders </a>
    </li>
    <li><a href="index.php?option=com_clonard&view=refunds"><i class="icon-book"></i> Refunds </a></li>
    <li class="active"><a href="index.php?option=com_clonard&view=packs"><i class="icon-briefcase"></i> Packs </a></li>
  </ul>
  </div>
</div>
<div class="row-fluid">
  <div class="span3">
    <ul class="nav nav-tabs nav-stacked" style="padding-left: 0px;">
      <li  class="active">
        <a href="#"><?php echo $this->pack->academic_year; ?><i style="margin-left:110px" class="icon-chevron-right"></i></a> 
      </li>
    </ul>
  </div>
  
  <div class="span9" style="padding-top:10px">
    <form class="well" name="refund-edit" method="post" action="index.php?option=com_clonard&view=packs">
      <label for="grade"><strong>Grade</strong></label>
      <select id="grade" name="grade">
        <option value="0" <?php if($this->pack->grade == '0') echo 'selected="selected"'; ?>>Grade R</option>
        <option value="1" <?php if($this->pack->grade == '1') echo 'selected="selected"'; ?>>Grade 1</option>
        <option value="2" <?php if($this->pack->grade == '2') echo 'selected="selected"'; ?>>Grade 2</option>
        <option value="3" <?php if($this->pack->grade == '3') echo 'selected="selected"'; ?>>Grade 3</option>
        <option value="4" <?php if($this->pack->grade == '4') echo 'selected="selected"'; ?>>Grade 4</option>
        <option value="5" <?php if($this->pack->grade == '5') echo 'selected="selected"'; ?>>Grade 5</option>
        <option value="6" <?php if($this->pack->grade == '6') echo 'selected="selected"'; ?>>Grade 6</option>
        <option value="7" <?php if($this->pack->grade == '7') echo 'selected="selected"'; ?>>Grade 7</option>
        <option value="8" <?php if($this->pack->grade == '8') echo 'selected="selected"'; ?>>Grade 8</option>
        <option value="9" <?php if($this->pack->grade == '9') echo 'selected="selected"'; ?>>Grade 9</option>
      </select>
      
      <label for="academic_year"><strong>Year</strong></label>
      <input type="text" class="input-xxlarge" value="<?php echo $this->pack->academic_year; ?>" name="academic_year" id="academic_year">
      
      <label for="price" class="control-label"><strong>Price</strong></label>
      <input type="text" class="input-xxlarge" value="<?php echo $this->pack->price; ?>" name="price" id="price">
      
      <input type="hidden" name="task" value="edit_pack">
      <input type="hidden" name="import" value="1">
      <input type="hidden" name="id" value="<?php echo $this->pack->id; ?>">      
      <label></label>
      <button type="submit" class="btn btn-large btn-success" style="color: #fff"> <i class="icon-ok icon-white"></i> Save </button>
      <a href="index.php?option=com_clonard&view=packs" class="btn btn-large"> <i class="icon-remove"></i> Cancel </a>
    </form>
  </div>
</div>