<template>
    <transition appear>
        <div class="mx-4 md:mx-auto md:w-[50%] min-h-screen flex items-center">

            <div class="mx-auto text-center">
                <h1 class="text-white text-sm">count:{{ count }}</h1>
                <p class="text-red-400 text-sm">res: {{ resp }}</p>
                <div>
                    <h1 class="text-white font-semibold text-lg">Login</h1>
                </div>

                <div class="flex flex-col gap-y-4">
                    <inputComponent  
                    class="w-full" 
                    placeholder="email" 
                    v-model:input="email" 
                    inputType="text" 
                    :error="error && error.type === 'email' ? error.message : ''"/>
                

                    <inputComponent  
                    class="w-full" 
                    placeholder="password" 
                    v-model:input="password" 
                    inputType="password" 
                    :error="error && error.type === 'password' ? error.message : ''"/>

                    <button @click="login" class="rounded-full bg-white text-xs font-semibold py-2 lg:hover:bg-white/60 lg:active:bg-white/80">
                        <span v-if="isworking" class="flex items-center justify-center">
                            <svg class="spinning" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>
                            <span>
                                loading
                            </span> 
                        </span>
                        <span v-else>
                            Login
                        </span>
                        
                    </button>
                </div>

                <span class="text-white text-xs">Create new account/ <span class="lg:hover:cursor-pointer lg:hover:text-white/40 active:text- white" @click="router.push({name : 'register'})">register</span></span>

            </div>
            </div>
    </transition>
</template>


<script setup>
import { ref } from 'vue';
import inputComponent from '../inputComponent.vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../../stores/userStore';

const userStore = useUserStore();
const router = useRouter();
const email = ref('');
const password = ref('');

const error = ref(null);
const count = ref(0);
const resp = ref(null);

const isworking = ref(false);


const login = () => {
    isworking.value = true;
    error.value = null;
    count.value = count.value + 1;
    if (!email.value) {
        error.value = {
            type : 'email',
            message : 'User email required.'
        }
        isworking.value = false;
        return;
    }

    if (!password.value) {
        error.value = {
            type : 'password',
            message : 'Password required.'
        }
        isworking.value = false;
        return;
    }


    const formdata = new FormData();

    formdata.append('email', email.value);
    formdata.append('password', password.value);

    userStore.login(formdata).then(res => {
        resp.value = JSON.stringify(res);
        isworking.value = false;
        if (res.status === 200) {
            resp.value = res;
            router.push({name : 'home'});
        }
    }).catch(error__ => {
        resp.value = JSON.stringify(error__); 
        isworking.value = false;
        console.log(error__.response.data.message);
        error.value = {
            type : 'password',
            message : error__.response.data.message
        }
    })

}



</script>

<style>
.spinning {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>