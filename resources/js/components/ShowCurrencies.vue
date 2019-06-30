<template>
  <div class="row">
  <div v-if="Object.keys(exchanges).length !== 0" class="alert alert-info mt-5" role="alert">
 Показаны результаты за {{ exchanges['@attributes']['Date'] }}.
  </div>
	 <table v-if="Object.keys(exchanges).length !== 0" class="table table-striped table-light mt-5">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Num Code</th>
                      <th scope="col">Currency Code</th>
                      <th scope="col">Currency Name</th>
                      <th scope="col">Nominal</th>
                      <th scope="col">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="exchange in exchanges.Valute">
                      <th scope="row">{{ exchange['@attributes'].ID}}</th>
                      <td>{{ exchange.NumCode }}</td>
                      <td>{{ exchange.CharCode }}</td>
                      <td>{{ exchange.Name }}</td>
                      <td>{{ exchange.Nominal }}</td>
                      <td>{{ exchange.Value }}</td>
                    </tr>
                  </tbody>
                </table>
</div>
</template>

<script>
export default {
props:{
  exchanges:{
    type:Object,
  }
},
  name: 'ShowCurrencies',

  data () {
    return {

    }
  },
}
</script>

<style lang="css" scoped>
</style>