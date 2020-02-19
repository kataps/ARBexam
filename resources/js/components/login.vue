<template>
        <div>
                
                <form @submit.prevent="login" class="form form-login">
                    <h3  class="text-info"><strong>Expense</strong> <span><i>manager </i></span></h3>
                    <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input v-model="email" :class="
                                this.email != '' && this.triggerdmail !=false ?  'green form-control':
                                this.email == '' && this.triggerdmail !=false ? 'red form-control' : 'form-control'
                            "
                            type="email" name="email" @click="istriggered('triggerdmail')"  >
                            <div v-show="this.triggerdmail == true  && email ==''">
                                <small class="text-danger mt-2">Email is required</small>
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="email">Password</label>
                            <input  v-model="password" 
                            :class="
                                this.password != '' && this.triggerdpass !=false ?  'green form-control':
                                this.password == '' && this.triggerdpass !=false ? 'red form-control ' : 'form-control'
                            "
                             type="password" name="password" @click="istriggered('triggerdpass')"  >
                             <div v-show="this.triggerdpass == true  && password ==''">
                                <small class="text-danger mt-2">Password is required</small>
                            </div>
                    </div>
                    <div class="form-group">
                            <button   type="sumbit" class="btn btn-primary">Login</button>
                    </div>
                    <div class="form-group">
                            <a href="javascript:void(0)" @click="forgotpassword()" class="text-primary"> forgot password ?</a>
                    </div>

                </form>
        </div>
</template>
<script>
export default {
    props:['userStatus'],
    data: function(){
         return {
                email:'',
                password:'',
                triggerdmail:false,
                triggerdpass:false,
         }
    },
    methods:{
        istriggered(input){
           this[input] = true; 
        },
         forgotpassword(){
              alert(" not available")
         },
         login(e){
               e.preventDefault()
               if(this.email == ''){
                      this.triggerdmail = true;
                      return false
               }
               if( this.password  == ''){
                   this.triggerdpass = true;
                   return false
               }    
               else{
                    let dataPayload = {
                        email :this.email,
                        password:this.password,
                    }
                    axios.post('/auth',dataPayload).then(response => {
                      
                            if(response.data.status == true ){
                                // let response  = response.data.userData;
                                this.$emit('user',response.data.message.userData);
                                this.$router.push('/user-management');
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
                                title: 'Login Failed',
                                html: errorm,
                                footer: '<a href>Why do I have this issue?</a>'
                                })
                            }
                    });
               }
         }
    }
}
</script>

<style >

</style>


