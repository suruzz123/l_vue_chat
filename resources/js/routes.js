import Vue from 'vue'
import VueRouter from 'vue-router'
import ChatApp from './components/ChatApp'

import MainApp from './components/MainApp'


Vue.use(VueRouter)

const routes = [
    {
        path: 'mainApp',
        component: MainApp

    },
    {
        path: '/chatApp',
        component: ChatApp

    }
];

const router = new VueRouter({
    routes
  })

export default router