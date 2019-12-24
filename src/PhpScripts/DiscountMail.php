<?php

namespace App\PhpScripts;


class DiscountMail
{
    public function db()
    {
        return mysqli_connect("localhost", "root", "", "symfony4");
    }

    public function sendMailToSubscribers()
    {
        $sql = "SELECT * FROM newsletter";

        if($result = mysqli_query($this->db(), $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $to = $row['email'];
                    $subject = "Info message";

                    $htmlContent = '
                        <html>
                        <head>
                            <title>Welcome to CodexWorld</title>
                        </head>
                        <body>
                            <h1>Thanks you for joining with us!</h1>
                        </body>
                        </html>';

                    // Set content-type header for sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // Additional headers
                    $headers .= 'From: shop.test@mail.com' . "\r\n";

                    mail($to, $subject, $htmlContent, $headers);
                }
            } else{
                echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($this->db());
        }
    }
}

//$cron = new DiscountMail();
//$cron->sendMailToSubscribers();
