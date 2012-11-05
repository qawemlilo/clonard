<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();

$document->addStyleSheet('components/com_clonard/css/bootstrap.min.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addStyleSheet('components/com_clonard/css/ui-lightness/jquery-ui-1.8.16.custom.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');
$document->addScript('components/com_clonard/js/jquery-ui-1.8.16.custom.min.js');

?>
<script type="text/javascript">
(function($) {
  $.noConflict();
  
  $(function() {
    $("#accordion").accordion({header: "h3", autoHeight: false});
  });
})(jQuery);
</script>

<div class="row">
  <div class="subnav">
  <ul class="nav nav-pills" style="padding-left:20px;  margin-bottom: 10px;">
    <li class="active">
      <a href="index.php?option=com_clonard&view=admin"><i class="icon-home icon-white"></i> Orders </a>
    </li>
    <li><a href="index.php?option=com_clonard&view=refunds"><i class="icon-book"></i> Refunds </a></li>
    <li><a href="index.php?option=com_clonard&view=packs"><i class="icon-briefcase"></i> Packs </a></li>
  </ul>
  </div>
</div>
<div class="row" style="padding-left:20px">
  
    <div id="orders-breadcrumbs">
      <form action="index.php?option=com_clonard&view=admin" method="post" name="myform">
        <strong>Display #</strong> <?php echo $this->pagination->getLimitBox() . " &nbsp; &nbsp; <span style=\"margin-left: 200px;\"> " . $this->pagination->getPagesCounter(); ?></span>
      </form>
    </div>
  
    <?php echo $this->orders; ?>  
  
    <div style="padding: 5px; margin: 10px 0px 10px 0px;">
      <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
</div>