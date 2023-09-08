import axios from 'axios';

const axiosClient = axios.create({
    baseURL : 'https://2f5d-2405-9800-b500-3f2f-417d-a8ed-ed3f-9c59.ngrok-free.app/api'
})


axiosClient.interceptors.request.use((config) => {
    const token = window.localStorage.getItem('token');

    if(token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
});

export default axiosClient;