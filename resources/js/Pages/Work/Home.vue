<script setup>
   import { defineProps } from 'vue';
   import Authenticated from '@/Layouts/AuthenticatedLayout.vue';
   import { Link } from '@inertiajs/vue3'
   
    const props=defineProps({
        publicWorks:Array,
        userWorks:Array
    });
</script>
<template>
    <Authenticated>
       <template #header>
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               IncSync
           </h2>
       </template>

        <div>
            <h1 class="text-2xl font-bold">公開ノート一覧</h1>
            <div v-for="work in publicWorks" :key="work.id" class="p-4 mv04 bg-gray-100 rounded">
                <h2 class="text-xl">
                    <Link :href="route('work.showNote',work.id)">{{work.title}}</Link>
                </h2>
                <p>{{work.user.name}}</p>
            </div>
        </div>
        
        <div>
            <h1 class="text-2xl font-bold mt-8">個人ノート一覧</h1>
            <div v-for="work in userWorks" :key="work.id" class="p-4 mv04 bg-gray-100 rounded">
                <h2 class="text-xl">
                    <Link :href="route('work.showNote',work.id)">{{work.title}}</Link>
                </h2>
            </div>
        </div>

    </Authenticated>
</template>

