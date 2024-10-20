import { defineStore } from "pinia";

export const useNavigationState = defineStore('navigationstate', {
    state: () => ({
        drawer: false,
    }),
    actions: {
        open() {
            this.drawer = true
        },
        close() {
            this.drawer = false
        },
        toggle() {
            this.drawer = !this.drawer
        },
    }
})
