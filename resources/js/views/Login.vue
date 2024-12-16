<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <Form
                            @submit="handleSubmit"
                            :validation-schema="schema"
                        >
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <Field
                                    name="email"
                                    type="email"
                                    class="form-control"
                                />
                                <ErrorMessage
                                    name="email"
                                    class="text-danger"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <Field
                                    name="password"
                                    type="password"
                                    class="form-control"
                                />
                                <ErrorMessage
                                    name="password"
                                    class="text-danger"
                                />
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const auth = useAuthStore();

const schema = yup.object({
    email: yup.string().required().email(),
    password: yup.string().required(),
});

const handleSubmit = async (values: any) => {
    try {
        await auth.login(values.email, values.password);
        router.push("/");
    } catch (error) {
        console.error("Login failed:", error);
    }
};
</script>
