<?php
            $mail_message = "Hey you got new subscription with Name " . $name_of_subscriber  . "and email id " . $email_of_subscriber . " for InfoBar notice";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= "From: \"$name_of_subscriber\" <$email_of_subscriber>\n";
            $headers .= "Return-Path: <" . mysql_real_escape_string(trim($email_of_subscriber)) . ">\n";
            $headers .= "Reply-To: \"" . mysql_real_escape_string(trim($name_of_subscriber)) . "\" <" . mysql_real_escape_string(trim($gcf_email)) . ">\n";

            $admin_email = get_option('infoemail_address');
            @wp_mail($admin_email, 'InfoBar', $mail_message, $headers); 
			echo "Thank you for subscribing";
?>