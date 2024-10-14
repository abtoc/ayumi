import { defineStore } from "pinia";

export const useLoginState = defineStore('loginstate', {
    state: () => ({
        loggedin: true,
        registration: false,
    }),
    getters: {
        loginDialog: (state) => {
            return !state.loggedin && !state.registration
        }
    },
    actions: {
        login() {
            this.loggedin = true
        },
        logout() {
            this.loggedin = false
        },
        registStart() {
            this.registration = true
        },
        registEnd() {
            this.registration = false
        },
    },
})
