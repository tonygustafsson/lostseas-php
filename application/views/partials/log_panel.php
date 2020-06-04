<aside id="log_panel" class="inventory-panel">
    <h3>What's going on?</h3>

    <?php if (isset($log_entries)): ?>
    <?php unset($log_entries['num_rows']); ?>

    <?php foreach ($log_entries as $entry): ?>
    <p>
        <img style="float: left; margin: 0.3em 0.5em 0.5em 0;"
            src="<?php echo base_url('assets/images/avatars/' . (($entry['character_gender'] == 'M') ? 'male' : 'female') . '_thumb/avatar_' . $entry['character_avatar'] . '.jpg')?>"
            alt="Avatar of <?php echo $entry['character_name']?>"
            width="40" height="40">
        <time style="font-weight: bold"><?php echo $entry['time']?></time><br>
        <?php echo $entry['character_name']?>
        <?php echo $entry['entry']?>
    </p>
    <?php endforeach; ?>
    <?php endif; ?>
</aside>