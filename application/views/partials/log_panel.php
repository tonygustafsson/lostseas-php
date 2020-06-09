<aside id="log_panel" class="log-panel">
    <h3>What's going on?</h3>

    <?php if (isset($log_entries)): ?>
    <?php unset($log_entries['num_rows']); ?>

    <?php foreach ($log_entries as $entry): ?>
    <div class="log-panel__item">
        <img class="log-panel__item__img"
            src="<?=base_url('assets/images/avatars/' . (($entry['character_gender'] == 'M') ? 'male' : 'female') . '_thumb/avatar_' . $entry['character_avatar'] . '.jpg')?>"
            alt="Avatar of <?=$entry['character_name']?>"
            width="40" height="40">

        <time style="font-weight: bold"><?=$entry['time']?></time><br />

        <?=$entry['character_name']?>
        <?=$entry['entry']?>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</aside>