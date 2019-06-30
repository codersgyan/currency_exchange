<template>
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Загрузка и хранение курсов валют</h5>
                <div class="card-body">
                  <form @submit.prevent="fetch">
                    <div class="row">
                      <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Дата</label>
                        <div class="d-flex">
                        <input type="date" class="form-control" v-model="form.date" name="date" id="exampleFormControlInput1" required>
                        </div>
                      </div>
                      </div>
                    </div>

                      <div class="form-check mb-4">
                          <input class="form-check-input" v-model="form.save_to_db" type="checkbox" name="save_to_db" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                          Сохранить в базе
                          </label>
                      </div>
                      <div class="d-flex align-items-center">
                                 <Loader v-show="loading"></Loader>
                        <button type="submit" class="btn btn-success ml-3">Загрузить</button>
                      </div>
                  </form>
                </div>
              </div>
          </div>
      </div>
          <ShowCurrencies :exchanges="exchanges"></ShowCurrencies>
  </div>
</template>

<script>
import ShowCurrencies from './ShowCurrencies.vue'
import Loader from './Loader.vue'
    export default {
        components:{
           ShowCurrencies,
           Loader
        },
        data(){
          return{
            form:{
              date:'',
              save_to_db:''
            },
            exchanges:{},
            loading:false
          }
        },
        methods:{
          fetch(){
            this.loading=true;
            axios.post('/exchange-rates/fetch',this.form)
              .then(response=>{
                if(response.data.responseCode===200){
                  this.loading=false;
                  this.exchanges = response.data.data;
                }
              }).catch(err=>{
                 this.loading=false;
              })
          }
        }
    }
</script>
