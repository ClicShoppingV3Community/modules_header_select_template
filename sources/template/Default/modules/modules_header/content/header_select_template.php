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
  <div class="alert alert-warning text-center">Do not forget to copy the css inside your new directory and clear your cache.
  <label for="TemplateCustomerSelected"><?php echo  CLICSHOPPING::getDef('module_header_select_template_text'); ?></label>
<?php echo $form; ?>
    <span class="text-center"><?php echo $header_template; ?></span>
<?php
  echo $endform;
?>
  </div>
</div>
