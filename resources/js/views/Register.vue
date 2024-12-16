<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <Form
                            @submit="handleSubmit"
                            :validation-schema="schema"
                        >
                            <div class="mb-3">
                                <label class="form-label">User Type</label>
                                <Field
                                    name="type"
                                    as="select"
                                    class="form-select"
                                    v-model="form.type"
                                >
                                    <option value="hospital">Hospital</option>
                                    <option value="receiver">Receiver</option>
                                </Field>
                                <ErrorMessage name="type" class="text-danger" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <Field
                                    name="name"
                                    type="text"
                                    class="form-control"
                                />
                                <ErrorMessage name="name" class="text-danger" />
                            </div>

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

                            <div class="mb-3">
                                <label class="form-label"
                                    >Confirm Password</label
                                >
                                <Field
                                    name="password_confirmation"
                                    type="password"
                                    class="form-control"
                                />
                                <ErrorMessage
                                    name="password_confirmation"
                                    class="text-danger"
                                />
                            </div>

                            <template v-if="form.type === 'hospital'">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <Field
                                        name="address"
                                        type="text"
                                        class="form-control"
                                    />
                                    <ErrorMessage
                                        name="address"
                                        class="text-danger"
                                    />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">State</label>
                                    <Field
                                        name="state"
                                        type="text"
                                        class="form-control"
                                    />
                                    <ErrorMessage
                                        name="state"
                                        class="text-danger"
                                    />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        >Hospital Image</label
                                    >
                                    <input
                                        type="file"
                                        @change="handleImageUpload"
                                        accept="image/*"
                                        class="form-control"
                                    />
                                    <small class="text-muted"
                                        >Maximum file size: 3MB</small
                                    >
                                    <div v-if="imageError" class="text-danger">
                                        {{ imageError }}
                                    </div>
                                </div>
                            </template>

                            <template v-if="form.type === 'receiver'">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Blood Group</label
                                    >
                                    <Field
                                        name="blood_group"
                                        as="select"
                                        class="form-select"
                                    >
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </Field>
                                    <ErrorMessage
                                        name="blood_group"
                                        class="text-danger"
                                    />
                                </div>
                            </template>

                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const auth = useAuthStore();

const form = ref({
    type: "receiver",
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    address: "",
    state: "",
    blood_group: "",
    image: null as File | null,
});

const imageError = ref("");

const schema = yup.object({
    type: yup.string().required().oneOf(["hospital", "receiver"]),
    name: yup.string().required().min(2),
    email: yup.string().required().email(),
    password: yup.string().required().min(8),
    password_confirmation: yup
        .string()
        .oneOf([yup.ref("password")], "Passwords must match"),
    address: yup.string().when("type", {
        is: "hospital",
        then: () => yup.string().required(),
    }),
    state: yup.string().when("type", {
        is: "hospital",
        then: () => yup.string().required(),
    }),
    blood_group: yup.string().when("type", {
        is: "receiver",
        then: () => yup.string().required(),
    }),
});

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        if (file.size > 3 * 1024 * 1024) {
            imageError.value = "Image size must be less than 3MB";
            form.value.image = null;
        } else {
            imageError.value = "";
            form.value.image = file;
        }
    }
};

const handleSubmit = async (values: any) => {
    try {
        const formData = new FormData();
        Object.keys(values).forEach((key) => {
            formData.append(key, values[key]);
        });
        if (form.value.image) {
            formData.append("image", form.value.image);
        }

        await auth.register(formData);
        router.push("/");
    } catch (error) {
        console.error("Registration failed:", error);
    }
};
</script>
