import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import firstPage from './components/pages/firstVuePage'
import secondndPage from './components/pages/secondVuePage'
import Hooks from './components/pages/basic/hooks'


const routes = [
    {
        path: '/my-new-vue-route',
        component: firstPage
    },
    {
        path: '/my-2nd-vue-route',
        component: secondndPage
    },
    {
        path: '/hooks',
        component: Hooks
    }
]
export default new Router({
    mode:'history',
    routes
})