<?php
    // Crew health
    $crew_health_img_25_display = 'none';
    $crew_health_img_50_display = 'none';
    $crew_health_img_75_display = 'none';
    $crew_health_img_100_display = 'none';

    if ($game['crew_health_lowest'] <= 25) {
        $crew_health_img_25_display = 'block';
    } elseif ($game['crew_health_lowest'] > 25 && $game['crew_health_lowest'] <= 50) {
        $crew_health_img_50_display = 'block';
    } elseif ($game['crew_health_lowest'] > 50 && $game['crew_health_lowest'] <= 75) {
        $crew_health_img_75_display = 'block';
    } elseif ($game['crew_health_lowest'] > 75) {
        $crew_health_img_100_display = 'block';
    }

    // Crew mood
    $crew_mood_aggressive_display = 'none';
    $crew_mood_grumpy_display = 'none';
    $crew_mood_calm_display = 'none';
    $crew_mood_cheerful_display = 'none';
    $crew_mood_happy_display = 'none';
    $crew_mood_euphoric_display = 'none';
    
    if ($game['crew_lowest_mood'] <= -10) {
        $crew_mood_aggressive_display = 'inline-block';
    } elseif ($game['crew_lowest_mood'] <= 0) {
        $crew_mood_grumpy_display = 'inline-block';
    } elseif ($game['crew_lowest_mood'] <= 5) {
        $crew_mood_calm_display = 'inline-block';
    } elseif ($game['crew_lowest_mood'] <= 10) {
        $crew_mood_cheerful_display = 'inline-block';
    } elseif ($game['crew_lowest_mood'] <= 18) {
        $crew_mood_happy_display = 'inline-block';
    } else {
        $crew_mood_euphoric_display = 'inline-block';
    }

    // Ship health
    $ship_health_img_25_display = 'none';
    $ship_health_img_50_display = 'none';
    $ship_health_img_75_display = 'none';
    $ship_health_img_100_display = 'none';

    if ($game['ship_health_lowest'] <= 25) {
        $ship_health_img_25_display = 'block';
    } elseif ($game['ship_health_lowest'] > 25 && $game['ship_health_lowest'] <= 50) {
        $ship_health_img_50_display = 'block';
    } elseif ($game['ship_health_lowest'] > 50 && $game['ship_health_lowest'] <= 75) {
        $ship_health_img_75_display = 'block';
    } elseif ($game['ship_health_lowest'] > 75) {
        $ship_health_img_100_display = 'block';
    }
?>

