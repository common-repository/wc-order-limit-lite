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
	if ( isset( $_POST['wcol_pid'] ) && ! empty( $_POST['wcol_pid'] ) ) {
		$pid = sanitize_text_field( wp_unslash( $_POST['wcol_pid'] ) );
	}
}
?>
<tr class="wcol-new" data-id="<?php echo esc_html( $rule_id ); ?>">
	<td class="check-column wcol-cb">
		<input type="checkbox"/>
		<input type="hidden" name="wcol-rules[product-rules][rule-id][<?php echo esc_html( $pid ); ?>]" value="<?php echo esc_html( $rule_id ); ?>">
	</td>
	<td class="column-primary">
		<select class="wcol-select-products" name="wcol-rules[product-rules][object-ids][<?php echo esc_html( $pid ); ?>][]" multiple="multiple"></select>
		<button type="button" class="toggle-row"><span class="screen-reader-text"><?php esc_html_e( 'Show more details', 'wc-order-limit-lite' ); ?></span></button>
	</td>
	<td data-colname="<?php esc_attr_e( 'Minimum Limit', 'wc-order-limit-lite' ); ?>">
		<input type="number" min="0" class="wcol-rule-min-limit" name="wcol-rules[product-rules][rule-limit][<?php echo esc_html( $pid ); ?>]" value="0" />
	</td>
	
	<td data-colname="<?php esc_attr_e( 'Applied On', 'wc-order-limit-lite' ); ?>">
		<?php
		$applied_on_ajax_options  = '<option value="amount" >' . esc_html__( 'Amount', 'wc-order-limit-lite' ) . '</option>';
		$applied_on_ajax_options .= '<option value="quantity" >' . esc_html__( 'Quantity', 'wc-order-limit-lite' ) . '</option>';
		$applied_on_ajax_options  = apply_filters( 'wcol_applied_on_ajax_option', $applied_on_ajax_options );
		?>
		<select class="wcol-select-applied-on" name="wcol-rules[product-rules][applied-on][<?php echo esc_html( $pid ); ?>]" >
			<?php
			//phpcs:ignore 
			echo $applied_on_ajax_options; ?>
		</select>
	</td>
	<td data-colname="<?php esc_attr_e( 'Accumulatively', 'wc-order-limit-lite' ); ?>">
		<input type="hidden" class="wcol-loop-checkbox-hidden" name="wcol-rules[product-rules][accomulative][<?php echo esc_html( $pid ); ?>]"/>
		<input type="checkbox" class="wcol-accomulative wcol-loop-checkbox"/>
	</td>	
	<td class="wcol-more-options-td">
		<div class="wcol-more-options">
			<a class="wcol-show-more-options" href="#"><?php esc_html_e( 'More Options', 'wc-order-limit-lite' ); ?></a>
			<a class="wcol-hide-more-options wcol-hidden" href="#"><?php esc_html_e( 'Hide Options', 'wc-order-limit-lite' ); ?></a>
			<div class="wcol-options-open wcol-hidden"></div>
			
			<div class=" wcol-rule-options wcol-hidden">
				<div class="wcol-more-options-header">
					<h3><?php esc_html_e( 'More Options', 'wc-order-limit-lite' ); ?></h3>
				</div>
				<table class="">
					<tr>
						<th><?php esc_html_e( 'Disable', 'wc-order-limit-lite' ); ?>:</th>
						<td>
							<input type="hidden" class="wcol-loop-checkbox-hidden" name="wcol-rules[product-rules][disable-limit][<?php echo esc_html( $pid ); ?>]" />
							<input class="wcol-disable-rule-limit wcol-loop-checkbox" type="checkbox" />
						</td>
					</tr>

					
					<tr>
						<th><?php esc_html_e( 'Enable Maximum Limit', 'wc-order-limit-lite' ); ?>:</th>
						<td>
							<input type="hidden" class="enable-max-rule-limit-hidden wcol-loop-checkbox-hidden" name="wcol-rules[product-rules][enable-max-rule-limit][<?php echo esc_html( $pid ); ?>]"/>
							<input class="enable-max-rule-limit wcol-loop-checkbox" type="checkbox" />
						</td>
					</tr>
					
					<tr class="wcol-hidden">
						<th><?php esc_html_e( 'Maximum Limit', 'wc-order-limit-lite' ); ?>:</th>
						<td><input type="number" min="0" class="wcol-rule-max-limit" name="wcol-rules[product-rules][max-rule-limit][<?php echo esc_html( $pid ); ?>]" /></td>
					</tr>
					
					
				</table>
				
			</div>
		</div>
	</td>
</tr>
