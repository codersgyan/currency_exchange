<template>
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Выгружать в json</h5>
                <div class="card-body">
                  <form @submit.prevent="exportToJson">
                    <div class="row">
                      <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">From Date</label>
                        <div class="d-flex">
                        <input type="date" class="form-control" v-model="form.from_date" id="exampleFormControlInput1" required>
                        </div>
                      </div>
                      </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Till Date</label>
                        <div class="d-flex">
                        <input type="date" class="form-control" v-model="form.till_date" id="exampleFormControlInput2" required>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div v-if="noResult" class="alert alert-warning" role="alert">
                      No result!
                    </div>
                    <div v-if="flash" class="alert alert-success" role="alert">
                     Data exported to a file as json format. to download file <a href="/reports">Visit here</a>
                    </div>

                      <div class="d-flex align-items-center">
                                 <Loader v-show="loading"></Loader>
                        <button type="submit" class="btn btn-primary ml-3">Выгружать в json</button>
                      </div>
                  </form>
                </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import Loader from './Loader.vue'
    export default {
        components:{
           Loader
        },
        data(){
          return{
            form:{
              from_date:'',
              till_date:''
            },
            noResult:false,
            flash:false,
            loading:false
          }
        },
        methods:{
          exportToJson(){
            this.loading=true;
            axios.post('/reports/export-to-json',this.form)
              .then(response=>{
                if(response.data===100){
                  this.noResult = true;
                  this.loading=false;
                } else {
                  this.noResult = false;
                  this.flash = true;
                  this.loading=false;
                }
              }).catch(err=>{
                 this.loading=false;
                  this.noResult = false;
              })
          }
        }
    }
</script>
