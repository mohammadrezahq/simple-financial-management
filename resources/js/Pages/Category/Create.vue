<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    categories: Object,
});

const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route("categories.store"), {
        onSuccess: () => form.reset(),
    });
};

const remove = (id) => {
    Inertia.delete(route("categories.destroy", id));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="اضافه کردن" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                اضافه کردن
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="دسته" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    اضافه کردن
                                </PrimaryButton>
                            </div>
                        </form>
                        <div class="mt-4">
                            <div
                                v-for="(c, i) in categories"
                                :key="c"
                                class="inline-flex bg-gray-100 rounded-lg p-4 m-2 gap-x-2 justify-center items-center"
                            >
                                <div class="text-lg font-bold">
                                    {{ c.name }}
                                </div>
                                <button
                                    class="hover:bg-gray-200 px-2 rounded-full"
                                    @click="remove(c.id)"
                                >
                                    x
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
