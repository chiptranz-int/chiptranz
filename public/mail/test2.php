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



	$sql="SELECT * From users where user_type<10 and email='jftobbi@gmail.com'";
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
      font-family: verdana,geneva,sans-serif;
      font-size: 16px;
    }
    body {
      color: #516775;
    }
    body a {
      color: #993300;
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
      <center class="wrapper" data-link-color="#993300" data-body-style="font-size:16px; font-family:verdana,geneva,sans-serif; color:#516775; background-color:#F9F5F2;">
        <div class="webkit">
          <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#F9F5F2">
            <tr>
              <td valign="top" bgcolor="#F9F5F2" width="100%">
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
                                        <td role="modules-container" style="padding:0px 0px 0px 0px; color:#516775; text-align:left;" bgcolor="#F9F5F2" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
    <tr>
      <td role="module-content">
        <p>How Do Our Interest Rates Work?</p>
      </td>
    </tr>
  </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="4UqFsRLozLcypAAv4CeoFS">
      <tbody><tr>
        <td style="font-size:6px; line-height:10px; padding:30px 0px 0px 0px;" valign="top" align="left">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:70% !important; width:70%; height:auto !important;" src="http://cdn.mcauto-images-production.sendgrid.net/544b898b9ed9e18e/afcb4424-05fa-4263-b650-d8d721105de5/310x106.png" alt="How Do Our Interest Rates Work?" width="420" data-responsive="true" data-proportionally-constrained="false">
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="iqe7juSSgLbdm3gXWExpsY">
      <tbody><tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody></table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="eUYR8ZuwyTirQCAuyEc98X">
      <tbody><tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:100% !important; width:100%; height:auto !important;" src="http://cdn.mcauto-images-production.sendgrid.net/544b898b9ed9e18e/76d423a7-d7d6-4735-8773-6bf161fb0819/300x168.jfif" alt="" width="600" data-responsive="true" data-proportionally-constrained="false">
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="8VquPM2ZMj7RJRhAUE6wmF" data-mc-module-version="2019-10-22">
      <tbody><tr>
        <td style="background-color:#ffffff; padding:50px 0px 10px 0px; line-height:30px; text-align:inherit;" height="100%" valign="top" bgcolor="#ffffff"><div><div style="font-family: inherit; text-align: left"><span style="color: #516775; font-size: 28px; font-family: georgia, serif"><strong>Hello '.$name.'</strong></span></div><div></div></div></td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="keQHYG1b1ztewxwhDtuCpS" data-mc-module-version="2019-10-22">
      <tbody><tr>
        <td style="background-color:#ffffff; padding:10px 40px 20px 40px; line-height:22px; text-align:inherit;" height="100%" valign="top" bgcolor="#ffffff"><div><div style="font-family: inherit">Over the past couple of weeks, it is become clear that the world is facing an unprecedented challenge. Nigeria is not left out; several confirmed cases of the Corona Virus Disease have been recorded across different states.<br>
While we send our heartfelt wishes to those who have been affected by the virus whether directly or indirectly and wish them a speedy recovery, we urge you to take adequate precautions to protect yourself and loved ones from this unfortunate incident that has overwhelmed the entire globe.<br>
As you might know, the World Health Organization has released basic protective measures against the virus, some of which include, though not limited to washing your hands regularly, refraining from touching your eyes, nose, and mouth, practicing respiratory hygiene, social distancing, handshakes avoidance, among others. We understand it is human to panic in the face of a pandemic but it is more important to take extra measures to stay safe.<br>
<br>
We are positive we will rise above this pandemic. Please take care of yourselves and each other. You should also be rest assured that your savings with us at Chiptranz is secure from every invasion of any pandemic.<br>
<br>
Through your support and understanding, we believe we shall definitely get over this pandemic as a people, even as we take personal responsibility for preventing the spread.<br>
<br>
We encourage you to abide by the guidelines and precautions set by health authorities such as the World Health Organisation WHO and the National Center for Diseases Control NCDC.</div>
<div style="font-family: inherit"><br>
<br>
Stay Safe.</div>
<div style="font-family: inherit">Chiptranz</div><div></div></div></td>
      </tr>
    </tbody></table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed" width="100%" data-muid="hthYAt191yTdg6FPWYKodF"><tbody><tr><td align="center" bgcolor="#ffffff" class="outer-td" style="padding:0px 0px 40px 0px; background-color:#ffffff;"><table border="0" cellpadding="0" cellspacing="0" class="button-css__deep-table___2OZyb wrapper-mobile" style="text-align:center"><tbody><tr><td align="center" bgcolor="#993300" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;"><a style="background-color:#993300; border:1px solid #333333; border-color:#333333; border-radius:0px; border-width:1px; color:#ffffff; display:inline-block; font-family:verdana,geneva,sans-serif; font-size:16px; font-weight:normal; letter-spacing:1px; line-height:30px; padding:12px 20px 12px 20px; text-align:center; text-decoration:none; border-style:solid;" href="https://twitter.com/Chiptranz" target="_blank">Follow Us</a></td></tr></tbody></table></td></tr></tbody></table><table class="module" role="module" data-type="divider" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="jw3c3eYnz3qZ2aqby3rNPX">
      <tbody><tr>
        <td style="padding:0px 0px 0px 0px;" role="module-content" height="100%" valign="top" bgcolor="">
          <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" height="10px" style="line-height:10px; font-size:10px;">
            <tbody><tr>
              <td style="padding:0px 0px 10px 0px;" bgcolor="#ffffff"></td>
            </tr>
          </tbody></table>
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="noXVUxSTfKbdSVM2Xrua2t">
      <tbody><tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="divider" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="noLZCGp2Fg6viPoP15ufF1">
      <tbody><tr>
        <td style="padding:0px 0px 0px 0px;" role="module-content" height="100%" valign="top" bgcolor="">
          <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" height="10px" style="line-height:10px; font-size:10px;">
            <tbody><tr>
              <td style="padding:0px 0px 10px 0px;" bgcolor="#ffffff"></td>
            </tr>
          </tbody></table>
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="aQTmVGoZvs6GLJLWsiastG">
      <tbody><tr>
        <td style="padding:0px 0px 40px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody></table><table class="module" role="module" data-type="social" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="sLpvVMcymGiSrXMXabUBds">
      <tbody>
        <tr>
          <td valign="top" style="padding:0px 0px 0px 0px; font-size:6px; line-height:10px; background-color:#f9f5f2;" align="center">
            <table align="center">
              <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
      <a role="social-icon-link" href="https://www.facebook.com/chiptranz" target="_blank" alt="Facebook" title="Facebook" style="display:inline-block; background-color:#516775; height:30px; width:30px; border-radius:30px; -webkit-border-radius:30px; -moz-border-radius:30px;">
        <img role="social-icon" alt="Facebook" title="Facebook" src="https://marketing-image-production.s3.amazonaws.com/social/white/facebook.png" style="height:30px; width:30px;" height="30" width="30">
      </a>
    </td><td style="padding: 0px 5px;" class="social-icon-column">
      <a role="social-icon-link" href="https://twitter.com/chiptranz" target="_blank" alt="Twitter" title="Twitter" style="display:inline-block; background-color:#516775; height:30px; width:30px; border-radius:30px; -webkit-border-radius:30px; -moz-border-radius:30px;">
        <img role="social-icon" alt="Twitter" title="Twitter" src="https://marketing-image-production.s3.amazonaws.com/social/white/twitter.png" style="height:30px; width:30px;" height="30" width="30">
      </a>
    </td><td style="padding: 0px 5px;" class="social-icon-column">
      <a role="social-icon-link" href="https://www.instagram.com/chiptranz" target="_blank" alt="Instagram" title="Instagram" style="display:inline-block; background-color:#516775; height:30px; width:30px; border-radius:30px; -webkit-border-radius:30px; -moz-border-radius:30px;">
        <img role="social-icon" alt="Instagram" title="Instagram" src="https://marketing-image-production.s3.amazonaws.com/social/white/instagram.png" style="height:30px; width:30px;" height="30" width="30">
      </a>
    </td><td style="padding: 0px 5px;" class="social-icon-column">
      <a role="social-icon-link" href="https://www.pinterest.com/sendgrid/" target="_blank" alt="Pinterest" title="Pinterest" style="display:inline-block; background-color:#516775; height:30px; width:30px; border-radius:30px; -webkit-border-radius:30px; -moz-border-radius:30px;">
        <img role="social-icon" alt="Pinterest" title="Pinterest" src="https://marketing-image-production.s3.amazonaws.com/social/white/pinterest.png" style="height:30px; width:30px;" height="30" width="30">
      </a>
    </td></tr></tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table><div data-role="module-unsubscribe" class="module unsubscribe-css__unsubscribe___2CDlR" role="module" data-type="unsubscribe" style="color:#444444; font-size:12px; line-height:20px; padding:16px 16px 16px 16px; text-align:center;" data-muid="mQ1u1Awkou7szvSGChCGcV"><div class="Unsubscribe--addressLine"></div><p style="font-family:arial,helvetica,sans-serif; font-size:12px; line-height:20px;"><a target="_blank" class="Unsubscribe--unsubscribeLink zzzzzzz" href="{{{unsubscribe}}}" style="">Unsubscribe</a> - <a href="{{{unsubscribe_preferences}}}" target="_blank" class="Unsubscribe--unsubscribePreferences" style="">Unsubscribe Preferences</a></p></div><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="eAq5DwvRYWV4D7T3oBCXhH">
      <tbody><tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody></table></td>
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
