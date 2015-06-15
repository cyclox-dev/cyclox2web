<!-- file: /app/View/Meets/view.ctp -->

<h1><?php echo h($meet['Meet']['code']); ?></h1>

<p><small>Created: <?php echo $meet['Meet']['created']; ?></small></p>

<p><?php echo '大会名称:' . h($meet['Meet']['name']); ?></p>
<p><?php echo '（短縮名）:' . h($meet['Meet']['short_name']); ?></p>