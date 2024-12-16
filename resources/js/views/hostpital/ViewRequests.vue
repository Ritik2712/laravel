<template>
    <div class="container mt-5">
        <h2>Blood Sample Requests</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Receiver Name</th>
                        <th>Blood Type</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="request in requests" :key="request.id">
                        <td>{{ request.id }}</td>
                        <td>{{ request.receiver.name }}</td>
                        <td>{{ request.blood_sample.blood_type }}</td>
                        <td>
                            {{
                                new Date(
                                    request.created_at
                                ).toLocaleDateString()
                            }}
                        </td>
                        <td>{{ request.status }}</td>
                        <td>
                            <button
                                v-if="request.status === 'pending'"
                                @click="updateStatus(request.id, 'approved')"
                                class="btn btn-success btn-sm me-2"
                            >
                                Approve
                            </button>
                            <button
                                v-if="request.status === 'pending'"
                                @click="updateStatus(request.id, 'rejected')"
                                class="btn btn-danger btn-sm"
                            >
                                Reject
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const requests = ref([]);

const fetchRequests = async () => {
    try {
        const response = await axios.get("/api/blood-requests/hospital");
        requests.value = response.data;
    } catch (error) {
        console.error("Error fetching requests:", error);
    }
};

const updateStatus = async (requestId: number, status: string) => {
    try {
        await axios.patch(`/api/blood-requests/${requestId}`, { status });
        await fetchRequests();
    } catch (error) {
        console.error("Error updating request status:", error);
    }
};

onMounted(fetchRequests);
</script>
