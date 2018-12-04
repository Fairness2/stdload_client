import Vue from 'vue';
import Router from 'vue-router';
//import appMain from '../components/appMain';
//import appLogin from '../components/appLogin';

Vue.use(Router);

const routes = [
    {
        path: '/login',
        //component: appLogin,
        meta: {
            forAuth: true
        },
    },
    {
        path: '/',
        //component: appMain,
        meta: {
            forAuth: true
        },

        children: [
            {path: ':page'}
        ]
    },
];

export default new Router({
  mode: 'history',
  routes
})
