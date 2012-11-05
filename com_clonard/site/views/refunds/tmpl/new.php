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
    <li class="active"><a href="index.php?option=com_clonard&view=refunds"><i class="icon-book"></i> Refunds </a></li>
    <li><a href="index.php?option=com_clonard&view=packs"><i class="icon-briefcase"></i> Packs </a></li>
  </ul>
  </div>
</div>
<div class="row-fluid">
  <div class="span3">
    <ul class="nav nav-tabs nav-stacked" style="padding-left: 0px;">
        <?php 
            foreach($this->grades as $grade) {
                if($this->gradeid == $grade->id) {
                  $li = '<li  class="active"><a href="index.php?option=com_clonard&view=refunds&grade=' . $grade->id . '">Grade ' . $grade->grade . ' <i style="margin-left:110px" class="icon-chevron-right"></i></a> </li>';
                  $gradedd .= '<option value="'.$grade->id.'" selected="selected">Grade '.$grade->grade.'</option>';
                }
                else {
                  $li = '<li><a href="index.php?option=com_clonard&view=refunds&grade=' . $grade->id . '">Grade ' . $grade->grade . ' <i style="margin-left:110px" class="icon-chevron-right"></i></a> </li>';
                  $gradedd .= '<option value="'.$grade->id.'">Grade '.$grade->grade.'</option>';
                }  
                echo $li;               
            }
            
            $gradedd .= '</select>'
        ?>
    </ul>
  </div>
  
  <div class="span9" style="padding-top:10px">
    <form class="well" method="post" action="index.php?option=com_clonard&view=refunds">
      <label for="gradeid"><strong>Grade</strong></label>
      <?php echo $gradedd; ?>
      
      <label for="title"><strong>Title</strong></label>
      <input type="text" class="input-xxlarge" placeholder="Book or item title..." name="title" id="title">
      
      <label for="price" class="control-label"><strong>Credit</strong></label>
      <input type="text" class="input-xxlarge" placeholder="R"size="4" name="price" id="price">
      
      <input type="hidden" name="task" value="save_book">
      <input type="hidden" name="import" value="1">
      <input type="hidden" name="academic_year" value="2013">
      <label></label>
      <button type="submit" class="btn btn-large btn-success" style="color: #fff"> <i class="icon-ok icon-white"></i> Save </button>
      <a href="index.php?option=com_clonard&view=refunds&grade=<?php echo $this->gradeid; ?>" class="btn btn-large"> <i class="icon-remove"></i> Cancel </a>
    </form>
  </div>
</div>