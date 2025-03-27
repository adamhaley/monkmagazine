<?php
/**
 * Monk-theme Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package monk-theme
 */

function monketheme_support(){
	add_theme_support('title-tag');
}

// add_action('wp_head', 'header_code');

function header_code() {
	echo '<!-- Global site tag (gtag.js) - Google Analytics --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-NN2K5L"></script> <script>  window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag(\'js\', new Date()); gtag(\'config\', \'G-NN2K5L\');</script>';
}


add_action('after_setup_theme', 'monketheme_support');
function monktheme_register_styles(){
	$version = wp_get_theme()->get('Version');

	wp_enqueue_style('monktheme-googlefonts', "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap", [], '1.0', 'all');
	wp_enqueue_style('monktheme-reset', get_stylesheet_directory_uri() . '/reset.css', [], $version, 'all');
	if(is_front_page()) {
		wp_enqueue_style('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css", [], '4.5.2', 'all');
		wp_enqueue_style('monktheme-style',
			get_stylesheet_directory_uri() . '/style.css',
			[],
			$version
		);
	}else {
		wp_enqueue_style('shop-style',
			get_stylesheet_directory_uri() . '/shop.css',
			[],
			$version
		);
	}
}

function monktheme_register_scripts(){
	$version = wp_get_theme()->get('Version');
	wp_enqueue_script('monktheme-jquery', "https://code.jquery.com/jquery-3.6.0.min.js", [], '3.6.0', true);
	wp_enqueue_script('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js", [], '4.5.2', true);
	wp_enqueue_script('monktheme-main', get_stylesheet_directory_uri() . "/assets/bundle.js", [], $version, true);
	if(is_front_page()){
		wp_enqueue_script('monktheme-home', get_stylesheet_directory_uri() . "/assets/home.js", [], $version, true);
	}


	wp_dequeue_script('wc-checkout');
	wp_enqueue_script('wc-checkout', WC()->plugin_url() . '/assets/js/frontend/checkout.min.js', array('jquery'), WC_VERSION, ['strategy' => 'defer']);

}


function smartwp_remove_wp_block_library_css(){
	if(is_front_page()) {
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
	}
}

/**woocommerce pages */
function add_open_container_div() {
	echo '<div class="container">';
}

function add_close_container_div() {
	echo '</div>';
}

function add_header() {
	get_header();
}

function add_footer() {
	get_footer();
}

function add_woo_support()
{
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
}

function serve_protected_pdf() {
    if (!isset($_GET['pdf_id']) || !is_user_logged_in()) {
        wp_die('Unauthorized access', '403 Forbidden', array('response' => 403));
    }

    $pdf_id = $_GET['pdf_id'];
    $user_id = get_current_user_id();
    $parent_product_id = $_GET['product_id']; // Replace with your WooCommerce product ID
    $digital_variation_id = $_GET['digital_variation_id'];

    if (!user_bought_digital_version($user_id, $parent_product_id, $digital_variation_id)) {
        wp_die('You do not have permission to access this file.', '403 Forbidden', array('response' => 403));
    }

    $pdf_path = ABSPATH . "/private_pdfs/{$pdf_id}.pdf"; // Adjust path

    if (file_exists($pdf_path)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_path) . '"');
        readfile($pdf_path);
        exit;
    } else {
        wp_die('File not found.', '404 Not Found', array('response' => 404));
    }
}
add_action('init', function() {
    if (strpos($_SERVER['REQUEST_URI'], '/pdf-serve/') !== false) {
        serve_protected_pdf();
    }
});

function user_bought_digital_version($user_id, $parent_product_id, $digital_variation_id) {
	return true;
	//return false;
    $customer_orders = wc_get_orders([
        'customer_id' => $user_id,
        'status'      => ['completed', 'processing'], // Only count completed/processing orders
        'limit'       => -1, // Get all orders
    ]);

    foreach ($customer_orders as $order) {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            if ($product) {
                $product_id = $product->get_id();
                $parent_id = $product->get_parent_id(); // For variations

                // Check if it's the specific digital variation
                if ($product_id == $digital_variation_id) {
                    return true;
                }

                // If checking within a variable product, ensure it's a child of the parent product
                if ($parent_id == $parent_product_id && $product_id == $digital_variation_id) {
                    return true;
                }
            }
        }
    }
    return false;
}

