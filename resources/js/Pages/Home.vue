<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "@vue/reactivity";

const props = defineProps({
    transactions: Object,
});

const sumOfTransactions = ref(0);
const categoryTable = ref({});

props.transactions.map((t) => {
    sumOfTransactions.value += t.amount;

    let category = "بدون دسته";
    let id = 0;

    if (t.category) {
        category = t.category.name;
        id = t.category.id;
    }

    if (!categoryTable.value[category]) {
        categoryTable.value[category] = {
            item: 1,
            amount: t.amount,
            id,
        };
    } else {
        categoryTable.value[category]["item"]++;
        categoryTable.value[category]["amount"] += t.amount;
    }
});
</script>

<template>
    <Head title="خانه" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                خانه
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex">
                            <div
                                class="bg-gray-100 rounded-lg p-4 flex flex-col justify-center items-center"
                            >
                                <div class="text-lg font-bold">
                                    جمع خرج این ماه
                                </div>
                                <div>
                                    {{ numberWithCommas(sumOfTransactions) }}
                                    تومان
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h2 class="font-bold text-xl">
                                هزینه ها به تفکیک دسته
                            </h2>
                            <Link
                                v-for="(ct, key) in categoryTable"
                                :key="ct"
                                class="inline-flex bg-gray-100 rounded-lg p-4 m-2 flex-col justify-center items-center"
                                :href="route('categories.show', ct.id)"
                            >
                                <div class="text-lg font-bold">{{ key }}</div>
                                <div>
                                    {{ numberWithCommas(ct.amount) }} تومان
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
