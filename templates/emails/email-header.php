<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.7.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );
$store_name                 = $store_name ?? get_bloginfo( 'name', 'display' );

/**
 * Filter the URL used for the email header image/logo link.
 *
 * Return an empty string to disable the link.
 *
 * @since 10.7.0
 * @param string $url The URL to link to. Defaults to the site home URL.
 */
$header_image_url = apply_filters( 'woocommerce_email_header_image_url', home_url() );

?>
<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" <?php language_attributes(); ?>>

<head>
 <meta charset="UTF-8" />
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <!--[if !mso]><!-- -->
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <!--<![endif]-->
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <meta name="format-detection" content="telephone=no, date=no, address=no, email=no" />
 <meta name="x-apple-disable-message-reformatting" />
 <link href="https://fonts.googleapis.com/css?family=DM+Sans:ital,wght@0,400;0,400;0,500;0,600;0,700;0,800" rel="stylesheet" />
 <link href="https://fonts.googleapis.com/css?family=Rubik:ital,wght@0,400;0,400;0,500;0,600" rel="stylesheet" />
 <title><?php echo esc_html( $store_name ); ?></title>

 <style>
 html, body { margin: 0 !important; padding: 0 !important; min-height: 100% !important; width: 100% !important; -webkit-font-smoothing: antialiased; }
         * { -ms-text-size-adjust: 100%; }
         #outlook a { padding: 0; }
         .ReadMsgBody, .ExternalClass { width: 100%; }
         .ExternalClass, .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font { line-height: 100%; }
         table, td, th { mso-table-lspace: 0 !important; mso-table-rspace: 0 !important; border-collapse: collapse; }
         u + .body table, u + .body td, u + .body th { will-change: transform; }
         body, td, th, p, div, li, a, span { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-line-height-rule: exactly; }
         img { border: 0; outline: 0; line-height: 100%; text-decoration: none; -ms-interpolation-mode: bicubic; }
         a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; }
         .body .pc-project-body { background-color: transparent !important; }
                 
 
         @media (min-width: 621px) {
             .pc-lg-hide {  display: none; } 
             .pc-lg-bg-img-hide { background-image: none !important; }
         }
 </style>
 <style>
 @media (max-width: 620px) {
 .pc-project-body {min-width: 0px !important;}
 .pc-project-container {width: 100% !important;}
 .pc-sm-hide, .pc-w620-gridCollapsed-1 > tbody > tr > .pc-sm-hide {display: none !important;}
 .pc-sm-bg-img-hide {background-image: none !important;}
 .pc-w620-itemsSpacings-0-20 {padding-left: 0px !important;padding-right: 0px !important;padding-top: 10px !important;padding-bottom: 10px !important;}
 table.pc-w620-spacing-0-0-24-0 {margin: 0px 0px 24px 0px !important;}
 td.pc-w620-spacing-0-0-24-0,th.pc-w620-spacing-0-0-24-0{margin: 0 !important;padding: 0px 0px 24px 0px !important;}
 .pc-w620-padding-0-0-0-0 {padding: 0px 0px 0px 0px !important;}
 .pc-w620-valign-top {vertical-align: top !important;}
 td.pc-w620-halign-left,th.pc-w620-halign-left {text-align: left !important;}
 table.pc-w620-halign-left {float: none !important;margin-right: auto !important;margin-left: 0 !important;}
 img.pc-w620-halign-left {margin-right: auto !important;margin-left: 0 !important;}
 div.pc-w620-align-left,th.pc-w620-align-left,a.pc-w620-align-left,td.pc-w620-align-left {text-align: left !important;text-align-last: left !important;}
 table.pc-w620-align-left{float: none !important;margin-right: auto !important;margin-left: 0 !important;}
 img.pc-w620-align-left{margin-right: auto !important;margin-left: 0 !important;}
 .pc-w620-width-fill {width: 100% !important;}
 .pc-w620-width-30pc {width: 30% !important;}
 .pc-w620-radius-none {border-radius: 0px !important;}
 .pc-w620-width-175 {width: 175px !important;}
 .pc-w620-height-auto {height: auto !important;}
 .pc-w620-valign-middle {vertical-align: middle !important;}
 td.pc-w620-halign-right,th.pc-w620-halign-right {text-align: right !important;}
 table.pc-w620-halign-right {float: none !important;margin-right: 0 !important;margin-left: auto !important;}
 img.pc-w620-halign-right {margin-right: 0 !important;margin-left: auto !important;}
 .pc-w620-width-100pc {width: 100% !important;}
 .pc-w620-itemsSpacings-24-0 {padding-left: 12px !important;padding-right: 12px !important;padding-top: 0px !important;padding-bottom: 0px !important;}
 
 .pc-w620-width-hug {width: auto !important;}
 div.pc-w620-align-right,th.pc-w620-align-right,a.pc-w620-align-right,td.pc-w620-align-right {text-align: right !important;text-align-last: right !important;}
 table.pc-w620-align-right{float: none !important;margin-left: auto !important;margin-right: 0 !important;}
 img.pc-w620-align-right{margin-right: 0 !important;margin-left: auto !important;}
 div.pc-w620-textAlign-right,th.pc-w620-textAlign-right,a.pc-w620-textAlign-right,td.pc-w620-textAlign-right {text-align: right !important;text-align-last: right !important;}
 table.pc-w620-textAlign-right{float: none !important;margin-left: auto !important;margin-right: 0 !important;}
 img.pc-w620-textAlign-right{margin-right: 0 !important;margin-left: auto !important;}
 .pc-w620-padding-40-24-40-24 {padding: 40px 24px 40px 24px !important;}
 table.pc-w620-spacing-0-0-0-0 {margin: 0px 0px 0px 0px !important;}
 td.pc-w620-spacing-0-0-0-0,th.pc-w620-spacing-0-0-0-0{margin: 0 !important;padding: 0px 0px 0px 0px !important;}
 .pc-w620-font-size-32px {font-size: 32px !important;}
 .pc-w620-line-height-32px {line-height: 32px !important;}
 .pc-w620-font-size-14px {font-size: 14px !important;}
 .pc-w620-line-height-140pc {line-height: 140% !important;}
 .pc-w620-padding-24-0-0-0 {padding: 24px 0px 0px 0px !important;}
 .pc-w620-itemsSpacings-0-30 {padding-left: 0px !important;padding-right: 0px !important;padding-top: 15px !important;padding-bottom: 15px !important;}
 .pc-w620-padding-0-6-0-6 {padding: 0px 6px 0px 6px !important;}
 .pc-w620-width-auto {width: auto !important;}
 .pc-w620-width-60 {width: 60px !important;}
 
 img.pc-w620-width-60-min {min-width: 60px !important;}
 .pc-w620-height-2 {height: 2px !important;}
 table.pc-w620-spacing-0-0-34-0 {margin: 0px 0px 34px 0px !important;}
 td.pc-w620-spacing-0-0-34-0,th.pc-w620-spacing-0-0-34-0{margin: 0 !important;padding: 0px 0px 34px 0px !important;}
 .pc-w620-padding-30-0-30-0 {padding: 30px 0px 30px 0px !important;}
 .pc-w620-padding-15-30-15-30 {padding: 15px 30px 15px 30px !important;}
 .pc-w620-font-size-24px {font-size: 24px !important;}
 .pc-w620-line-height-40px {line-height: 40px !important;}
 table.pc-w620-spacing-0-0-20-0 {margin: 0px 0px 20px 0px !important;}
 td.pc-w620-spacing-0-0-20-0,th.pc-w620-spacing-0-0-20-0{margin: 0 !important;padding: 0px 0px 20px 0px !important;}
 .pc-w620-font-size-16px {font-size: 16px !important;}
 .pc-w620-line-height-28px {line-height: 28px !important;}
 table.pc-w620-spacing-0-0-5-0 {margin: 0px 0px 5px 0px !important;}
 td.pc-w620-spacing-0-0-5-0,th.pc-w620-spacing-0-0-5-0{margin: 0 !important;padding: 0px 0px 5px 0px !important;}
 table.pc-w620-spacing-15-16-0-0 {margin: 15px 16px 0px 0px !important;}
 td.pc-w620-spacing-15-16-0-0,th.pc-w620-spacing-15-16-0-0{margin: 0 !important;padding: 15px 16px 0px 0px !important;}
 .pc-w620-width-64 {width: 64px !important;}
 
 img.pc-w620-width-64-min {min-width: 64px !important;}
 .pc-w620-height-64 {height: 64px !important;}
 .pc-w620-view-vertical,.pc-w620-view-vertical > tbody,.pc-w620-view-vertical > tbody > tr,.pc-w620-view-vertical > tbody > tr > th,.pc-w620-view-vertical > tr,.pc-w620-view-vertical > tr > th {display: inline-block;width: 100% !important;}
 div.pc-w620-textAlign-left,th.pc-w620-textAlign-left,a.pc-w620-textAlign-left,td.pc-w620-textAlign-left {text-align: left !important;text-align-last: left !important;}
 table.pc-w620-textAlign-left{float: none !important;margin-right: auto !important;margin-left: 0 !important;}
 img.pc-w620-textAlign-left{margin-right: auto !important;margin-left: 0 !important;}
 .pc-w620-line-height-26px {line-height: 26px !important;}
 .pc-w620-line-height-20px {line-height: 20px !important;}
 .pc-w620-padding-28-32-24-16 {padding: 28px 32px 24px 16px !important;}
 .pc-w620-padding-32-24-32-24 {padding: 32px 24px 32px 24px !important;}
 .pc-w620-fontSize-24px {font-size: 24px !important;}
 .pc-w620-lineHeight-40 {line-height: 40px !important;}
 .pc-w620-radius-10-10-10-10 {border-radius: 10px 10px 10px 10px !important;}
 .pc-w620-itemsSpacings-0-4 {padding-left: 0px !important;padding-right: 0px !important;padding-top: 2px !important;padding-bottom: 2px !important;}
 td.pc-w620-halign-center,th.pc-w620-halign-center {text-align: center !important;}
 table.pc-w620-halign-center {float: none !important;margin-right: auto !important;margin-left: auto !important;}
 img.pc-w620-halign-center {margin-right: auto !important;margin-left: auto !important;}
 .pc-w620-padding-16-24-16-24 {padding: 16px 24px 16px 24px !important;}
 .pc-w620-itemsSpacings-0-16 {padding-left: 0px !important;padding-right: 0px !important;padding-top: 8px !important;padding-bottom: 8px !important;}
 .pc-w620-text-align-left {text-align: left !important;text-align-last: left !important;}
 .pc-w620-padding-32-0-4-0 {padding: 32px 0px 4px 0px !important;}
 table.pc-w620-spacing-10-0-0-0 {margin: 10px 0px 0px 0px !important;}
 td.pc-w620-spacing-10-0-0-0,th.pc-w620-spacing-10-0-0-0{margin: 0 !important;padding: 10px 0px 0px 0px !important;}
 .pc-w620-padding-24-24-24-24 {padding: 24px 24px 24px 24px !important;}
 .pc-w620-itemsSpacings-0-0 {padding-left: 0px !important;padding-right: 0px !important;padding-top: 0px !important;padding-bottom: 0px !important;}
 .pc-w620-padding-25-35-0-35 {padding: 25px 35px 0px 35px !important;}
 
 .pc-w620-gridCollapsed-1 > tbody,.pc-w620-gridCollapsed-1 > tbody > tr,.pc-w620-gridCollapsed-1 > tr {display: inline-block !important;}
 .pc-w620-gridCollapsed-1.pc-width-fill > tbody,.pc-w620-gridCollapsed-1.pc-width-fill > tbody > tr,.pc-w620-gridCollapsed-1.pc-width-fill > tr {width: 100% !important;}
 .pc-w620-gridCollapsed-1.pc-w620-width-fill > tbody,.pc-w620-gridCollapsed-1.pc-w620-width-fill > tbody > tr,.pc-w620-gridCollapsed-1.pc-w620-width-fill > tr {width: 100% !important;}
 .pc-w620-gridCollapsed-1 > tbody > tr > td,.pc-w620-gridCollapsed-1 > tr > td {display: block !important;width: auto !important;padding-left: 0 !important;padding-right: 0 !important;margin-left: 0 !important;}
 .pc-w620-gridCollapsed-1.pc-width-fill > tbody > tr > td,.pc-w620-gridCollapsed-1.pc-width-fill > tr > td {width: 100% !important;}
 .pc-w620-gridCollapsed-1.pc-w620-width-fill > tbody > tr > td,.pc-w620-gridCollapsed-1.pc-w620-width-fill > tr > td {width: 100% !important;}
 .pc-w620-gridCollapsed-1 > tbody > .pc-grid-tr-first > .pc-grid-td-first,.pc-w620-gridCollapsed-1 > .pc-grid-tr-first > .pc-grid-td-first {padding-top: 0 !important;}
 .pc-w620-gridCollapsed-1 > tbody > .pc-grid-tr-last > .pc-grid-td-last,.pc-w620-gridCollapsed-1 > .pc-grid-tr-last > .pc-grid-td-last {padding-bottom: 0 !important;}
 
 .pc-w620-gridCollapsed-0 > tbody > .pc-grid-tr-first > td,.pc-w620-gridCollapsed-0 > .pc-grid-tr-first > td {padding-top: 0 !important;}
 .pc-w620-gridCollapsed-0 > tbody > .pc-grid-tr-last > td,.pc-w620-gridCollapsed-0 > .pc-grid-tr-last > td {padding-bottom: 0 !important;}
 .pc-w620-gridCollapsed-0 > tbody > tr > .pc-grid-td-first,.pc-w620-gridCollapsed-0 > tr > .pc-grid-td-first {padding-left: 0 !important;}
 .pc-w620-gridCollapsed-0 > tbody > tr > .pc-grid-td-last,.pc-w620-gridCollapsed-0 > tr > .pc-grid-td-last {padding-right: 0 !important;}
 
 .pc-w620-tableCollapsed-1 > tbody,.pc-w620-tableCollapsed-1 > tbody > tr,.pc-w620-tableCollapsed-1 > tr {display: block !important;}
 .pc-w620-tableCollapsed-1.pc-width-fill > tbody,.pc-w620-tableCollapsed-1.pc-width-fill > tbody > tr,.pc-w620-tableCollapsed-1.pc-width-fill > tr {width: 100% !important;}
 .pc-w620-tableCollapsed-1.pc-w620-width-fill > tbody,.pc-w620-tableCollapsed-1.pc-w620-width-fill > tbody > tr,.pc-w620-tableCollapsed-1.pc-w620-width-fill > tr {width: 100% !important;}
 .pc-w620-tableCollapsed-1 > tbody > tr > td,.pc-w620-tableCollapsed-1 > tr > td {display: block !important;width: auto !important;}
 .pc-w620-tableCollapsed-1.pc-width-fill > tbody > tr > td,.pc-w620-tableCollapsed-1.pc-width-fill > tr > td {width: 100% !important;box-sizing: border-box !important;}
 .pc-w620-tableCollapsed-1.pc-w620-width-fill > tbody > tr > td,.pc-w620-tableCollapsed-1.pc-w620-width-fill > tr > td {width: 100% !important;box-sizing: border-box !important;}
 }
 @media (max-width: 520px) {
 .pc-w520-padding-15-25-15-25 {padding: 15px 25px 15px 25px !important;}
 .pc-w520-padding-25-30-0-30 {padding: 25px 30px 0px 30px !important;}
 }
 </style>
 <!--[if !mso]><!-- -->
 <style>
 @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 800; src: url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAIptRR23w.woff') format('woff'), url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAIptRR232.woff2') format('woff2'); } @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 400; src: url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAopxRR23w.woff') format('woff'), url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAopxRR232.woff2') format('woff2'); } @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 500; src: url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAkJxRR23w.woff') format('woff'), url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAkJxRR232.woff2') format('woff2'); } @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 700; src: url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwARZtRR23w.woff') format('woff'), url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwARZtRR232.woff2') format('woff2'); } @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 600; src: url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAfJtRR23w.woff') format('woff'), url('https://fonts.gstatic.com/s/dmsans/v15/rP2tp2ywxg089UriI5-g4vlH9VoD8CmcqZG40F9JadbnoEwAfJtRR232.woff2') format('woff2'); } @font-face { font-family: 'Rubik'; font-style: normal; font-weight: 400; src: url('https://fonts.gstatic.com/s/rubik/v28/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-B4iFWUUz.woff') format('woff'), url('https://fonts.gstatic.com/s/rubik/v28/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-B4iFWUU1.woff2') format('woff2'); } @font-face { font-family: 'Rubik'; font-style: normal; font-weight: 500; src: url('https://fonts.gstatic.com/s/rubik/v28/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-NYiFWUUz.woff') format('woff'), url('https://fonts.gstatic.com/s/rubik/v28/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-NYiFWUU1.woff2') format('woff2'); } @font-face { font-family: 'Rubik'; font-style: normal; font-weight: 600; src: url('https://fonts.gstatic.com/s/rubik/v28/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-2Y-FWUUz.woff') format('woff'), url('https://fonts.gstatic.com/s/rubik/v28/iJWZBXyIfDnIV5PNhY1KTN7Z-Yh-2Y-FWUU1.woff2') format('woff2'); }
 </style>
 <!--<![endif]-->
 <!--[if mso]>
    <style type="text/css">
        .pc-font-alt {
            font-family: Arial, Helvetica, sans-serif !important;
        }
    </style>
    <![endif]-->
 <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
