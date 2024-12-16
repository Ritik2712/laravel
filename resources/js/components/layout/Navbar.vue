<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <router-link class="navbar-brand" to="/"
                >Blood Bank System</router-link
            >
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/available-blood"
                            >Available Blood</router-link
                        >
                    </li>
                    <template v-if="auth.isHospital">
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                to="/hospital/add-blood"
                                >Add Blood</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                to="/hospital/view-requests"
                                >View Requests</router-link
                            >
                        </li>
                    </template>
                </ul>
                <auth-menu />
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
import AuthMenu from "./AuthMenu.vue";

const auth = useAuthStore();
</script>
