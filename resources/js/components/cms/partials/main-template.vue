<template>
        <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
                <HeaderCms :signOut ="signOut" :activeUser = "activeUser" />
             <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
                <div class="app-main" style="z-index:0 !important">
                    <SideBarCms :activeUser="activeUser" />
                    <div class="app-main__outer">                 
                        <router-view></router-view>
                     </div>
                 </div>
            </div>
        </div>
</template>

<script>
export default {
  props:{
     signOut:{type:Function}
  },
  data: function(){
    return {
        'activeUser':[]
    }
  },
  method:{
      getActiveUser: function(){
          axios.get('/checkUser',)
      }
  },
 
  mounted:function(){
     axios.get('/checkAuth').then(response =>{
        this.activeUser = response.data.userData;
     });
  }
}
</script>

<style>

</style>