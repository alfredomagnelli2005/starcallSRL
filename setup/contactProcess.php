<?php
// Inizia la sessione per memorizzare eventuali messaggi di errore o successo
session_start();

// Controllo se il modulo è stato inviato via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prendi i dati dal form, usando `trim()` per evitare spazi indesiderati
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validazione semplice dei campi (assicurati che non siano vuoti)
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = 'Tutti i campi obbligatori devono essere compilati.';
        header('Location: ../index.php'); // Torna alla pagina con il form
        exit;
    }

    // Validazione dell'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Indirizzo email non valido.';
        header('Location: ../index.php'); // Torna alla pagina con il form
        exit;
    }

    // Imposta i destinatari e altre informazioni per l'email
    $to = 'alfredomagnelli45@gmail.com';  // Sostituisci con l'indirizzo email del destinatario
    $from = $email;
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Oggetto dell'email
    $email_subject = "Nuovo messaggio da $name: $subject";

    // Corpo dell'email in formato HTML
    $email_body = "
    <html>
    <head>
        <title>$email_subject</title>
    </head>
    <body>
        <h2>Nuovo messaggio ricevuto:</h2>
        <p><strong>Nome:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Oggetto:</strong> $subject</p>
        <p><strong>Messaggio:</strong></p>
        <p>$message</p>
    </body>
    </html>
    ";

    // Funzione mail() di PHP per inviare l'email
    if (mail($to, $email_subject, $email_body, $headers)) {
        $_SESSION['success'] = 'Messaggio inviato con successo!';
    } else {
        $_SESSION['error'] = 'Si è verificato un errore nell\'invio del messaggio.';
    }

    // Redirige alla pagina iniziale (index.php) con il messaggio di successo o errore
    header('Location: ../index.php');
    exit;
} else {
    // Se il form non è stato inviato tramite POST
    $_SESSION['error'] = 'Errore: il modulo non è stato inviato correttamente.';
    header('Location: ../index.php');
    exit;
}
?>