function secure_pdf_flipbook() {
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to access this content. <a href="' . esc_url(wp_login_url()) . '">Login</a></p>';
    }

    if (isset($_GET['pdf_id']) && isset($_GET['product_id']) && isset($_GET['digital_variation_id'])) {
        $pdf_id = $_GET['pdf_id'];
        $user_id = get_current_user_id();
        $parent_product_id = $_GET['product_id']; // Replace with your WooCommerce product ID
        $digital_variation_id = $_GET['digital_variation_id'];

	if (!user_bought_digital_version( $user_id, $parent_product_id, $digital_variation_id )) {
            return '<p>You need to purchase access to view this PDF. <a href="' . esc_url(get_permalink($parent_product_id)) . '">Buy Now</a></p>';
        }

        // Secure PDF path
        $pdf_path = ABSPATH . "private_pdfs/{$pdf_id}.pdf"; // Adjust storage location
	//echo $pdf_path;

        if (file_exists($pdf_path)) {
            $pdf_viewer_url = esc_url(site_url('/pdf-serve/?pdf_id=' . $pdf_id . '&product_id=' . $parent_product_id . '&digital_variation_id=' . $digital_variation_id));
	  
	    echo $pdf_viewer_url;
        	// DearFlip Shortcode Implementatio
	    //
	    //// Return the dFlip shortcode

	    return do_shortcode('[dflip id="599" source="' . esc_url($pdf_viewer_url) . '" width="100%" height="800px"]');
	
        } else {
            return '<p>Invalid PDF ID or file not found.</p>';
        }
    } else {
        return '<p>No PDF specified.</p>';
    }
}

add_shortcode('pdf_flipbook', 'secure_pdf_flipbook');

function display_digital_version_link() {
    global $product;

    // Check if the user is logged in
    if (!is_user_logged_in()) {
        return;
    }

    $user_id = get_current_user_id();

    // Get the parent product ID
    $parent_product_id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();

    // Assuming you know how to identify the digital variation, you can retrieve it like this:
    // You can replace this logic with your specific approach to get the digital version ID
    $digital_product_id = get_digital_product_variation_id($parent_product_id);

    // Check if the user has purchased the digital version of this product
    if (user_bought_digital_version( $user_id, $parent_product_id, $digital_product_id )) {
        // Generate the URL to the secure PDF viewer
        $pdf_viewer_url = home_url('/monk-magazine-reader/?pdf_id=1&product_id=' . $product->get_id() . '&digital_variation_id=' . $digital_product_id);

        // Display the message with the link to the digital version (PDF viewer)
        echo '<p>You have purchased the digital version of this product. <a href="' . esc_url($pdf_viewer_url) . '" target="_blank">Click here to access it.</a></p>';
    }
}

// Example function to retrieve the digital variation ID for a product (you may need to adjust this)
function get_digital_product_variation_id($parent_product_id) {
    // Here you can implement a way to fetch the digital product variation ID based on the parent product ID
    // For example, if digital variations have a specific attribute or SKU:
    $variations = get_posts([
        'post_type' => 'product_variation',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => '_parent',
                'value' => $parent_product_id,
            ],
        ],
    ]);

    foreach ($variations as $variation) {
        // Check for a specific condition, for example, checking the SKU, attribute, or custom field for the digital version
        if (has_term('digital', 'product_cat', $variation->ID)) {
            return $variation->ID;
        }
    }

    return false; // Return false if no digital variation is found
}

add_action('woocommerce_before_single_product_summary', 'display_digital_version_link', 20);

function add_digital_version_link_to_email( $order, $sent_to_admin, $plain_text, $email ) {
    // Loop through each item in the order
    foreach ( $order->get_items() as $item_id => $item ) {
        $product = $item->get_product();
        
        // Assuming you know how to identify the digital product, for example by SKU or variation ID
        $parent_product_id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();
        $digital_product_id = get_digital_product_variation_id($parent_product_id);

        // If the purchased product is a digital variation, add the link to the email
        if ( user_bought_digital_variation( get_current_user_id(), $digital_product_id ) ) {
            // Generate the URL to the secure PDF viewer
            $pdf_viewer_url = home_url('/secure-pdf-viewer/?pdf_id=' . $product->get_id());

            // Add the link to the email body
            if ( $plain_text ) {
                $message = "You have purchased the digital version of this product. Access it here: " . $pdf_viewer_url;
            } else {
                $message = '<p>You have purchased the digital version of this product. <a href="' . esc_url($pdf_viewer_url) . '" target="_blank">Click here to access it.</a></p>';
            }

            // Append the message to the email content
            echo $message;
        }
    }
}

