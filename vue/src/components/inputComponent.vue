<template>
    <div>
        <input 
        class="w-full bg-transparent border border-white/20 focus:border-white/40  text-white text-sm broder-[#EFF0EB] rounded-lg p-1 placeholder-white/60 focus:outline-none"
        :type="inputType"
        @focusin="isFocused = true"
        @blur="isFocused = false"
        v-model="inputComputed"
        :class="{'border-gray-900' : isFocused}, {'border-red-500' : error}"
        :placeholder="placeholder"
        autocomplete="off"
        >

        <span v-if="error" class="text-red-500 text-[14px] font-semibold">
            {{ error }}
        </span>
    </div>
</template>

<script setup>
import { computed, ref, toRefs } from 'vue';

const emit = defineEmits(['update:input']);
const props = defineProps(['input', 'placeholder', 'max', 'inputType', 'error']);


const { input, placeholder, max, inputType, error} = toRefs(props);

const isFocused = ref(false);

const inputComputed = computed({
    get : () => input.value,
    set : (val) => emit('update:input', val)
})
</script>

<style>
</style>