<script setup>
   import { defineProps } from 'vue';
   import Authenticated from '@/Layouts/AuthenticatedLayout.vue';
   import { Link } from '@inertiajs/vue3'
   
    const props = defineProps({
        publicWorks: Array,
        userWorks: Array,
        isAuthenticated: Boolean
    });
</script>

<template>
    <Authenticated>
       <template #header>
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Home
           </h2>
       </template>
       
        <div class="container mx-auto mt-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- 公開ノート一覧 -->
                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-4">公開ノート一覧</h1>
                    <div v-for="work in publicWorks" :key="work.id" class="p-4 mb-4 border rounded-lg shadow-sm bg-white">
                        <h2 class="text-xl mb-2">
                            <Link :href="route('work.showNote', work.id)" class="text-blue-600 hover:underline">{{ work.title }}</Link>
                        </h2>
                        <p class="text-gray-700">ユーザー名: {{ work.user.name }}</p>
                    </div>
                </div>
                <!-- 個人ノート一覧 または ログインメッセージ -->
                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-4">
                        個人ノート一覧
                    </h1>
                    <div v-if="isAuthenticated">
                        <div v-for="work in userWorks" :key="work.id" class="p-4 mb-4 border rounded-lg shadow-sm bg-white">
                            <h2 class="text-xl mb-2">
                                <Link :href="route('work.showNote', work.id)" class="text-blue-600 hover:underline">{{ work.title }}</Link>
                            </h2>
                        </div>
                    </div>
                    <div v-else>
                        <p class="text-gray-700 mb-4">ログインしてあなたのノートも見てみましょう！</p>
                        <Link href="/login" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            ログインページへ
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Authenticated>
</template>
