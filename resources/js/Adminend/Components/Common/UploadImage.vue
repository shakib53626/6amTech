<script setup>
import { Plus } from '@element-plus/icons-vue'
import { ref } from 'vue'
const model = defineModel({
    type: Object,
    default: ''
});
defineProps({
  disabled: Boolean,
  label   : String,
  form    : Object
})

const dialogVisible  = ref(false);
const dialogImageUrl = ref('');

const handlePictureCardPreview = (file) => {
    dialogVisible.value = true;
    dialogImageUrl.value = file?.url
}

</script>

<template>
    <div>
        <text class="pb-2 font-semibold">{{ label }}</text>
        <el-upload action="#" list-type="picture-card" :auto-upload="false" v-model:file-list="model" :on-preview="handlePictureCardPreview" >
            <el-icon><Plus /></el-icon>
        </el-upload>

        <span class="text-red-500">{{ form?.errors?.image }}</span>

        <el-dialog v-model="dialogVisible">
            <img w-full :src="dialogImageUrl" alt="Preview Image" />
        </el-dialog>
    </div>
</template>
