<script setup>
import { defineProps } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Authenticated from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    title: '',
    description: '',
    is_public: false,
});

const submit = () => {
    form.post(route('work.store'));
};
</script>

<template>
    <Authenticated>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ワーク新規作成
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <form @submit.prevent="submit">
                <div>
                    <label for="title">タイトル</label>
                    <input v-model="form.title" id="title" type="text" class="block w-full mt-1" required />
                </div>
    
                <div class="mt-4">
                    <label for="description">概要</label>
                    <textarea v-model="form.description" id="description" class="block w-full mt-1" required></textarea>
                </div>
                
                <div class="mt-4">
                    <label for="is_public">公開</label>
                    <input v-model="form.is_public" id="is_public" type="checkbox" class="block mt-1" />
                </div>
    
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                        作成
                    </button>
                </div>
            </form>
        </div>
    </Authenticated>
</template>