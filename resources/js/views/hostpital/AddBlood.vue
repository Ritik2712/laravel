<template>
    <div class="container mt-5">
        <h2>Add Blood Sample</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <Form @submit="handleSubmit" :validation-schema="schema">
                    <div class="mb-3">
                        <label class="form-label">Blood Type</label>
                        <Field
                            name="blood_type"
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
                        <ErrorMessage name="blood_type" class="text-danger" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity (units)</label>
                        <Field
                            name="quantity"
                            type="number"
                            class="form-control"
                        />
                        <ErrorMessage name="quantity" class="text-danger" />
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Add Blood Sample
                    </button>
                </Form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import axios from "axios";

const schema = yup.object({
    blood_type: yup.string().required(),
    quantity: yup.number().required().positive().integer(),
});

const handleSubmit = async (values: any) => {
    try {
        await axios.post("/api/blood-samples", values);
        alert("Blood sample added successfully!");
    } catch (error) {
        console.error("Error adding blood sample:", error);
    }
};
</script>
