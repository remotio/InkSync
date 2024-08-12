<script setup>
import { defineProps } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Authenticated from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    work: Object,
    note: Object,
});

const form = useForm({
    title: props.work.title,
    description: props.work.description,  
    html_path: props.note.html_path,
});

const submit = () => {
    form.put(route('work.update', props.work.id));
};

watch(
  () => props.work.title,
  (newTitle) => {
    document.title = newTitle;
  },
  { immediate: true }
);
</script>

<template>
    <Authenticated>
       <template #header>
           <div class="w-full mx-auto sm:px-20 lg:px-30">
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   InkSync
               </h2>
           </div>
       </template>

        <div>
            <h1 class="text-2xl font-bold">ノートを編集</h1>
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
                    <label for="html_path">内容</label>
                    <textarea v-model="form.html_path" id="html_path" class="block w-full mt-1" required></textarea>
                </div>
    
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                        更新
                    </button>
                </div>
            </form>
        </div>
    </Authenticated>
</template>