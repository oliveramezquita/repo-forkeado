import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

export const permissions = computed(() => page.props.userPermissions);
export const appType = computed(() => page.props.appType);