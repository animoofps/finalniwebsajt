<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Provjera i prikupljanje podataka iz obrasca
  $name = $_POST["name"];
  $visitor_email = $_POST["email"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];

  // Email adresa s koje će se slati poruka
  $email_from = "sveuciliste@zagreb.hr";

  // Predmet email poruke
  $email_subject = "Nova poruka od korisnika: $name";

  // Tijelo email poruke
  $email_body = "Ime: $name\n" .
    "Email: $visitor_email\n" .
    "Predmet: $subject\n" .
    "Poruka:\n$message\n";

  // Postavke za SMTP server
  $smtp_server = 'smtp.freesmtpservers.com';
  $smtp_port = 25;
  $smtp_username = ''; // Postavke za testiranje besplatnog SMTP servera (prazno)
  $smtp_password = ''; // Postavke za testiranje besplatnog SMTP servera (prazno)

  // Postavljanje dodatnih zaglavlja
  $headers = "From: $email_from\r\n";

  // Konfiguracija za slanje putem SMTP-a
  ini_set('SMTP', $smtp_server);
  ini_set('smtp_port', $smtp_port);
  ini_set('sendmail_from', $email_from);

  // Email adresa na koju će stići poruka
  $to = "sveuciliste@zagreb.hr";

  // Slanje email poruke
  if (mail($to, $email_subject, $email_body, $headers)) {
    header("Location: kontakt.html?success=true");
  } else {
    header("Location: kontakt.html?success=false");
  }
} else {
  header("Location: kontakt.html");
}
