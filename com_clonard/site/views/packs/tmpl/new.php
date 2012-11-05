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
    <form class="well" method="post" action="index.php?option=com_clonard&view=packs">
      <label for="grade"><strong>Grade</strong></label>
      <select id="grade" name="grade">
        <option value="R">Grade R</option>
        <option value="1">Grade 1</option>
        <option value="2">Grade 2</option>
        <option value="3">Grade 3</option>
        <option value="4">Grade 4</option>
        <option value="5">Grade 5</option>
        <option value="6">Grade 6</option>
        <option value="7">Grade 7</option>
        <option value="8">Grade 8</option>
        <option value="9">Grade 9</option>
      </select>
      
      <label for="academic_year"><strong>Year</strong></label>
      <input type="text" class="input-xxlarge" placeholder="e.g 2013" name="academic_year" id="academic_year">
      
      <label for="price" class="control-label"><strong>Price</strong></label>
      <input type="text" class="input-xxlarge" placeholder="R"size="4" name="price" id="price">
      
      <input type="hidden" name="task" value="save_pack">
      <input type="hidden" name="import" value="1">
      <label></label>
      <button type="submit" class="btn btn-large btn-success" style="color: #fff"> <i class="icon-ok icon-white"></i> Save </button>
      <a href="index.php?option=com_clonard&view=packs" class="btn btn-large"> <i class="icon-remove"></i> Cancel </a>
    </form>
</div>