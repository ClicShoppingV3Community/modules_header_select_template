<?php
  /**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT

 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class he_header_select_template {
    public string $code;
    public string $group;
    public $title;
    public $description;
    public ?int $sort_order = 0;
    public bool $enabled = false;
    public $pages;

    public function __construct() {

      $this->code = get_class($this);
      $this->group = basename(__DIR__);
      $this->title = CLICSHOPPING::getdef('module_header_select_template_title');
      $this->description = CLICSHOPPING::getdef('module_hader_select_template_description');

      $this->title = CLICSHOPPING::getDef('module_header_select_template_title');
      $this->description = CLICSHOPPING::getDef('module_header_mailchimp_description');


      if (\defined('MODULE_HEADER_SELECT_TEMPLATE_STATUS')) {
        $this->sort_order = MODULE_HEADER_SELECT_TEMPLATE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_SELECT_TEMPLATE_STATUS == 'True');
        $this->pages = MODULE_HEADER_SELECT_TEMPLATE_DISPLAY_PAGES;
      }
    }

    public function execute() {
      $CLICSHOPPING_Template = Registry::get('Template');

      $content_width = MODULE_HEADER_SELECT_TEMPLATE_CONTENT_WIDTH;

      $data ='<!-- header select template  start -->' . "\n";

      if (!isset($_GET['TemplateCustomerSelected'])) {
        $header_template = $CLICSHOPPING_Template->getDropDownSelectedTemplateByCustomer();
      } else {
        $header_template = $CLICSHOPPING_Template->getDropDownSelectedTemplateByCustomer($_GET['TemplateCustomerSelected']);
      }

      $form = HTML::form('select_template',CLICSHOPPING::getBaseNameIndex() . '?' .CLICSHOPPING::getAllGET(), 'post', null, ['session_id' => true]);
      $endform ='</form>';

      ob_start();

      $data ='<!-- header select template  start -->' . "\n";

      require_once($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/header_select_template'));
      $data .= ob_get_clean();

      $data .='<!-- header select template  end -->' . "\n";

      $CLICSHOPPING_Template->addBlock($data, $this->group);
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return \defined('MODULE_HEADER_SELECT_TEMPLATE_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want to enable this module ?',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want to enable this module in your shop ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please indicate the width of the content',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Please specify a display width',
          'configuration_group_id' => '6',
          'sort_order' => '2',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort order',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_SORT_ORDER',
          'configuration_value' => '1',
          'configuration_description' => 'Sort order of display. Lowest is displayed first. The sort order must be different on every module',
          'configuration_group_id' => '6',
          'sort_order' => '3',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );


      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please indicate where boxing should be displayed',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_DISPLAY_PAGES',
          'configuration_value' => 'all',
          'configuration_description' => 'Sélectionnez les pages o&ugrave; la boxe doit être présente',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_select_pages_list',
          'date_added' => 'now()'
        ]
      );

    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
      return array('MODULE_HEADER_SELECT_TEMPLATE_STATUS',
        'MODULE_HEADER_SELECT_TEMPLATE_SORT_ORDER',
        'MODULE_HEADER_SELECT_TEMPLATE_DISPLAY_PAGES'
      );
    }
  }
