	
import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '../stores/userStore';
import  homeComponent  from '../components/homeComponent.vue';
import authComponent from '../components/auth/authComponent.vue';
import LoginComponent from '../components/auth/LoginComponent.vue';

const router = createRouter({
    history : createWebHistory(import.meta.env.BASE_URL),
    routes : [
        {
            path : '/',
            name : 'home',
            component : homeComponent,
            beforeEnter : (to, from, next) => {
                const userStore = useUserStore();
                if(userStore.token) {
                  next();
                } else {
                  next({name : 'login'});
                }
              },
        },
        {
            path : '/register',
            name : 'register',
            component : authComponent
        },
        {
          path : '/login',
          name : 'login',
          component : LoginComponent
      }
    ]
})


export default router;