import { defineStore } from "pinia";
import axiosClient from '../axios';

export const useUserStore = defineStore('USER-STORE', {
    state : () => {
        return {
            token  : localStorage.getItem('token'),
            userLog : []
        }
    },
    actions : {
        register (payload) {
            return axiosClient.post('/register', payload).then(res => {
                console.log(res.data);
                return res;
            })
        },
        login (payload) {
            return axiosClient.post('login', payload).then(res => {
                if (res.status === 200) {
                    this.token = res.data.token;
                    localStorage.setItem('token', res.data.token);
                   
                }
                return res;
            })
        },
        logout () {
            return axiosClient.post('/logout').then(res => {
                if (res.status === 200) {
                    this.token = null;
                    localStorage.removeItem('token');

                }

                return res;
            })
        },
        fetchUserLog () {
            return axiosClient.get('/userActivities').then(res => {
                if (res.status === 200) {
                    this.userLog = res.data.activities;
                    console.log(res.data.activities);
                }
                return res;
            })
        }
    }
})