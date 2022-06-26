<?php
include 'functions.php';
session_start();

$pdo = pdo_connect_mysql();

$fkc = $pdo -> prepare('SET FOREIGN_KEY_CHECKS=0');
        $fkc -> execute();

// hohlt alle Ticktes aus der Tabelle Tickets
$stmt_ticket= $pdo->prepare('SELECT * From tickets INNER JOIN issue on tickets.ticket_ID = issue.ticket_ID'); 
$stmt_ticket->execute();
$tickets = $stmt_ticket->fetchall(PDO::FETCH_ASSOC);

if (isset($_POST['kommentar']) && !empty($_POST['kommentar'])){
    $stmt_insert = $pdo ->prepare('INSERT INTO tickets_comments (ticket_ID, kommentar) VALUES (?,?)');
    $stmt_insert->execute(array(
        $_GET['id'],
        $_POST['kommentar']
    ));
}
if (isset($_GET['status']) && in_array($_GET['status'], array('open', 'closed', 'resolved'))) {
    $stmt = $pdo->prepare('UPDATE tickets SET StatusTicket = ? WHERE ticket_ID = ?');
    $stmt->execute([ $_GET['status'], $_GET['id'] ]);
}


$stmt_comment = $pdo -> prepare('SELECT kommentar, erstelldatum, ticket_ID from tickets_comments');
$stmt_comment->execute();
$comments = $stmt_comment->fetchall(PDO::FETCH_ASSOC);

?>



<?=template_header('hilfe bei der fehlerfindung')?>
<div class="content view">
    <h1>Tickets</h1>

    <?php 
if(!isset($_GET['id'])):?>
    <?php foreach ($tickets as $tk):?>

    <a href="admin.php?id=<?=$tk['ticket_ID']?>" class="ticket">
        <span class="con">
            <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?>
                <span class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span>
            </h2>
    </a>
    <p class="created"><?=date('f ds, g:ia', strtotime($tk['created']))?></p>
    </span>

    <?php endforeach;?>


    <?php else: ?>
    <?php foreach ($tickets as $tk):?>
    <?php if ($tk['ticket_ID'] == $_GET['id']): ?>
    <div class="ticket">
        <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?>
            <span class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span>
        </h2>
        <p class="created"><?=date('f ds, g:ia', strtotime($tk['created']))?></p>
        <?php echo $tk['Beschreibung'] ?>
        <p class="msg"><?php nl2br(htmlspecialchars($tk['Beschreibung'], ENT_QUOTES)); ?></p>
    </div>
    <div class="btns">
        <a href="admin.php?id=<?=$_GET['id']?>&status=closed" class="btn red">Close</a>
        <a href="admin.php?id=<?=$_GET['id']?>&status=resolved" class="btn">Resolve</a>
    </div>

    <div class="comments">
        <?php foreach($comments as $comment): ?>
        <?php if ($comment['ticket_ID'] == $_GET['id']): ?>
        <div class="comment">
            <div>
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <p>
                <span><?=date('F dS, G:ia', strtotime($comment['erstelldatum']))?></span>
                <?=nl2br(htmlspecialchars($comment['kommentar'], ENT_QUOTES))?>
            </p>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <form action="" method="post">
        <textarea name="kommentar" placeholder="Rückmeldung eingeben"></textarea>
        <div class="btns">
            <input type="submit" value="Abschicken">
            <a href="admin.php" class="btn">Zurück</a>
        </div>

    </form>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif ?>
</div>
<?=template_footer()?>