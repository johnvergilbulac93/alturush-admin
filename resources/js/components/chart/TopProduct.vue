<script>
import { Pie } from "vue-chartjs";

export default {
    name: "TopProductChart",
    extends: Pie,
    props: ["qty", "labels"],
    computed: {
        chartQty() {
            return this.qty;
        },
        chartLabels() {
            return this.labels;
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
                        position: "right"
                    }
                }
            );
        }
    },
    watch: {
        labels() {
            this.loadChart();
        }
    },
    mounted() {
        this.loadChart();
    }
};
</script>
