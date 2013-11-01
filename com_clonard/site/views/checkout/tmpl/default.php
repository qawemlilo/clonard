<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');

$session =& JFactory::getSession(); 
$total = $session->get('total');
?>

<div id="form-cont">

<div class="steps"> 
  <ul>
    <li class="active prior">3. Select Books</li>
	<li class="active prior">4. Payment Options</li>
	<li class="active prior">5. Shipping Options</li>
	<li class="active last">6. Order &amp; Pay</li>
  </ul>
</div>

<div class="clear"></div>

<div id="total"><span style="margin-left: 40px; font-size: 12px;"><strong>Total:</strong> R<span id="amount"><?php echo (!$total) ? '0' : $total; ?></span><span></div>


<div class="clear"></div>
<!-- Our form -->
 <div id="contactForm">
 
    <fieldset>
	  <legend>6. Order &amp; Pay</legend>
	  <p style="width:100%; height:10px; margin:0px; padding:0px;"> &nbsp; </p>
	  
	  
	  <?php echo $this->html; ?>  
	  
	 <?php echo $this->form; ?>
	  <div class="clear"></div>
	  <p>
	    &nbsp;
	  </p>
	</fieldset>
 </div>
 <p><img src="components/com_clonard/images/CardLogos.png" style="margin-left: 15px; margin-right: 10px; vertical-align: middle"/></p>
</div>
<script type="text/javascript">
jQuery.noConflict();

(function($) {
    var ordersIds = '<?php echo implode(",", $this->orders); ?>', active = false;
    $(function() {
        $("#payoncollection").click(function (e) {
            e.preventDefault();
            
            var pmethod = 'oncollection';
            
            if (active) {
              return false;
            }
            
            active = true;
            $('.progress').slideDown(); 
            
            send(ordersIds, pmethod, function (data) {
                location.href = 'index.php?option=com_clonard&view=collect';   
            });
            
            return false;
        });
        
        $("#paywitheft").click(function (e) {
            e.preventDefault();
            
            var pmethod = 'eft';

            if (active) {
              return false;
            }
            
            active = true;
            $('.progress').slideDown(); 
            
            send(ordersIds, pmethod, function (data) {
                location.href = 'index.php?option=com_clonard&view=eft';   
            });
            
            return false;
        });
        
        $("#paywithcard").click(function (e) {
            e.preventDefault();
            
            var pmethod = 'card';

            if (active) {
              return false;
            }
            
            active = true; 
            $('.progress').slideDown(); 
            
            send(ordersIds, pmethod, function (data) {
                $('.progress').hide();
                
                alert('You will now be taken to MonsterPay Secure website to make payment, please dont close this window');
                $('#payform').submit();            
            });
            
            return false;
        });
    });
    
    
    function send(ids, pmethod, done) {
        $.post('index.php?option=com_clonard&view=checkout&task=update', {'mymethod': pmethod, 'ids':ids})
        .done(done)
        .fail(done);
    }
})(jQuery);
</script>
