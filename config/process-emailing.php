<?php
require_once '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

require_once './helpers.php';
require_once './constants.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');

    $contactName = $_POST['contact-name'] ?? null;
    $contactPhone = $_POST['contact-phone'] ?? null;
    $contactMail = $_POST['contact-mail'] ?? null;
    $messageSubject = $_POST['message-subject'] ?? null;
    $message = $_POST['message'] ?? null;
    $error = null;

    if (!empty($contactName)) {
        if (!empty($contactPhone)) {
            if (!empty($contactMail)) {
                if (filter_var($contactMail, FILTER_VALIDATE_EMAIL)) {
                    if (!empty($messageSubject)) {
                        if (!empty($message)) {
                            if (sendEmail($messageSubject, $contactName, $contactPhone, $contactMail, $message)) {
                                $response = array(
                                    'success' => true,
                                    'message' => 'Message sent successfully. We will contact you as soon as possible.'
                                );
                            } else {
                                $error = 'Message could not be sent';
                            }
                        } else {
                            $error = 'Please enter your message.';
                        }
                    } else {
                        $error = 'Please enter the subject of the message.';
                    }
                } else {
                    $error = 'Invalid email format';
                }
            } else {
                $error = 'Please enter your email address.';
            }
        } else {
            $error = 'Please enter your phone number.';
        }
    } else {
        $error = 'Please enter your full name.';
    }

    if ($error !== null) {
        $response = array(
            'success' => false,
            'message' => $error
        );
    }

    ob_clean();
    echo json_encode($response);
} else {
    header('HTTP/1.0 403 Forbidden');
}