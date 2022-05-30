<script>
import { Doughnut } from "vue-chartjs";
export default {
    extends: Doughnut,
    props: ["data", "labels"],
    computed: {
        chartData() {
            return this.data;
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
                                "#34D399",
                                "#F59E0B",
                                "#B45309",
                                "#389941",
                                "#312E81"
                            ],
                            data: this.chartData
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
                    title: {
                        display: true,
                        text: "ITEM NOT AVAILABLE"
                    }
                }
                );
            }
    },
    watch: {
        data() {
            // this.$data._chart.destroy();
            this.loadChart();
        }
    },
    mounted() {
        this.loadChart();
    }
};
</script>
