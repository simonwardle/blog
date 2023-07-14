<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
require 'includes/init.php';
require "includes/header.php";

$email = '';
$subject = '';
$message = '';
$sent = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $errors = [];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'Please enter a valid email address';
    }

    if ($subject == '') {
        $errors[] = 'Please enter a subject';
    }

    if ($message == '') {
        $errors[] = 'Please enter a message';
    }

    if (empty($errors)) {

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'email-smtp.eu-north-1.amazonaws.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'AKIA3BHRRZBOVANZBGPW';
            $mail->Password = 'BO+2+w6AjLse4TP5buttr9Y+OjZQrFfs/FH9AqMY7KJc';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;


            $mail->setFrom('wardle.simon@gmail.com');
            //$mail->setFrom('simonwardle@vivaldi.net');
            $mail->addAddress('simonwardle@vivaldi.net');
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();

            $sent = true;
        } catch (Exception $e) {
            $errors[] = $mail->ErrorInfo;
        }

    }
}
?>


<h2>Contact</h2>

<?php if ($sent) : ?>
    <p>Message sent.</p>
<?php else : ?>
    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" id="formContact">

        <div class="form-group mb-3">
            <label for="email">Your email</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="Your email" value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="form-group mb-3">
            <label for="subject">Subject</label>
            <input class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= htmlspecialchars($subject) ?>">
        </div>

        <div class="form-group mb-3">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="message" placeholder="Message" value="<?= htmlspecialchars($message) ?>"></textarea>
        </div>

        <button class="btn btn-primary">Send</button>

    </form>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>