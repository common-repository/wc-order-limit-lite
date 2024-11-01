<?php
/**
 * Setting rule tab
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
	<div class="wcol-rules-section wcol-advance-tab-section <?php echo ( 'wcol-settings-tab' === $selected_tab ) ? '' : 'hidden'; ?>">
		<table class="form-table wcol-form-table">
			<tbody>
				<tr>
					<td><h3><?php esc_html_e( 'Product Limit Options:', 'wc-order-limit-lite' ); ?></h3></td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc"> 
						<label for=""><?php esc_html_e( 'Products Limits', 'wc-order-limit-lite' ); ?>:</label>
						<div class="wcol-help-tip">
							<span class="wcol-tip"> <?php esc_html_e( 'Check this box to enable products based limits.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-checkbox" >
						<fieldset>
							<legend class="screen-reader-text"><span><?php esc_html_e( 'Products Limits', 'wc-order-limit-lite' ); ?></span></legend>
							<label for="wcol-enable-product-limit">
								<input type="checkbox" name="wcol-enable-product-limit" <?php echo ( isset( $wcol_settings['enable_product_limit'] ) && 'on' === $wcol_settings['enable_product_limit'] ) ? 'checked' : ''; ?> > 
								<?php esc_html_e( 'Enable Products Limits', 'wc-order-limit-lite' ); ?>
							</label> 
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc"> 
						<label for="wcol-product-limit-message"><?php esc_html_e( 'Message for Product limit', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip">
							<span class="wcol-tip"> <?php esc_html_e( 'This message will be shown on cart page if customer do not fulfill the order limit that you specified for products.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-textarea">
						<div>
							<textarea name="wcol-product-limit-message" id="wcol-product-limit-message" rows="3"><?php echo ( isset( $wcol_settings['product_limit_message'] ) ) ? esc_html( $wcol_settings['product_limit_message'] ) : ''; ?></textarea>
							<span style="display: inline-block; padding: 0 50px 0 5px; font-style: italic; font-size: 11px; ">
								<?php esc_html_e( 'Use {product-name} for Product Name, {min-limit} for Minimum Limit, {max-limit} for Maximum Limit {applied-on} for quantity/amount , {time-span} for rule time span, {limit-reset-day} for rule rest date.', 'wc-order-limit-lite' ); ?>
							</span>

						</div>
					</td>				
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc"> 
						<label for="wcol-product-limit-accomulative"><?php esc_html_e( 'Message for Product limit For Accomulative Rules', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip">
							<span class="wcol-tip"> <?php esc_html_e( 'This message will be shown on cart page if customer do not fulfill rule for Acomulative Products.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-textarea">
						<div>
							<textarea name="wcol-product-limit-message-accomulative" id="wcol-product-limit-message-accomulative" rows="3"><?php echo ( isset( $wcol_settings['product_limit_message_accomulative'] ) ) ? esc_html( $wcol_settings['product_limit_message_accomulative'] ) : ''; ?></textarea>
							<span style="display: inline-block; padding: 0 50px 0 5px; font-style: italic; font-size: 11px; ">
								<?php esc_html_e( 'Use {product-names} for Product Names seperated by comma, {max-limit} for Maximum Limit {min-limit} for Minimum Limit, {applied-on} for quantity/amount,  , {time-span} for rule time span, {limit-reset-day} for rule rest date.', 'wc-order-limit-lite' ); ?>
							</span>

						</div>
					</td>				
				</tr>

				<tr valign="top">
					<td><h3><?php esc_html_e( 'Category Limit Options:', 'wc-order-limit-lite' ); ?></h3></td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="wcol-enable-category-limit"><?php esc_html_e( 'Category Limits', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip" title="">
							<span class="wcol-tip"> <?php esc_html_e( 'Check this box to enable product categories based limits.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-checkbox" >
						<fieldset>
							<legend class="screen-reader-text"><span><?php esc_html_e( 'Category Limits', 'wc-order-limit-lite' ); ?></span></legend>
							<label for="wcol-enable-category-limit">
								<input type="checkbox" name="wcol-enable-category-limit" <?php echo ( isset( $wcol_settings['enable_category_limit'] ) && 'on' === $wcol_settings['enable_category_limit'] ) ? 'checked' : ''; ?>> 
								<?php esc_html_e( 'Enable Category Limits', 'wc-order-limit-lite' ); ?>
							</label> 
						</fieldset>
					</td>
				</tr>
				<tr valign="top" class="titledesc">
					<th scope="row"> 
						<label for="wcol-category-limit-message"><?php esc_html_e( 'Message for Category limit', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip" title="">
							<span class="wcol-tip"> <?php esc_html_e( 'This message will be shown on cart page if customer do not fulfill the order limit that you specified for product categories.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-textarea">
						<div>
							<textarea name="wcol-category-limit-message" id="wcol-category-limit-message" rows="3"><?php echo ( isset( $wcol_settings['category_limit_message'] ) ) ? esc_html( $wcol_settings['category_limit_message'] ) : ''; ?></textarea>
							<span style="display: inline-block; padding: 0 50px 0 5px; font-style: italic; font-size: 11px; ">
								<?php esc_html_e( 'Use {category-name} for Category, {min-limit} for Minimum Limit, {max-limit} for Maximum Limit {applied-on} for quantity/amount , {time-span} for rule time span, {limit-reset-day} for rule rest date.', 'wc-order-limit-lite' ); ?>
							</span>

						</div>
					</td>				
				</tr>	
				<tr valign="top" class="titledesc">
					<th scope="row"> 
						<label for="wcol-category-limit-message-accomulative"><?php esc_html_e( 'Message for Category limit for Accomulative Rules', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip" title="">
							<span class="wcol-tip"> <?php esc_html_e( 'This message will be shown on cart page if customer do not fulfill an accomulative rule for product categories.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-textarea">
						<div>
							<textarea name="wcol-category-limit-message-accomulative" id="wcol-category-limit-message-accomulative" rows="3"><?php echo ( isset( $wcol_settings['category_limit_message_accomulative'] ) ) ? esc_html( $wcol_settings['category_limit_message_accomulative'] ) : ''; ?></textarea>
							<span style="display: inline-block; padding: 0 50px 0 5px; font-style: italic; font-size: 11px; ">
								<?php esc_html_e( 'Use {category-names} for Categories seperated by comma, {max-limit} for Maximum Limit, {min-limit} for Minimum Limit, {applied-on} for quantity/amount , {time-span} for rule time span, {limit-reset-day} for rule rest date.', 'wc-order-limit-lite' ); ?>
							</span>

						</div>
					</td>				
				</tr>
				<tr valign="top">
					<td><h3><?php esc_html_e( 'Cart Total Limit Options:', 'wc-order-limit-lite' ); ?></h3></td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc"> 
						<label for="wcol-enable-cart-total-limit"><?php esc_html_e( 'Cart Total Limits', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip" title="">
							<span class="wcol-tip"> <?php esc_html_e( 'Check this box to enable limits on cart total.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-checkbox" >
						<fieldset>
							<legend class="screen-reader-text"><span><?php esc_html_e( 'Cart Total Limits', 'wc-order-limit-lite' ); ?></span></legend>
							<label for="wcol-enable-cart-total-limit">
								<input type="checkbox" name="wcol-enable-cart-total-limit" <?php echo ( isset( $wcol_settings['enable_cart_total_limit'] ) && 'on' === $wcol_settings['enable_cart_total_limit'] ) ? 'checked' : ''; ?>> 
								<?php esc_html_e( 'Enable Cart Total Limits', 'wc-order-limit-lite' ); ?>
							</label> 
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc"> 
						<label for="wcol-cart-total-limit-message"><?php esc_html_e( 'Message for Product limit', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip" title="">
							<span class="wcol-tip"> <?php esc_html_e( 'This message will be shown on cart page if customer do not fulfill the order limit that you specified for cart totals.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td class="wcol-forminp wcol-forminp-textarea">
						<div>
							<textarea name="wcol-cart-total-limit-message"  id="wcol-cart-total-limit-message" rows="3"><?php echo ( isset( $wcol_settings['cart_total_limit_message'] ) ) ? esc_html( $wcol_settings['cart_total_limit_message'] ) : ''; ?></textarea>
							<span style="display: inline-block; padding: 0 50px 0 5px; font-style: italic; font-size: 11px; ">
								<?php esc_html_e( 'Use {min-limit} for Minimum Limit, {max-limit} for Maximum Limit, {applied-on} for quantity/amount.', 'wc-order-limit-lite' ); ?>
							</span>

						</div>
					</td>				
				</tr>
				<tr valign="top">
					<td><h3><?php esc_html_e( 'Other Options:', 'wc-order-limit-lite' ); ?></h3></td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="wcol-enable-checkout-button"><?php esc_html_e( 'Hide Checkout Button', 'wc-order-limit-lite' ); ?></label>
						<div class="wcol-help-tip">
							<span class="wcol-tip"> <?php esc_html_e( 'If you check this checkbox then Checkout Button will be hidden on cart page if customer do not fulfill any of the limits that you specified.', 'wc-order-limit-lite' ); ?> </span>
						</div>
					</th>
					<td><input type="checkbox" name="wcol-enable-checkout-button"  <?php echo ( isset( $wcol_settings['enable_checkout_button'] ) && 'on' === $wcol_settings['enable_checkout_button'] ) ? 'checked' : ''; ?>></td>
				</tr>
				<tr valign="top" class="wc-actions-row">
					<td class="wcol-order-total-save">
						<input type="submit"  class="button button-primary button-large xs-wcol" value="<?php esc_html_e( 'Save Changes', 'wc-order-limit-lite' ); ?>"/>
						<span class="spinner xs-wcol-spinner"></span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</form>
