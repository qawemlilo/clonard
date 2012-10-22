<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
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
<div id="form-cont">

  <h2 style="margin-left:10px">Clonard Orders</h2>

  <?php echo $this->orders; ?>  
</div>