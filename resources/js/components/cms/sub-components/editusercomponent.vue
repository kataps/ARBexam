<template>
    <div>
        <form  @submit.prevent="updateUser" v-if="this.userID != null" >
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" v-model="UserData.name"  class="form-control" >
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text"  v-model="UserData.username"  class="form-control" >
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email"  v-model="UserData.email" @blur="checkEmailifExist"  @keyup="isValidEmail=true" class="form-control" required>
                    <span style="color:red">{{ emailValidation }}</span>
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="text"  v-model="password"  class="form-control" >
                  
                </div>
                 
                <div class="form-group mb-2">
                    <label for="password2">Confirm Password</label>
                    <input type="text"  v-model="passwordConfirm"  class="form-control" >
                    
                </div>
                <span style="color:red"> {{ PasswordValidation }} </span>
                <div class="form-group">
                    <label for="">Role</label>
                        <select  v-model="selected_role" class="form-control" >
                                <option value="0" selected disabled> SELECT  ROLES </option>
                                <option  :value="role.id"  v-for="role in roles" :key="role.id"  > {{ role.name }}</option>
                        </select>
                </div>
                <button class="btn btn-success" type="submit">Update</button>
        </form>
    </div>
</template>

<script>
export default {
    props:{
        userID:{ type: Number },
        getUsers: { type: Function },
        users:{ type: Array }
    },
    data: function(){
        return {
            'UserData': [],
            'password':'',
            'passwordConfirm':'',
            'isValidEmail' : true,
            'selected_role':0,
            'roles': [],
            
        }
    },
    methods:{
        updateUser:function(){
             let data = {
                'username' : this.UserData.username,
                'newpassword': this.password,
                'password_confirm':this.passwordConfirm,
                'email' :  this.UserData.email,
                'name' : this.UserData.name,
                'role' : this.selected_role,
             }
             let url = "/webapi/user/"+this.userID;
             axios.put(url,data).then(resp =>{

                    if(resp.data.status == true){
                        this.getUsers();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: 'Account Successfully Created!',
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
                            title: 'Account Creation failed!',
                            html: errorm,
                            footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                        })
                   }
             });

        },
        checkEmailifExist: function(){
            let valid = true 
            this.getUsers();
            this.users.forEach(el =>{
                    if(el.email == this.UserData.email && el.id != this.UserData.id){
                        console.log(el.email);
                            return valid = false ;
                    }
            });
            this.isValidEmail = valid;
         },
    },
    watch:{
        userID: function(newVal, oldVal){
            let url = '/webapi/user/'+this.userID+'/edit';
             axios.get(url).then( resp =>{
                  this.UserData = resp.data.user;
                  this.selected_role = resp.data.role;
             });
        }
    },
    mounted:function(){
         axios('/webapi/roles/').then(response =>{
                     response.data.roles.forEach(role => {
                          this.roles.push({ name: role.name , id : role.id})
              });
         });
    },
   computed:{
        PasswordValidation: function(){
            if( this.password != this.passwordConfirm){
                  return "Password doesn't  match";
            }
            else{
                 return '';
            }
        },
        emailValidation : function(){
                if(this.isValidEmail == false ){
                     return  "Email Already Exist";
                }
                else{
                    return ''; 
                }
        }
    }
}
</script>

<style>

</style>