// Hook into WooCommerce email content
add_action( 'woocommerce_email_order_details', 'add_digital_version_link_to_email', 10, 4 );


remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 10 );
add_filter('woocommerce_product_description_heading', '__return_null' );
add_filter('use_block_editor_for_post', '__return_false');
add_action('after_setup_theme', 'add_woo_support');
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 10);
add_action('wp_enqueue_scripts', 'monktheme_register_styles');
add_action('wp_enqueue_scripts', 'monktheme_register_scripts');
add_action('woocommerce_before_main_content','add_header', 5);
add_action('woocommerce_before_main_content','add_open_container_div', 7);
add_action('woocommerce_after_main_content','add_close_container_div', 150);
add_action('woocommerce_after_main_content','add_footer', 160);
// add_action('woocommerce_before_checkout_form','add_header', 1);
add_action('woocommerce_before_checkout_form','add_open_container_div', 7);
add_action('woocommerce_after_checkout_form','add_close_container_div', 170);
add_action('woocommerce_after_checkout_form','add_footer', 100);
add_action('woocommerce_before_cart','add_header', 5);
add_action('woocommerce_before_cart','add_open_container_div', 12);
add_action('woocommerce_after_cart','add_close_container_div', 200);
add_action('woocommerce_after_cart','add_footer', 215);
add_action('woocommerce_before_thankyou','add_header',5);
add_action('woocommerce_after_thankyou','add_footer',150);
add_action('woocommerce_cart_is_empty', 'add_header_to_page', 2);
add_action('woocommerce_cart_is_empty', 'get_footer', 1000);
add_filter('woocommerce_checkout_get_value','__return_empty_string',10);
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
add_filter( 'aioseo_thumbnail_size', function( $imageSize ) {
    return [ 612, 700 ];
} );


function add_favicon_to_head() {
    $favicon_url = 'https://monkmagazine.com/M-icon.png';
    echo '<link rel="icon" href="' . esc_url($favicon_url) . '" type="image/x-icon" />';
}
add_action('wp_head', 'add_favicon_to_head');


//add header before page content
add_action('the_content', 'add_header_to_page', 1);
function add_header_to_page($content) {
	if(is_page()) {
		add_header();
		add_open_container_div();
	}
	return $content;
}

//add footer after page content
add_action('the_content', 'add_footer_to_page', 300);
function add_footer_to_page($content) {
	ob_start();
	if(is_page()) {
		add_close_container_div() . add_footer();
	}
	$footer = ob_get_clean();
	return $content . $footer;
}


remove_action( 'wp_footer', 'the_block_template_skip_link' );

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

function custom_woocommerce_gallery_thumbnail_size($size) {
    // Adjust the gallery image size
    $size = array(
        'width' => 9999, // Set a large width
        'height' => 9999, // Set a large height
        'crop' => false, // Disable cropping
    );
    return $size;
}
add_filter('woocommerce_get_image_size_gallery_thumbnail', 'custom_woocommerce_gallery_thumbnail_size');


// Add custom content before the Thank You page
function woosuite_custom_before_thankyou_content() {
	echo '<h2 class="we-got-it">We Got It!  You are AWESOME and soon to be Monked!  Your Rare Copy of Monk Magazine is on its way!  Thank you for joining the journey.
<em>- The Monks</em></h2><br /><br /><br />';
}
add_action('woocommerce_before_thankyou', 'woosuite_custom_before_thankyou_content');


