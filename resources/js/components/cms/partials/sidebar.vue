<template>
    <div>
        
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"><h1>BRA</h1></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>    <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu" v-if="activeUser[0]">
                            <li class="app-sidebar__heading">Menu</li>
                            <li >
                                <a href="javascript:void(0)">
                                    <i class="metismenu-icon pe-7s-rocket"></i>
                                    Dashboards
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <router-link to="/dashboard" >
                                            <i class="metismenu-icon">
                                            </i>main
                                        </router-link>
                                    </li>
                                   
                                    <!-- <li>
                                        <a href="#">
                                            <i class="metismenu-icon"></i>
                                            CRM
                                        </a>
                                    </li> -->
                                </ul>
                            </li>
                            <li   v-if="activeUser[0].access_lvl == 'Administrator'"  :class="this.$route.path.includes('user-management') || this.$route.path.includes('role-management') ? 'mm-active' : ''">
                                <a href="#"  >
                                    <i class="metismenu-icon pe-7s-browser"></i>
                                    User Management
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <router-link  to="/user-management"> <i class="metismenu-icon">
                                            </i>User 
                                        </router-link>
                                    </li>
                                    <li>
                                          <router-link  to="/role-management"> <i class="metismenu-icon">
                                            </i>Role 
                                        </router-link>
                                    </li>
                                  </ul>
                            </li>
                             <li :class="this.$route.path.includes('expense-category') || this.$route.path.includes('expenses') ? 'mm-active' : ''">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-browser"></i>
                                    Expense Management
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li v-if="activeUser[0].access_lvl == 'Administrator'" >
                                        <router-link  to="/expense-category"> <i class="metismenu-icon">
                                            </i>Expense Category
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link  to="/expenses"> <i class="metismenu-icon"></i>
                                        Expenses
                                        </router-link>
                                    </li>
                                  </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>   
    </div>
</template>

<script>
export default {
props:['activeUser']
}
</script>

<style>

</style>