/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter);
let routes = [
    //cms components
    { path:'/dashboard',component:require('./components/cms/dashboard').default },
    { path:'/user-management',component:require('./components/cms/usermanagement').default },
    { path:'/expense-category',component:require('./components/cms/expensecategory').default },
    { path:'/expenses',component:require('./components/cms/expenses').default },
    { path:'/role-management',component:require('./components/cms/rolesmanagement').default },
    { path:'/change-password',component:require('./components/cms/sub-components/changePassword').default },
]
// sub components
    Vue.component('AddUser',require('./components/cms/sub-components/addusercomponent').default);
    Vue.component('EditUser',require('./components/cms/sub-components/editusercomponent').default);
    Vue.component('AddRole',require('./components/cms/sub-components/addrolecomponent').default);
    Vue.component('EditRole',require('./components/cms/sub-components/editrolecomponent').default);
    Vue.component('AddExpCategory',require('./components/cms/sub-components/addexpensecomponent').default);
    Vue.component('EditExpCategory',require('./components/cms/sub-components/editexpensecategorycomponent').default)
    Vue.component('AddExpenses',require('./components/cms/sub-components/addexpenses').default)
    Vue.component('EditExpenses',require('./components/cms/sub-components/editexpenses').default); 
  


//Outer Most components:
    Vue.component('main-layout',require('./components/main-layout.vue').default); //main
    Vue.component('login',require('./components/login.vue').default);  //login component as /
//partials
    Vue.component('HeaderCms',require('./components/cms/partials/header.vue').default);
    Vue.component('SideBarCms',require('./components/cms/partials/sidebar.vue').default);
    Vue.component('MainTemplate',require('./components/cms/partials/main-template.vue').default);



const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'mm-active',
    routes
})

const app = new Vue({
    el: '#app',
    router,
});
