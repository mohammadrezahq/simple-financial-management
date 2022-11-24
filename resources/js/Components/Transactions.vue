<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    transactions: Object,
    category: Object,
});
</script>

<template>
    <div class="flex font-bold p-4 m-2 text-slate-600 bg-slate-100">
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
        <div class="w-6/12 overflow-hidden font-bold text-md">
            {{ transaction.title }}
        </div>
        <div class="w-2/12">
            <Link v-if="category" :href="route('categories.show', category.id)">
                {{ category.name }}
            </Link>
            <Link
                :href="route('categories.show', transaction.category?.id ?? 0)"
                v-else
            >
                {{
                    transaction.category
                        ? transaction.category.name
                        : "بدون دسته"
                }}
            </Link>
        </div>
        <div class="w-2/12">
            {{ new Date(transaction.created_at).toLocaleDateString("fa-IR") }}
        </div>
        <div class="w-2/12">
            <span class="font-bold">
                {{ transaction.type == "expense" ? " - " : " + " }}
            </span>
            {{ numberWithCommas(transaction.amount) }} تومان
        </div>
    </div>
</template>
