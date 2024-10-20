import { defineStore } from "pinia";

export const useLoginState = defineStore('loginstate', {
    state: () => ({
        loggedin: true,
        registration: false,
        user: [],
    }),
    getters: {
        loginDialog: (state) => {
            return !state.loggedin && !state.registration
        },
        setUser: (user) => {
            this.user = user
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
