<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import MobileConsMenuConfig from '@/MobileConsMenuConfig.js';
import MobileSchoolMenuConfig from '@/MobileSchoolMenuConfig.js';
import { permissions, appType } from '@/utils/inertiaUtils';

const props = defineProps ({
	croute: String,
});

</script>

<template>
	<div class="sample-footer">
		Sample Footer
	</div>
</template>

<style scoped>
.sample-footer {
	position: fixed;
	bottom: 0;
	width: 100%;
	height: 4rem;
	background-color: #9ea8a8;
	display: flex;
	justify-content: center;
	align-items: center;
	z-index: 999;
	color: white;
}
</style>