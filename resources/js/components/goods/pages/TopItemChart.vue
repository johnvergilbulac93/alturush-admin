<script>
import { Line } from "vue-chartjs";
export default {
    extends: Line,
    props: ["data", "labels", "year", "month", "flag"],
    computed: {
        chartData() {
            return this.data;
        },
        chartLabels() {
            return this.labels;
        },
        newLabel(){
            if(this.flag){
                return  moment(this.year).format("YYYY");
            }else{
                return  moment(this.year).format("YYYY") + ' - ' + moment(this.month).format("MMMM");
            }
        }
    },
    methods: {  
        loadChart() {
            this.renderChart(
                {
                    labels: this.chartLabels,
                    datasets: [
                        {
                            label: this.newLabel,
                            data: this.chartData,
                            backgroundColor: "#3B82F6",
                            borderColor: "#3B82F6",
                            fill: false,
                            tension: 0.2
                        }
                    ]
                },
                {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: "TOP 10 ITEM"
                    },
                    tooltips: {
                        mode: "label",
                        intersect: false
                    },
                    hover: {
                        mode: "nearest",
                        intersect: true
                    },
                    scales: {
                        //     xAxes: [
                        //         {
                        //             display: true,
                        //             scaleLabel: {
                        //                 display: true,
                        //                 labelString: "Item Description"
                        //             }
                        //         }
                        //     ],
                        yAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: "Quantity"
                                },
                            }
                        ],
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
