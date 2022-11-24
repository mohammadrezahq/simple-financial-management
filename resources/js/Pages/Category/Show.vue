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
    category: Object,
});

const category = ref(props.category);
const transactions = ref(props.category.transaction);

const starts_at = ref();
const ends_at = ref();

const filter = () => {
    axios
        .post(route("transactions.filter"), {
            starts_at: starts_at.value,
            ends_at: ends_at.value,
            category_id: category.value.id,
        })
        .then(({ data }) => {
            transactions.value = data;
        });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="'دسته ' + category.name" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ "دسته " + category.name }}
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

                        <Tranactions
                            :transactions="transactions"
                            :category="category"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