add_action('woocommerce_thankyou', function(){?>

<div class="footer">
	<img src=" <?php echo esc_url( get_stylesheet_directory_uri() .  '/assets/images/connect.png' ); ?>" alt="Footer" class="connect" />

	<br />
	<div class="social-links">
		<!-- inline SVG gloriousness -->
		<!--facebook-->
		<svg class="facebook" width="20px" height="20px" viewBox="0 0 20 20" aria-hidden="true">
			<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"></path>
		</svg>
		<svg class="twitter" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="20px" height="20px"><path d="M 6.9199219 6 L 21.136719 26.726562 L 6.2285156 44 L 9.40625 44 L 22.544922 28.777344 L 32.986328 44 L 43 44 L 28.123047 22.3125 L 42.203125 6 L 39.027344 6 L 26.716797 20.261719 L 16.933594 6 L 6.9199219 6 z"/></svg>
		<!--ig svg -->
		<svg class="ig" width="20" height="20" viewBox="0 0 20 20" aria-hidden="true">
			<circle cx="10" cy="10" r="3.3"></circle>
			<path d="M14.2,0H5.8C2.6,0,0,2.6,0,5.8v8.3C0,17.4,2.6,20,5.8,20h8.3c3.2,0,5.8-2.6,5.8-5.8V5.8C20,2.6,17.4,0,14.2,0zM10,15c-2.8,0-5-2.2-5-5s2.2-5,5-5s5,2.2,5,5S12.8,15,10,15z M15.8,5C15.4,5,15,4.6,15,4.2s0.4-0.8,0.8-0.8s0.8,0.4,0.8,0.8S16.3,5,15.8,5z"></path>
		</svg>
		<!--email svg -->
		<svg class="email" width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M10,10.1L0,4.7C0.1,3.2,1.4,2,3,2h14c1.6,0,2.9,1.2,3,2.8L10,10.1z M10,11.8c-0.1,0-0.2,0-0.4-0.1L0,6.4V15c0,1.7,1.3,3,3,3h4.9h4.3H17c1.7,0,3-1.3,3-3V6.4l-9.6,5.2C10.2,11.7,10.1,11.7,10,11.8z"></path></svg>
		<!-- linked in svg -->
		<svg class="linkedin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
	</div>
	<div class="copyright"> &copy;2023 Monk Magazine | <a href="/press/">Press</a></div>
</div>

<!--NAV MENU-->
<ul class="nav-menu">
	<li><a href="#read-this">Read This</a></li>
	<li><a href="#buy">Buy</a></li>
	<li><a href="#on-the-road">On The Road</a></li>
	<li><a href="index.php/cart/">Shopping Cart</a></li>
	<div class="social-links">
		<!-- inline SVG gloriousness -->
		<!--facebook-->
		<svg class="facebook" width="20px" height="20px" viewBox="0 0 20 20" aria-hidden="true">
			<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"></path>
		</svg>
		<svg xmlns="http://www.w3.org/2000/svg" class="twitter" viewBox="0 0 50 50" width="25px" height="25px"><path d="M 6.9199219 6 L 21.136719 26.726562 L 6.2285156 44 L 9.40625 44 L 22.544922 28.777344 L 32.986328 44 L 43 44 L 28.123047 22.3125 L 42.203125 6 L 39.027344 6 L 26.716797 20.261719 L 16.933594 6 L 6.9199219 6 z"/></svg>
		<!--ig svg -->
		<svg class="ig" width="20" height="20" viewBox="0 0 20 20" aria-hidden="true">
			<circle cx="10" cy="10" r="3.3"></circle>
			<path d="M14.2,0H5.8C2.6,0,0,2.6,0,5.8v8.3C0,17.4,2.6,20,5.8,20h8.3c3.2,0,5.8-2.6,5.8-5.8V5.8C20,2.6,17.4,0,14.2,0zM10,15c-2.8,0-5-2.2-5-5s2.2-5,5-5s5,2.2,5,5S12.8,15,10,15z M15.8,5C15.4,5,15,4.6,15,4.2s0.4-0.8,0.8-0.8s0.8,0.4,0.8,0.8S16.3,5,15.8,5z"></path>
		</svg>
		<!--email svg -->
		<svg class="email" width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M10,10.1L0,4.7C0.1,3.2,1.4,2,3,2h14c1.6,0,2.9,1.2,3,2.8L10,10.1z M10,11.8c-0.1,0-0.2,0-0.4-0.1L0,6.4V15c0,1.7,1.3,3,3,3h4.9h4.3H17c1.7,0,3-1.3,3-3V6.4l-9.6,5.2C10.2,11.7,10.1,11.7,10,11.8z"></path></svg>
		<!-- linked in svg -->
		<svg class="linkedin" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
	</div>
</ul>
<div class="back-to-top-link">
	<a href="#">
		<svg  width="15" height="15" viewBox="0 0 20 20"><path d="M10,0L9.4,0.6L0.8,9.1l1.2,1.2l7.1-7.1V20h1.7V3.3l7.1,7.1l1.2-1.2l-8.5-8.5L10,0z"></path></svg>
	</a>
</div>
<!--END NAV MENU-->
<?php wp_footer() ?>

<?php }, 10, 1);
