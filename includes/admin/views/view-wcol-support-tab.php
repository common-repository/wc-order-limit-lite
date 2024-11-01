<?php
	/**
	 * Support tab of admin area
	 *
	 * This file is used to markup the admin-facing aspects of the plugin.
	 *
	 * @link       https://xfiniftysoft.com
	 * @since      1.0.0
	 *
	 * @package    wc_order_limit_lite
	 * @subpackage wc_order_limit_lite/includes/admin/views/
	 */

?>
<div class="warp">
	<?php
	wp_nonce_field( 'xsollwc_support', '_xsollwc_support_nonce', true );
	switch ( $tab1 ) {
		case 'report':
			?>
			<div class="xs-send-email-notice xs-top-margin">
				<p></p>
				<button type="button" class="notice-dismiss xs-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice', 'wc-order-limit-lite' ); ?></span></button>
			</div>
			<form method="post" class="xsollwc_support_form">
				<input type="hidden" name="type" value="report">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th>
								<label for='xs_name'><?php esc_html_e( 'Your Name:', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<input type="text" id="xs_name" name="xs_name" required="required">
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="xs_email"><?php esc_html_e( 'Your Email', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<input type="email" id="xs_email" name="xs_email" required="required">
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="xs_message"><?php esc_html_e( 'Message', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<textarea id="xs_message" name="xs_message" rows="12", cols="47" required="required"></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="input-group">
					<?php submit_button( __( 'Send' ), 'primary xs-send-mail' ); ?>
					<span class="spinner xs-mail-spinner"></span> 
				</div>
			</form>
			
			<?php
			break;
		case 'request':
			?>
			<div class="xs-send-email-notice xs-top-margin">
				<p></p>
				<button type="button" class="notice-dismiss xs-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice', 'wc-order-limit-lite' ); ?></span></button>
			</div>
			<form method="post" class="xsollwc_support_form">
				<input type="hidden" name="type" value="request">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th>
								<label for='xs_name'><?php esc_html_e( 'Your Name:', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<input type="text" id="xs_name" name="xs_name" required>
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="xs_email"><?php esc_html_e( 'Your Email', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<input type="email" id="xs_email" name="xs_email" required>
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="xs_message"><?php esc_html_e( 'Message', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<textarea id="xs_message" name="xs_message" rows="12", cols="47" required></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="input-group">
					<?php submit_button( __( 'Send' ), 'primary xs-send-mail' ); ?>
					<span class="spinner xs-mail-spinner"></span> 
				</div>
				
			</form>
			<?php
			break;
		case 'hire':
			?>
			<h2><?php esc_html_e( 'Hire us to customize/develope Plugin/Theme or WordPress projects', 'wc-order-limit-lite' ); ?></h2>
			<div class="xs-send-email-notice xs-top-margin">
				<p></p>
				<button type="button" class="notice-dismiss xs-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice', 'wc-order-limit-lite' ); ?></span></button>
			</div>
			<form method="post" class="xsollwc_support_form">
				<input type="hidden" name="type" value="hire">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th>
								<label for='xs_name'><?php esc_html_e( 'Your Name:', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<input type="text" id="xs_name" name="xs_name" required="required">
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="xs_email"><?php esc_html_e( 'Your Email', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<input type="email" id="xs_email" name="xs_email" required="required">
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="xs_message"><?php esc_html_e( 'Message', 'wc-order-limit-lite' ); ?></label>
							</th>
							<td>
								<textarea id="xs_message" name="xs_message" rows="12", cols="47" required="required"></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="input-group">
					<?php submit_button( __( 'Send' ), 'primary xs-send-mail' ); ?>
					<span class="spinner xs-mail-spinner"></span> 
				</div>
			</form>
			<?php
			break;
		case 'review':
			?>
			<p class="about-description xs-top-margin"><?php esc_html_e( 'If you like our plugin and support than kindly share your', 'wc-order-limit-lite' ); ?> <a href="https://wordpress.org/plugins/wc-order-limit-lite/#reviews" target="_blank"> <?php esc_html_e( 'feedback', 'wc-order-limit-lite' ); ?> </a><?php esc_html_e( 'Your feedback is valuable.', 'wc-order-limit-lite' ); ?> </p>
			<?php
			break;
		default:
			break;
	}
	?>
</div>
