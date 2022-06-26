<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

$msg = '';

//checkt ob die alle Felder ausgefüllt wurden
if (isset($_POST['Nachname'], $_POST['Email'], $_POST['Vorname'], $_POST['Password'])) {
    //checkt das die Felder nicht leer sind
    if (empty($_POST['Nachname']) || empty($_POST['Email']) || empty($_POST['Vorname']) || empty($_POST['Password'])) {
        $msg = 'Bitte füllen sie alle Felder aus!';
    } else if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
        $msg = 'Bitte geben Sie eine gültige E-Mail-Adresse ein!';
    } else {
        // fügt neue Eintrag in die Datenbank
        $stmt = $pdo->prepare('INSERT INTO user (Email, Nachname, Vorname, Passwort) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $_POST['Email'],
            $_POST['Nachname'],
            $_POST['Vorname'],
            $_POST['Password'],
        ]);
        header('Location: userLogin.php');
    }
}
?>

<?=template_header('Registrierung')?>
<div class="content create">
    <h2>Login</h2>
    <form action="http://localhost/Ticketsystem/userRegistration.php" method="POST">
        <label for="Email">Email</label>
        <input type="Email" name="Email" placeholder="max@msutermann.com" id="Email">
        <label for="Nachname">Name</label>
        <input type="text" name="Nachname" placeholder="hier könnte ihr Name stehen" id="Nachname">
        <label for="Vorname">Vorname</label>
        <input type="text" name="Vorname" placeholder="hier könnte ihr Vorname stehen" id="Vorname">
        <label for="Password">Password</label>
        <input type="password" name="Password" placeholder="hier könnte ihr Passwort stehen" id="Password">
        <input type="submit" value="Registrieren">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>


<?=template_footer()?>