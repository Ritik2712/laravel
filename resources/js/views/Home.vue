<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Blood Bank System</h1>
            <p class="lead">
                Connecting hospitals and receivers for efficient blood donation
                management
            </p>
            <hr class="my-4" />
            <p>
                View available blood samples or register to start contributing
            </p>
            <router-link
                to="/available-blood"
                class="btn btn-primary btn-lg me-2"
            >
                View Available Blood
            </router-link>
            <router-link
                v-if="!auth.isAuthenticated"
                to="/register"
                class="btn btn-success btn-lg"
            >
                Register Now
            </router-link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
</script>
