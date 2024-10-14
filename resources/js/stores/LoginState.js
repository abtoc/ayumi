import { defineStore } from "pinia";

export const useLoginState = defineStore('loginstate', {
    state: () => ({
        loggedin: true,
    }),
    actions: {
        login() {
            this.loggedin = true
        },
        logout() {
            this.loggedin = false
        },
    },
})
