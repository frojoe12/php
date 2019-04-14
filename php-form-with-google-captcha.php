<?php
	// start change to your own settings
		$public_key="111111"; // your public key for Google recaptcha
		$private_key="111111"; // your private key for Google recaptcha
		$main_email="me@me.com"; // email to send the completed contact form to
		$owner_name="My company name"; // name of the website ie My Website
		$header_from_email = "contact_form@mywebsite.com"; // email address for the contact form from address ie contact_form@mywebsite.com
	// end change to your own settings
?>

<?php
// ********* don't change below this point!!  **************/
$contact_name_error="none;";
$contact_email_error="none;";
$contact_phone_error="none;";
$contact_subject_error="none;";
$contact_message_error="none;";
$contact_hidden_field="no_js";
$contact_captcha_error="none";
$contact_captcha_allowed = false;
$form_ok=false;
$form_submitted=false;

if (isset($_POST['hidden_field'])) {
	$form_ok=true;
	$form_submitted=true;
	if ($_POST['hidden_field']=="javascript_on") {
		$contact_hidden_field = "js_ok";
	} else {
		$form_ok=false;
	}
} 

if (isset($_POST['g-recaptcha-response'])) {
	if ($_POST['g-recaptcha-response'] == "") {
		$contact_captcha_error="block; font-weight:bold;";
		$form_ok=false;
	} else {
	$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($private_key) .  '&response=' . urlencode($_POST['g-recaptcha-response']);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        if($responseKeys["success"]) {
                
                $contact_captcha_allowed = true;
        } else {
                $contact_captcha_allowed = false;
               	$form_ok=false;
        }
	}
	
}

if (isset($_POST['contact_name'])) {
	$contact_name=$_POST['contact_name'];
		if ($contact_name=="") {
			$contact_name_error = "block; font-weight:bold;";
			$form_ok=false;
		}
	}
if (isset($_POST['contact_email'])) {
	$contact_email=$_POST['contact_email'];
	if ($contact_email=="") {
			$contact_email_error = "block; font-weight:bold;";
			$form_ok=false;
		} else if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
   		 	$contact_email_error = "block; font-weight:bold;";
			$form_ok=false;
		}
	}
if (isset($_POST['contact_phone'])) {
	$contact_phone=$_POST['contact_phone'];
	if ($contact_phone=="") {
			$contact_phone_error = "block; font-weight:bold;";
			$form_ok=false;
		}
	}
if (isset($_POST['contact_subject'])) {
	$contact_subject=$_POST['contact_subject'];
	if ($contact_subject=="") {
			$contact_subject_error = "block; font-weight:bold;";
			$form_ok=false;
		}
}
if (isset($_POST['contact_message'])) {
	$contact_message=$_POST['contact_message'];
	if ($contact_message=="") {
			$contact_message_error = "block; font-weight:bold;";
			$form_ok=false;
		}
}
?>
<div style="width:auto; max-width:500px; background-image: linear-gradient(to bottom right, #e9e8df, #d2d0c1); margin:25px 0; padding:35px 14px; border-radius:8px; color:#000; font-size: 18px; border:1px solid #bbb;">

