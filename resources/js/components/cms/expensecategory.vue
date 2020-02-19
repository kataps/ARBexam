<template>
    <div>
       <div class="container-fluid w-100 bg-light vh-100">
            <div class="app-page-title w-100 mt-4">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-stopwatch icon-gradient bg-amy-crisp">
                            </i>
                        </div>
                        <div>Expense Category Management
                            <div class="page-title-subheading">Keep Moving forward :)
                            </div>
                        </div>
                     </div>
             </div>
             <div class="card">
                 <div class="card-body">
                       <!-- modal add-->
                        <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target=".bd-example-modal-add-lg" >Add Expense Category</button>
                        <div class="modal fade bd-example-modal-add-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                            <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Category </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                        </div>
                                        <div class="modal-body">
                                                <AddExpCategory :allCategory="getAllExpCategory"  />
                                        </div>
                                    </div>
                                </div>
                        </div>                    
                    <!-- modal edit -->
                        <div class="modal fade bd-example-modal-edit-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                            <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Category </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <EditExpCategory :categoryID="sel_cat_id"  :allCategory="getAllExpCategory"  />
                                            </div>
                                    </div>
                                </div>
                        </div>
                        <table class="table mt-3">
                             <thead>
                                <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr  v-for ="category in expCategories" :key="category.id" >
                                    <td > {{ category.name }}</td>
                                    <td >{{ category.description }}</td>
                                    <td >
                                          <button type="button" class="btn btn-success" data-toggle="modal" @click="editCategory(category.id)" data-target=".bd-example-modal-edit-lg" ><i class="pe-7s-edit"/> Edit</button>
                                           <button class="btn btn-danger"  @click="deleteCategory(category.id)"> <i class="pe-7s-delete-user"></i> Delete</button>
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
  data : function(){
      return {
           'expCategories': [],
           'sel_cat_id' : null,
      }
  },
  methods:{
      getAllExpCategory:function(){
         let url = '/webapi/expense-categories';
         axios.get(url).then(resp => {
             this.expCategories = resp.data.categories;
         });
      },
      editCategory: function(id){
        this.sel_cat_id = id 
      },
      deleteCategory:function(id){
           
           let url = "webapi/expense-categories/"+id;
            axios.delete(url).then(resp => {
                this.getAllExpCategory();
            });
      }
  },
  mounted:function(){
      this.getAllExpCategory();

  }


}
</script>

<style>

</style>