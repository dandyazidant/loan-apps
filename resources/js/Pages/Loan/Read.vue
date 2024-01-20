<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import moment from 'moment';

const props = defineProps({
    loan: {
        type: Object,
        default: () => ({}),
    },
    bills: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: props.loan.id,
    title: props.loan.title,
    content: props.loan.content,
});

function getFormattedDate(date) {
    return moment(date).format("dddd, DD-MMMM-YYYY");
}

function getStatusClass(status) {
    return {
        'bg-green-500': status === 'Paid',
        'bg-yellow-500': status === 'Unpaid',
    };
}


const submit = () => {
    form.put(route("loan.update", props.loan.id));
};
</script>

<template>
    <Head title="Loan Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Loan Detail
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
                            <!-- Grid -->
                            <div class="grid md:grid-cols-2 gap-3">
                                <div>
                                    <div class="grid space-y-3">
                                        <dl class="grid sm:flex gap-x-3 text-sm">
                                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                                Name :
                                            </dt>
                                            <dd class="text-gray-800 ">
                                                {{ $page.props.loan.user.name }}
                                                <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline font-medium"
                                                    href="#">
                                                </a>
                                            </dd>
                                        </dl>

                                        <dl class="grid sm:flex gap-x-3 text-sm">
                                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                                Loan Date :
                                            </dt>
                                            <dd class="font-medium text-gray-800 dark:text-gray-500">
                                                {{ getFormattedDate($page.props.loan.created_at) }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <!-- Col -->

                                <div>
                                    <div class="grid space-y-3">
                                        <dl class="grid sm:flex gap-x-3 text-sm">
                                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                                Amount :
                                            </dt>
                                            <dd class="font-medium text-gray-800 dark:text-gray-500">
                                                {{ $page.props.loan.amount }}
                                            </dd>
                                        </dl>

                                        <dl class="grid sm:flex gap-x-3 text-sm">
                                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                                Length of loan :
                                            </dt>
                                            <dd class="font-medium text-gray-800 dark:text-gray-500">
                                                {{ $page.props.loan.loan_term }} Week
                                            </dd>
                                        </dl>

                                    </div>
                                </div>
                                <!-- Col -->
                            </div>
                            <!-- End Grid -->

                            <table class="w-full my-6 text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50" width="100%">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Penalty
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bill, index) in bills" :key="bill.id" class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium">
                                            {{ index + 1 }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium">
                                            {{ getFormattedDate(bill.due_at) }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium">
                                            {{ bill.penalty }}
                                        </th>

                                        <th scope="row" class="px-6 py-4 font-medium">
                                            {{ bill.amount }}
                                        </th>

                                        <th scope="row" class="px-6 py-4 font-medium">
                                            <span v-if="bill.status === 'PAID'"
                                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-500 text-white"
                                                :class="getStatusClass(bill.status)">{{ bill.status }}</span>
                                            <span v-if="bill.status === 'UNPAID'"
                                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-500 text-white"
                                                :class="getStatusClass(bill.status)">{{ bill.status }}</span>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <Link :href="route('bill.payment', $page.props.loan.id)"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-emerald-600 text-white hover:bg-emerald-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                Payment
                            </Link>
                        </div>
                        <!-- End Invoice -->
                    </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout></template>