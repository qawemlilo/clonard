<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();

$document->addStyleSheet('components/com_clonard/css/bootstrap.min.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');

function moneyFt($num) {
    return 'R' . money_format("%(#10n", $num);
}
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
    <div style="text-align: right; margin-bottom: 10px;">
      <a href="index.php?option=com_clonard&view=packs&layout=new" class="btn btn-large btn-success" style="color: #fff"> <i class="icon-plus-sign icon-white"></i> New Pack </a>
    </div>
    
    <div>
      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th colspan="2">Package</th>
            <th colspan="2">Price</th>
            <th style="width:200px;">Actions</th>
          </tr>
          <tr>
            <th>Grade</th>
            <th>Academic Year</th>
            <th>Option A (5% discount )</th>
            <th>Option B (No discount)</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php 
          if(is_array($this->packs) && count($this->packs) > 0) :
            foreach($this->packs as $pack) {
        ?>
            <tr>
              <td>
                Grade <?php if($pack->grade) echo $pack->grade; else echo 'R'; ?>
              </td>
              <td>
                 <?php echo $pack->academic_year; ?>
              </td>
              <td>
                <?php echo moneyFt(ceil($pack->price * (0.95))); ?>
              </td>
              <td>
                <?php echo moneyFt($pack->price); ?>
              </td>
              <td>
                <a href="index.php?option=com_clonard&view=packs&layout=edit&id=<?php echo $pack->id; ?>" class="btn"> <i class="icon-edit"></i> Edit </a>
                &nbsp;
                <a href="index.php?option=com_clonard&view=packs&task=remove_pack&id=<?php echo $pack->id; ?>" style="color: #fff" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete that Pack?');"> <i class="icon-remove icon-white"></i> Delete </a>
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
