import Vue from 'vue'
import Router from 'vue-router'
import auMain from '@/components/auMain'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/report/',
            name: 'auMain',
            component: auMain,
            meta: {
                forAuth: true
            }
        }
    ]
})
