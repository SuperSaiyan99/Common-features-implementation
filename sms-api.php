<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitBtn'])) {

    #inputs sa user
    $phoneNumber = $_POST['phone_number'];
    $messageContent = $_POST['message'];

    #validations
    if (empty($phoneNumber) || empty($messageContent)) {
        echo '<script type="text/javascript">toastr.error("Phone number and message are required.")</script>';
    }

    else {
        #mao ni ang PARAMETERS, ang SENDER ID is dili na siya mailisdan kay strict
        #ang mga telco about sa pangalan sa sender karon
        $send_data = [
            'sender_id' => "PhilSMS",
            'recipient' => $phoneNumber,
            'message' => $messageContent
        ];


        # API token ninyo
        $token = "1245|jxRfR6wSVjqAzXDWslrnr3kx1kDU3o7a7y0n9wUZ";

        #processess [dili na hilabtan]
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://app.philsms.com/api/v3/sms/send');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $token
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($send_data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        #get sms
        $get_sms_status = curl_exec($ch);
        curl_close($ch);


        # Decode response
        $data = json_decode($get_sms_status, true);

        # Display result
        if (isset($data['status']) && $data['status'] === 'success') {
            echo '<script type="text/javascript">toastr.success("' . htmlspecialchars($data['message']) . '");</script>';
        } else {
            $errorMessage = isset($data['message']) ? $data['message'] : 'Failed to send SMS. Please try again.';
            echo '<script type="text/javascript">toastr.error("' . htmlspecialchars($errorMessage) . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container mt-5">
    <h1>Send SMS</h1>
    <form method="post">
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter your message" required></textarea>
        </div>
        <button type="submit" name="submitBtn" class="btn btn-primary">Send SMS</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.min.js"></script>
</body>
</html>