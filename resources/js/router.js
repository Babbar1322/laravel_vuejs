import Vue from 'vue';
import Router  from 'vue-router';

import firstPage from  './components/pages/myFirstVuePage.vue';
import newPage from  './components/pages/newPage.vue';
import hooks from './components/pages/basic/hooks.vue';
import methods from './components/pages/basic/methods.vue';


import home from './admin/pages/home.vue';
import tags from './admin/pages/tags.vue';
import category from './admin/pages/category.vue';
import adminusers from './admin/pages/adminusers.vue';
import login from './admin/pages/login.vue';
import register from './admin/pages/register.vue';
import role from './admin/pages/role.vue';

import tagDetails from "./admin/pages/tag_details.vue";



Vue.use(Router)

const routes = [
    {
        path:'/dashboard',
        component:home,
        name:"Home",
    //    meta:{ user:true}
    },
    {
        path:'/tags',
        component:tags,
        // meta:{ user:true}

    },
    {
        path:'/category',
        component:category,
        // meta:{ user:true}

    },
    {
        path:'/adminusers',
        component:adminusers,
        // meta:{ user:true}

    },
    {
        path:'/login',
        component:login,
        
        // meta:{ user:false}

    },
    {
        path:'/register',
        component:register,
        
        // meta:{ user:false}

    },
    {
        path:'/logout',
        component:login,
        // meta:{ user:false}
    },
    {
        path:'/role',
        component:role,
        // meta:{ user:false}
    },
    {
        path:'/tag/:id',
        component:tagDetails,
        name:"tag"
        // meta:{ user:false}
    },















    {
        path:'/my-new-vue-route',
        component:firstPage
    },
    {
        path:'/newRoute',
        component:newPage
    },

    //vue hooks

    {
        path:'/hooks',
        component:hooks
    },
    //another basic
    {
        path:'/methods',
        component:methods
    },


]



const router = new Router({
    mode: 'history',
    routes
});

// router.beforeEach((to, from, next) => {
//     if (to.matched.some((record) => record.meta.user)) {
//       if (store.state.user) {
//         next("/");
//         return;
//       }
//       next("/login");
//     } else {
//       next();
//     }
//   });

export default router;