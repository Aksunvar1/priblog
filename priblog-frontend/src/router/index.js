import {createRouter, createWebHistory} from 'vue-router'
import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import IndexView from "@/views/Blogs/IndexView.vue";
import ShowView from "@/views/Blogs/ShowView.vue";
import EditView from "@/views/Blogs/EditView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/register',
            name: 'register',
            component: RegisterView
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/',
            name: 'blogs.index',
            component: IndexView
        },
        {
            path: '/blogs/:id',
            name: 'blogs.show',
            component: ShowView
        },
        {
            path: '/blogs/:id',
            name: 'blogs.edit',
            component: EditView
        },
    ]
})

router.beforeEach((to, from) => {
    if (to.name === 'register' || to.name === 'login') {
        return true
    }

    if (!localStorage.getItem('token')) {
        return {
            name: 'login'
        }
    }
})

export default router
