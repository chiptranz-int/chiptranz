<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
require 'vendor/autoload.php';


$conn= new mysqli("localhost", "chiptran_chuser", "NewChipTranz", "chiptran_chipdb");


if ($conn->connect_error) {
	# code...
	die("could not connect." .$conn->connect_error);
}



//	$sql="SELECT * From users where user_type<10";
		$sql="SELECT * From users where email ='jftobbi@gmail.com'";
	if($result=$conn->query($sql)){
		while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
			# code...
			$mails = $row['email'];
		$name=$row['name'];
	




// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 'resources@chiptranz.com';
$senderName = 'Chiptranz';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
//$recipient = '';
$recipient =$mails;

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AKIAVOLD67GMFI5A2JDI';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = 'BLUSRsv/iQouYJwu/iETMb3VIQ+Nh8RJrThuWNswsDRd';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
$configurationSet = 'chiptranz_config_set';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.us-west-2.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = 'Be Safe From Corona Virus: Safety tips from Chiptranz. 
';

// The plain-text body of the email
$bodyText =  "Email Test\r\nThis email was sent through the
    Amazon SES SMTP interface using the PHPMailer class.";

// The HTML-formatted body of the email
$bodyHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html data-editor-version="2" class="sg-campaigns" xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <!--<![endif]-->
      <!--[if (gte mso 9)|(IE)]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
      <!--[if (gte mso 9)|(IE)]>
  <style type="text/css">
    body {width: 600px;margin: 0 auto;}
    table {border-collapse: collapse;}
    table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
    img {-ms-interpolation-mode: bicubic;}
  </style>
<![endif]-->
      <style type="text/css">
    body, p, div {
      font-family: arial,helvetica,sans-serif;
      font-size: 14px;
    }
    body {
      color: #000000;
    }
    body a {
      color: #42ee99;
      text-decoration: none;
    }
    p { margin: 0; padding: 0; }
    table.wrapper {
      width:100% !important;
      table-layout: fixed;
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: 100%;
      -moz-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    img.max-width {
      max-width: 100% !important;
    }
    .column.of-2 {
      width: 50%;
    }
    .column.of-3 {
      width: 33.333%;
    }
    .column.of-4 {
      width: 25%;
    }
    @media screen and (max-width:480px) {
      .preheader .rightColumnContent,
      .footer .rightColumnContent {
        text-align: left !important;
      }
      .preheader .rightColumnContent div,
      .preheader .rightColumnContent span,
      .footer .rightColumnContent div,
      .footer .rightColumnContent span {
        text-align: left !important;
      }
      .preheader .rightColumnContent,
      .preheader .leftColumnContent {
        font-size: 80% !important;
        padding: 5px 0;
      }
      table.wrapper-mobile {
        width: 100% !important;
        table-layout: fixed;
      }
      img.max-width {
        height: auto !important;
        max-width: 100% !important;
      }
      a.bulletproof-button {
        display: block !important;
        width: auto !important;
        font-size: 80%;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .columns {
        width: 100% !important;
      }
      .column {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
      .social-icon-column {
        display: inline-block !important;
      }
    }
  </style>
      <!--user entered Head Start-->

     <!--End Head user entered-->
    </head>
    <body>
      <center class="wrapper" data-link-color="#42ee99" data-body-style="font-size:14px; font-family:arial,helvetica,sans-serif; color:#000000; background-color:#000000;">
        <div class="webkit">
          <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#000000">
            <tr>
              <td valign="top" bgcolor="#000000" width="100%">
                <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="100%">
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td>
                            <!--[if mso]>
    <center>
    <table><tr><td width="600">
  <![endif]-->
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;" align="center">
                                      <tr>
                                        <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#FFFFFF" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
    <tr>
      <td role="module-content">
        <p>Show What You Know!</p>
      </td>
    </tr>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="vB9TDziyvx65CC2nx3oyRH">
      <tbody><tr>
        <td style="padding:0px 0px 20px 0px;" role="module-content" bgcolor="#000000">
        </td>
      </tr>
    </tbody></table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="37c1DUYE1TN31PTwSNoaE7">
      <tbody><tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px; background-color:#000000;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:100% !important; width:100%; height:auto !important;" src="http://cdn.mcauto-images-production.sendgrid.net/544b898b9ed9e18e/5c8fa2b9-448e-464e-a0ad-0d5731da7bbf/299x169.jpg" alt="" width="600" data-responsive="true" data-proportionally-constrained="false">
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="qk51Jjn4bm3rn2Yb31Dxzb" data-mc-module-version="2019-10-22">
      <tbody><tr>
        <td style="background-color:#ffffff; padding:50px 50px 10px 50px; line-height:22px; text-align:center;" height="100%" valign="top" bgcolor="#ffffff"><div><div style="font-family: inherit; text-align: inherit"><span style="font-size: 24px; font-family: verdana, geneva, sans-serif"><strong>Wishing you a happy Children's day from all of us at Chiptranz&nbsp;</strong></span></div><div></div></div></td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="iTBXe9c6QUCujvmJs8hYKr" data-mc-module-version="2019-10-22">
      <tbody><tr>
        <td style="background-color:#ffffff; padding:40px 40px 40px 40px; line-height:22px; text-align:inherit;" height="100%" valign="top" bgcolor="#ffffff"><div><div style="font-family: inherit; text-align: inherit"><span style="font-size: 16px; font-family: verdana, geneva, sans-serif">We hope that our Children will lead a life of positive changes, actualize their dreams and fully express their potentials. For these, we must create for them a plan of financial freedom.</span>&nbsp;</div>
<div style="font-family: inherit; text-align: inherit"><span style="font-size: 16px; font-family: verdana, geneva, sans-serif">Create a savings plan today</span></div><div></div></div></td>
      </tr>
    </tbody></table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%" data-muid="qY8ouFUf6bFVP8tHkQ5gq7"><tbody><tr><td align="center" bgcolor="#ffffff" class="outer-td" style="padding:20px 20px 60px 20px; background-color:#ffffff;"><table border="0" cellpadding="0" cellspacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center"><tbody><tr><td align="center" bgcolor="#00dc73" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;"><a style="background-color:#00dc73; border:0px solid #08b65d; border-color:#08b65d; border-radius:0px; border-width:0px; color:#ffffff; display:inline-block; font-family:verdana,geneva,sans-serif; font-size:16px; font-weight:normal; letter-spacing:3px; line-height:30px; padding:12px 18px 12px 18px; text-align:center; text-decoration:none; border-style:solid;" href="https://chiptranz.com/login" target="_blank">CREATE PLAN</a></td></tr></tbody></table></td></tr></tbody></table><table class="module" role="module" data-type="divider" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="c3nRrjMndqXf1snYDFPSF9">
      <tbody><tr>
        <td style="padding:0px 0px 0px 0px;" role="module-content" height="100%" valign="top" bgcolor="#000000">
          <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" height="3px" style="line-height:3px; font-size:3px;">
            <tbody><tr>
              <td style="padding:0px 0px 3px 0px;" bgcolor="#42ee99"></td>
            </tr>
          </tbody></table>
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="pa9PeYjCEFyByuP5878Sd2">
      <tbody><tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="#000000">
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="vHVg85Rtcz7gagZZquA4Bw">
      <tbody><tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="#000000">
        </td>
      </tr>
    </tbody></table><div data-role="module-unsubscribe" class="module unsubscribe-css__unsubscribe___2CDlR" role="module" data-type="unsubscribe" style="background-color:#000000; color:#ffffff; font-size:12px; line-height:20px; padding:16px 16px 16px 16px; text-align:center;" data-muid="vqq9VGfbTmLsFG2U3YC8Fh"><div class="Unsubscribe--addressLine"></div><p style="font-family:verdana,geneva,sans-serif; font-size:12px; line-height:20px;"><a target="_blank" class="Unsubscribe--unsubscribeLink zzzzzzz" href="{{{unsubscribe}}}" style="color:#42ee99;">Unsubscribe</a> - <a href="{{{unsubscribe_preferences}}}" target="_blank" class="Unsubscribe--unsubscribePreferences" style="color:#42ee99;">Unsubscribe Preferences</a></p></div></td>
                                      </tr>
                                    </table>
                                    <!--[if mso]>
                                  </td>
                                </tr>
                              </table>
                            </center>
                            <![endif]-->
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </center>
    </body>
  </html>
	 ';

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "tls";
    $mail->addCustomHeader("X-SES-CONFIGURATION-SET", $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();
    echo "Email sent!" , PHP_EOL;
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}
}
}
?>
