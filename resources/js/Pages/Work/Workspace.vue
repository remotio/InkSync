<script setup>
import { ref, watch, onMounted, nextTick } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Editor } from '@toast-ui/editor';
import { marked } from 'marked';
import '@toast-ui/editor/dist/toastui-editor.css';
import axios from 'axios'; 
import Authenticated from '@/Layouts/AuthenticatedLayout.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    work: Object,
    note: Object,
});

const form = useForm({
    title: props.work.title,
    description: props.work.description,  
});


let html_path= props.note.html_path;
const markdownContent = ref(html_path);

watch(
    [() => form.title, () => form.description, () => markdownContent.value], 
    debounce(async ([newTitle, newDescription, newHtmlPath]) => {
        html_path = newHtmlPath;
        await axios.put(route('work.update', props.work.id), {
            title: newTitle,
            description: newDescription,
            html_path: newHtmlPath,
        });
    }, 1000) 
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

// Geminiの返答をマークダウン化
const renderMarkdown = (content) => {
  return marked(content);
};

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
<script>
    export default {
      components: {
        MarkdownEditor,
  }
};
</script>

<template>
    <Authenticated>
        <template #header>
            <div class="w-full mx-auto sm:px-20 lg:px-30">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{form.title}}
                </h2>
            </div>
        </template>

        <div class="flex h-screen">
            <!--チャット機能-->
          <div class="w-1/2 border-r p-4 h-full flex flex-col">
                <div class="flex-1 overflow-y-auto" ref="chatContainer">
                    <div
                        v-for="(msg, index) in chatMessages"
                        :key="index"
                        :class="['mb-2', msg.sender === 'user' ? 'text-right' : 'text-left']"
                    >
                    <!-- Geminiの返答にマークダウンを適用 -->
                    <div
                        v-if="msg.sender === 'gemini'"
                        class="inline-block p-2 rounded-lg max-w-xs bg-gray-200 text-black"
                        v-html="renderMarkdown(msg.text)"
                    ></div>
                    <div
                        v-else
                        class="inline-block p-2 rounded-lg max-w-xs bg-lightblue text-black"
                    >
                        {{ msg.text }}
                    </div>
              </div>
            </div>
    
                <!-- 入力エリア -->
                <div class="sticky bottom-0 bg-white p-4">
                    <input v-model="userInput" type="text" class="border rounded p-2 w-full" placeholder="メッセージを入力..." @keyup.enter="sendMessage" />
                    <button @click="sendMessage" class="mt-2 p-2 bg-blue-500 text-white rounded">送信</button>
                </div>
            </div>

            <!--ノート機能-->
            <div class="w-1/2 p-4 h-full">
                <form @submit.prevent="submit">
                    <div>
                        <label for="title">タイトル</label>
                        <input v-model="form.title" id="title" type="text" class="block w-full mt-1" required />
                    </div>

                    <div class="mt-4">
                        <label for="description">概要</label>
                        <textarea v-model="form.description" id="description" class="block w-full mt-1" required></textarea>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <label for="html_path">内容</label>
                    </div>
                        <MarkdownEditor v-model="markdownContent" />
                </form>
            </div>
        </div>
    </Authenticated>
</template>

<style scoped>
.max-w-xs {
    max-width: 90%;
}

.bg-lightblue {
    background-color: #cfe8fc;
}

.sticky {
    position: -webkit-sticky;
    position: sticky;
    bottom: 0;
}
</style>