</head>

<body class="body pc-font-alt" style="width: 100% !important; min-height: 100% !important; margin: 0 !important; padding: 0 !important; font-weight: normal; color: #2D3A41; mso-line-height-rule: exactly; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-variant-ligatures: normal; text-rendering: optimizeLegibility; -moz-osx-font-smoothing: grayscale; background-color: #ffffff;" bgcolor="#ffffff">
 <table class="pc-project-body" style="table-layout: fixed; width: 100%; min-width: 600px; background-color: #ffffff;" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" role="presentation">
  <tr>
   <td align="center" valign="top" style="width:auto;">
    <table class="pc-project-container" align="center" style="width: 600px; max-width: 600px;" border="0" cellpadding="0" cellspacing="0" role="presentation">
     <tr>
      <td style="padding: 20px 0px 20px 0px;" align="left" valign="top">
       <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
       <tr>
         <td valign="top">
          <!-- BEGIN MODULE: Header -->
          <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
           <tr>
            <td class="pc-w620-spacing-0-0-0-0" width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
              <tr>
               <td valign="top" class="pc-w620-padding-24-0-0-0" style="height: unset; background-color: #ffffff;" bgcolor="#ffffff">
                <table class="pc-w620-width-fill" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                 <tr>
                  <td class="pc-w620-spacing-0-0-24-0 pc-w620-valign-top pc-w620-align-left" style="padding: 0px 0px 24px 0px;">
                   <table class="pc-width-fill pc-w620-gridCollapsed-0 pc-w620-width-fill pc-w620-halign-left" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                    <tr class="pc-grid-tr-first pc-grid-tr-last">
                     <td class="pc-grid-td-first pc-w620-itemsSpacings-0-20" align="left" valign="top" style="width: 50%; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">
                      <table class="pc-w620-width-30pc pc-w620-halign-left" border="0" cellpadding="0" cellspacing="0" role="presentation">
                       <tr>
                        <td class="pc-w620-radius-none pc-w620-halign-left pc-w620-valign-top" align="left" valign="middle">
                         <table class="pc-w620-halign-left" align="left" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                           <td class="pc-w620-halign-left" align="left" valign="top" style="line-height: 1;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                             <tr>
                              <td class="pc-w620-halign-left" align="left" valign="top">

                               <?php
									$img = get_option( 'woocommerce_email_header_image' );
									/**
									 * This filter is documented in templates/emails/email-styles.php
									 *
									 * @since 9.6.0
									 */
									if ( apply_filters( 'woocommerce_is_email_preview', false ) ) {
										$img_transient = get_transient( 'woocommerce_email_header_image' );
										$img           = false !== $img_transient ? $img_transient : $img;
									}

									if ( $email_improvements_enabled ) :
										
										
                                        
                                        if ( $img ) {
											$image_html = '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $store_name ) . '" class="pc-w620-width-175 pc-w620-height-auto pc-w620-align-left" width="152" height="auto" style="display: block; outline: 0; line-height: 100%; -ms-interpolation-mode: bicubic; width: 45%; height: auto; border: 0;"/>';
											if ( $header_image_url ) {
												// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $image_html is built from esc_url() and esc_attr().
												echo '<a href="' . esc_url( $header_image_url ) . '" style="display: inline-block; text-decoration: none;" target="_blank">' . $image_html . '</a>';
											} else {
												// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												echo $image_html;
											}
                                        } elseif ( $header_image_url ) {
											echo '<a href="' . esc_url( $header_image_url ) . '" style="color: inherit; text-decoration: none;" target="_blank">' . esc_html( $store_name ) . '</a>';
										} else {
											echo esc_html( $store_name );
										}
                                        ?>
												
									<?php else : ?>
										<div id="template_header_image">
											<?php
											if ( $img ) {
												$image_html = '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $store_name ) . '" />';
												if ( $header_image_url ) {
													// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $image_html is built from esc_url() and esc_attr().
													echo '<a href="' . esc_url( $header_image_url ) . '" style="display: inline-block; text-decoration: none;" target="_blank">' . $image_html . '</a>';
												} else {
													// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													echo $image_html;
												}
											}
											?>
										</div>
									<?php endif; ?>

                              </td>
                             </tr>
                            </table>
                           </td>
                          </tr>
                         </table>
                        </td>
                       </tr>
                      </table>
                     </td>
                     <td class="pc-grid-td-last pc-w620-itemsSpacings-0-20" align="left" valign="top" style="width: 50%; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">
                      <table class="pc-w620-width-fill pc-w620-halign-left" style="width: 100%; height: 100%;" border="0" cellpadding="0" cellspacing="0" role="presentation">
                       <tr>
                        <td class="pc-w620-halign-right pc-w620-valign-middle" align="right" valign="middle">
                         <table class="pc-w620-halign-right" align="right" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                           <td class="pc-w620-halign-right" align="right" valign="top">
                            <table class="pc-w620-halign-right" align="right" border="0" cellpadding="0" cellspacing="0" role="presentation">
                             <tr>
                              <td class="pc-w620-valign-middle pc-w620-halign-right" align="right">
                               <table class="pc-w620-halign-right pc-w620-width-hug" align="right" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                 <td style="width:unset;" valign="top">
                                  <table class="pc-width-hug pc-w620-gridCollapsed-0 pc-w620-width-hug pc-w620-halign-right" align="right" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                   <tr class="pc-grid-tr-first pc-grid-tr-last">
                                    <td class="pc-grid-td-first pc-grid-td-last pc-w620-itemsSpacings-24-0" valign="middle" style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">
                                     <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                      <tr>
                                       <td class="pc-w620-halign-right pc-w620-valign-middle" align="center" valign="middle">
                                        <table class="pc-w620-halign-right" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                         <tr>
                                          <td class="pc-w620-halign-right" align="center" valign="top">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                             <th valign="top" class="pc-w620-align-right" align="center" style="text-align: center; font-weight: normal;">
                                              <!--[if mso]>
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" class="pc-w620-align-right" align="center" style="border-collapse: separate; border-spacing: 0; margin-right: auto; margin-left: auto;">
            <tr>
                <td valign="middle" align="center" style="border-radius: 5px 5px 5px 5px; background-color: #ec7e30; text-align:center; color: #ffffff; padding: 14px 28px 14px 28px; mso-padding-left-alt: 0; margin-left:28px;" bgcolor="#ec7e30">
                                    <a class="pc-font-alt" style="display: inline-block; text-decoration: none; text-align: center;" href="https://tref-ik.nl/contact" target="_blank"><span style="font-size:17px;mso-line-height-alt:24px;line-height:24px;color:#ffffff;letter-spacing:-0.2px;font-weight:600;font-style:normal;display:inline-block;vertical-align:top;"><span style="display:inline-block;"><span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 17px; line-height: 24px;">Contact</span></span></span></a>
                                </td>
            </tr>
        </table>
        <![endif]-->
                                              <!--[if !mso]><!-- -->
                                              <a class="pc-w620-textAlign-right" style="display: inline-block; box-sizing: border-box; border-radius: 5px 5px 5px 5px; background-color: #ec7e30; padding: 14px 28px 14px 28px; vertical-align: top; text-align: center; text-align-last: center; text-decoration: none; -webkit-text-size-adjust: none;" href="https://tref-ik.nl/contact" target="_blank"><span style="font-size:17px;mso-line-height-alt:24px;line-height:24px;color:#ffffff;letter-spacing:-0.2px;font-weight:600;font-style:normal;display:inline-block;vertical-align:top;"><span style="display:inline-block;"><span style="font-family: 'DM Sans', Arial, Helvetica, sans-serif; font-size: 17px; line-height: 24px;">Contact</span></span></span></a>
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
                                    </td>
                                   </tr>
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
                        </td>
                       </tr>
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
            </td>
           </tr>
          </table>
          <!-- END MODULE: Header -->
         </td>
        </tr>