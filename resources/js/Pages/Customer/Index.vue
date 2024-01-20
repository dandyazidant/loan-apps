<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    customers: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("customer.destroy", id));
    }
}
</script>
<template>
    <Head title="Customer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Customers</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Edit
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers" :key="customer.id"
                                class="bg-white border-b">
                                <th scope="row"
                                    class="px-6 py-4 font-medium">
                                    {{ customer.id }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium">
                                    {{ customer.name }}
                                </th>

                                <td class="px-6 py-4">
                                    <Link :href="route('customer.edit', customer.id)
                                        " class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                </td>
                                <td class="px-6 py-4">
                                    <PrimaryButton class="bg-red-700" @click="destroy(customer.id)">
                                        Delete
                                    </PrimaryButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
