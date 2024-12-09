import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),

    routes: [
        {
            path: '/index', component: () => import('./components/Post/Index.vue'),
            name: 'index.post'
        },
        {
            path: '/post/:id', component: () => import('./components/Post/Show.vue'),
            name: 'show.post'
        },         
        {
            path: '/create', component: () => import('./components/Post/Create.vue'),
            name: 'create.post'
        },
        {
            path: '/update/:id', component: () => import('./components/Post/Update.vue'),
            name: 'update.post'
        }, 
        {
            path: '/user/login', component: () => import('./components/User/Login.vue'),
            name: 'user.login'
        },
        {
            path: '/user/registration', component: () => import('./components/User/Registration.vue'),
            name: 'user.registration'
        },
        {
            path: '/user/personal', component: () => import('./components/User/Personal.vue'),
            name: 'user.personal'
        },
        //{ path: '/:pathMatch(.*)*', name: 'not-found', component: () => import('./components/Error/Error404.vue') }
    ]
})
router.beforeEach((to, from, next) => {
    const hasAccess = localStorage.getItem('authorized') 

    if (!hasAccess) {
        if ((to.name == 'user.login' || to.name == 'user.registration')) {
            return next()
        }
        return next({
            name: 'user.login'
        })
    }
    if ((to.name == 'user.login' || to.name == 'user.registration') && hasAccess) {
        return next({
            name: 'user.personal'
        })
    }
    next()
})

export default router