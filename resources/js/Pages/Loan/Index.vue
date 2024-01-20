<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import moment from 'moment';

const props = defineProps({
    loans: {
        type: Object,
        default: () => ({}),
    },
    auth: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({});

function getFormattedDate(date) {
    return moment(date).format("DD-MM-YYYY");
}

function approval(id) {
    if (confirm("Are you sure you want to Approval")) {
        form.patch(route("loan.approval", id));
    }
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("loan.destroy", id));
    }
}
</script>
<template>
    <Head title="Loans" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Loans</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="m-3">
                        <Link :href="route('loan.create')">
                        <PrimaryButton>Apply Loan</PrimaryButton>
                        </Link>
                    </div>
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50" width="100%">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total Amount
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Loan Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Loan Term
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3" width="20%">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="loan in loans" :key="loan.id" class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ loan.id }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ loan.user.name }} <br>
                                    <Link :href="route('loan.show', loan.id)" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Lihat</Link>
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ loan.amount }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{getFormattedDate(loan.created_at)}}
                                </th>

                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ loan.loan_term }} Weeks
                                </th>

                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ loan.status }}
                                </th>


                                <td class="px-6 py-4">
                                    <Link v-if="$page.props.auth.user.role != 'admin'" :href="route('loan.edit', loan.id)
                                        " class="px-4 py-2 text-white bg-blue-600 rounded-lg inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil-fill mr-1" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                    </svg>
                                    Edit
                                    </Link>

                                    <!-- <form v-if="$page.props.auth.user.role === 'admin'"
                                        @submit.prevent="formapproval.post(route('loan.approval'))">

                                        <button type="submit" :disabled="form.processing"
                                            class="px-4 py-2 m-1 text-white bg-green-600 rounded-lg inline-flex ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check-square-fill mr-1"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z" />
                                            </svg>
                                            Approval
                                        </button>
                                    </form> -->


                                    <PrimaryButton v-if="$page.props.auth.user.role === 'admin'"
                                        class="px-4 py-2 m-1 text-white rounded-lg inline-flex bg-green-700"
                                        @click="approval(loan.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-check-square-fill mr-1" viewBox="0 0 16 16">
                                            <path
                                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z" />
                                        </svg>
                                        Approval
                                    </PrimaryButton>

                                    <PrimaryButton v-if="$page.props.auth.user.role != 'admin'"
                                        class="px-4 py-2 m-1 text-white rounded-lg inline-flex bg-red-700"
                                        @click="destroy(loan.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash-fill mr-1" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                        </svg>
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
