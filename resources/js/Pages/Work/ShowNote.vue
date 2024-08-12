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
           <div class="w-full mx-auto sm:px-20 lg:px-30">
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   {{work.title}}
               </h2>
           </div>
       </template>

        <div>
            <p>{{ note.html_path }}</p>
            <!-- 自分のノートであれば編集ボタンを表示 -->
            <div v-if="work.user_id === auth.user.id">
                <Link :href="route('workspace', work.id)" class="text-blue-500 hover:underline">
                    編集
                </Link>
            </div>
        </div>
    </Authenticated>
</template>


