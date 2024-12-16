<template>
    <ul class="navbar-nav">
        <template v-if="!auth.isAuthenticated">
            <li class="nav-item">
                <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/register"
                    >Register</router-link
                >
            </li>
        </template>
        <template v-else>
            <li class="nav-item">
                <span class="nav-link">Welcome, {{ auth.user?.name }}</span>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" @click.prevent="logout">Logout</a>
            </li>
        </template>
    </ul>
</template>

<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const auth = useAuthStore();
const router = useRouter();

const logout = async () => {
    await auth.logout();
    router.push("/login");
};
</script>
