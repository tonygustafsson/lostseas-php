"use strict";

$('.actions img').tooltip();

function tavernGambleSlider(sliderId, inputId, standard, minimum, maximum) {
	$(sliderId).slider({
		range: "min",
		animate: "fast",
		value: standard,
		min: minimum,
		max: maximum,
		slide: function(event, ui) {
			$(inputId).val(ui.value);
			$(inputId + '_presenter').html(ui.value);
			
			var currentMoney = parseInt($('#current_money').val(), 10);
			$('span.money_left').html(currentMoney - ui.value);
		}
	});
}

function createSliders() {
	if ($('#gamble-slider').length)	{
		var currentMoney = parseInt($('#current_money').val(), 10);
		var lastBet = parseInt($('#last_bet').val(), 10);
		tavernGambleSlider('#gamble-slider', '#bet', lastBet, 0, currentMoney);
	}
}

function tavernChangeSlider(inputId, sliderValue) {
	$(inputId).val(sliderValue);
	$(inputId + '_presenter').html(sliderValue);
	
	var numberOfMen = parseInt($('#number_of_men').val(), 10);
	var currentMoney = parseInt($('#current_money').val(), 10);

	var crewLowestMood = parseInt($('#crew_lowest_mood').val(), 10);
	var crewLowestHealth = parseInt($('#crew_lowest_health').val(), 10);

	var dinnerQuantity = parseInt($('#dinner_quantity').val(), 10);
	var wineQuantity = parseInt($('#wine_quantity').val(), 10);
	var rumQuantity = parseInt($('#rum_quantity').val(), 10);
	
	var totalCost = ((dinnerQuantity * 10) + (wineQuantity * 15) + (rumQuantity * 20)) * numberOfMen;
	var newMood = dinnerQuantity + (wineQuantity * 2) + (rumQuantity * 3);
	var newHealth = dinnerQuantity * 10;
	
	var totalMood = crewLowestMood + newMood;
	if (totalMood > 40) { totalMood = 40; }
	
	var totalHealth = crewLowestHealth + newHealth;
	if (totalHealth > 100) { totalHealth = 100; }
	
	$('span.money_left').html(currentMoney - totalCost);
	$('span.crew_new_mood').html(totalMood);
	$('span.crew_new_health').html(totalHealth);

	if ((currentMoney - totalCost) < 0)	{
		$('span.money_left').css('color', '#d52525');
	}
	else {
		$('span.money_left').css('color', '#000');
	}
}

function tavernReset() {
	if ($('#dinner-slider').slider('option', 'value', 0)) {
		tavernChangeSlider('#dinner_quantity', 0);
	}
	
	if ($('#wine-slider').slider('option', 'value', 0)) {
		tavernChangeSlider('#wine_quantity', 0);
	}
	
	if ($('#rum-slider').slider('option', 'value', 0)) {
		tavernChangeSlider('#rum_quantity', 0);
	}
	
	return false;
}

function tavernGambleSet(percent) {
	var currentMoney = parseInt($('#current_money').val(), 10);
	var theBet = Math.floor(currentMoney * (percent / 100));
	
	$('#gamble-slider').slider('option', 'max', currentMoney);

	if ($('#gamble-slider').slider('option', 'value', theBet)) {
		$('#bet_presenter').html(theBet);
		$('#bet').val(theBet);
		$('span.money_left').html(currentMoney - theBet);
	}
	
	return false;
}

setTimeout(createSliders, 100);