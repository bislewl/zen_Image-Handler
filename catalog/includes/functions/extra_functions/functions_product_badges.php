<?php

/**
 * @package functions
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: $
 */
define('PRODUCT_BADGES_ENABLED', 'true');
define('PRODUCT_BADGES_SORT_NEW', '1');
define('PRODUCT_BADGES_SORT_FEATURED', '2');
define('PRODUCT_BADGES_SORT_SPECIAL', '3');
define('PRODUCT_BADGES_SORT_SALE', '4');
define('PRODUCT_BADGES_IMAGE_DIRECTORY', 'template'); // template or images
define('PRODUCT_BADGES_IMAGE_NEW_FILE', 'new_badge.gif');
define('PRODUCT_BADGES_IMAGE_FEATURED_FILE', 'featured_badge.gif');
define('PRODUCT_BADGES_IMAGE_SPECIAL_FILE', 'special_badge.gif');
define('PRODUCT_BADGES_IMAGE_SALE_FILE', 'sale_badge.gif');
define('PRODUCT_BADGES_IMAGE_WIDTH', '50');
define('PRODUCT_BADGES_IMAGE_HEIGHT', '50');

function get_product_badge($products_id) {
    global $db, $template, $current_page_base;
    if (PRODUCT_BADGES_ENABLED != 'true') {
        return '';
    }
//get sorts
    $array_of_sorts = array(
        PRODUCT_BADGES_SORT_NEW => 'new',
        PRODUCT_BADGES_SORT_FEATURED => 'featured',
        PRODUCT_BADGES_SORT_SPECIAL => 'special',
        PRODUCT_BADGES_SORT_SALE => 'sale'
    );
    ksort($array_of_sorts);
// get image names
    $array_of_images = array(
        'new' => PRODUCT_BADGES_IMAGE_NEW_FILE,
        'featured' => PRODUCT_BADGES_IMAGE_FEATURED_FILE,
        'special' => PRODUCT_BADGES_IMAGE_SPECIAL_FILE,
        'sale' => PRODUCT_BADGES_IMAGE_SALE_FILE,
    );
//set defualt vars
    $badge_active = '';
    $new_status = $featured_status = $sale_status = $special_status = false;
    $product_base_price = zen_get_products_base_price($products_id);
    if (PRODUCT_BADGES_SORT_NEW != '0') {
        $display_limit = zen_get_new_date_range();
        $new_query = $db->Execute("SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_id='" . $products_id . "' " . $display_limit);
        if ($new_query->RecordCount() > 0) {
            $new_status = true;
        }
    }
    if (PRODUCT_BADGES_SORT_FEATURED != '0') {
        $date_range = time();
        $zc_featured_date = date('Ymd', $date_range);
        $featured_query = $db->Execute("select featured_id
                       from " . TABLE_FEATURED . "
                       where status = '1'
                       and ((" . $zc_featured_date . " <= expires_date or expires_date = '0001-01-01')
                       and (" . $zc_featured_date . " > featured_date_available or featured_date_available = '0001-01-01'))
                       and products_id='" . $products_id . "'");
        if ($featured_query->RecordCount() > 0) {
            $featured_status = true;
        }
    }
    if (PRODUCT_BADGES_SORT_SPECIAL != '0') {
        $display_sale_price = zen_get_products_special_price($products_id, false);
        if ($display_sale_price != $product_base_price) {
            $sale_status = true;
        }
    }
    if (PRODUCT_BADGES_SORT_SALE != '0') {
        $display_special_price = zen_get_products_special_price($products_id, true);
        if ($display_special_price != $product_base_price) {
            $special_status = true;
        }
    }
    foreach ($array_of_sorts as $badge) {
        if ($badge_active == '') {
            switch ($badge) {
                case 'new':
                    if ($new_status == true) {
                        $badge_active = 'new';
                    }
                    break;
                case 'featured':
                    if ($featured_status == true) {
                        $badge_active = 'featured';
                    }
                    break;
                case 'special':
                    if ($special_status == true) {
                        $badge_active = 'special';
                    }
                    break;
                case 'sale':
                    if ($sale_status == true) {
                        $badge_active = 'sale';
                    }
                    break;
            }
        }
    }
    if ($badge_active != '') {
        $images_name = $array_of_images[$badge_active];
        if (PRODUCT_BADGES_IMAGE_DIRECTORY == 'template') {
            $images_url = $template->get_template_dir('/' . $images_name, DIR_WS_TEMPLATE, $current_page_base, 'images') . '/' . $images_name;
        } else {
            $images_url = DIR_WS_IMAGES . $images_name;
        }
        $image_width = str_replace("px", "", PRODUCT_BADGES_IMAGE_WIDTH);
        $image_height = str_replace("px", "", PRODUCT_BADGES_IMAGE_HEIGHT);
        $image_tag = zen_image($images_url, $badge_active, $image_width, $image_height, 'class="product-badge-' . $badge_active . '"');
        return $image_tag;
    }
    return '';
}
