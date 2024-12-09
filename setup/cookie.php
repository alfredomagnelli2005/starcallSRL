<!-- Popup per i cookie -->
<div id="cookie-popup" style="display:none; position: fixed; bottom: 0; left: 0; width: 100%; background-color: #222; color: #fff; padding: 20px; text-align: center; font-size: 16px; z-index: 1000;">
    <p>Questo sito utilizza i cookie per migliorare l'esperienza utente. Continuando a navigare, accetti il nostro <a href="https://heyzine.com/flip-book/bba6eab2b2.html" target="_blank">avviso sui cookie</a>.</p>
    <button id="accept-cookies" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; cursor: pointer; font-size: 16px; margin-top: 10px;">Accetto</button>
</div>

<script>
// Funzione per mostrare il popup se il consenso non è stato dato
function checkCookieConsent() {
    const cookieConsent = localStorage.getItem('cookieConsent');
    if (!cookieConsent) {
        document.getElementById('cookie-popup').style.display = 'block';
    }
}

// Funzione per accettare i cookie
function acceptCookies() {
    localStorage.setItem('cookieConsent', 'true');
    document.getElementById('cookie-popup').style.display = 'none';
}

// Verifica se l'utente ha già dato il consenso
checkCookieConsent();

// Aggiungi un listener al pulsante di accettazione
document.getElementById('accept-cookies').addEventListener('click', acceptCookies);
</script>
