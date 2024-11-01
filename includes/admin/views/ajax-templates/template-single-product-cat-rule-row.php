<?php
	/**
	 * Provide a admin area view for the plugin
	 *
	 * This file is used to markup the admin-facing aspects of the plugin.
	 *
	 * @link       https://xfiniftysoft.com
	 * @since      1.0.0
	 *
	 * @package    wc_order_limit_lite
	 * @subpackage wc_order_limit_lite/includes/admin/views/ajax-templates
	 */

$rule_id = uniqid();
if ( isset( $_POST['_wcol_new_rule_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wcol_new_rule_nonce'] ) ), 'wcol_new_rule' ) ) {
	if ( isset( $_POST['wcol_spcid'] ) && ! empty( $_POST['wcol_spcid'] ) ) {
		$spcid = sanitize_text_field( wp_unslash( $_POST['wcol_spcid'] ) );
	}
}
?>
<div class="wcol_single_cat_rule wcol-new wcol_single_cat_rule_open">
	<input type="hidden" name="wcol_rules[rule-id][<?php echo esc_html( $spcid ); ?>]" value="<?php echo esc_html( $rule_id ); ?>"/>
	<input type="hidden" name="wcol_rules[wcol_rule_key][<?php echo esc_html( $spcid ); ?>]"/>
	<h3 class="wcol_cat_accordion"><?php esc_html_e( 'New Rule(Not Saved)', 'wc-order-limit-lite' ); ?><span class="wcol-delete"><?php esc_html_e( 'Delete', 'wc-order-limit-lite' ); ?></span></h3>
	<div class="wcol_cat_panel" style="display:block">
		<div class="options_group">
			<p class="form-field">
				<label><?php esc_html_e( 'Minimum Order', 'wc-order-limit-lite' ); ?>:</label>
				<input type="number" min="0"  name="wcol_rules[wcol_min_order_limit][<?php echo esc_html( $spcid ); ?>]" class="wcol-rule-min-limit" value="" placeholder="<?php esc_html_e( 'Enter Minimum Order Limit', 'wc-order-limit-lite' ); ?>" />
			</p>
			<p class="wcol-description"><?php esc_html_e( 'Leave blank for no limit', 'wc-order-limit-lite' ); ?>.</p>
		</div>
		<div class="options_group">
			<p class="form-field">
				<label><?php esc_html_e( 'Enable Maximum Limit', 'wc-order-limit-lite' ); ?>:</label>
				<input type="hidden" class="wcol-loop-checkbox-hidden" name="wcol_rules[enable-max-rule-limit][<?php echo esc_html( $spcid ); ?>]" />
				<input type="checkbox" class="wcol-loop-checkbox enable-max-rule-limit" min="0"/>
			</p>
			<p class="form-field wcol-hidden">
				<label><?php esc_html_e( 'Maximum Order', 'wc-order-limit-lite' ); ?>:</label>
				<input type="number" class="wcol-rule-max-limit" min="0"  name="wcol_rules[wcol_max_order_limit][<?php echo esc_html( $spcid ); ?>]" value="" placeholder="<?php esc_html_e( 'Enter Maximum Order Limit', 'wc-order-limit-lite' ); ?>" />
			</p>
		</div>
		<div class="options_group">
			<p class="form-field">
				<label><?php esc_html_e( 'Applied on', 'wc-order-limit-lite' ); ?>:</label>
				<?php
				$applied_on_ajax_options  = '<option value="amount" >' . esc_html__( 'Amount', 'wc-order-limit-lite' ) . '</option>';
				$applied_on_ajax_options .= '<option value="quantity" >' . esc_html__( 'Quantity', 'wc-order-limit-lite' ) . '</option>';
				$applied_on_ajax_options  = apply_filters( 'wcol_applied_on_ajax_option', $applied_on_ajax_options );
				?>
				<select name="wcol_rules[wcol_applied_on][<?php echo esc_html( $spcid ); ?>]" >
					<?php
					//phpcs:ignore 
					echo $applied_on_ajax_options; ?>
				</select>
			</p>
			<p class="wcol-description"><?php esc_html_e( 'Select if limit will be applied on quantity or amount.', 'wc-order-limit-lite' ); ?></p>
		</div>

	</div>
</div>
