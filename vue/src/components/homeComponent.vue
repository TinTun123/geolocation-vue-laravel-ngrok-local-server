<template>
    <div class="mx-4 pt-8 md:w-[60%] md:mx-auto">
        <div class=" flex gap-x-4">
            <button @click="logout" class="rounded-full bg-white flex items-center text-xs font-semibold py-1 px-2 lg:hover:bg-white/60 lg:active:bg-white/80">Logout</button>
            <button @click="router.push({name : 'register'})" class="rounded-full bg-white flex items-center text-xs font-semibold py-1 px-2 lg:hover:bg-white/60 lg:active:bg-white/80">Add new user</button>
        </div>

        <div class="mx-4 mt-8">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(user, i) in userStore.userLog" :key="user.id">
                            <tr @click.stop="toggledrop(user.id)" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ user.id }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ user.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ user.email }}
                                </td>
                                <td colspan="1" class="px-6 py-4">
                                    
                                </td>
                            </tr>
                            <!-- small table  -->
                            <!-- <transition name="slide-down"> -->
                            <tr scope="row" v-if="dropUserId === user.id" :class="[dropUserId === user.id ? 'max-h-[1000px]' : 'max-h-0']" class="relative transition-[max-height]">
                                <td colspan="4" class="dark:bg-gray-800">
                                    <div class="relative overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Action
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        IP
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Country
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        City
                                                    </th>

                                                    <th scope="col" class="px-6 py-3">
                                                        Lat
                                                    </th>

                                                    <th scope="col" class="px-6 py-3">
                                                        Lon
                                                    </th>

                                                    <th scope="col" class="px-6 py-3">
                                                        Date Time
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(log, i) in user.locations" :key="log.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ log.action }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ log. ip_address }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ log.country }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ log.city }}
                                                    </td>

                                                    <td class="px-6 py-4">
                                                        {{ log.latitude }}
                                                    </td>

                                                    <td class="px-6 py-4">
                                                        {{ log.longitude }}
                                                    </td>

                                                    <td class="px-6 py-4">
                                                        {{ log.updated_at }}
                                                    </td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                                
                            </tr>
                        </template>
                        
                        <!-- </transition> -->
                        
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/userStore';
import { onBeforeMount, ref } from 'vue';


const userStore = useUserStore();
const router = useRouter();
const dropUserId = ref(null);

const logout = () => {
    userStore.logout().then(res => {
        if (res.status === 200) {
            router.push({name : 'login'});
        }
    })
}

const toggledrop = (user_id) => {
    if (dropUserId.value === user_id) {
        dropUserId.value = null;
        return;
    }

    dropUserId.value  = user_id;
    return;
}


onBeforeMount(async () => {

    await userStore.fetchUserLog();

})

</script>

<style>

.slide-down-leave-active {
    transition: 0.3s ease-in;
}

.slide-down-enter-from {
    max-height: 0px;
    opacity: 0;
}

.slide-down-enter-to {
    max-height: 1000px;
    opacity: 1;
}

.slide-down-leave-from {
    max-height: 0px;
    opacity: 0;
}

.slide-down-leave-to {
    max-height: 0px;
    opacity: 0;
}

</style>