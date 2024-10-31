<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://loudbells.com
 * @since      1.0.0
 *
 * @package    Products_Missing_Featured_Image
 * @subpackage Products_Missing_Featured_Image/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Products_Missing_Featured_Image
 * @subpackage Products_Missing_Featured_Image/admin
 * @author     Loud Bells <hello@loudbells.com>
 */
class Products_Missing_Featured_Image_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		// Run only if products is active
		if (class_exists('woocommerce')) {
			wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/products-missing-featured-image-admin.css', array(), $this->version, 'all');
		}
	}

	public function missing_featured_images()
	{
		// Run only if products is active
		if (class_exists('woocommerce')) {
			add_management_page(
				'Missing Featured Image', // page_title
				'Missing Featured Image', // menu_title
				'manage_options', // capability
				'missing-featured-image', // menu_slug
				function () {
?>
				<div class="wrap">
					<h2>Missing Featured Image</h2>
					<table class="widefat fixed" cellspacing="0">
						<thead>
							<tr>
								<th>#</th>
								<th>Product</th>
								<th>Category</th>
								<th></th>
							</tr>
						</thead>
						<?php
						$bulk = 300;
						$offset = 0;
						$count = 1;
						$missing_count = 0;

						while (true) {
							$products = get_posts([
								'numberposts' => $bulk,
								'offset' => $offset,
								'post_type' => 'product',
								'orderby' => 'title',
								'order' => 'ASC',
								'status' => 'publish',
							]);

							$offset += $bulk;

							if (empty($products)) {
								break;
							}

							foreach ($products as $product) {
								if (!has_post_thumbnail($product->ID)) {
									$missing_count++;
									$term_list = wp_get_post_terms($product->ID, 'product_cat');
									$category = (empty($term_list[0]->name)) ? '-' : $term_list[0]->name;

									echo '<tr>';
									echo '<td>' . $count++ . '.</td>';
									echo '<td>' . $product->post_title . '</td>';
									echo '<td>' . $category . '</td>';
									echo '<td><a href="post.php?post=' . $product->ID . '&action=edit" target="_blank">Edit</a> | <a href="' . get_permalink($product->ID) . '" target="_blank">View</a></td>';
									echo '</tr>';
								}
							}
						}
						?></tbody>
					</table>
					<?php
					if ($missing_count === 0) {
					?>
						<div class="no-missing-featured-image">
							<style>
								.tools_page_missing-featured-image .wrap table {
									display: none !important
								}
							</style>
							Well done! All of your products have a featured image assigned.
						</div>
					<?php
					}
					?>
				</div>
<?php }
			);
		}
	}
}
