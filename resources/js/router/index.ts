import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import Home from "@/views/Home.vue";
import Login from "@/views/Login.vue";
import Register from "@/views/Register.vue";
import AvailableBlood from "@/views/AvailableBlood.vue";
import AddBlood from "@/views/hospital/AddBlood.vue";
import ViewRequests from "@/views/hospital/ViewRequests.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
        },
        {
            path: "/register",
            name: "register",
            component: Register,
        },
        {
            path: "/available-blood",
            name: "available-blood",
            component: AvailableBlood,
        },
        {
            path: "/hospital/add-blood",
            name: "add-blood",
            component: AddBlood,
            meta: { requiresAuth: true, requiresHospital: true },
        },
        {
            path: "/hospital/view-requests",
            name: "view-requests",
            component: ViewRequests,
            meta: { requiresAuth: true, requiresHospital: true },
        },
    ],
});

router.beforeEach((to, from, next) => {
    const auth = useAuthStore();

    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        next("/login");
        return;
    }

    if (to.meta.requiresHospital && auth.user?.type !== "hospital") {
        next("/");
        return;
    }

    next();
});

export default router;
