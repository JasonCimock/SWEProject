//sends notification to user or IT dept uses GMAIL for delivery


<html>
<head>
<title>Online PHP Script Execution</title>
</head>
<body>
<?require_once "Mail.php";

 $from = "Red Shirt <redshirtspms@gmail.com>";
 $to = "Jason Cimock <jcimock@gmail.com>";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 
 $host = "ssl://smtp.gmail.com";
 $port = "465";
 $username = "redshirtspms@gmail.com";
 $password = "softwareengineering";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);
 
 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
  }
?>

</body>
</html>
