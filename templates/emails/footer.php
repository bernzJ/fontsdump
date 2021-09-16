<?php
/**
*
* @package Cariera
*
* @since 1.4.4
* 
* ========================
* EMAIL FOOTER TEMPLATE
* ========================
*     
**/



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


<table align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%; ">
<tr>
<td align="center" style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:20px;word-break:break-word;">
</td>
</tr>
<tr>
    <td align="center" bgcolor="#2F67F6" role="presentation" style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">
        <a href="<?=get_home_url() . '/login-register';?>" style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
        Sign in
        </a>
    </td>
</tr>
</table>


<?php

$site_title = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
$main_color = cariera_get_option('cariera_main_color');
?>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer" bgcolor="#f6f6f6">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" class="footercopy">
                                        <?php echo date('Y'); ?> &#169; <a href="<?php echo home_url('/'); ?>" style="color: <?php echo esc_attr( $main_color ); ?>"><?php echo esc_html( $site_title ); ?></a> <?php esc_html_e( 'All Rights Reserved.', 'cariera' ); ?>
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