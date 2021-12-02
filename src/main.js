import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue';
import AdventPage from './pages/Advent.vue'
import HomePage from './pages/Home.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: HomePage
        },
        {
            path: '/:advent_key/',
            component: AdventPage,
            props: true
        },
        {
            path: '/:notFound(.*)*',
            redirect: '/'
        }
    ]
});

const app = createApp(App);

app.use(router);
app.mount('#app');