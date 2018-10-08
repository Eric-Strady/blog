<?php

	require_once('model/Posts.php');

	function contact($contact_subject, $contact_email, $contact_message)
	{
		$to = 'strady60@gmail.com';
		$subject = $contact_subject;
		$message = '
			<html>
				<head></head>
				<body>
					<p>' . $contact_message . '</p>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);
		$path = 'Location: http://127.0.0.1/blog/index.php';
		header($path);
	}