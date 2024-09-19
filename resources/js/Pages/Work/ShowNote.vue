<script setup>
import { defineProps } from 'vue';
import Authenticated from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { marked } from 'marked';

const props = defineProps({
    work: Object,
    note: Object,
    auth: Object
});

const renderMarkdown = (content) => {
    return marked(content);
};
</script>

<template>
    <Authenticated>
        <template #header>
            <div class="w-full mx-auto sm:px-20 lg:px-30 flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ work.title }}
                </h2>
                <div v-if="auth.user && work.user_id === auth.user.id">
                    <Link :href="route('workspace', work.id)" class="text-blue-500 hover:underline">
                        編集
                    </Link>
                </div>
            </div>
        </template>

        <div class="container mx-auto p-4">
            <p v-if="work.description" class="text-gray-600 mb-4">{{ work.description }}</p>
            
            <div v-html="renderMarkdown(note.html_path)" class="prose max-w-none"></div>
        </div>
    </Authenticated>
</template>

<style scoped>
    
.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.prose {
    max-width: 100%;
    font-size: 1.1em;
    line-height: 1.6;
}

h2 {
    font-size: 1.5em;
}

p {
    margin-bottom: 10px;
    color: #333;
}
</style>
