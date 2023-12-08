<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookings";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed:" . $conn->connect_error);
}

// handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $paket = $_POST["paket"];
    $message = $_POST["message"];

    $sql = "INSERT INTO `booking`(`name`, `email`, `number`, `date`, `time`, `paket`, `message`) 
            VALUES ('$name','$email','$number','$date','$time','$paket','$message')";

    if ($conn->query($sql) === TRUE) {
        // Booking successful, send confirmation email
        $to = $email;
        $subject = "Boknings bekräftelse";
        $confirmationMessage = "Hej! $name, \n\nDin bokning har bekräftats.\n\nDetaljer: \nDatum: $date\nTid: $time\nPaket: $paket\n\nAdditional Message: $message\n\nTack för att du väljer Diamond Rekond!";

        // Create a new PHPMailer instance for confirmation email
        $mailConfirmation = new PHPMailer(true);

        try {
            // SMTP configuration
            $mailConfirmation->isSMTP();
            $mailConfirmation->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mailConfirmation->SMTPAuth = true;
            $mailConfirmation->Username = 'alex.naemi.2020@gmail.com'; // Replace with your SMTP username
            $mailConfirmation->Password = 'kzid izqi xbhx bvov'; // Replace with your SMTP password
            $mailConfirmation->SMTPSecure = 'tls';
            $mailConfirmation->Port = 587;

            // Email content for confirmation email
            $mailConfirmation->setFrom('alex.naemi.2020@gmail.com', 'Alex Naemi'); // Replace with your email address
            $mailConfirmation->addAddress($to, $name);
            $mailConfirmation->Subject = $subject;
            $mailConfirmation->Body = $confirmationMessage;

            // Send the confirmation email
            $mailConfirmation->send();
            
            header("Location: confirmation.html");

            // Create a new PHPMailer instance for customer email
            $mailCustomer = new PHPMailer(true);

            // SMTP configuration for customer email
            $mailCustomer->isSMTP();
            $mailCustomer->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mailCustomer->SMTPAuth = true;
            $mailCustomer->Username = 'alex.naemi.2020@gmail.com'; // Replace with your SMTP username
            $mailCustomer->Password = 'kzid izqi xbhx bvov'; // Replace with your SMTP password
            $mailCustomer->SMTPSecure = 'tls';
            $mailCustomer->Port = 587;

            // Email content for customer email
            $mailCustomer->setFrom($email, $name); // Use customer's email and name
            $mailCustomer->addAddress('alex.naemi.2020@gmail.com', 'Alex Naemi'); // Replace with your email and name
            $mailCustomer->Subject = 'Bokningsförfrågan';
            $mailCustomer->Body = "Kundens namn: $name\nKundens Nummer: $number\nKundens Email: $email\nBoknings datum: $date\nBoknings tid: $time\nMedelande från kunden: $message";

            // Send the customer email
            $mailCustomer->send();

            echo "Customer email notification sent to your email address.";
        } catch (Exception $e) {
            echo "Failed to send confirmation email. Error: {$mailConfirmation->ErrorInfo}";
        }
    } else {
        echo "Failed to book" . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

