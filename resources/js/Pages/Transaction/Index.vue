<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "@vue/reactivity";

const props = defineProps({
    transactions: Object,
});

const transactions = ref(props.transactions);

const starts_at = ref();
const ends_at = ref();

const filter = () => {
    axios
        .post(route("transactions.filter"), {
            starts_at: starts_at.value,
            ends_at: ends_at.value,
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
                        <h2 class="text-xl font-bold mb-2">
                            فیلتر بر اساس تاریخ
                        </h2>
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
                                <PrimaryButton @click="filter()">
                                    فیلتر
                                </PrimaryButton>
                            </div>
                        </div>

                        <div
                            class="flex font-bold p-4 m-2 text-slate-600 bg-slate-100"
                        >
                            <div class="w-6/12">تیتر</div>
                            <div class="w-2/12">دسته</div>
                            <div class="w-2/12">تاریخ</div>
                            <div class="w-2/12">تغییر</div>
                        </div>
                        <div
                            v-for="(transaction, i) in transactions"
                            :key="i"
                            :class="
                                transaction.type == 'expense'
                                    ? 'flex rounded-full p-4 m-2 text-red-600 bg-red-50'
                                    : 'flex rounded-full p-4 m-2 text-green-600 bg-green-50'
                            "
                        >
                            <div
                                class="w-6/12 overflow-hidden font-bold text-md"
                            >
                                {{ transaction.title }}
                            </div>
                            <div class="w-2/12">
                                <Link
                                    :href="
                                        route(
                                            'categories.show',
                                            transaction.category?.id ?? 0
                                        )
                                    "
                                >
                                    {{
                                        transaction.category
                                            ? transaction.category.name
                                            : "بدون دسته"
                                    }}
                                </Link>
                            </div>
                            <div class="w-2/12">
                                {{
                                    new Date(
                                        transaction.created_at
                                    ).toLocaleDateString("fa-IR")
                                }}
                            </div>
                            <div class="w-2/12">
                                <span class="font-bold">
                                    {{
                                        transaction.type == "expense"
                                            ? " - "
                                            : " + "
                                    }}
                                </span>
                                {{ numberWithCommas(transaction.amount) }} تومان
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
