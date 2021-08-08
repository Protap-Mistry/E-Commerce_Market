<?php

    require "vendor/autoload.php";

    $sender = 'pro.cse4.bu@gmail.com';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    $developmentMode = true;
    $mailer = new PHPMailer($developmentMode);
    $mailer->Mailer = "smtp";

    try 
    {
        $mailer->SMTPDebug = 2;
        $mailer->isSMTP();

        if ($developmentMode) 
        {
            $mailer->SMTPOptions = [
                'ssl'=> [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                ]
            ];
        }


        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = $sender;
        $mailer->Password = 'protap@12345@mistry';
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;

        $mailer->setFrom($sender, 'Author');
        $mailer->addAddress('protapmstr@gmail.com', 'Name of recipient');

        $mailer->isHTML(true);
        $mailer->Subject = 'PHPMailer Test';
        $mailer->Body = 'This is a <b>SAMPLE<b> email sent through <b>PHPMailer<b>';

        $mailer->send();
        $mailer->ClearAllRecipients();
        echo "MAIL HAS BEEN SENT SUCCESSFULLY";

    } 
    catch (Exception $e) 
    {
        echo "EMAIL SENDING FAILED. INFO: " . $mailer->ErrorInfo;
    }
?>