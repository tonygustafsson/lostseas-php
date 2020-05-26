import { Line as ChartistLine } from 'chartist';

function checkAll(name) {
    if ($("input[name='check_all']").is(':checked')) {
        $("input[name='" + name + "[]']").prop('checked', true);
        $("input[name='" + name + "[]']")
            .parent()
            .parent()
            .css('background', '#e5f0f6');
    } else {
        $("input[name='" + name + "[]']").prop('checked', false);
        $("input[name='" + name + "[]']")
            .parent()
            .parent()
            .css('background', 'transparent');
    }
}

window.checkAll = checkAll;

$(document).on('click', '#crew_form tr td:not(:first-child)', function () {
    var thisCheckbox = $(this).parent().find('td:first-child').find('input[type="checkbox"]');

    if (thisCheckbox.length !== 0) {
        if (thisCheckbox.is(':checked')) {
            thisCheckbox.prop('checked', false);
            $(this).parent().css('background', 'transparent');
        } else {
            thisCheckbox.prop('checked', true);
            $(this).parent().css('background', '#e5f0f6');
        }
    }
});

$(document).on('change', '#crew_form input[type=checkbox]', function () {
    if ($(this).is(':checked')) {
        $(this).parent().parent().css('background', '#e5f0f6');
    } else {
        $(this).parent().parent().css('background', 'transparent');
    }
});

$(document).on('change', '#history_weeks', function () {
    var url = $('#base_url').val() + '/' + $('#history_data').val() + '/' + $('#history_weeks').val();
    $('#history_update_link').attr('href', url);
});

$(document).on('change', '#history_data', function () {
    var url = $('#base_url').val() + '/' + $('#history_data').val() + '/' + $('#history_weeks').val();
    $('#history_update_link').attr('href', url);
});

const createInventoryGraph = () => {
    const chartHistoryEl = document.querySelector('.js-chartist-history');

    if (!chartHistoryEl || !chartHistoryEl.dataset.chartData || !chartHistoryEl.dataset.chartLabels) {
        return;
    }

    let chartData = chartHistoryEl.dataset.chartData;
    chartData = chartData.split(',');
    chartData = chartData.map((x) => parseInt(x, 10));

    let chartLabels = chartHistoryEl.dataset.chartLabels;
    chartLabels = chartLabels.split(',');

    const data = {
        labels: chartLabels,
        series: [chartData]
    };

    const options = {
        axisX: {
            labelOffset: {
                x: -15
            }
        },
        axisY: {
            onlyInteger: true,
            labelOffset: {
                y: 6
            }
        },
        showArea: true,
        fullWidth: true,
        height: 400,
        chartPadding: {
            right: 0,
            left: 0
        }
    };

    const responsiveOptions = [
        [
            'screen and (min-width: 800px)',
            {
                chartPadding: {
                    right: 120,
                    left: 120
                }
            }
        ]
    ];

    new ChartistLine(chartHistoryEl, data, options, responsiveOptions);
};

window.addEventListener('inventory-history', createInventoryGraph);
