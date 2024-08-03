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
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash della password

// Controlla se l'email esiste già
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email già registrata. Per favore usa un'altra email.";
} else {
    // Prepara e esegui l'inserimento
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    if ($stmt->execute()) {
        echo "Registrazione completata con successo.";
    } else {
        echo "Errore: " . $stmt->error;
    }
}

// Chiude la connessione
$stmt->close();
$conn->close();
?>

