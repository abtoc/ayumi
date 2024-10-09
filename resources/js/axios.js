import axios from "axios";

const instance = axios.create({
    baseURL: import.meta.env.VITE_APP_URL,
    headers: {
        "Content-type": "application/json",
        "Accept": "applicatrion/json",
        "Refer": import.meta.env.VITE_APP_URL,
        "Origin": import.meta.env.VITE_APP_URL,
    }
})

export default instance
