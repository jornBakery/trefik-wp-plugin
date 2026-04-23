<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.6.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/**
 * Filter whether to display the section divider in the email body.
 *
 * @since 10.6.0
 * @param bool $display_section_divider Whether to display the section divider. Default true.
 */
$display_section_divider   = (bool) apply_filters( 'woocommerce_email_body_display_section_divider', true );
$heading_class             = $email_improvements_enabled ? 'email-order-detail-heading' : '';
$order_table_class         = $email_improvements_enabled ? 'email-order-details' : '';
$order_total_text_align    = $email_improvements_enabled ? 'right' : 'left';
$order_quantity_text_align = $email_improvements_enabled ? 'right' : 'left';

if ( $email_improvements_enabled ) {
	add_filter( 'woocommerce_order_shipping_to_display_shipped_via', '__return_false' );
}

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php
if ( $sent_to_admin ) {
	$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
	$after  = '</a>';
} else {
	$before = '';
	$after  = '';
}

/* translators: %s: Order ID. */
$order_number_string = __( '[Order #%s]', 'woocommerce' );
if ( $email_improvements_enabled ) {
	/* translators: %s: Order ID. */
	$order_number_string = __( 'Order #%s', 'woocommerce' );
}
?>

<tr>
    <td valign="top">
    <!-- BEGIN MODULE: Order Summary -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
    <tr>
    <td class="pc-w620-spacing-0-0-0-0" width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
        <tr>
        <td valign="top" class="pc-w620-radius-10-10-10-10 pc-w620-padding-32-24-32-24" style="padding: 40px 24px 40px 24px; height: unset; border-radius: 20px 20px 20px 20px; background-color: #f3f3f3;" bgcolor="#f3f3f3">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
            <td class="pc-w620-spacing-0-0-0-0" align="center" valign="top" style="padding: 0px 0px 8px 0px; height: auto;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="margin-right: auto; margin-left: auto;">
            <tr>
                <td valign="top" class="pc-w620-padding-0-0-0-0" align="center">
                <div class="pc-font-alt" style="text-decoration: none;">
                <div style="font-size:24px;mso-line-height-alt:24px;line-height:24px;text-align:center;text-align-last:center;color:#001942;font-weight:600;font-style:normal;">
                <div>
                    <span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 24px; line-height: 100%; letter-spacing: -0.03em;" class="pc-w620-font-size-24px pc-w620-line-height-40px">
                    <?php esc_html_e( 'Besteloverzicht', 'trefik' ); ?>
                    </span>
                </div>
                </div>
                </div>
                </td>
            </tr>
            </table>
            </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
            <td class="pc-w620-spacing-0-0-20-0" align="center" valign="top" style="padding: 0px 0px 30px 0px; height: auto;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="margin-right: auto; margin-left: auto;">
            <tr>
                <td valign="top" class="pc-w620-padding-0-0-0-0" align="center">
                <div class="pc-font-alt" style="text-decoration: none;">
                <div style="font-size:14px;mso-line-height-alt:19.6px;line-height:19.6px;text-align:center;text-align-last:center;color:#001942;letter-spacing:0px;font-weight:400;font-style:normal;">
                <div>
                    <span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 14px; line-height: 140%;" class="pc-w620-font-size-16px pc-w620-line-height-28px">
                    <?php echo wp_kses_post( $before . sprintf( $order_number_string . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) ); ?>
                    </span>
                </div>
                </div>
                </div>
                </td>
            </tr>
            </table>
            </td>
            </tr>
        </table>
        <?php
			$image_size = $email_improvements_enabled ? 48 : 32;
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => $email_improvements_enabled,
					'image_size'    => array( $image_size, $image_size ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
        ?>
        <?php
			$item_totals       = $order->get_order_item_totals();
			$item_totals_count = count( $item_totals );

			if ( $item_totals ) {
				$i = 0;
				foreach ( $item_totals as $total ) {
					++$i;
					$last_class = ( $i === $item_totals_count ) ? ' order-totals-last' : '';
					?>			
					
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                        <td style="padding: 5px 0px 4px 0px;">
                        <table class="pc-w620-tableCollapsed-0 order-totals order-totals-<?php echo esc_attr( $total['type'] ?? 'unknown' ); ?><?php echo esc_attr( $last_class ); ?>" border="0" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#ffffff" style="width: 100%; background-color:#ffffff; border-radius: 10px 10px 10px 10px;">
                        <tbody>
                            <tr>
                            <td align="left" valign="middle" style="padding: 16px 0px 16px 16px; height: auto;">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tr>
                                <td valign="top" align="left">
                                <div class="pc-font-alt" style="text-decoration: none;">
                                <div style="font-size:16px;mso-line-height-alt:22.4px;line-height:22.4px;text-align:left;text-align-last:left;color:#001942;font-weight:600;font-style:normal;">
                                <div>
                                    <span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 16px; line-height: 140%; letter-spacing: -0.03em;" class="pc-w620-font-size-16px pc-w620-line-height-26px">
                                        <?php
										echo wp_kses_post( $total['label'] ) . ' ';
										if ( $email_improvements_enabled ) {
											echo isset( $total['meta'] ) ? wp_kses_post( $total['meta'] ) : '';
										}
										?>
                                    </span>
                                </div>
                                </div>
                                </div>
                                </td>
                            </tr>
                            </table>
                            </td>
                            <td align="right" valign="middle" style="padding: 16px 16px 16px 16px; height: auto;">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tr>
                                <td valign="top" align="right">
                                <div class="pc-font-alt" style="text-decoration: none;">
                                <div style="font-size:16px;mso-line-height-alt:20px;line-height:20px;text-align:right;text-align-last:right;color:#001942;font-weight:400;font-style:normal;">
                                <div>
                                    <span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 16px; line-height: 140%; letter-spacing: -0.03em;" class="pc-w620-font-size-16px pc-w620-line-height-20px">
                                        <?php echo wp_kses_post( $total['value'] ); ?>
                                    </span>
                                </div>
                                </div>
                                </div>
                                </td>
                            </tr>
                            </table>
                            </td>
                            </tr>

                        </tbody>
                        </table>
                        </td>
                        </tr>
                    </table>
                <?php
				}
			}?>
            <?php if ( $display_section_divider ) : ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="padding: 16px 0;">
                            <hr style="border: 0; border-top: 1px solid #1E1E1E; border-top-color: rgba(30, 30, 30, 0.2); margin: 0;">
                        </td>
                    </tr>
                </table>
            <?php endif; ?>

            <?php if ( $order->get_customer_note() && $email_improvements_enabled ) : ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="padding: 0;">
                            <table class="pc-w620-tableCollapsed-0 order-customer-note" border="0" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#ffffff" style="width: 100%; background-color:#ffffff; border-radius: 10px 10px 10px 10px;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 16px;">
                                            <div class="pc-font-alt" style="text-decoration: none;">
                                                <div style="font-size:14px;mso-line-height-alt:20px;line-height:20px;text-align:left;text-align-last:left;color:#001942;font-weight:400;font-style:normal;">
                                                    <b><?php esc_html_e( 'Customer note', 'woocommerce' ); ?></b><br>
                                                    <?php echo wp_kses( nl2br( wc_wptexturize_order_note( $order->get_customer_note() ) ), array( 'br' => array() ) ); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php elseif ( $order->get_customer_note() && ! $email_improvements_enabled ) : ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="padding: 0;">
                            <table class="pc-w620-tableCollapsed-0 order-customer-note" border="0" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#ffffff" style="width: 100%; background-color:#ffffff; border-radius: 10px 10px 10px 10px;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 16px;">
                                            <div class="pc-font-alt" style="text-decoration: none;">
                                                <div style="font-size:14px;mso-line-height-alt:20px;line-height:20px;text-align:left;text-align-last:left;color:#001942;font-weight:400;font-style:normal;">
                                                    <b><?php esc_html_e( 'Note:', 'woocommerce' ); ?></b><br>
                                                    <?php echo wp_kses( nl2br( wc_wptexturize_order_note( $order->get_customer_note() ) ), array() ); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
            <tr>
            <td style="padding: 0px 0px 32px 0px;">
            <table class="pc-w620-tableCollapsed-0" border="0" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#ffffff" style="width: 100%; background-color:#ffffff; border-radius: 10px 10px 10px 10px;">
            
            </table>
            </td>
            </tr>
        </table>
        </td>
        </tr>
        </table>
    </td>
    </tr>
    </table>
    <!-- END MODULE: Order Summary -->
    </td>
</tr>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php
if ( $email_improvements_enabled ) {
	remove_filter( 'woocommerce_order_shipping_to_display_shipped_via', '__return_false' );
}
?>