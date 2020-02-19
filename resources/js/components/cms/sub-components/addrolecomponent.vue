<template>
    <div>
        <form @submit.prevent = "SubmitRole" >
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
             <button class="btn btn-primary"> Add Role </button>
        </form>
    </div>
</template>

<script>
export default {
    props:{
        getAllRoles: { type: Function }
    },
    data:function(){
        return {
            'role_name': null,
            'role_description':null,
            'haserror': false,
        }
    },
    methods:{
        SubmitRole: function(){
            if(this.haserror == false){
                     let data = {
                          'roleName': this.role_name,
                          'roleDesc' : this.role_description,
                     }
                     let url = "/webapi/roles";
                     axios.post(url,data).then(resp =>{
                           
                            if(resp.data.status == true ){
                                    this.getAllRoles();
                                    this.role_name = null
                                    this.role_description = null
                                     Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        html: 'Role Successfully Created!',
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

            }else{
                 
            }

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