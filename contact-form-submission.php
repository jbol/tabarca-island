<?php

// check for form submission - if it doesn't exist then send back to contact form
//if (!isset($_POST['save']) || $_POST['save'] != 'contact') {
//    header('Location: contact.php'); exit;
//}
    
// get the posted data
$name = $_POST['contact_name'];
$email_address = $_POST['contact_email'];
$phone = $_POST['contact_phone'];
$message = $_POST['contact_message'];
    
// check that a name was entered
if (empty($name))
	if ($_POST['save'] == "contacto"){
		$error = 'Nombre y apellidos requerido';
	}
	else {		
    	$error = 'You must enter your name.';
    }
// check that an email address was entered
elseif (empty($email_address)) 
	if ($_POST['save'] == "contacto"){
		$error = 'Dirección de email requerido';
	}
	else {		
    	$error = 'You must enter your email address.';
    }
    
// check for a valid email address
elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email_address))
    if ($_POST['save'] == "contacto"){
		$error = 'Dirección de email no valido';
	}
	else {		
    	$error = 'You must enter a valid email address.';
    }

// check that a phone number was entered
elseif (empty($message))
	if ($_POST['save'] == "contacto"){
		$error = 'Por favor, incluya un mensaje';
	}
	else {		
    	$error = 'You must enter a message.';
    }
// verify reCaptcha success
elseif(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
           if ($_POST['save'] == "contacto"){
              $error = 'Por favor intenta el captcha de nuevo';
           }
           else {
              $error = 'Please retry the captcha form.';
           }
        }
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ld-mgATAAAAAKSQ1G4PTtoHWFK665x4_fA-a2pK&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if($response.success==false){
           if ($_POST['save'] == "contacto"){
              $error = 'No se ha verificado correctamente el captcha, por favor intentalo de nuevo';
           }
           else {
              $error = 'Something went wrong, please retry the captcha form.';
           }
        }
    
        
// check if an error was found - if there was, send the user back to the form
if (isset($error)) {
	if ($_POST['save'] == "contacto"){
		header('Location: contacto.php?e='.urlencode($error)); exit;
	}
	else {		
    	header('Location: contact.php?e='.urlencode($error)); exit;
    }
    
}

$headers = "From: gayle@tabarcaisland.com\r\n"; 
$headers .= "Reply-To: $email_address\r\n";

// write the email content
$email_content = "Name: $name\n";
$email_content .= "Email Address: $email_address\n";
$email_content .= "Phone Number: $phone\n";
$email_content .= "Message:\n\n$message";
    
// send the email
//ENTER YOUR INFORMATION BELOW FOR THE FORM TO WORK!
mail ('jbcremades@gmail.com', 'Tabarca Island - Contact Form Submission', $email_content, $headers);
    
// send the user back to the form
if ($_POST['save'] == "contacto"){
    header('Location: contacto.php?s='.urlencode('Gracias! Estaremos en contacto')); exit;
}
else {
    header('Location: contact.php?s='.urlencode('Thank you for your message.')); exit;
}
?>