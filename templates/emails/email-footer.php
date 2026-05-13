<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.4.0
 */

defined( 'ABSPATH' ) || exit;

$email = $email ?? null;

$email_footer_text = get_option( 'woocommerce_email_footer_text' );
/**
 * This filter is documented in templates/emails/email-styles.php
 *
 * @since 9.6.0
 */
if ( apply_filters( 'woocommerce_is_email_preview', false ) ) {
	$text_transient    = get_transient( 'woocommerce_email_footer_text' );
	$email_footer_text = false !== $text_transient ? $text_transient : $email_footer_text;
}

$email_footer_text = wp_kses_post(
	wpautop(
		wptexturize(
			/**
			 * Provides control over the email footer text used for most order emails.
			 *
			 * @since 4.0.0
			 *
			 * @param string $email_footer_text
			 */
			apply_filters( 'woocommerce_email_footer_text', $email_footer_text, $email )
		)
	)
);
?>        
         <td valign="top">
          <!-- BEGIN MODULE: Footer -->
          <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
           <tr>
            <td class="pc-w620-spacing-0-0-0-0" width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
              <tr>
               <td valign="top" class="pc-w620-radius-10-10-10-10 pc-w620-padding-24-24-24-24" style="padding: 24px 24px 24px 24px; height: unset; border-radius: 10px 10px 10px 10px; background-color: #272727;" bgcolor="#272727">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                 <tr>
                  <td align="center" valign="top" style="padding: 0px 0px 12px 0px; height: auto;">
                   <img src="/wp-content/uploads/2021/06/logo-tref-ik-512x-300x111.png" width="135" height="49" alt="" style="display: block; outline: 0; line-height: 100%; -ms-interpolation-mode: bicubic; width: 135px; height: auto; max-width: 100%; border: 0;" />
                  </td>
                 </tr>
                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                 <tr>
                  <td class="pc-w620-spacing-10-0-0-0" align="center" valign="top">
                   <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="margin-right: auto; margin-left: auto;">
                    <tr>
                     <td valign="top" class="pc-w620-padding-0-0-0-0" align="center">
                      <div class="pc-font-alt" style="text-decoration: none;">
                       <div style="font-size:14px;mso-line-height-alt:20.02px;line-height:20.02px;text-align:center;text-align-last:center;color:#ffffff;font-style:normal;font-weight:500;letter-spacing:-0.2px;">
                        <div><span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 14px; line-height: 143%;">Sikkelstraat 4, 7552EE Hengelo, Overijssel, Nederland</span>
                        </div>
                       </div>
                      </div>
                     </td>
                    </tr>
                   </table>
                  </td>
                 </tr>
                </table>
                <?php if ( $email_footer_text ) : ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                 <tr>
                  <td class="pc-w620-spacing-10-0-0-0" align="center" valign="top" style="padding-top: 10px;">
                   <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="margin-right: auto; margin-left: auto;">
                    <tr>
                     <td valign="top" class="pc-w620-padding-0-0-0-0" align="center">
                      <div class="pc-font-alt" style="text-decoration: none;">
                       <div style="font-size:12px;mso-line-height-alt:18px;line-height:18px;text-align:center;text-align-last:center;color:#ffffff;font-style:normal;font-weight:400;letter-spacing:-0.1px;">
                        <?php echo $email_footer_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                       </div>
                      </div>
                     </td>
                    </tr>
                   </table>
                  </td>
                 </tr>
                </table>
                <?php endif; ?>
               </td>
              </tr>
             </table>
            </td>
           </tr>
          </table>
          <!-- END MODULE: Footer -->
         </td>
        </tr>
        </table>
      </td>
     </tr>
    </table>
   </td>
  </tr>
 </table>
</body>

</html>
