import { Line as ChartistLine } from 'chartist';

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
