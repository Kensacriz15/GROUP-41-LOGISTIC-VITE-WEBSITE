import Chart from 'chart.js/auto';

try {
  window.Chart = Chart;
} catch (e) {}

export { Chart };

export default {
  mounted() {
    // Fetch top product data from your Laravel controller
    fetch('/top-products')
      .then(response => response.json())
      .then(data => {
        const chartElement = document.getElementById('topProductsChart');
        const topProductsChart = new Chart(chartElement, {
          type: 'bar',
          data: {
            labels: data.productNames,
            datasets: [
              {
                label: 'Quantity Sold',
                data: data.quantitiesSold,
                backgroundColor: 'rgba(255, 205, 86, 0.5)' // Yellow
              }
            ]
          }
        });
      });
  }
};
