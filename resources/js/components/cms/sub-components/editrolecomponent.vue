<template>
    <div>
        <form @submit.prevent = "EditRole" >
            <div class="form-group">
                    <label for="">Name</label>
                     <input type="text"  v-model="role_name" class="form-control" required>
                     <span style="color:red">{{ roleValidation }}</span>
            </div>
            <div class="form-group">
                    <label for="">Description</label>
                    <input type="text" v-model="role_description" class="form-control" required>
                      <span style="color:red">{{ descValidation }}</span>
            </div>
             <button class="btn btn-primary"> Update </button>
        </form>
    </div>
</template>

<script>
export default {
    props:{
        getAllRoles: { type: Function },
        roleID: { type: Number }
    },
    data:function(){
        return {
            'role_name': null,
            'role_description':null,
            'haserror': false,
        }
    },
    methods:{
        EditRole: function(){
            if(this.haserror == false){
                     let data = {
                          'roleName': this.role_name,
                          'roleDesc' : this.role_description,
                     }
                     let url = "/webapi/roles/"+this.roleID;
                     axios.put(url,data).then(resp =>{
                            if(resp.data.status == true ){
                                    this.getAllRoles();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        html: 'Role Successfully Modified!',
                                        footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                                    });
                            }else{
                                    let errorm = '';
                                        Object.keys(resp.data.message).forEach(function(key) {
                                        var value = resp.data.message[key];
                                        value.forEach( element => {
                                        errorm = errorm + "<br>"+element;
                                        });
                                   });
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Role Update Failed!',
                                        html: errorm,
                                        footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                                    })
                            }
                     });

            }else{
                 
            }

        },

    },
    watch:{
        roleID: function(newVal, oldVal){
            let url = '/webapi/roles/'+this.roleID+'/edit';
             axios.get(url).then( resp =>{
                  console.log(resp.data);
                  this.role_name = resp.data.roleName;
                  this.role_description = resp.data.roleDesc;
             });
             console.log(this.role_name , this.role_description);
        }
    },
    computed:{
       roleValidation:function(){
            if(this.role_name == ''){
                 this.haserror = true;
                 return 'This shoudn\'t be empty!';
            }else{
                this.haserror = false;
                 return ''
            }
       },
       descValidation: function(){
             if(this.role_description == ''){
                    this.haserror = true;
                      return 'This shoudn\'t be empty!';  
             }else{
                this.haserror = false;
                 return '';
            }
       },
    }
}
</script>

<style>

</style>