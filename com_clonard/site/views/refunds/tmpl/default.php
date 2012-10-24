<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();

$document->addStyleSheet('components/com_clonard/css/bootstrap.min.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');
?>

<div class="row">
  <ul class="nav nav-pills" style="padding-left:20px;  margin-bottom: 10px;">
    <li>
      <a href="index.php?option=com_clonard&view=admin"><i class="icon-home"></i> Orders </a>
    </li>
    <li class="active"><a href="index.php?option=com_clonard&view=refunds"><i class="icon-book"></i> Refunds </a></li>
    <li><a href="#"><i class="icon-briefcase"></i> Packs </a></li>
  </ul>
</div>
<div class="row-fluid">
  <div class="span3">
    <ul class="nav nav-tabs nav-stacked" style="padding-left: 0px;">
        <?php 
            foreach($this->grades as $grade) {
                if($this->currentpage == $grade->id) {
                  $li = '<li  class="active"><a href="index.php?option=com_clonard&view=refunds&grade=' . $grade->id . '">Grade ' . $grade->grade . ' <i style="margin-left:110px" class="icon-chevron-right"></i></a> </li>';
                }
                else {
                  $li = '<li><a href="index.php?option=com_clonard&view=refunds&grade=' . $grade->id . '">Grade ' . $grade->grade . ' <i style="margin-left:110px" class="icon-chevron-right"></i></a> </li>';
                }  
                echo $li;               
            }
        ?>
    </ul>
  </div>
  
  <div class="span9">
  </div>
</div>