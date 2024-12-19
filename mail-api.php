<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitBtn'])) {
    // Collect input for the mailtrap email logic


    $toEmail = $_POST['recepient_email'];
    $messageContent = $_POST['message'];
    $token = "70e39d2c50763d49447c0c8f995840dd";


    // Validate inputs
    if (empty($toEmail) || empty($messageContent)) {
        echo '<script type="text/javascript">toastr.error("Recipient email and message are required.")</script>';
    } else {
        $data = array(

            # your mailtrap email
            'from' => array(
                'email' => 'hello@demomailtrap.com',
                'name' => 'Mailtrap Test'
            ),

            # respondents kamo na bahala sa logic
            #pwede mo mag loop ani for multiple email targets ninyo
            #depende na sa style niyo
            'to' => array(
                array('email' => $toEmail),
            ),

            # subject email
            'subject' => 'Yahay kaayo ka',
            'text' => $messageContent,
            'category' => 'Integration Test'
        );

        $jsonData = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://bulk.api.mailtrap.io/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo '<script type="text/javascript">toastr.error("Error sending email: ' . htmlspecialchars($err) . '")</script>';
        } else {
            $responseData = json_decode($response, true);
            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                echo '<script type="text/javascript">toastr.success("Email sent successfully.")</script>';
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Failed to send email. Please try again.';
                echo '<script type="text/javascript">toastr.error("' . htmlspecialchars($errorMessage) . '")</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container mt-5">
    <h1>Send Email</h1>
    <form method="post">
        <div class="form-group">
            <label for="recepient_email">Recipient Email:</label>
            <input type="email" class="form-control" id="recepient_email" name="recepient_email" placeholder="Enter recipient email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter your message" required></textarea>
        </div>
        <button type="submit" name="submitBtn" class="btn btn-primary">Send Email</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.min.js"></script>
</body>
</html>
