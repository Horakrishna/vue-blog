import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

// import firstPage from './components/pages/firstVuePage'
// import secondndPage from './components/pages/secondVuePage'
// import Hooks from './components/pages/basic/hooks'
// import Method from './components/pages/basic/methods'

import Home from './components/pages/home'
import Tag from './admin/pages/tag'
import Category from './admin/pages/category'

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/tags',
        component: Tag
    },
    {
        path: '/categorys',
        component: Category
    },
    // {
    //     path: '/my-2nd-vue-route',
    //     component: secondndPage
    // },
    // {
    //     path: '/hooks',
    //     component: Hooks
    // },
    // {
    //     path:'/methods',
    //     component:Method
    // }
]
export default new Router({
    mode:'history',
    routes
})