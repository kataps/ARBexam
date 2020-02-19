<template>
        <div> 
             <login v-if="user == false "  @user="updateUser"  />
             <MainTemplate :signOut="signOut"  v-else/>
        </div>
</template>
<script>
export default {
    data: function(){
        return {
              user:null,
        }
    }, 
    methods:{
        updateUser(data){
         this.user = data;
        },
         signOut:function(){
            let url = '/signout';
            axios.get(url).then(resp=>{
                    if(resp.data.status == true){
                       this.user =false;
                       this.$router.push('/');
                    }
            });
     }
    },
    watch:{
         user:function(val){
               console.log(val);
         },
    },
    mounted: function(){
        if(this.user == false || this.user == null){
                axios.get('/checkAuth').then(response =>{
                this.user = response.data.status;
          });
        }
    },
}
</script>
<style>

</style>