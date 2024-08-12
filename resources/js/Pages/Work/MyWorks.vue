<script setup>
  import { defineProps } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  import Authenticated from '@/Layouts/AuthenticatedLayout.vue';
  
  const props = defineProps({
    works: Array
  });
  
  const confirmDelete = (id) => {
    if (confirm('このワークを削除してもよろしいですか？')) {
      Inertia.delete(route('work.destroy', id));
    }
  };
  

  
  const togglePublic = async (id, isPublic) => {
    const response = await Inertia.put(route('work.publish', id), { is_public: isPublic });
  };
  
  
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('ja-JP', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit'
    });
  };
  
</script>

<template>
  <Authenticated>
    <template #header>
      <div class="w-full mx-auto sm:px-20 lg:px-30">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          ワーク一覧
        </h2>
      </div>
    </template>
    
    <!-- ワークが存在しない場合の表示 -->
    <div v-if="works.length === 0" class="no-works-card">
      <p class="text-gray-700 mb-4">ノートがまだ作成されていません</p>
      <Link :href="route('work.create')" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
        ワークを作成
      </Link>
    </div>

    <!-- ワークが存在する場合の表示 -->
    <div v-else class="works-container">
      <div v-for="work in works" :key="work.id" class="work-card">
        <div class="work-info">
          <h3 class="work-title">{{ work.title }}</h3>
          <div v-if="work.tags" class="work-tags">
            <span v-for="tag in work.tags" :key="tag.id" class="work-tag">{{ tag.name }}</span>
          </div>
          <p class="work-description">{{ work.description }}</p>
        </div>
        <div class="work-actions">
          <div class="work-updated">最終更新：{{ formatDate(work.updated_at) }}</div>
          <label class="toggle-label">
            <input
              type="checkbox"
              :checked="work.is_public === 1"
              @change="togglePublic(work.id, $event.target.checked ? true : false)"
            />
            公開
          </label>
          <button class="delete-button" @click="confirmDelete(work.id)">削除する</button>
        </div>
      </div>
    </div>
  </Authenticated>
</template>


<style scoped>
.works-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.work-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: white;
  border-radius: 15px;
  padding: 20px;
  border: 1px solid #ccc;
}


.no-works-card{
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: white;

  padding: 20px;
  border: 1px solid #ccc;
  text-align: center;
  margin-top: 30px;
}

.work-info {
  max-width: 60%;
}

.work-title {
  font-size: 1.5em;
  font-weight: bold;
  margin-bottom: 10px;
}

.work-tags {
  display: flex;
  gap: 5px;
  margin-bottom: 10px;
}

.work-tag {
  background-color: #f0f0f0;
  border-radius: 5px;
  padding: 5px 10px;
  font-size: 0.9em;
}

.work-description {
  color: #333;
}

.work-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.work-updated {
  margin-bottom: 10px;
  font-size: 0.9em;
  color: #888;
}

.toggle-label {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.delete-button {
  color: #ff4d4f;
  cursor: pointer;
  border: none;
  background: none;
  font-size: 0.9em;
}
</style>
