import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import firstPage from './components/pages/myFirstPage'
import secondPage from './components/pages/mySecondPage'
import hook from './components/pages/basic/hook'
import home from './components/pages/home'
import tags from './admin/components/pages/tags'
import category from './admin/components/pages/category'
const routes = [
    {
        path: '/',
        component: home
        
    },
    {
        path: '/tags',
        component: tags
        
    },
    {
        path: '/category',
        component: category
        
    },
    {
        path: '/first-page',
        component: firstPage
        
    },
    {
        path: '/second-page',
        component: secondPage
        
    },
    {
        path: '/hook',
        component: hook
        
    }
]

export default new Router({
    mode: 'history',
    routes
})