<?php
if (($form_ok) && ($form_submitted)) {
?>	
	<div style='margin-bottom:25px; color:#000; font-size:25px; line-height:35px;'>Thank you for contacting us, we will get back to you asap.<br /><br />Kind Regards<br /><?php echo $owner_name;?></div><br />
	<div style="margin-bottom:5px;">
		Name: <?php echo $contact_name;?>
	</div>
	<div style="margin-bottom:5px;">
		Email: <?php echo $contact_email;?>
	</div>
	<div style="margin-bottom:5px;">
		Phone: <?php echo $contact_phone;?>
	</div>
	<div style="margin-bottom:5px;">
		Subject: <?php echo $contact_subject;?>
	</div>
	<div style="margin-bottom:5px;">
		Message: <?php echo $contact_message;?>
	</div>
	
	
<?php

$to = $main_email;
$subject = "Enquiry from website - ".$contact_subject;

$message = "
<html>
<head>
<title>".$contact_message."</title>
</head>
<body>
<div style='font-size:16px; line-height:20px;'>
<p>Message from contact form on ".$owner_name." website</p>
<br />
<p>Name: ".$contact_name."</p>
<p>Email: ".$contact_email."</p>
<p>Phone: ".$contact_phone."</p>
<p>Subject: ".$contact_subject."</p>
<p>Message: ".$contact_message."</p>
</div>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: '.$header_from_email.'' . "\r\n";

mail($to,$subject,$message,$headers);

	
} else {
?>
<div style='margin-bottom:25px; color:#000; font-size:25px;'>Contact <?php echo $owner_name;?></div>
<form name="contact_form" method="POST" action="">
<div style="margin-bottom:5px;"><div style="display: inline-block; width:20%;">Name:</div><input style="width:75%; padding:5px; font-size:16px;" type="text" name="contact_name" value="<?php echo $contact_name;?>" /></div>
<div style='display: <?php echo $contact_name_error;?>; padding:0 0 5px 0; font-size:16px; color:#ff0000; margin-bottom:10px; padding:7px 4px;'>** Please input a name above.</div>
<div style="margin-bottom:5px; margin-top:12px;"><div style="display: inline-block; width:20%;">Email:</div><input style="width:75%; padding:5px; font-size:16px;" type="text" name="contact_email" value="<?php echo $contact_email;?>" /></div>
<div style='display: <?php echo $contact_email_error;?>; padding:0 0 5px 0; font-size:16px; color:#ff0000; margin-bottom:10px; padding:7px 4px;'>** Please input a valid email address above.</div>
<div style="margin-bottom:5px; margin-top:12px;"><div style="display: inline-block; width:20%;">Telephone:</div><input style="width:75%; padding:5px; font-size:16px;" type="text" name="contact_phone" value="<?php echo $contact_phone;?>" /></div>
<div style='display: <?php echo $contact_phone_error;?>; padding:0 0 5px 0; font-size:16px; color:#ff0000; margin-bottom:10px; padding:7px 4px;'>** Please input a valid telephone above.</div>
<div style="margin-bottom:5px; margin-top:12px;"><div style="display: inline-block; width:20%;">Subject:</div><input style="width:75%; padding:5px; font-size:16px;" type="text" name="contact_subject" value="<?php echo $contact_subject;?>" /></div>
<div style='display: <?php echo $contact_subject_error;?>;  padding:0 0 5px 0; font-size:16px; color:#ff0000; margin-bottom:10px; padding:7px 4px;'>** Please input a subject.</div>
<div style="margin-bottom:5px; margin-top:12px;"><div style="display: inline-block; width:95%;">Message:</div><textarea style="width:98%; margin-top:5px;padding:5px; font-size:16px; min-height:100px;" name="contact_message"><?php echo $contact_message;?></textarea></div>
<div style='display: <?php echo $contact_message_error;?>;  padding:0 0 5px 0; font-size:16px; color:#ff0000; margin-bottom:10px; padding:7px 4px;'>** Please type a message into the box above.</div>
<div style='margin-top:10px;' class="g-recaptcha" data-sitekey="<?php echo $public_key;?>"></div>
<div style='display: <?php echo $contact_captcha_error;?>;  padding:0 0 5px 0; font-size:16px; color:#ff0000; margin-bottom:10px; padding:7px 4px;'>** Please tick the "I am not a robot" checkbox above.</div>


<input style="display:none;" name="hidden_field" class="hidden_field" />

<input style="margin-top:15px; font-size:16px; padding:10px; background:#2cba1d; border:3px solid #9bd195;color:#fff; border-radius:5px; webkit-display:none;" type="submit" name="submit" value="Send Message" />
</form>
<script type='text/javascript' async >
	document.querySelector(".hidden_field").value="javascript_on";
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php	
}
?>
</div>
