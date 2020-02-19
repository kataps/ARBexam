<template>
    <div>
       <div class="container-fluid w-100 bg-light vh-100">
            <div class="app-page-title w-100 mt-4">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-stopwatch icon-gradient bg-amy-crisp">
                            </i>
                        </div>
                        <div>Expenses Management
                            <div class="page-title-subheading">Keep Moving forward :)
                            </div>
                        </div>
                     </div>
             </div>
             <div class="card">
                 <div class="card-body">    
                        <!-- modal add-->
                        <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target=".bd-example-modal-add-lg" >Add Expense</button>
                        <div class="modal fade bd-example-modal-add-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                            <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Expense </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                        </div>
                                        <div class="modal-body">
                                                <AddExpenses :allExpense="getAllExpenses"  />
                                        </div>
                                    </div>
                                </div>
                        </div>                    
                       <!-- modal edit -->
                        <div class="modal fade bd-example-modal-edit-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                            <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Expense </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <EditExpenses  :expenseID="sel_exp_id"  :allExpense="getAllExpenses"   />
                                                    <!-- <EditExpCategory :categoryID="sel_cat_id"  :allCategory="getAllExpCategory"  /> -->
                                            </div>
                                    </div>
                                </div>
                        </div>

                        <table class="table mt-3">
                            <thead>
                                <th> Expense Category</th>
                                <th>Amount</th>
                                <th> Entry Date</th>
                                <th> Created at</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                    <tr v-for="expense in expenses"  :key="expense.id" >
                                        <td>{{ expense.categoryName }}</td>
                                        <td> {{ expense.amount }} </td>
                                        <td>{{ expense.entry_date }} </td>
                                        <td>{{ expense.created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-toggle="modal" @click="editExpense(expense.id)" data-target=".bd-example-modal-edit-lg" ><i class="pe-7s-edit"/> Edit</button>
                                           <button class="btn btn-danger"  @click="deleteExpense(expense.id)"> <i class="pe-7s-delete-user"></i> Delete</button>
    
                                        </td>
                                    </tr>
                            </tbody>
                        </table>


                 </div>
             </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function(){
        return {
            'expenses': [],
            'sel_exp_id': null,
        }
    },
    methods:{
        getAllExpenses: function(){
            let url = '/webapi/expenses';
            axios.get(url).then(resp => {
                this.expenses = resp.data.expenses;
            });
        },
        editExpense:function(id){
            this.sel_exp_id = id;
        },
        deleteExpense: function(id){
           let url = "webapi/expenses/"+id;
            axios.delete(url).then(resp => {
                this.getAllExpenses();
            });
        }
    },
    mounted:function(){
        this.getAllExpenses()
    }

}
</script>

<style>

</style>