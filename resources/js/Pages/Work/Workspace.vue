<script setup>
import { defineProps } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch, onMounted, nextTick } from 'vue';
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

// チャット関連
const chatMessages = ref([]);
const userInput = ref('');
const chatContainer = ref(null);

const scrollToEnd = () => {
    nextTick(() => {
        if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
    });
};

// 履歴の表示
onMounted(async () => {
    try {
        const response = await axios.get(route('chat.getHistory'), {
            params: {
                work_id: props.work.id,
            }
        }); 

        chatMessages.value = response.data.history.map(msg => ({
            sender: msg.is_user ? 'user' : 'gemini',
            text: msg.message
        }));

        scrollToEnd();
    } catch (error) {
        console.error('チャット履歴の取得エラー: ', error);
    }
});

const sendMessage = async () => {
    if (userInput.value.trim() !== '') {
        const userInputCopy = userInput.value;
        userInput.value = '';
        chatMessages.value.push({ sender: 'user', text: userInputCopy });

        try {
            const response = await axios.post(route('chat.send'), {
                work_id: props.work.id,
                message: userInputCopy,
            });

            chatMessages.value.push({ sender: 'gemini', text: response.data.message });
        } catch (error) {
            console.error('APIリクエストエラー: ', error);
            chatMessages.value.push({ sender: 'system', text: 'エラーが発生しました' });
        }

        scrollToEnd();
    }
};
</script>

<template>
    <div class="flex">
        <!--チャット機能-->
        <div class="w-1/2 border-r p-4 h-screen overflow-y-auto" ref="chatContainer">
            <!-- チャットエリア -->
            <div v-for="(msg, index) in chatMessages" :key="index" :class="['mb-2', msg.sender === 'user' ? 'text-right' : 'text-left']">
                <div :class="['inline-block', 'p-2', 'rounded-lg', 'max-w-xs', msg.sender === 'user' ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black']">
                    {{ msg.text }}
                </div>
            </div>

            <!-- 入力エリア -->
            <input v-model="userInput" type="text" class="border rounded p-2 w-full" placeholder="メッセージを入力..." @keyup.enter="sendMessage" />
            <button @click="sendMessage" class="mt-2 p-2 bg-blue-500 text-white rounded">送信</button>
        </div>

        <!--ノート機能-->
        <div class="w-1/2 p-4">
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

<style scoped>
.text-right {
    text-align: right;
}

.text-left {
    text-align: left;
}

.max-w-xs {
    max-width: 90%;
}

.bg-blue-500 {
    background-color: #4299e1;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}

.rounded-lg {
    border-radius: 1rem; 
}
</style>
