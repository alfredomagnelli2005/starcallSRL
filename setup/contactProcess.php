<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Raccogli i dati dal modulo
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Controlla se i dati sono validi
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Se ci sono errori, redirigi alla pagina index con il messaggio di errore
        echo "<script>
                alert('Tutti i campi sono obbligatori.');
                window.location.href = '../index.php';
              </script>";
        exit;
    }

    // Controllo sull'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Se l'email non è valida, redirigi con il messaggio di errore
        echo "<script>
                alert('L\'email inserita non è valida.');
                window.location.href = '../index.php';
              </script>";
        exit;
    }

    // Gestione del file allegato (se presente)
    $attachment = null;
    $attachment_name = null;
    $attachment_tmp = null;
    $attachment_size = null;
    $attachment_error = null;
    $file_content = null;

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        // Assegna i valori del file caricato
        $attachment = $_FILES['attachment'];
        $attachment_name = $attachment['name'];
        $attachment_tmp = $attachment['tmp_name'];
        $attachment_size = $attachment['size'];
        $attachment_error = $attachment['error'];

        // Verifica il tipo di file (PDF o DOCX)
        $allowed_extensions = ['pdf', 'docx'];
        $file_extension = strtolower(pathinfo($attachment_name, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>
                    alert('Formato file non valido. Sono consentiti solo PDF e DOCX.');
                    window.location.href = '../index.php';
                  </script>";
            exit;
        }

        // Limite di dimensione (5MB in questo esempio)
        if ($attachment_size > 5 * 1024 * 1024) {
            echo "<script>
                    alert('Il file è troppo grande. La dimensione massima consentita è 5MB.');
                    window.location.href = '../index.php';
                  </script>";
            exit;
        }

        // Leggi il contenuto del file in memoria
        $file_content = chunk_split(base64_encode(file_get_contents($attachment_tmp)));
    }

    // Dati per l'email destinata all'azienda (info@starcall.it)
    $to = "info@starcall.it"; // Email destinataria
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".md5(time())."\"\r\n";

    // Corpo dell'email destinata all'azienda
    $messageContent = "--PHP-mixed-" . md5(time()) . "\r\n";
    $messageContent .= "Content-Type: text/html; charset=UTF-8\r\n";
    $messageContent .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $messageContent .= "<h2>Nuovo Messaggio da $name</h2>
                       <p><strong>Oggetto:</strong> $subject</p>
                       <p><strong>Messaggio:</strong><br>$message</p>";

    // Se c'è un file allegato, aggiungi l'attachment all'email
    if ($file_content) {
        $messageContent .= "\r\n--PHP-mixed-" . md5(time()) . "\r\n";
        $messageContent .= "Content-Type: application/octet-stream; name=\"$attachment_name\"\r\n";
        $messageContent .= "Content-Transfer-Encoding: base64\r\n";
        $messageContent .= "Content-Disposition: attachment; filename=\"$attachment_name\"\r\n\r\n";
        $messageContent .= $file_content . "\r\n";
        $messageContent .= "--PHP-mixed-" . md5(time()) . "--\r\n";
    }

    // Invio dell'email all'azienda
    if (mail($to, $subject, $messageContent, $headers)) {
        // Successo: invio della risposta automatica all'utente
        $replySubject = "Conferma ricezione messaggio - StarCall";
        $replyMessage = "
        <html>
        <body style='font-family: Arial, sans-serif; color: #333;'>
            <table style='width: 100%; padding: 20px; background-color: #f4f4f4;'>
                <tr>
                    <td>
                        <table style='width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px;'>
                            <tr>
                                <td style='text-align: center; padding-bottom: 20px;'>
                                    <h2 style='color: #0066cc;'>Ciao $name,</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom: 15px;'>
                                    <p>Grazie per averci contattato! La tua richiesta è stata ricevuta con successo. Il nostro team esaminerà il tuo messaggio al più presto e ti risponderà nel minor tempo possibile.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom: 15px;'>
                                    <p><strong>Nota importante:</strong></p>
                                    <p>Questa è una <strong>email automatica</strong> inviata dal nostro sistema di supporto. Ti preghiamo di non rispondere a questa email, poiché l'indirizzo <strong>noreply@starcall.it</strong> non è monitorato e il tuo messaggio non verrà letto.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: center;'>
                                    <p style='color: #666;'>Se hai ulteriori domande, ti invitiamo a contattarci direttamente attraverso il nostro sito o via email all'indirizzo <a href='mailto:info@starcall.it' style='color: #0066cc;'>info@starcall.it</a>.</p>
                                    <br>
                                    <p style='color: #666;'>Il team StarCall</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";

        $replyHeaders = "From: noreply@starcall.it\r\n";
        $replyHeaders .= "Reply-To: noreply@starcall.it\r\n";
        $replyHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Invio della risposta automatica all'utente
        if (mail($email, $replySubject, $replyMessage, $replyHeaders)) {
            echo "<script>
                    alert('Messaggio inviato con successo!');
                    window.location.href = '../index.php';
                  </script>";
        } else {
            // Errore nel mandare la risposta automatica
            echo "<script>
                    alert('Errore nell\'invio della risposta automatica.');
                    window.location.href = '../index.php';
                  </script>";
        }
    } else {
        // Errore nell'invio dell'email
        echo "<script>
                alert('Si è verificato un errore durante l\'invio del messaggio.');
                window.location.href = '../index.php';
              </script>";
    }
} else {
    // Metodo di richiesta non valido
    echo "<script>
            alert('Metodo di richiesta non valido.');
            window.location.href = '../index.php';
          </script>";
}
?>
