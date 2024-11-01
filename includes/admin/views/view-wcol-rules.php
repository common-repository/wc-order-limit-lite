<?php
/**
 * Main file tabs of admin area
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://xfiniftysoft.com
 * @since      1.0.0
 *
 * @package    wc_order_limit_lite
 * @subpackage wc_order_limit_lite/includes/admin/views/
 */

$selected_tab = 'wcol-products-tab';
if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'setting' ) ) {
	if ( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ) {
		$selected_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
	}
}
?>
<div class="wrap wcol">
	<h3><?php esc_html_e( 'Order Limit Lite for WooCommerce', 'wc-order-limit-lite' ); ?>
		<a class="xs-pro-link" href="https://codecanyon.net/item/woocommerce-wc-vendors-order-limit/20688279" target="_blank">
			<div class="xs-button-main">
				<?php submit_button( esc_html__( 'Pro Version' ), 'secondary', 'xs-button' ); ?>
			</div>
		</a>
	</h3>
	<div class="xs-wcol-alert xs-wcol-alert-success wcol-data-save-notice">
		<button type="button" class="xs-wcol-close xs-wcol-notice-dismiss" >&times;</button>
		<strong><?php esc_html_e( 'Success!', 'wc-order-limit-lite' ); ?></strong><?php esc_html_e( 'Data Saved Successfully.', 'wc-order-limit-lite' ); ?> 
		</div>
		<!-- Main Setting tab -->	
		<nav class="nav nav-tabs wcol-nav">
			<!-- Order Limit Rules For Products Tab -->
			<a id = "wcol-products" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-products-tab', 'setting' ) ); ?>" class="nav-tab <?php echo ( 'wcol-products-tab' === $selected_tab ) ? 'nav-tab-active' : ''; ?> " ><?php esc_html_e( 'Products', 'wc-order-limit-lite' ); ?></a>
			<!-- Order Limit Rules For Categories Tab -->
			<a id = "wcol-categories" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-categories-tab', 'setting' ) ); ?>" class="nav-tab <?php echo ( 'wcol-categories-tab' === $selected_tab ) ? 'nav-tab-active' : ''; ?>"  ><?php esc_html_e( 'Categories', 'wc-order-limit-lite' ); ?></a>
			<!-- Order Limit Rules For Order Total  Tab -->				
			<a id = "wcol-order-total" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-order-total-tab', 'setting' ) ); ?>" class="nav-tab <?php echo ( 'wcol-order-total-tab' === $selected_tab ) ? 'nav-tab-active' : ''; ?>"  ><?php esc_html_e( 'Order Total', 'wc-order-limit-lite' ); ?></a>		
			<!-- Advance Tab -->				
			<a id = "wcol-advance-tab" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-settings-tab', 'setting' ) ); ?>" class="nav-tab <?php echo ( 'wcol-settings-tab' === $selected_tab ) ? 'nav-tab-active' : ''; ?>" ><?php esc_html_e( 'Advanced', 'wc-order-limit-lite' ); ?></a>
			<a id = "wcol-advance-tab" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-support-tab', 'setting' ) ); ?>" class="nav-tab <?php echo ( 'wcol-support-tab' === $selected_tab ) ? 'nav-tab-active' : ''; ?>" ><?php esc_html_e( 'Support', 'wc-order-limit-lite' ); ?></a>
		</nav>
		<?php
		$tab1 = isset( $_GET['tab1'] ) ? sanitize_text_field( wp_unslash( $_GET['tab1'] ) ) : 'report';
		if ( 'wcol-support-tab' === $selected_tab ) {
			?>
		<ul class="subsubsub xs-list">
			<li> 
				<a class="<?php echo ( 'report' === $tab1 ) ? 'current' : ''; ?>" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-support-tab&tab1=report', 'setting' ) ); ?>">
					<?php esc_html_e( 'Report a bug', 'wc-order-limit-lite' ); ?>
				</a>
				|
			</li>
			<li>
				<a class="<?php echo ( 'request' === $tab1 ) ? 'current' : ''; ?>" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-support-tab&tab1=request', 'setting' ) ); ?>">
					<?php esc_html_e( 'Request a Feature', 'wc-order-limit-lite' ); ?>
				</a>
				|
			</li>
			<li>
				<a class="<?php echo ( 'hire' === $tab1 ) ? 'current' : ''; ?>" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-support-tab&tab1=hire', 'setting' ) ); ?>" >
					<?php esc_html_e( 'Hire US', 'wc-order-limit-lite' ); ?>
				</a>
				|
			</li>
			<li>
				<a class="<?php echo ( 'review' === $tab1 ) ? 'current' : ''; ?>" href="<?php echo esc_url( wp_nonce_url( '?page=order-limit-lite-wc&tab=wcol-support-tab&tab1=review', 'setting' ) ); ?>">
					<?php esc_html_e( 'Review', 'wc-order-limit-lite' ); ?>
				</a>
			</li>
		</ul>
		<?php } ?>
		<div class="wcol-inner">
		<?php
		switch ( $selected_tab ) {
			case 'wcol-products-tab':
				require 'view-wcol-product-rules.php';
				break;
			case 'wcol-categories-tab':
				require 'view-wcol-category-rules.php';
				break;
			case 'wcol-order-total-tab':
				require 'view-wcol-order-total-rules.php';
				require 'view-wcol-advance-tab.php';
				break;
			case 'wcol-settings-tab':
				require 'view-wcol-order-total-rules.php';
				require 'view-wcol-advance-tab.php';
				break;
			case 'wcol-support-tab':
				require 'view-wcol-support-tab.php';
				break;
			default:
				require 'view-wcol-product-rules.php';
				break;
		}

		?>
		</div>
	<div class="xs-wcol-modal" id="wcol-modal">
		<div class="xs-wcol-modal-dialog">
			<div class="xs-wcol-modal-content">
				<!-- Modal Header -->
				<div class="xs-wcol-modal-header">
					<h4 class="xs-wcol-modal-title"><?php esc_html_e( 'Do  you want to ?', 'wc-order-limit-lite' ); ?></h4>
				</div>
				<!-- Modal footer -->
				<div class="xs-wcol-modal-footer">
					<button type="button" class="xs-wcol-btn xs-wcol-btn-info" id='wcol-modal-sbp'><?php esc_html_e( 'Save before proceeding', 'wc-order-limit-lite' ); ?> </button>
					<button type="button" class="xs-wcol-btn xs-wcol-btn-info" id='wcol-modal-pwos'><?php esc_html_e( 'Proceed without saving', 'wc-order-limit-lite' ); ?></button>
						<button type="button" class="xs-wcol-btn xs-wcol-btn-danger" id='wcol-modal-close'><?php esc_html_e( 'Close', 'wc-order-limit-lite' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
