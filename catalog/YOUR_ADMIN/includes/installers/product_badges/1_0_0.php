<?php
/**
 * @package functions
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: bislewl 6/9/2015
 */

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
    $admin_page = 'configProductBadges';
  // delete configuration menu
  $db->Execute("DELETE FROM ".TABLE_ADMIN_PAGES." WHERE page_key = '".$admin_page."' LIMIT 1;");
  // add configuration menu
  if (!zen_page_key_exists($admin_page)) {
    if ((int)$configuration_group_id > 0) {
      zen_register_admin_page($admin_page,
                              'BOX_PRODUCT_BADGES', 
                              'FILENAME_CONFIGURATION',
                              'gID=' . $configuration_group_id, 
                              'configuration', 
                              'Y',
                              $configuration_group_id);
        
      $messageStack->add('Enabled Product Badges Configuration Menu.', 'success');
    }
  }
}
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_ENABLED', 'Enable Product Badge Module', 'true', 'Enable the product badges module?', 'zen_cfg_select_option(array(\'true\', \'false\'),');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_SORT_NEW', 'Importance of New Status', '1', 'How important is the new status. (lowest number is the most important, and 0 is disable)', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_SORT_FEATURED', 'Importance of Featured Status', '1', 'How important is the featured status. (lowest number is the most important, and 0 is disable)', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_SORT_SPECIAL', 'Importance of Special Status', '1', 'How important is the special status. (lowest number is the most important, and 0 is disable)', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_SORT_SALE', 'Importance of Sale Status', '1', 'How important is the sale status. (lowest number is the most important, and 0 is disable)', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_DIRECTORY', 'Image Source', 'tempalte', 'Where should the images for this module come from?<br/>includes/templates/YOUR_TEMPLATE/images - template<br/>or<br/>images/ - images', 'zen_cfg_select_option(array(\'template\', \'images\'),');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_NEW_FILE', 'New Badge Filename', 'new_badge.gif', 'What file should be used for the new badge? it is recommended that the background be transparent', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_FEATURED_FILE', 'Featured Badge Filename', 'featured_badge.gif', 'What file should be used for the featured badge? it is recommended that the background be transparent', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_SPECIAL_FILE', 'Special Badge Filename', 'special_badge.gif', 'What file should be used for the special badge? it is recommended that the background be transparent', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_SALE_FILE', 'Sale Badge Filename', 'sale_badge.gif', 'What file should be used for the sale badge? it is recommended that the background be transparent', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_WIDTH', 'Badge Image Width', '50', 'What should be defined as the width of the badge?', '');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int) $configuration_group_id . ", 'PRODUCT_BADGES_IMAGE_HEIGHT', 'Badge Image Height', '50', 'What should be defined as the height of the badge?', '');");
