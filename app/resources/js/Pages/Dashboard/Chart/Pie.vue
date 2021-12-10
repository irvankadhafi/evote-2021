<script>
import { Doughnut } from 'vue-chartjs'
export default {
  extends: Doughnut,
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
            label: 'Mahasiswa',
            backgroundColor: ['#1c64f2', 'rgb(239, 68, 68)'],
            data: this.chartDatas,
          },
        ],
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
      })
    },
  },
}
</script>
