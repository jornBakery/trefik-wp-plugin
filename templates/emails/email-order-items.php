<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.4.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

defined( 'ABSPATH' ) || exit;

$margin_side = is_rtl() ? 'left' : 'right';

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );
$price_text_align           = $email_improvements_enabled ? 'right' : 'left';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
	}

	?>
<table class="pc-w620-tableCollapsed-0" border="0" cellpadding="0" cellspacing="0" role="presentation" bgcolor="#FFFFFF"
    style="width: 100%; background-color:#FFFFFF; border-radius: 10px 10px 10px 10px;">
    <tbody>
        <tr>
            <td class="pc-w620-halign-left pc-w620-valign-middle" align="left" valign="top"
                style="padding: 16px 0px 8px 16px; height: auto;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="pc-w620-spacing-0-0-5-0" valign="top" style="padding: 0px 0px 5px 0px;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="pc-w620-align-left" valign="top">
                                        <table class="pc-w620-align-left" border="0" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <th valign="top" style="font-weight: normal; text-align: left;">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation">
                                                        <tr>
                                                            <td class="pc-w620-spacing-15-16-0-0 pc-w620-align-left"
                                                                valign="top"
                                                                style="padding: 0px 20px 0px 0px; height: auto;">
                                                                <?php
                                                                    /**
                                                                     * Email Order Item Thumbnail hook.
                                                                     *
                                                                     * @param string                $image The image HTML.
                                                                     * @param WC_Order_Item_Product $item  The item being displayed.
                                                                     * @since 2.1.0
                                                                     */;
                                                                    if ( $show_image ) {
                                                                        echo wp_kses_post( apply_filters( 'trefik_email_order_item_thumbnail', apply_filters( 'woocommerce_order_item_thumbnail', $image, $item ) ) );
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" style="font-weight: normal; text-align: left;">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation">
                                                        <tr>
                                                            <td valign="top" style="padding: 0px 0px 5px 0px;">
                                                                <table width="100%" border="0" cellpadding="0"
                                                                    cellspacing="0" role="presentation">
                                                                    <tr>
                                                                        <td class="pc-w620-align-left" valign="top">
                                                                            <table width="100%" border="0"
                                                                                cellpadding="0" cellspacing="0"
                                                                                role="presentation">
                                                                                <tr>
                                                                                    <th class="pc-w620-textAlign-left"
                                                                                        align="left" valign="top"
                                                                                        style="padding: 0px 0px 4px 0px;">
                                                                                        <table border="0"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            role="presentation"
                                                                                            class="pc-w620-textAlign-left"
                                                                                            width="100%">
                                                                                            <tr>
                                                                                                <td valign="top"
                                                                                                    class="pc-w620-textAlign-left"
                                                                                                    align="left"
                                                                                                    style="padding: 9px 0px 0px 0px; height: auto;">
                                                                                                    <div class="pc-font-alt pc-w620-textAlign-left" style="text-decoration: none;">
                                                                                                        <div style="font-size:16px;mso-line-height-alt:26px;line-height:26px;text-align:left;text-align-last:left;color:#ec7e30;font-weight:500;font-style:normal;">
                                                                                                            <div>
                                                                                                                <span style="font-family: 'Rubik', Arial, Helvetica, sans-serif; font-size: 20px; line-height: 140%; letter-spacing: -0.03em;" class="pc-w620-font-size-16px pc-w620-line-height-26px">
                                                                                                                    <?php
                                                                                                                    /**
                                                                                                                     * Order Item Name hook.
                                                                                                                     *
                                                                                                                     * @param string                $item_name The item name HTML.
                                                                                                                     * @param WC_Order_Item_Product $item      The item being displayed.
                                                                                                                     * @since 2.1.0
                                                                                                                     */
                                                                                                                    echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );
                                                                                                                    ?>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="pc-w620-textAlign-left"
                                                                                        align="left" valign="top"
                                                                                        style="">
                                                                                        <table border="0"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            role="presentation"
                                                                                            class="pc-w620-textAlign-left"
                                                                                            width="100%">
                                                                                            <tr>
                                                                                                <td valign="top"
                                                                                                    class="pc-w620-textAlign-left"
                                                                                                    align="left">
                                                                                                    <div class="pc-font-alt pc-w620-textAlign-left"
                                                                                                        style="text-decoration: none;">
                                                                                                        <div
                                                                                                            style="font-size:16px;mso-line-height-alt:20px;line-height:20px;text-align:left;text-align-last:left;color:#001942;font-weight:400;font-style:normal;">
                                                                                                            <div>
                                                                                                                <span
                                                                                                                    style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 16px; line-height: 140%; letter-spacing: -0.03em;"
                                                                                                                    class="pc-w620-font-size-16px pc-w620-line-height-20px">
                                                                                                                    <?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th valign="top"
                                                                                        class="pc-w620-align-left"
                                                                                        align="left"
                                                                                        style="padding: 10px 0px 0px 0px; text-align: left; font-weight: normal;">
                                                                                         
                                                                                                                    
                                                                                        <!--[if mso]>
                                                                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" class="pc-w620-align-left" align="left" style="border-collapse: separate; border-spacing: 0;">
                                                                                                <tr>
                                                                                                    <td valign="middle" align="center" style="border-radius: 5px 5px 5px 5px; background-color: #2a2a2a; text-align:center; color: #ffffff; padding: 10px 30px 10px 30px; mso-padding-left-alt: 0; margin-left:30px;" bgcolor="#2a2a2a">
                                                                                                        <a class="pc-font-alt" style="display: inline-block; text-decoration: none; text-align: center;" target="_blank">
                                                                                                            <span style="font-size:17px;mso-line-height-alt:24px;line-height:24px;color:#ffffff;letter-spacing:-0.2px;font-weight:600;font-style:normal;display:inline-block;vertical-align:top;">
                                                                                                                <span style="display:inline-block;">
                                                                                                                    <span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 17px; line-height: 24px;">
                                                                                                                        24 uur
                                                                                                                    </span>
                                                                                                                </span>
                                                                                                            </span>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        <![endif]-->
                                                                                        <!--[if !mso]><!-- -->
                                                                                        <a class="pc-w620-textAlign-left"
                                                                                            style="display: inline-block; box-sizing: border-box; border-radius: 5px 5px 5px 5px; background-color: #2a2a2a; padding: 10px 30px 10px 30px; vertical-align: top; text-align: center; text-align-last: center; text-decoration: none; -webkit-text-size-adjust: none;"
                                                                                            target="_blank">
                                                                                            <span style="font-size:17px;mso-line-height-alt:24px;line-height:24px;color:#ffffff;letter-spacing:-0.2px;font-weight:600;font-style:normal;display:inline-block;vertical-align:top;">
                                                                                                <span style="display:inline-block;">
                                                                                                    <span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 17px; line-height: 24px;">
                                                                                                    <?php
                                                                                                    /**
                                                                                                     * Allow other plugins to add additional product information.
                                                                                                     *
                                                                                                     * @param int                   $item_id    The item ID.
                                                                                                     * @param WC_Order_Item_Product $item       The item object.
                                                                                                     * @param WC_Order              $order      The order object.
                                                                                                     * @param bool                  $plain_text Whether the email is plain text or not.
                                                                                                     * @since 2.3.0
                                                                                                     */
                                                                                                        // allow other plugins to add additional product information here.
                                                                                                        do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

                                                                                                        $item_meta = wc_display_item_meta(
                                                                                                            $item,
                                                                                                            array(
                                                                                                                'before'        => '',
                                                                                                                'after'         => '',
                                                                                                                'separator'     => '<br>',
                                                                                                                'echo'          => false,
                                                                                                                'label_before'  => '',
                                                                                                                'label_after'   => '',
                                                                                                                'show_meta_key' => false,
                                                                                                            )
                                                                                                        );
                                                                                                        echo wp_kses(
                                                                                                            $item_meta,
                                                                                                            array(
                                                                                                                'br'   => array(),
                                                                                                                'span' => array(),
                                                                                                                'a'    => array(
                                                                                                                    'href'   => true,
                                                                                                                    'target' => true,
                                                                                                                    'rel'    => true,
                                                                                                                    'title'  => true,
                                                                                                                ),
                                                                                                            )
                                                                                                        );

                                                                                                        // allow other plugins to add additional product information here.
                                                                                                        do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );
                                                                                                    ?>
                                                                                                    </span>
                                                                                                </span>
                                                                                            </span>
                                                                                        </a>
                                                                                        <!--<![endif]-->
                                                                                    </th>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="pc-w620-padding-28-32-24-16" align="right" valign="top"
                style="padding: 24px 16px 24px 16px; height: auto;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                    <tr>
                        <td valign="top" align="left">
                            <div class="pc-font-alt" style="text-decoration: none;">
                                <div
                                    style="font-size:15px;mso-line-height-alt:21px;line-height:21px;text-align:left;text-align-last:left;color:#53627a;font-weight:400;font-style:normal;">
                                    <div>
                                        <span style="font-family: 'Rubik', Arial, Helvetica, sans-serif; font-size: 15px; line-height: 140%; letter-spacing: -0.03em;">
                                        <?php
                                            $qty          = $item->get_quantity();
                                            $refunded_qty = $order->get_qty_refunded_for_item( $item_id );

                                            if ( $refunded_qty ) {
                                                $qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
                                            } else {
                                                $qty_display = esc_html( $qty );
                                            }
                                            echo wp_kses_post( ( $email_improvements_enabled ? '×' : '' ) . apply_filters( 'woocommerce_email_order_item_quantity', $qty_display, $item ) . ( $email_improvements_enabled ? '' : 'x' ) );
                                        ?>
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

<?php endforeach; ?>