import Vue from 'vue';
import Router from 'vue-router';
import appMain from '../components/appMain';

Vue.use(Router);

const routes = [
    {
    path: '/',
    component: appMain,
    meta: {
        forAuth: true
    },

    children: [    
      {path: ':page'}
    ]
  },
]

export default new Router({
  mode: 'history',
  routes
})
