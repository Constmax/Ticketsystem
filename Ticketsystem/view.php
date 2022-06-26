<?php
include 'functions.php';
session_start();
//mit der Datenbank verbinden
$pdo = pdo_connect_mysql();
if(!isset($_GET['id'])){
    exit('Die ID wurde nicht angegeben!');
}
//niemand bracht Fremdschlüssel checks
$fkc = $pdo -> prepare('SET FOREIGN_KEY_CHECKS=0');
$fkc -> execute();

/*
// hohlt alle Ticktes aus der Datenbank
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM tickets');
    $stmt->execute();
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
}*/


// wenn der Button gedrückt wurde
$stmt = $pdo -> prepare('SELECT * FROM tickets');
$stmt -> execute();
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($ticket);


if (!$ticket) {
    exit('Invalid ticket ID!');
}

//aktualisiert den status des tickets
if (isset($_GET['status']) && in_array($_GET['status'], ['open', 'resolved', 'closed'])) {
    $status = $_GET['status'];
    $stmt = $pdo->prepare('UPDATE tickets SET StatusTicket = ? WHERE nutzer_ID = ?');
    $stmt->execute(array(
        $status,
        $id,
    ));
    header('Location: view.php?id=' . $id);  // redirect to the view page
}

// checkt ob das ticket geschlossen wurde
if (isset($_POST['msg']) && !empty($_POST['msg'])) {
    // fügt neues Kommentar in die Datenbank hinzu
    $stmt = $pdo->prepare('INSERT INTO tickets_comments (user_ID, kommentar) VALUES (?, ?)');
    $stmt->execute([
        $_GET['id'],
        $_POST['msg'],

    ]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;
}

?>
/*
// hohlt alle Kommentare aus der Datenbank
$stmt = $pdo->prepare('SELECT * FROM tickets_comments WHERE ticket_id = ? ORDER BY erstelldatum DESC');
$stmt->execute([ $_GET['id'] ]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>*/

<?=template_header('Ticket')?>

<div class="content view">
    <?php foreach ($ticket as $tk):
        echo gettype($tk);?>

    <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?> <span
            class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span></h2>
    <div class="ticket">
        <p class="created"><?=date('F dS, G:ia', strtotime((string)$tk['created']))?></p>
        <p class="msg"><?=nl2br(htmlspecialchars((string)$tk['title'], ENT_QUOTES))?></p>
    </div>
    <?php endforeach; ?>
    <div class="btns">
        <a href="view.php?id=<?=$_GET['id']?>&status=closed" class="btn red">Close</a>
        <a href="view.php?id=<?=$_GET['id']?>&status=resolved" class="btn">Resolve</a>
    </div>

    <?=template_footer()?>