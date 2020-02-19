<template>
    <div>
        <div class="container-fluid w-100 bg-light vh-100">
            <div class="app-page-title w-100 mt-4">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-stopwatch icon-gradient bg-amy-crisp">
                            </i>
                        </div>
                        <div>Role Management
                            <div class="page-title-subheading">Keep Moving forward :)
                            </div>
                        </div>
                     </div>
             </div>

            <div class="card">
                 <div class="card-body">
                      <!-- modal -->
                        <button type="button" class="btn mr-2 mb-2 btn-info text-white" data-toggle="modal" data-target=".bd-example-modal-sm">Add Role</button>
                        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Role </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                           <AddRole :getAllRoles="getAllRoles"/>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <div class="modal fade bd-example-modal-sm-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top:100px !important">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Role </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                           <EditRole :getAllRoles="getAllRoles" :roleID="sel_role_id" />
                                    </div>
                                </div>
                            </div>
                          </div>
                        <!-- mdoal -->
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in roles" :key="role.id">
                                <td>{{ role.id}}</td>
                                <th scope="row" >{{ role.name }}</th>
                                <td> {{ role.description }}</td>
                                <td>
                                   <button type="button" @click="selectRole(role.id)" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-sm-edit"><i class="pe-7s-edit"/> Edit</button>
                                    <button type="button" @click="deleteRole(role.id)" class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-edit-lg" ><i class="pe-7s-delete-user"/> Delete</button>
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
            'roles':[],
             'sel_role_id': null,
        }
    },
    methods:{
        getAllRoles :function(){
           let url = '/webapi/roles';
                axios.get(url).then(resp =>{
                        this.roles = resp.data.roles;         
            });
        },
        deleteRole : function(id){
             let url = '/webapi/roles/'+id;
             axios.delete(url).then(resp =>{
                 if(resp.data.status == true ){
                    this.getAllRoles();
                 }
             });
        },
        selectRole: function(id){
                this.sel_role_id = id;
        }
    },
    mounted:function(){
        this.getAllRoles()
    }
}
</script>
<style>

</style>