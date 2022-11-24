<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "@vue/reactivity";
import Tranactions from "@/Components/Transactions.vue";

const props = defineProps({
    transactions: Object,
    categories: Object,
});

const transactions = ref(props.transactions);

const starts_at = ref();
const ends_at = ref();
const category_id = ref(null);
const type = ref(null);

const filter = () => {
    axios
        .post(route("transactions.filter"), {
            starts_at: starts_at.value,
            ends_at: ends_at.value,
            category_id: category_id.value,
            type: type.value,
        })
        .then(({ data }) => {
            transactions.value = data;
        });
};
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
                        <h2 class="text-xl font-bold mb-2">فیلتر</h2>
                        <div class="flex gap-x-2 items-end mb-4">
                            <div>
                                <InputLabel for="starts_at"
                                    >تاریخ شروع:</InputLabel
                                >
                                <DatePicker
                                    format="YYYY-MM-DD HH:mm:ss"
                                    display-format="dddd jDD jMMMM jYYYY"
                                    v-model="starts_at"
                                    id="starts_at"
                                />
                            </div>
                            <div>
                                <InputLabel for="ends_at"
                                    >تاریخ پایان:</InputLabel
                                >
                                <DatePicker
                                    format="YYYY-MM-DD HH:mm:ss"
                                    display-format="dddd jDD jMMMM jYYYY"
                                    v-model="ends_at"
                                    id="ends_at"
                                />
                            </div>
                            <div>
                                <InputLabel for="type">نوع:</InputLabel>
                                <select
                                    name="type"
                                    id="type"
                                    v-model="type"
                                    class="border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="">همه</option>
                                    <option selected value="expense">
                                        خرج
                                    </option>
                                    <option value="income">درآمد</option>
                                </select>
                            </div>
                            <div>
                                <InputLabel for="category">دسته:</InputLabel>
                                <select
                                    name="category"
                                    id="category"
                                    v-model="category_id"
                                    class="border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="">همه</option>
                                    <option
                                        v-for="(category, i) in categories"
                                        :key="i"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <PrimaryButton @click="filter()">
                                    فیلتر
                                </PrimaryButton>
                            </div>
                        </div>

                        <Tranactions :transactions="transactions" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
