<?php

if (!function_exists('renderURL')) {
    function renderURL($path, $returnUrl = false)
    {
        $url = "https://" . $_SERVER['SERVER_NAME'] . "/$path";

        if ($returnUrl) return $url;
        echo $url;
    }
}

if (!function_exists('sendEmail')) {
    function sendEmail(string $subject, string $name, string $phone, string $user_mail, string $message): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_ADDRESS;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = MAIL_PORT;

            $mail->setFrom(MAIL_ADDRESS, MAIL_NAME);
            $mail->addAddress('info@ggc-international.com', 'GGC - INFO');

            $mail->isHTML(true);
            $mail->Subject = 'Subject : ' . $subject;
            $mail->Body = "Contact Name : $name <br>Contact Phone : $phone <br>Contact Mail : $user_mail<br>Message Subject : $subject<br> Message : $message";
            return $mail->send();
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('showFlashMessage')) {
    function showFlashMessage($type, $message, $duration = 5): void
    {
        $validTypes = ['success', 'warning', 'error', 'info'];

        if (!in_array($type, $validTypes)) {
            $type = 'info';
        }

        $_SESSION['flash_message'] = [
            'type' => $type,
            'text' => $message,
            'duration' => $duration,
            'timestamp' => time(),
        ];

        if (isset($_SESSION['flash_message'])) {
            $flash = $_SESSION['flash_message'];

            if ((time() - $flash['timestamp']) <= $flash['duration']) {
                $iconClass = match ($flash['type']) {
                    'success' => 'fa-regular fa-badge-check fa-beat',
                    'error' => 'fa-regular fa-ban-bug fa-beat',
                    'warning' => 'fa-regular fa-triangle-exclamation fa-beat',
                    default => 'fa-regular fa-circle-info fa-beat',
                };

                echo '<div id="flash-message" class="flash-message ' . $flash['type'] . '" data-duration="' . $duration . '"><div class="inner d-flex align-items-center"><i class="' . $iconClass . '"></i><span>' . $flash['text'] . '</span></div></div>';
            }

            unset($_SESSION['flash_message']);
        }
    }
}

if (!function_exists('validateImage')) {
    function validateImage($file, $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'], $maxSize = 5000000): true|string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "Une erreur est survenue lors du téléchargement de l'image.";
        }

        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions, true)) {
            return "Format d'image non valide. Les formats autorisés sont: " . implode(', ', $allowedExtensions) . ".";
        }

        if ($fileSize > $maxSize) {
            return "Le fichier est trop volumineux. La taille maximale autorisée est de " . ($maxSize / 1000000) . " Mo.";
        }

        return true;
    }
}

if (!function_exists('generatePassword')) {
    function generatePassword($length = 12): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }
}

if (!function_exists('isUserLoggedIn')) {
    function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('redirectToLoginIfNotAuthenticated')) {
    function redirectToLoginIfNotAuthenticated(): void
    {
        if (!isUserLoggedIn()) {
            header("Location: /admin/auth/login.php");
            exit();
        }
    }
}

if (!function_exists('redirectToDashboardIfAuthenticated')) {
    function redirectToDashboardIfAuthenticated(): void
    {
        if (isUserLoggedIn()) {
            header("Location: /admin/");
            exit();
        }
    }
}

if (!function_exists('getAuthenticatedUser')) {
    function getAuthenticatedUser()
    {
        if (isset($_SESSION['user_id'])) {
            $db = (new Database())->getConnection();
            $query = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }
}
