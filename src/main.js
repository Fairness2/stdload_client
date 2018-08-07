import Vue from 'vue';
import App from './App';
import router from './router';
import Store from './store/index.js';


Vue.config.productionTip = false;

new Vue({
    el: '#app',
    store: Store,
    router: router,
    components: {App},
    template: '<App/>'
})
