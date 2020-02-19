<template>
    <div>
          <form @submit.prevent="addExpense" >
              
              <div class="row " style="max-width:80%;margin:0 auto;">
                  <div class="col-md-6">
                      <div class="form-group mb-4">
                           <label for=""> Expense Category</label>
                      </div>
                      <div class="form-group mb-4">
                           <label for="">Amount</label>
                      </div>
                       <div class="form-group mb-4"> 
                             <label for=""> Entry Date</label>
                       </div>
                       <div class="form-group mb-4">
                               <button class="btn btn-primary" type="submit">Submit</button>
                       </div>
                  </div>
                  <div class="col-md-6"> 
                         <div class="form-group">
                             <select v-model="expensecat_selected" class="form-control" required >
                                    <option value="" disabled selected> Select a Category</option>
                                    <option  :value="ecategory.id" v-for="ecategory  in expense_category" :key="ecategory.id"> {{ ecategory.name }}</option>
                             </select>
                       </div>
                       <div class="form-group">
                         <input v-model="amount" type="number" class="form-control" required >
                       </div>

                        <div class="form-group">
                            <input v-model="entry_date" type="date" class="form-control" required >
                        </div>
                 </div>
              </div>
          
          </form>
    </div>
</template>
<script>
export default {
    props:{
        allExpense:{ type: Function},
    },
    data: function(){
        return {
            'expense_category':[],
            'expensecat_selected': '',
            'amount':null,
            'entry_date': null,
        }
    },
    methods:{
        addExpense: function(){
              let data = {
                  'category': this.expensecat_selected,
                  'amount' : this.amount,
                  'edate': this.entry_date,
              }
              let url = "/webapi/expenses";
              axios.post(url,data).then( resp =>{
                    if(resp.data.status == true){
                        this.allExpense();
                        this.expensecat_selected = '';
                        this.amount = null;
                        this.entry_date = null;
                         Swal.fire({
                              icon: 'success',
                              title: 'Success',
                              html: 'New Category Successfully Created!',
                              footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                          });
                    }else{
                         let errorm = '';
                         Object.keys(response.data.message).forEach(function(key) {
                              var value = response.data.message[key];
                              
                              value.forEach( element => {
                                   errorm = errorm + "<br>"+element;
                              });
                          });
                          Swal.fire({
                              icon: 'error',
                              title: 'Account Creation failed!',
                              html: errorm,
                              footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                          })
                    }


              });

        },
        getExpenseCategories: function(){
            let url = '/webapi/expense-categories';
              axios.get(url).then(resp => {
                this.expense_category = resp.data.categories;
            });
        }
    },
    mounted:function(){
        this.getExpenseCategories();
    }

}
</script>

<style>

</style>