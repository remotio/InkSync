<script setup>
import { defineProps } from 'vue';
import Authenticated from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    work: Object,
    note: Array,
    auth: Object
});
</script>

<template>
    <Authenticated>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ work.title }}
            </h2>
        </template>

        <div>
            <p>{{ note.html_path }}</p>
            <!-- 自分のノートであれば編集ボタンを表示 -->
            <div v-if="work.user_id === auth.user.id">
                <Link :href="route('note.edit', note.id)" class="text-blue-500 hover:underline">
                    編集
                </Link>
            </div>
        </div>
    </Authenticated>
</template>


