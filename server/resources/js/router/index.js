import Vue from 'vue';
import Router from 'vue-router';
import StlPageAllotments from '../components/stlPageAllotments';

Vue.use(Router);

const routes = [
    {
        name: 'pageAllotments',
        path: '/page/allotments',
        component: StlPageAllotments,
    },
    {
        name: 'homePage',
        path: '/home',
        redirect: {name: 'pageAllotments'},
        components: StlPageAllotments
    }
];

export default new Router({
  mode: 'history',
  routes,
  scrollBehavior(to, from, savedPosition) {
      return {x: 0, y: 0} //сброс позиции прокрутки при переходе по ссылкам
  },
})
