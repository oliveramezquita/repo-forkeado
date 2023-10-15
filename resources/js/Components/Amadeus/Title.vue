<script setup>
const props = defineProps ({
	title: String,
});
</script>

<template>
    <div class="container-fluid container-rounded container-title">
        <span>{{ props.title }}</span>
    </div>
</template>

<style>
    .container-title {
        display: flex;
        justify-content: center;
        align-items: center ;
        background-color: #EDF3FB;
        border-bottom: 2px solid #649bff;
        height: 5rem;
        color: #2B5DB6;
        font-weight: 600;
        font-size: 1.8rem;
    }
</style> 