<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    loans: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    amount: Number,
    loan_term: "",
});

const submit = () => {
    form.post(route("loan.store"));
};
</script>

<template>
    <Head title="Blog Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Blog Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="amount" value="Amount" />

                                <div class="flex rounded-lg shadow-sm">
                                    <span
                                        class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500">$</span>
                                    <TextInput id="amount" type="number" v-model.number="form.amount" required autofocus
                                        autocomplete="username"
                                        class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" />
                                </div>

                                <InputError class="mt-2" :message="form.errors.amount" />
                            </div>
                            <div class="my-6">
                                <label for="loan_term" class="block mb-2 text-sm font-medium text-gray-900">Loan
                                    Term</label>
                                <select
                                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    v-model="form.loan_term">
                                    <option selected>Open this loan terms</option>
                                    <option value="1">1 weeks</option>
                                    <option value="2">2 weeks</option>
                                    <option value="3">3 weeks</option>
                                    <option value="4">4 weeks</option>
                                    <option value="5">5 weeks</option>
                                    <option value="6">6 weeks</option>
                                    <option value="7">7 weeks</option>
                                    <option value="8">8 weeks</option>
                                    <option value="9">9 weeks</option>
                                </select>
                                
                                <div v-if="form.errors.loan_term" class="text-sm text-red-600">
                                    {{ form.errors.loan_term }}
                                </div>
                            </div>

                            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>