<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

defineProps({
    transactions: Object,
});

const submit = () => {};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="لیست تراکنش ها" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                لیست تراکنش ها
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div
                            v-for="(transaction, i) in transactions"
                            :key="i"
                            :class="
                                transaction.type == 'expense'
                                    ? 'flex rounded-full p-4 m-2 text-red-600 bg-red-100'
                                    : 'flex rounded-full p-4 m-2 text-green-600 bg-green-400'
                            "
                        >
                            <div
                                class="w-2/4 overflow-hidden font-bold text-md"
                            >
                                {{ transaction.title }}
                            </div>
                            <div class="w-1/4">
                                {{
                                    new Date(
                                        transaction.created_at
                                    ).toLocaleDateString("fa-IR")
                                }}
                            </div>
                            <div class="w-1/4">
                                {{ numberWithCommas(transaction.amount) }} تومان
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
