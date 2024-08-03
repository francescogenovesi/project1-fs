<?php
// Configura le variabili di connessione al database
$servername = "localhost";
$username = "root"; // Cambia con il tuo username del database
$password = ""; // Cambia con la tua password del database
$dbname = "mydatabase";

// Crea la connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Preleva i dati dal form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepara e esegui la selezione
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $hashed_password);
$stmt->fetch();

if ($stmt->num_rows > 0) {
    // Verifica la password
    if (password_verify($password, $hashed_password)) {
        echo "Login avvenuto con successo.";
        // Puoi iniziare una sessione qui e reindirizzare l'utente a una pagina protetta
        // session_start();
        // $_SESSION['user_id'] = $id;
        // header("Location: protected_page.php");
    } else {
        echo "Password non corretta.";
    }
} else {
    echo "Nessun utente trovato con questa email.";
}

// Chiude la connessione
$stmt->close();
$conn->close();
?>
