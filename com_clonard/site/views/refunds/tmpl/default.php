<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();

$document->addStyleSheet('components/com_clonard/css/bootstrap.min.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');
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
    <div style="text-align: right; margin-bottom: 10px;">
      <a href="index.php?option=com_clonard&view=refunds&grade=<?php echo $this->gradeid; ?>&layout=new" class="btn btn-large btn-success" style="color: #fff"> <i class="icon-plus-sign icon-white"></i> New Item </a>
    </div>
    
    <div>
      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th colspan="2">Refundable Items</th>
            <th style="width:200px;">Actions</th>
          </tr>
          <tr>
            <th>Title</th>
            <th>Credit</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php 
          if(is_array($this->refundables) && count($this->refundables) > 0) :
            foreach($this->refundables as $refundable) {
        ?>
            <tr>
              <td>
                <?php echo $refundable->title; ?>
              </td>
              <td>
                R<?php echo $refundable->price; ?> .00
              </td>
              <td>
                <a href="index.php?option=com_clonard&view=refunds&grade=<?php echo $this->gradeid; ?>&layout=edit&id=<?php echo $refundable->id; ?>" class="btn"> <i class="icon-edit"></i> Edit </a>
                <a href="index.php?option=com_clonard&view=refunds&grade=<?php echo $this->gradeid; ?>&task=remove&id=<?php echo $refundable->id; ?>" style="color: #fff" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete that item?');"> <i class="icon-remove icon-white"></i> Delete </a>
              </td>
            </tr>
        <?php                
            }
          endif;
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>