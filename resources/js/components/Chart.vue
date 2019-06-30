<script>
import { Line } from 'vue-chartjs'
export default {
  name:'Chart',
  extends: Line,
  props:['labels','values', 'currency'],
  data(){
  	return{
  		chartdata:{
  			labels: this.labels,
        datasets: [{
            label: this.currency,
            data: this.values,
            backgroundColor: [
                'rgba(0, 153, 255, 0.2)',
            ],
            borderColor: [
                'rgba(0, 153, 255, 1)',
            ],
            borderWidth: 1
        }
        ]
  		},
  		options:{
  			responsive:false,
  			scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    precision:1
                }
            }]
        }
  		}
  	}
  },
  watch:{
    labels(){
      this.reRenderChart();
    }
  },
  mounted () {
   this.reRenderChart();
  },
  methods:{
      reRenderChart(){
      this.chartdata.labels = this.labels;
      this.chartdata.datasets[0].data = this.values;
       this.chartdata.datasets[0].label= this.currency;
      this.renderChart(this.chartdata, this.options);
  }
  }
}
</script>

<style lang="css" scoped>
</style>