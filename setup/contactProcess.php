<?php
session_start();  // Avvia la sessione

// Definisci variabili per i messaggi di errore e successo
$error = '';
$success = '';

// Raccogli e pulisci i dati del modulo
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$subjectEmail = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Verifica che i campi non siano vuoti e che l'email sia valida
if (empty($name) || empty($email) || empty($message)) {
    $error = "Tutti i campi sono obbligatori.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Indirizzo email non valido.";
} else {
    // Imposta l'indirizzo email del destinatario e l'oggetto
    $to = 'alfredomagnelli45@gmail.com'; // Sostituisci con il tuo indirizzo email
    $subject = 'NUOVO MESSAGGIO DAL MODULO DI CONTATTO STARCALL';

    // Crea il corpo del messaggio
    $email_message = "Nome: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Oggetto: $subjectEmail\n";
    $email_message .= "Messaggio:\n$message\n";

    // Intestazioni dell'email
    $headers = "From: no-reply@gmail.com\r\n"; // Sostituisci con un indirizzo email valido
    $headers .= "Reply-To: $email\r\n"; // Usa l'email del mittente come Reply-To
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    // Invia l'email al destinatario principale
    if (mail($to, $subject, $email_message, $headers)) {
        // Invia email di conferma al cliente
        $confirmation_subject = "Conferma di ricezione del messaggio";
        $confirmation_message = "Ciao $name,\n\n";
        $confirmation_message .= "Abbiamo ricevuto il tuo messaggio. Ti risponderemo al più presto!\n\n";
        $confirmation_message .= "Grazie,\nIl team di StarCall S.R.L";

        $confirmation_headers = "From: no-reply@gmail.com\r\n";
        $confirmation_headers .= "Reply-To: no-reply@gmail.com\r\n";
        $confirmation_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $confirmation_headers .= "MIME-Version: 1.0\r\n";
        $confirmation_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        // Invia l'email di conferma al cliente
        if (mail($email, $confirmation_subject, $confirmation_message, $confirmation_headers)) {
            // Memorizza l'email nella sessione
            $_SESSION['email'] = $email;
            // Reindirizza alla pagina di conferma in caso di successo
            header("Location: ty.php");
            exit();
        } else {
            $error = "L'email di conferma non è stata inviata.";
        }
    } else {
        $error = "Si è verificato un errore nell'invio del messaggio.";
    }
}

// Reindirizza l'utente al modulo con un messaggio di errore se l'invio dell'email fallisce
if ($error) {
    header("Location: contact_form.php?error=" . urlencode($error));
    exit();
}
?>
