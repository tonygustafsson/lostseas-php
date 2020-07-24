import { Line as ChartistLine } from 'chartist';

const initGraph = (chartHistoryEl) => {
    if (!chartHistoryEl || !chartHistoryEl.dataset.chartData || !chartHistoryEl.dataset.chartLabels) {
        return;
    }

    let chartData = chartHistoryEl.dataset.chartData;
    chartData = JSON.parse(chartData);
    chartData = chartData.map((x) => parseInt(x, 10));

    let chartLabels = chartHistoryEl.dataset.chartLabels;
    chartLabels = JSON.parse(chartLabels);

    const data = {
        labels: chartLabels,
        series: [chartData]
    };

    const options = {
        axisY: {
            onlyInteger: true
        },
        showArea: true,
        fullWidth: true,
        height: 400,
        chartPadding: {
            right: 0,
            left: 0
        }
    };

    new ChartistLine(chartHistoryEl, data, options);
};

const graphSettingsLinkClick = (e) => {
    e.preventDefault();

    const link = e.target;
    const baseUrl = document.getElementById('base_url').value;
    const weeksSettingsEl = document.getElementById('history_weeks');
    const url = `${baseUrl}/${weeksSettingsEl.value}`;

    link.href = url;
    link.click();
};

const initGraphSettingsChange = () => {
    const link = document.getElementById('history_update_link');

    link.addEventListener('click', graphSettingsLinkClick);
};

const initGraphs = () => {
    const chartHistoryEls = Array.from(document.querySelectorAll('.js-chartist-history'));

    chartHistoryEls.forEach((el) => {
        initGraph(el);
    });
};

window.addEventListener('inventory-history', () => {
    initGraphs();
    initGraphSettingsChange();
});
