<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

use ClicShopping\OM\CLICSHOPPING;
?>
<div class="col-md-<?php echo $content_width; ?>">
  <div class="separator"></div>
  <span><?php echo  CLICSHOPPING::getDef('module_header_select_template_text'); ?></span>
<?php echo $form; ?>
    <span class="text-md-center"><?php echo $header_template; ?></span>
<?php
  echo $endform;
?>
</div>

