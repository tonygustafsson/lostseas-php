<?php
    $sailors_disabled = isset($game['event']['tavern_sailors']['banned']) && $game['event']['tavern_sailors']['banned'] ? 'disabled' : '';
?>

<header class="area-header"
    title="<?=$game['town_human'] . ' ' . $game['place']?>">
    <h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
    </h2>
    <img src="<?=base_url('assets/images/places/gamble_' . $game['nation'] . '.png')?>"
        class="area-header__img">
</header>

<div class="container">
    <div class="button-area">
        <a class="ajaxHTML button big-icon" title="Buy something to eat or drink"
            href="<?=base_url('tavern')?>">
            <svg width="32" height="32" alt="Buy">
                <use xlink:href="#icon-rum"></use>
            </svg>
            Buy
        </a>
        <a id="actions_sailors" <?=$sailors_disabled?>
            class="ajaxHTML
            button big-icon" title="Talk to the sailors at the bar"
            href="<?=base_url('tavern/sailors')?>">
            <svg width="32" height="32" alt="Sailors">
                <use xlink:href="#icon-pirate"></use>
            </svg>
            Sailors
        </a>
        <a class="ajaxHTML button big-icon" title="Gamble for gold!"
            href="<?=base_url('tavern/gamble')?>">
            <svg width="32" height="32" alt="Gamble">
                <use xlink:href="#icon-dices"></use>
            </svg>
            Gamble
        </a>
        <a class="ajaxHTML button big-icon" title="Play black jack"
            href="<?=base_url('tavern/blackjack')?>">
            <svg width="32" height="32" alt="Black Jack">
                <use xlink:href="#icon-cards"></use>
            </svg>
            Black Jack
        </a>
    </div>

    <h2>Black Jack</h2>

    <p class="mb-4">
        Here you can play Black Jack. Place a sum of money and press Play. If you do not win, the money will be lost. If
        you do win however, you'll get three times the bet.
    </p>

    <?php if (isset($viewdata['dealer_cards'])): ?>
    <div class="blackjack__dealer-cards mb-2">
        <h4>
            Dealers cards
            <?php if (isset($viewdata['total_dealer_value'])): ?>
            (<?=$viewdata['total_dealer_value']?>/21)
            <?php endif; ?>
        </h4>
        <div class="blackjack__table">
            <?php foreach ($viewdata['dealer_cards'] as $card): ?>
            <div
                class="blackjack__card blackjack__card--<?=$card['suite_name']?>">
                <span class="blackjack__card__symbol"><?=$card['suite_symbol']?></span><?=$card['value']?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($viewdata['cards']) && count($viewdata['cards']) > 0): ?>
    <div class="blackjack__player-cards">
        <h4>
            Your cards
            <?php if (isset($viewdata['total_value'])): ?>
            (<?=$viewdata['total_value']?>/21)
            <?php endif; ?>
        </h4>

        <div class="blackjack__table">
            <?php foreach ($viewdata['cards'] as $card): ?>
            <div
                class="blackjack__card blackjack__card--<?=$card['suite_name']?>">
                <span class="blackjack__card__symbol"><?=$card['suite_symbol']?></span><?=$card['value']?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!isset($viewdata['total_value']) && !isset($viewdata['busted']) && !isset($viewdata['player_won']) && !isset($viewdata['dealer_won'])): ?>
    <fieldset>
        <form class="ajaxJSON" method="post"
            action="<?=base_url('tavern/blackjack_play')?>">
            <input type="hidden" name="current_money" id="current_money"
                value="<?=$game['doubloons']?>">
            <input type="hidden" name="last_bet" id="last_bet"
                value="<?=isset($viewdata['next_bet']) ? $viewdata['next_bet'] : 0?>">

            <div
                class="slider-container blackjack__slider-container <?=count($viewdata['cards']) <= 0 ? 'blackjack__slider-container--active' : ''?>">
                <div id="blackjack-slider" class="slider"></div>

                <table>
                    <tr>
                        <td>Bet</td>
                        <td><span id="bet_presenter"><?=$viewdata['next_bet']?></span>
                            dbl</td>
                    </tr>
                    <tr>
                        <td>Doubloons left if you lose</td>
                        <td><span class="money_left"><?=$game['doubloons'] - $viewdata['next_bet']?></span>
                            dbl</td>
                    </tr>
                    <input type="hidden" id="bet" name="bet"
                        value="<?=$viewdata['next_bet']?>">
                </table>
            </div>

            <p
                class="text-right blackjack__bet-buttons <?=count($viewdata['cards']) <= 0 ? 'blackjack__bet-buttons--active' : ''?>">
                <button type="button" class="js-tavern-bet-set" data-value="10">10%</button>
                <button type="button" class="js-tavern-bet-set" data-value="25">25%</button>
                <button type="button" class="js-tavern-bet-set" data-value="50">50%</button>
                <button type="button" class="js-tavern-bet-set" data-value="75">75%</button>
                <button type="button" class="js-tavern-bet-set" data-value="100">100%</button>

                <button type="submit" class="primary">Play</button>
            </p>
        </form>
    </fieldset>
    <?php endif; ?>

    <?php if (isset($viewdata['total_value']) && !isset($viewdata['busted']) && !isset($viewdata['player_won']) && !isset($viewdata['dealer_won'])): ?>
    <form class="ajaxJSON" method="post"
        action="<?=base_url('tavern/blackjack_draw')?>">
        <p class="text-center">
            <a class="ajaxJSON button big"
                href="<?=base_url('tavern/blackjack_stand')?>"
                type="button">Stand</a>
            <button type="submit" class="primary big">Draw</button>
        </p>
    </form>
    <?php endif; ?>

    <?php if (isset($viewdata['busted']) || isset($viewdata['player_won']) || isset($viewdata['dealer_won'])): ?>
    <p class="text-center">
        <a class="ajaxHTML button big"
            href="<?=base_url('tavern/blackjack')?>"
            type="button">Play again</a>
    </p>
    <?php endif; ?>
</div>