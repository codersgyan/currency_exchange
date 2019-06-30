<template>
	<div>
		<form action="" @submit.prevent="loadData">
	<div class="inputs d-flex mt-5 mb-5">
		<div class="form-group mr-4">
				<label>Select Currency</label>
			<select v-model="form.currency_id" 
				class="form-control" 
				name="currency" 
				@change="watchSelectedCurrency($event)" 
				required>
			  <option v-for="currency in currency_codes" 
			  	:value="currency.currency_id" 
			  	:data-item-type="currency.currency_code">{{ currency.currency_code }}</option>
			</select>
		</div>

		<div class="form-group mr-4">
		    <label for="exampleFormControlInput1">From Date</label>
		    <input v-model="form.from_date" type="date" class="form-control" id="exampleFormControlInput1" required>
		</div>

		<div class="form-group mr-4 d-flex align-items-end">
			<div class="mr-4">
			<label for="exampleFormControlInput2">Till Date</label>
		    <input v-model="form.till_date" type="date" class="form-control" id="exampleFormControlInput2" required>	
			</div>

			  <div class="form-check">
			    <input type="checkbox" v-model="form.storeAsJson" class="form-check-input" id="exampleCheck1">
			    <label class="form-check-label" for="exampleCheck1">Save reports to json</label>
			  </div>


			<div class="ml-4 d-flex align-items-center">
				<button type="submit" class="btn btn-primary mr-4">Search</button>
				<Loader v-if="loading"></Loader>
			</div>

		</div>



		</div>
		</form>
		<Chart 
		v-if="loadChart"
		:currency="selectedCurrency"
		:width="1130" 
		:height="500"
		:labels="labels"
		:values="values"
		></Chart>	
	</div>
</template>

<script>
import Chart from './Chart.vue'
import Loader from './Loader.vue'
export default {
  name: 'CurrencyChart',
  components:{
  	Chart,
  	Loader
  },

  data () {
    return {
    	currency_codes:[],
    	labels:[],
    	values:[],
    	selectedCurrency:'USD',
    	loadChart:false,
    	loading:false,
    	form:{
    		currency_id:'',
    		from_date:'',
    		till_date:'',
    		storeAsJson:false
    	}
    }
  },
  mounted(){
  	this.fetchCurrencyList();
  	this.loadData();
  },
  methods:{
  	fetchCurrencyList(){
  		axios.get('/exchanges/currency-codes').then(response=>{
  			this.currency_codes = response.data;
  		}).catch(err=>{

  		})
  	},
  	loadData(){
  		this.loading = true;
  		axios.post('/exchanges/analytics',this.form).then(response=>{
  			this.labels = Object.keys(response.data);
  			this.values = Object.values(response.data);
  			this.loadChart = true;
  			this.loading = false;
  		}).catch(err=>{
	this.loading = false;
  		})
  	},
        watchSelectedCurrency(event){
        this.selectedCurrency = event.target.options[event.target.selectedIndex]
        .attributes['data-item-type'].value;
    }
  }
}
</script>

<style lang="css" scoped>
</style>