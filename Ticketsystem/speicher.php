<div class="comments">
    <?php foreach($comments as $comment): ?>
    <div class="comment">
        <div>
            <i class="fas fa-comment fa-2x"></i>
        </div>
        <p>
            <span><?=date('F dS, G:ia', strtotime($comment['erstelldatum']))?></span>
            <?=nl2br(htmlspecialchars($comment['kommentar'], ENT_QUOTES))?>
        </p>
    </div>
    <?php endforeach; ?>
</div>
</div>


// index php tikcet status
<?php if ($ticket['StatusTicket'] == 'open'): ?>
<i class="far fa-clock fa-2x"></i>
<?php elseif ($ticket['StatusTicekt'] == 'resolved'): ?>
<i class="fas fa-check fa-2x"></i>
<?php elseif ($ticket['StatusTicket'] == 'closed'): ?>
<i class="fas fa-times fa-2x"></i>'
<?php endif; ?>

<a href="view.php?id=<?=$ticket['ticket_ID']?>" class="ticket">



<?php foreach ($stmt_ticket as $tk):?>
    <a href="admin.php?id=<?=$tk['ticket_ID']?>" class="ticket">
        <span class="con">
            <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?></h2>
            <span class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span>
            <p class="created"><?=date('f ds, g:ia', strtotime($tk['created']))?></p>
            <?php endforeach;?>
        </span>


<span class="con">
    <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?> <span
            class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span></h2>
    <span class="msg"><?php $tk['Beschreibung']; ?></span>
</span>