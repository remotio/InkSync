<template>
  <div id="editor"></div>
</template>

<script>
import { Editor } from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';

export default {
  props: ['modelValue'],
  emits: ['update:modelValue'],
  mounted() {
    this.editor = new Editor({
      el: document.querySelector('#editor'),
      height: '500px',
      initialEditType: 'markdown',
      previewStyle: 'vertical',
      initialValue: this.modelValue || '',
    });

    this.editor.on('change', () => {
      const markdown = this.editor.getMarkdown();
      this.$emit('update:modelValue', markdown);
    });
  }
};
</script>

<style scoped>
  #editor {
    border: 1px solid #ddd;
    margin-top: 20px;
  }
</style>
