import { Line as ChartistLine } from 'chartist';

const initGraph = () => {
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

const graphSettingsLinkClick = (e) => {
    e.preventDefault();

    const link = e.target;
    const baseUrl = document.getElementById('base_url').value;
    const weeksSettingsEl = document.getElementById('history_weeks');
    const dataTypeEl = document.getElementById('history_data');
    const url = `${baseUrl}/${dataTypeEl.value}/${weeksSettingsEl.value}`;

    link.href = url;
    link.click();
};

const initGraphSettingsChange = () => {
    const link = document.getElementById('history_update_link');

    link.addEventListener('click', graphSettingsLinkClick);
};

window.addEventListener('inventory-history', () => {
    initGraph();
    initGraphSettingsChange();
});
