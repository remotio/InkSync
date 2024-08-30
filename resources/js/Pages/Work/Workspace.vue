<script setup>
import { defineProps } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios'; 
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

//チャット関連
const chatMessages = ref([]);
const userInput = ref('');

const sendMessage = async () => {
    if (userInput.value.trim() !== '') {
        // ユーザーのメッセージをチャットに追加
        chatMessages.value.push({ sender: 'user', text: userInput.value });

        try {
            // Gemini APIへのリクエスト
            const response = await axios.post('/api/chat', {
                message: userInput.value,
            });

            // レスポンスをチャットに追加
            chatMessages.value.push({ sender: 'gemini', text: response.data.message });

        } catch (error) {
            console.error('APIリクエストエラー: ', error);
            chatMessages.value.push({ sender: 'system', text: 'エラーが発生しました' });
        }

        // ユーザー入力をクリア
        userInput.value = '';
    }
};

</script>

<template>
    <div class="flex">
        <!--チャット機能-->
        <div class="w-1/2 border-r p-4">
            <!-- チャットエリア -->
            <div v-for="(msg, index) in chatMessages" :key="index" class="mb-2">
                <strong>{{ msg.sender }}:</strong> {{ msg.text }}
            </div>

            <!-- 入力エリア -->
            <input v-model="userInput" type="text" class="border rounded p-2 w-full" placeholder="メッセージを入力..." @keyup.enter="sendMessage" />
            <button @click="sendMessage" class="mt-2 p-2 bg-blue-500 text-white rounded">送信</button>
        </div>

        <div class="w-1/2 p-4">
            <!--ノート機能-->
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
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">更新</button>
                </div>
            </form>
        </div>
    </div>
</template>