<aside id="inventory_panel" class="inventory-panel">
    <a class="js-panel-close top-nav-panel__close-btn">
        <svg width="20" height="20" alt="Close">
            <use xlink:href="#close"></use>
        </svg>
    </a>

    <h3>Inventory</h3>

    <div class="inventory_user">
        <a class="ajaxHTML"
            href="inventory/player/<?=$user['id']?>#character">
            <div style="height: 100%; width: 40px">
                <img id="inventory_character_avatar"
                    src="<?=$game['character_avatar_thumb_path']?>"
                    alt="Character avatar" width="120" height="120">
            </div>
            <div style="width: 100%;">
                <span id="inventory_character_name"><?=$game['character_name']?></span>,
                <span id="inventory_title"><?=$game['title']?></span>
                from <span id="inventory_nationality"><?=ucwords($game['nationality'])?></span>
            </div>
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($user['new_messages'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="You have new messages!"
            href="inventory/messages/<?=$user['id']?>">
            <svg alt="Message" width="24" height="24">
                <use xlink:href="#message"></use>
            </svg>
            <span id="inventory_new_messages"><?=$user['new_messages']?></span>
            <?=($user['new_messages'] > 1) ? 'messages' : 'message'; ?>
        </a>
    </div>

    <!-- Section: Game status -->

    <div class="inventory_item">
        <a class="ajaxHTML" id="inventory_crew_health_link"
            title="You have <?=$game['crew_members']?> crew members with the health <?=$game['crew_health_lowest']?>%"
            href="inventory/crew/<?=$user['id']?>">
            <svg alt="Ships" width="24" height="24">
                <use xlink:href="#crew-man"></use>
            </svg>
            <svg id="inventory_crew_health_25" alt="Crew Health" width="24" height="24" class="addon-icon"
                style="display: <?=$crew_health_img_25_display?>">
                <use xlink:href="#heart-25"></use>
            </svg>
            <svg id="inventory_crew_health_50" alt="Crew Health" width="24" height="24" class="addon-icon"
                style="display: <?=$crew_health_img_50_display?>">
                <use xlink:href="#heart-50"></use>
            </svg>
            <svg id="inventory_crew_health_75" alt="Crew Health" width="24" height="24" class="addon-icon"
                style="display: <?=$crew_health_img_75_display?>">
                <use xlink:href="#heart-75"></use>
            </svg>
            <svg id="inventory_crew_health_100" alt="Crew Health" width="24" height="24" class="addon-icon"
                style="display: <?=$crew_health_img_100_display?>">
                <use xlink:href="#heart-100"></use>
            </svg>
            <span id="inventory_crew"><?=$game['crew_members']?></span>
            men
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['crew_members'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" id="inventory_crew_mood_link"
            title="Your crew is <?=$game['crew_lowest_friendly_mood']?> (Mood <?=$game['crew_lowest_mood']?>)"
            href="inventory/crew/<?=$user['id']?>">
            <svg id="inventory_crew_mood_aggressive" alt="Mood" width="24" height="24"
                style="display: <?=$crew_mood_aggressive_display?>">
                <use xlink:href="#mood-aggressive"></use>
            </svg>
            <svg id="inventory_crew_mood_grumpy" alt="Mood" width="24" height="24"
                style="display: <?=$crew_mood_grumpy_display?>">
                <use xlink:href="#mood-grumpy"></use>
            </svg>
            <svg id="inventory_crew_mood_calm" alt="Mood" width="24" height="24"
                style="display: <?=$crew_mood_calm_display?>">
                <use xlink:href="#mood-calm"></use>
            </svg>
            <svg id="inventory_crew_mood_cheerful" alt="Mood" width="24" height="24"
                style="display: <?=$crew_mood_cheerful_display?>">
                <use xlink:href="#mood-cheerful"></use>
            </svg>
            <svg id="inventory_crew_mood_happy" alt="Mood" width="24" height="24"
                style="display: <?=$crew_mood_happy_display?>">
                <use xlink:href="#mood-happy"></use>
            </svg>
            <svg id="inventory_crew_mood_euphoric" alt="Mood" width="24" height="24"
                style="display: <?=$crew_mood_euphoric_display?>">
                <use xlink:href="#mood-euphoric"></use>
            </svg>
            <span id="inventory_crew_mood"><?=$game['crew_lowest_friendly_mood']?></span>
        </a>
    </div>

    <div class="inventory_item">
        <a class="ajaxHTML" title="Doubloons that you can use immediately"
            href="inventory/player/<?=$user['id']?>#capital">
            <svg alt="Doubloons" width="24" height="24">
                <use xlink:href="#doubloons"></use>
            </svg>
            <span id="inventory_doubloons"><?=$game['doubloons']?></span>
            dbl
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['bank_account'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Doubloons in your bank account"
            href="inventory/player/<?=$user['id']?>#capital">
            <svg alt="Savings" width="24" height="24">
                <use xlink:href="#savings"></use>
            </svg>
            <span id="inventory_bank_account"><?=$game['bank_account']?></span>
            dbl
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['bank_loan'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your bank loan amount"
            href="inventory/player/<?=$user['id']?>#capital">
            <svg alt="Loan" width="24" height="24">
                <use xlink:href="#loan"></use>
            </svg>
            <span id="inventory_bank_loan"><?=$game['bank_loan']?></span>
            dbl
        </a>
    </div>

    <div class="inventory_item">
        <a class="ajaxHTML" title="Amount of weeks that has passed, see log book"
            href="inventory/log/<?=$user['id']?>">
            <svg alt="Log book" width="24" height="24">
                <use xlink:href="#logbook"></use>
            </svg>
            week <span id="inventory_week"><?=$game['week']?></span>
        </a>
    </div>

    <!-- Section: Ship status -->
    <div style="padding-top: 1em; width: 100%;"></div>

    <div class="inventory_item">
        <a class="ajaxHTML" id="inventory_ships_health_link"
            title="You own <?=$game['ships']?> ships with the health <?=$game['ship_health_lowest']?>%"
            href="inventory/ships/<?=$user['id']?>">
            <svg alt="Ships" width="24" height="24">
                <use xlink:href="#ship"></use>
            </svg>
            <svg id="inventory_ships_health_25" alt="Ship Health" width="24" height="24" class="addon-icon"
                style="display: <?=$ship_health_img_25_display?>">
                <use xlink:href="#heart-25"></use>
            </svg>
            <svg id="inventory_ships_health_50" alt="Ship Health" width="24" height="24" class="addon-icon"
                style="display: <?=$ship_health_img_50_display?>">
                <use xlink:href="#heart-50"></use>
            </svg>
            <svg id="inventory_ships_health_75" alt="Ship Health" width="24" height="24" class="addon-icon"
                style="display: <?=$ship_health_img_75_display?>">
                <use xlink:href="#heart-75"></use>
            </svg>
            <svg id="inventory_ships_health_100" alt="Ship Health" width="24" height="24" class="addon-icon"
                style="display: <?=$ship_health_img_100_display?>">
                <use xlink:href="#heart-100"></use>
            </svg>
            <span id="inventory_ships"><?=$game['ships']?></span>
            <?=($game['ships'] > 1) ? 'ships' : 'ship'; ?>
        </a>
    </div>

    <div class="inventory_item">
        <a class="ajaxHTML" id="inventory_cannons_link"
            title="You own <?=$game['cannons']?> cannons, <?=$game['manned_cannons']?> are manned"
            href="inventory/ships/<?=$user['id']?>">
            <svg alt="Cannon" width="24" height="24">
                <use xlink:href="#cannon"></use>
            </svg>
            <span id="inventory_manned_cannons"><?=$game['manned_cannons']?></span>/<span
                id="inventory_cannons"><?=$game['cannons']?></span>
            cannons
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['rafts'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your life boats, used in shipwreck"
            href="inventory/ships/<?=$user['id']?>">
            <svg alt="Raft" width="24" height="24">
                <use xlink:href="#raft"></use>
            </svg>
            <span id="inventory_rafts"><?=$game['rafts']?></span>
            <?=($game['rafts'] > 1) ? 'rafts' : 'raft'; ?>
        </a>
    </div>

    <!-- Section: Stock status -->
    <div style="padding-top: 1em; width: 100%;"></div>

    <div class="inventory_item"
        style="display: <?=($game['prisoners'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your prisoners, can be left in City Hall for a ransom"
            href="inventory/ships/<?=$user['id']?>">
            <svg alt="Raft" width="24" height="24">
                <use xlink:href="#prisoners"></use>
            </svg>
            <span id="inventory_prisoners"><?=$game['prisoners']?></span>
            prisoners
        </a>
    </div>

    <div class="inventory_item">
        <a class="ajaxHTML" title="Your food, used by crew members for sea traveling"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Food" width="24" height="24">
                <use xlink:href="#food"></use>
            </svg>
            <span id="inventory_food"><?=$game['food']?></span> food
        </a>
    </div>

    <div class="inventory_item">
        <a class="ajaxHTML" title="Your water, used by crew members for sea traveling"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Water" width="24" height="24">
                <use xlink:href="#water"></use>
            </svg>
            <span id="inventory_water"><?=$game['water']?></span>
            water
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['porcelain'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your porcelain, used as barter goods"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Porcelain" width="24" height="24">
                <use xlink:href="#porcelain"></use>
            </svg>
            <span id="inventory_porcelain"><?=$game['porcelain']?></span>
            porcelain
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['spices'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your spices, used as barter goods"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Spices" width="24" height="24">
                <use xlink:href="#spices"></use>
            </svg>
            <span id="inventory_spices"><?=$game['spices']?></span>
            spices
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['silk'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your silk, used as barter goods"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Silk" width="24" height="24">
                <use xlink:href="#silk"></use>
            </svg>
            <span id="inventory_silk"><?=$game['silk']?></span> silk
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['medicine'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your medicine, can heal crew members"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Medicine" width="24" height="24">
                <use xlink:href="#medicine"></use>
            </svg>
            <span id="inventory_medicine"><?=$game['medicine']?></span>
            medicine
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['tobacco'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your tobacco, used as barter goods and can raise crew members mood"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Tobacco" width="24" height="24">
                <use xlink:href="#tobacco"></use>
            </svg>
            <span id="inventory_tobacco"><?=$game['tobacco']?></span>
            tobacco
        </a>
    </div>

    <div class="inventory_item"
        style="display: <?=($game['rum'] > 0) ? 'block' : 'none'?>">
        <a class="ajaxHTML" title="Your rum, used as barter goods and can raise crew members mood"
            href="inventory/player/<?=$user['id']?>#stock">
            <svg alt="Rum" width="24" height="24">
                <use xlink:href="#rum"></use>
            </svg>
            <span id="inventory_rum"><?=$game['rum']?></span> rum
        </a>
    </div>
</aside>