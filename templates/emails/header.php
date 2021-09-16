<?php
/**
*
* @package Cariera
*
* @since 1.4.4
* 
* ========================
* EMAIL HEADER TEMPLATE
* ========================
*     
**/



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site_title = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
$main_color = cariera_get_option('cariera_main_color');
?>


<!-- <!DOCTYPE html> -->
<html <?php language_attributes() ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width">

    <style>
        html { background: #f1f2f6; }
        body { 
            font-family: sans-serif; 
            -webkit-font-smoothing: antialiased; 
            font-size: 16px;
            line-height: 1.4; 
            -ms-text-size-adjust: 100%; 
            -webkit-text-size-adjust: 100%; 
            margin: 0; 
            padding: 0; 
            min-width: 100% !important; 
        }
        img { border: none; -ms-interpolation-mode: bicubic; max-width: 100%; }
        .content { width: 100%; max-width: 600px; border: 1px solid #e3e3e3; border-radius: 3px; overflow: hidden; }
        .main { padding: 80px 0; color: #666; font-family: sans-serif; }
        .main a { text-decoration: none; }
        .header { padding: 20px; }
        .innerpadding { padding: 30px; }
        .borderbottom { border-bottom: 1px solid #e3e3e3; }
        .title { text-align: center; text-transform: uppercase; }
        .title a { font-size: 32px; line-height: 40px; color: #fff; }
        .subhead { text-align: center; font-size: 12px; color: #fff; }
        .h1 { text-align: center; font-size: 30px; color: #fff; }
        .h2 { padding: 0 0 15px 0; font-size: 16px; line-height: 28px; font-weight: bold; }
        .h3 { font-size: 15px; text-decoration: underline; }
        .bodycopy { font-size: 14px; line-height: 22px; }
        .mssg { font-size: 12px; text-align: center; }
        .footer { padding: 20px 30px 15px 30px; border-top: 1px solid #f5f5f5; }
        .footer a { color: <?php echo esc_attr( $main_color ); ?> }
        .footercopy { font-size: 15px; color: #777777; }
        .footercopy a {}
        .social a { font-size: 14px; }
        @media screen and (max-width: 600px) { .main { padding: 0; } }

        #outlook a {
            padding: 0;
        }
        
        .ReadMsgBody {
            width: 100%;
        }
        
        .ExternalClass {
            width: 100%;
        }
        
        .ExternalClass * {
            line-height: 100%;
        }
        
        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        
        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <!--[if !mso]><!-->
    <style type="text/css">
        @media only screen and (max-width:480px) {
            @-ms-viewport {
                width: 320px;
            }
            @viewport {
                width: 320px;
            }
        }
    </style>
    <!--<![endif]-->
    <!--[if mso]>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->
    <!--[if lte mso 11]>
        <style type="text/css">
          .outlook-group-fix { width:100% !important; }
        </style>
        <![endif]-->


    <style type="text/css">
        @media only screen and (min-width:480px) {
            .mj-column-per-100 {
                width: 100% !important;
            }
        }
    </style>


    <style type="text/css">

    </style>


</head>


<!-- Body -->
<body yahoo bgcolor="#f5eddb">

    <div style="background-color:#f9f9f9;">


        <!--[if mso | IE]>
      <table
         align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


        <div style="background:#f9f9f9;background-color:#f9f9f9;Margin:0px auto;max-width:600px;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#f9f9f9;background-color:#f9f9f9;width:100%;">
                <tbody>
                    <tr>
                        <td style="border-bottom:#332096 solid 5px;direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                            <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
        </tr>
      
                  </table>
                <![endif]-->
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>


        <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      
      <table
         align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->


        <div style="background:#fff;background-color:#fff;Margin:0px auto;max-width:600px;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#fff;background-color:#fff;width:100%;">
                <tbody>
                    <tr>
                        <td style="border:#dddddd solid 1px;border-top:0px;direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                            <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td
               style="vertical-align:bottom;width:600px;"
            >
          <![endif]-->

                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:bottom;width:100%;">

                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:bottom;" width="100%">

                                    <tr>
                                        <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">

                                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:100%;">

                                                            <img height="auto" src="https://goxchain.stage.surf/wp-content/uploads/2021/04/go-chain-2-1.png" style="border:0;display:block;outline:none;text-decoration:none; width:50%; margin: auto;" width="50%" />

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>

                    <tr style="padding: 30px;">
                        <td class="innerpadding borderbottom">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">