<template>
   <div>
       <form @submit.prevent="addUser" class="form">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" v-model="name"  class="form-control" required>
        
        </div>
        <div class="form-group">
            <label for="">Username</label>
            <input type="text"  v-model="username"  class="form-control" required>
            
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email"  v-model="email" @blur="checkEmailifExist"  @keyup="isValidEmail=true" class="form-control" required>
              <span style="color:red">{{ emailValidation }}</span>
        </div>
        
        <div class="form-group">
            <label for="">Password</label>
            <input type="text"  v-model="password"  class="form-control" required>
            <span style="color:red"> {{  PasswordValidation }} </span>
        </div>
        
        <div class="form-group">
            <label for="password2">Confirm Password</label>
            <input type="text"  v-model="password2"  class="form-control" required>
            <span style="color:red">{{ PasswordValidation  }}</span>
        </div>
        <div class="form-group">
            <label for="">Role</label>
            <select  v-model="selected_role" class="form-control" >
                    <option value="0" selected disabled> SELECT  ROLES </option>
                    <option   :value="role.id" v-for="role in roles" :key="role.id"  > {{ role.name }}</option>
            </select>
        </div>
        <button class="btn btn-success" type="submit">Submit</button>
           <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    </form>
   </div>
</template>

<script>
export default {
    props:{
        getUsers: { type: Function },
        users:{ type: Array }

    },
    data: function (){
         return {
              'name':'',
              'username':'',
              'email':'',
              'password':'',
              'password2':'',
              'selected_role':0,
              'roles':[],
              'isValidEmail':true,
         }
    },

    methods:{
        addUser: function(){
             let dataPayload ={
                 'name' : this.name,
                 'username': this.username,
                 'email' : this.email,
                 'password': this.password,
                 'password_confirmation':this.password2,
                 'role' : this.selected_role   
             }
            let url = '/webapi/user';
            axios.post(url,dataPayload).then(response =>{
               
                if(response.data.status == true ){
                    this.getUsers();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: 'Account Successfully Created!',
                        footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                    });
                    this.name ='';
                    this.email ='';
                    this.username ='';
                    this.password2 = '';
                    this.password = '';
                    this.selected_role = 0;
                  
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
        checkEmailifExist: function(){
                let valid = true 
                this.getUsers();
                this.users.forEach(el =>{
                        if(el.email == this.email){
                            console.log(el.email);
                              return valid = false ;
                        }
                });
                this.isValidEmail = valid;
        },
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
            if( this.password != this.password2){
                  return "Password doesn't  match";
            }else{
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

    },
}
</script>

<style>

</style>