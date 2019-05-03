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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class he_header_select_template {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;
    public $pages;

    public function __construct() {

      $this->code = get_class($this);
      $this->group = basename(__DIR__);
      $this->title = CLICSHOPPING::getdef('module_header_select_template_title');
      $this->description = CLICSHOPPING::getdef('module_hader_select_template_description');

      $this->title = CLICSHOPPING::getDef('module_header_select_template_title');
      $this->description = CLICSHOPPING::getDef('module_header_mailchimp_description');


      if ( defined('MODULE_HEADER_SELECT_TEMPLATE_STATUS') ) {
        $this->sort_order = MODULE_HEADER_SELECT_TEMPLATE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_SELECT_TEMPLATE_STATUS == 'True');
        $this->pages = MODULE_HEADER_SELECT_TEMPLATE_DISPLAY_PAGES;
      }
    }

    public function execute() {
      $CLICSHOPPING_Template = Registry::get('Template');

      $content_width = MODULE_HEADER_SELECT_TEMPLATE_CONTENT_WIDTH;

      $data ='<!-- header select template  start -->' . "\n";

      if (is_null($_GET['TemplateCustomerSelected']) ) {
        $header_template = $CLICSHOPPING_Template->getDropDownSelectedTemplateByCustomer();
      } else {
        $header_template = $CLICSHOPPING_Template->getDropDownSelectedTemplateByCustomer($_GET['TemplateCustomerSelected']);
      }

      $form =  HTML::form('select_template',CLICSHOPPING::getBaseNameIndex() . '?' .CLICSHOPPING::getAllGET(), 'post', null, ['session_id' => true]);
      $endform ='</form>';

      ob_start();
      require_once($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/header_select_template'));
      $data .= ob_get_clean();

      $data .='<!-- header elect template  end -->' . "\n";

      $CLICSHOPPING_Template->addBlock($data, $this->group);
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_HEADER_SELECT_TEMPLATE_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer ce module ?',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Souhaitez vous activer ce module à votre boutique ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Veuillez indiquer la largeur du contenu',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Veuillez indiquer une largeur d\'affichage',
          'configuration_group_id' => '6',
          'sort_order' => '2',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Ordre de tri d\'affichage',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_SORT_ORDER',
          'configuration_value' => '1',
          'configuration_description' => 'Ordre de tri pour l\'affichage (Le plus petit nombre est montré en premier)',
          'configuration_group_id' => '6',
          'sort_order' => '3',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );


      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Veuillez indiquer ou la boxe doit s\'afficher',
          'configuration_key' => 'MODULE_HEADER_SELECT_TEMPLATE_DISPLAY_PAGES',
          'configuration_value' => 'all',
          'configuration_description' => 'Sélectionnez les pages o&ugrave; la boxe doit être présente',
          'configuration_group_id' => '6',
          'sort_order' => '7',
          'set_function' => 'clic_cfg_set_select_pages_list',
          'date_added' => 'now()'
        ]
      );

      return $CLICSHOPPING_Db->save('configuration', ['configuration_value' => '1'],
        ['configuration_key' => 'WEBSITE_MODULE_INSTALLED']
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
