<script>
import { Pie } from "vue-chartjs";
import Chart from "chart.js";

export default {
    name: "TopProductChart",
    extends: Pie,
    props: ["disable_product"],
    computed: {
        chartQty() {
            return this.disable_product.qty;
        },
        chartLabels() {
            return this.disable_product.labels;
        }
    },
    methods: {
        loadChart() {
            this.renderChart(
                {
                    labels: this.chartLabels,
                    datasets: [
                        {
                            backgroundColor: [
                                "#41B883",
                                "#E46651",
                                "#00D8FF",
                                "#DD1B16",
                                "#fcc203",
                                "#fc03ba",
                                "#8c828a",
                                "#1a0115",
                                "#1f3959",
                                "#1ddbb5"
                            ],
                            data: this.chartQty
                        }
                    ]
                },
                {
                    responsive: true,
                    maintainAspectRatio: false,
                    resizeDelay: 0,
                    animation: {
                        animateRotate: true
                    },
                    legend: {
                        position: "top"
                    }
                }
            );
        }
    },
    watch: {
        disable_product() {
            this.loadChart();
        }
    },
    mounted() {
        this.loadChart();
    }
};
</script>
