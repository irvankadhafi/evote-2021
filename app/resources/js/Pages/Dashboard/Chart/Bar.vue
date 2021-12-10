<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  props:['label', 'chartData'],
  computed: {
    chartDatas() {
      return this.chartData
    },
  },
  watch:{
    data: function() {
      this._chart.destroy()
      this.renderBarChart()
    },
  },
  mounted() {
    this.renderBarChart()
  },
  methods:{
    renderBarChart(){
      this.renderChart({
        labels: this.label,
        datasets: [
          {
            label: 'Hasil',
            backgroundColor: ['#1c64f2', '#0694a2', '#7e3af2'],
            borderColor: ['#1c64f2', '#0694a2', '#7e3af2'],
            data: this.chartDatas,
            borderWidth: 1,
          },
        ],
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
            },
          }],
        },
      })
    },
  },
}
</script>
