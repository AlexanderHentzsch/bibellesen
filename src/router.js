import Vue from 'vue'
import Router from 'vue-router'

import vue_overview from "./components/vue_overview";
import vue_ldz from "./components/vue_ldz";
import vue_personally from "./components/vue_personally";
import vue_option from "./components/vue_option";

Vue.use(Router);

export default new Router({
    mode: 'hash',
    base: process.env.BASE_URL,
    routes: [
        {
            name: 'Default',
            path: '/',
            component: vue_overview
        },
        {
            name: 'LDZ',
            path: '/ldz/',
            component: vue_ldz
        },
        {
            name: 'Personally',
            path: '/personally/',
            component: vue_personally
        },
        {
            name: 'Option',
            path: '/option/',
            component: vue_option
        }
    ]
});