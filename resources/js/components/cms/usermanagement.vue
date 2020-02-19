<template>
    <div>
        <div class="container-fluid w-100 bg-light vh-100">
             <div class="app-page-title w-100 mt-4">
                    <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-stopwatch icon-gradient bg-amy-crisp">
                                    </i>
                                </div>
                                <div>User Management
                                    <div class="page-title-subheading">Keep Moving forward :)
                                    </div>
                                </div>
                     </div>
             </div>
              <div class="card p-3">
                  <div class="card-body">
                      <div class="table-responsive">
                           <!-- modal -->
                                    <!-- Add User modal -->
                                        <button type="button" class="btn mr-2 mb-2 btn-info text-white" data-toggle="modal" data-target=".bd-example-modal-lg">Add User</button>
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Add User </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                            <AddUser :getUsers="getAllUser" :users="users"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                 <!-- Edit User Modal -->
                            <div class="modal fade bd-example-modal-edit-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Update User </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                <div class="modal-body">
                                        <EditUser :userID="sel_user_id"  :getUsers="getAllUser" :users="users" />
                                </div>
                                    </div>
                                </div>
                            </div>
                           <!-- end of modal -->



                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" v-bind:key="user.id" >
                                            <td>    
                                                    {{ user.name }}
                                            </td>
                                            <td>    
                                                    {{ user.email }}
                                            </td>
                                            <td>    
                                                    {{ user.role }}
                                            </td>
                                            <td>    
                                                 <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-edit-lg" @click="modifyUser(user.id)"><i class="pe-7s-edit"/> Edit</button>
                                                <button class="btn btn-danger" @click="deleteUser(user.id)"> <i class="pe-7s-delete-user"></i> Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>    
                        </div>
                  </div>
              </div>      
         </div>
     </div>
</template>
<script>
export default {
    data: function(){
            return {
                    'users':[],
                    'sel_user_id' : null,
                }
    },
    methods:{
        modifyUser:function(id){
            this.sel_user_id = id;
        },
        deleteUser:function(id){
            let url = 'webapi/user/'+id;
            axios.delete(url).then(response =>{
                this.users = response.data.users
            });
        },
        getAllUser:function(){
                axios.get('webapi/user').then(response =>{
                    this.users = response.data.users;
            });
        }
    },
    mounted:function(){
        this.getAllUser();
    }
}
</script>

<style>

</style>