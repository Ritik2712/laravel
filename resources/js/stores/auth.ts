import { defineStore } from "pinia";
import axios from "axios";

interface User {
    id: number;
    name: string;
    email: string;
    type: "hospital" | "receiver";
    address?: string;
    state?: string;
    blood_group?: string;
    image_path?: string;
}

interface AuthState {
    user: User | null;
    token: string | null;
}

export const useAuthStore = defineStore("auth", {
    state: (): AuthState => ({
        user: null,
        token: localStorage.getItem("token"),
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
        isHospital: (state) => state.user?.type === "hospital",
        isReceiver: (state) => state.user?.type === "receiver",
    },

    actions: {
        async login(email: string, password: string) {
            try {
                const response = await axios.post("/api/login", {
                    email,
                    password,
                });
                this.token = response.data.token;
                this.user = response.data.user;
                localStorage.setItem("token", this.token);
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
            } catch (error) {
                throw error;
            }
        },

        async register(userData: any) {
            try {
                const response = await axios.post("/api/register", userData);
                this.token = response.data.token;
                this.user = response.data.user;
                localStorage.setItem("token", this.token);
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
            } catch (error) {
                throw error;
            }
        },

        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem("token");
            delete axios.defaults.headers.common["Authorization"];
        },
    },
});
