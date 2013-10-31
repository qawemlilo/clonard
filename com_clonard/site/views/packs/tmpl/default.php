<?php 
defined('_JEXEC') or die('Restricted access'); 

$document = &JFactory::getDocument();

$document->addStyleSheet('components/com_clonard/css/bootstrap.min.css');
$document->addStyleSheet('components/com_clonard/css/style.css');
$document->addStyleSheet('components/com_clonard/css/steps.css');
$document->addScript('components/com_clonard/js/jquery-1.6.2.min.js');

if (!function_exists('money_format')) {
function money_format($format, $number)
{
    $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
              '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
    if (setlocale(LC_MONETARY, 0) == 'C') {
        setlocale(LC_MONETARY, '');
    }
    $locale = localeconv();
    preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
    foreach ($matches as $fmatch) {
        $value = floatval($number);
        $flags = array(
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                           $match[1] : ' ',
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                           $match[0] : '+',
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
        );
        $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
        $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
        $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
        $conversion = $fmatch[5];

        $positive = true;
        if ($value < 0) {
            $positive = false;
            $value  *= -1;
        }
        $letter = $positive ? 'p' : 'n';

        $prefix = $suffix = $cprefix = $csuffix = $signal = '';

        $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
        switch (true) {
            case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                $prefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                $suffix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                $cprefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                $csuffix = $signal;
                break;
            case $flags['usesignal'] == '(':
            case $locale["{$letter}_sign_posn"] == 0:
                $prefix = '(';
                $suffix = ')';
                break;
        }
        if (!$flags['nosimbol']) {
            $currency = $cprefix .
                        ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                        $csuffix;
        } else {
            $currency = '';
        }
        $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

        $value = number_format($value, $right, $locale['mon_decimal_point'],
                 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
        $value = @explode($locale['mon_decimal_point'], $value);

        $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
        if ($left > 0 && $left > $n) {
            $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
        }
        $value = implode($locale['mon_decimal_point'], $value);
        if ($locale["{$letter}_cs_precedes"]) {
            $value = $prefix . $currency . $space . $value . $suffix;
        } else {
            $value = $prefix . $value . $space . $currency . $suffix;
        }
        if ($width > 0) {
            $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                     STR_PAD_RIGHT : STR_PAD_LEFT);
        }

        $format = str_replace($fmatch[0], $value, $format);
    }
    return $format;
}
}

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
