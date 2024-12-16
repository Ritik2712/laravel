<template>
    <div class="container mt-5">
        <h2>Available Blood Samples</h2>
        <div class="row">
            <div
                v-for="sample in bloodSamples"
                :key="sample.id"
                class="col-md-4 mb-4"
            >
                <div class="card">
                    <img
                        v-if="sample.hospital.image_path"
                        :src="sample.hospital.image_path"
                        class="card-img-top"
                        alt="Hospital"
                    />
                    <div class="card-body">
                        <h5 class="card-title">{{ sample.blood_type }}</h5>
                        <p class="card-text">
                            Hospital: {{ sample.hospital.name }}<br />
                            Quantity: {{ sample.quantity }} units<br />
                            Location: {{ sample.hospital.address }},
                            {{ sample.hospital.state }}
                        </p>
                        <button
                            @click="requestSample(sample)"
                            class="btn btn-primary"
                            :disabled="!canRequest(sample)"
                        >
                            Request Sample
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import axios from "axios";

const router = useRouter();
const auth = useAuthStore();
const bloodSamples = ref([]);

const fetchBloodSamples = async () => {
    try {
        const response = await axios.get("/api/blood-samples");
        bloodSamples.value = response.data;
    } catch (error) {
        console.error("Error fetching blood samples:", error);
    }
};

const canRequest = (sample: any) => {
    if (!auth.isAuthenticated) return false;
    if (!auth.isReceiver) return false;

    // Check blood type compatibility
    const receiverBloodGroup = auth.user?.blood_group;
    return isCompatible(receiverBloodGroup, sample.blood_type);
};

const isCompatible = (receiverGroup: string, donorGroup: string) => {
    // Implement blood type compatibility logic
    const compatibility: { [key: string]: string[] } = {
        "A+": ["A+", "A-", "O+", "O-"],
        "A-": ["A-", "O-"],
        "B+": ["B+", "B-", "O+", "O-"],
        "B-": ["B-", "O-"],
        "AB+": ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
        "AB-": ["A-", "B-", "AB-", "O-"],
        "O+": ["O+", "O-"],
        "O-": ["O-"],
    };

    return compatibility[receiverGroup]?.includes(donorGroup) || false;
};

const requestSample = async (sample: any) => {
    if (!auth.isAuthenticated) {
        router.push("/login");
        return;
    }

    try {
        await axios.post(`/api/blood-requests`, {
            blood_sample_id: sample.id,
        });
        alert("Blood sample request submitted successfully!");
    } catch (error) {
        console.error("Error requesting blood sample:", error);
    }
};

onMounted(fetchBloodSamples);
</script>
