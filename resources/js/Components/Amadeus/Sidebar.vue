<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import SchoolMenuConfig from '@/SchoolMenuConfig.js';
import ConsMenuConfig from '@/ConsMenuConfig.js';
import { permissions, appType } from '@/utils/inertiaUtils';

const props = defineProps ({
	croute: String,
});

const isSidebarClosed = ref(true);
const isSidebarHoverable = ref(true);
const activeRoute = props.croute;

let items;
if(appType.value === 'school') {
	items = ref(SchoolMenuConfig);
} else if (appType.value === 'cons'){
	items = ref(ConsMenuConfig);
}
const submenuItems = ref([]);

const getLinkIndex = () => {
	const linkActive = document.querySelector('.link-active') || document.querySelector('.menu-active');
	return linkActive?.getAttribute("item-link-index");
};

const hideSidebar = () => {
	if (isSidebarHoverable.value) {
		isSidebarClosed.value = true;
		closeSubmenuItems();
		const index = getLinkIndex();
		submenuItems.value[index]?.classList.add('is_active');
	}
};

const showSidebar = () => {
	if (isSidebarHoverable.value) {
		isSidebarClosed.value = false;
		const index = getLinkIndex();
		submenuItems.value[index]?.classList.add('show_submenu', 'is_active');
	}
};

const closeSubmenuItems = (index) => {
	if (index === undefined) {
		submenuItems.value.forEach((item) => {
			item.classList.remove('show_submenu', 'is_active');
		});
		return;
	}

	submenuItems.value.forEach((item, index2) => {
		if (index !== index2 && item) {
			item.classList.remove('show_submenu', 'is_active');
		}
	});
};

// Verifica si una ruta dada está activa
function isActive(routeName) {
	return activeRoute === routeName
}

const handleClick = (item, index) => {
	// Verificar si el elemento ya tiene la clase "is_active"
	if (item.classList.contains('show_submenu', 'is_active')) {
		item.classList.remove('show_submenu', 'is_active');
		return;
	}
	item.classList.add('show_submenu', 'is_active');
	closeSubmenuItems(index);
};

const hideMenuWithNoChildren = () => {
	// Selecciona todos los elementos ul que tienen la clase submenu
	const submenus = document.querySelectorAll('.submenu');
	// Para cada submenu dentro de submenus, verifica si los li tienen un elemento hijo a
	submenus.forEach((submenu) => {
		const items = submenu.querySelectorAll('li');
		let hasChildren = false;
		items.forEach((item) => {
			if (item.querySelector('a')) {
				hasChildren = true;
			}
		});
		// Si no tiene hijos
		if (!hasChildren) {
			// Elimina al padre del elemento submenu
			submenu.parentElement.remove();
		}
	});
	
};


onMounted(() => {
	if (window.innerWidth < 800) {
		isSidebarClosed.value = true;
		isSidebarHoverable.value = false;
	} else {
		isSidebarHoverable.value = true;
	}
	submenuItems.value = document.querySelectorAll('.submenu_item');
	submenuItems.value.forEach((item, index) => {
		item.addEventListener('click', () => handleClick(item, index));
	});
	const index = getLinkIndex();
	submenuItems.value[index]?.classList.add('is_active');
	hideMenuWithNoChildren();
});

</script>

<template>
	<div class="position-absolute">
		<nav class="sidebar" :class="{ close: isSidebarClosed, hoverable: isSidebarHoverable }"
			@mouseleave="hideSidebar" @mouseenter="showSidebar">

			<div class="menu_content">
				<div class="menu_items">

					<ul class="menu_item">
						<li class="item" v-for="(item, index) in items" :key="index" :class="{ 'first-active': index == 0 && isActive(item.routeName) }">

							<template v-if="item.submenu && item.submenu.length > 0">
								<a class="link submenu_item" role="button">
									<div class="d-flex align-items-center">
										<i :class="item.icon" class="fa-sm"></i>
										<span>{{ item.label }}</span>
									</div>
									<i class="fal fa-angle-down arrow-down"></i>
								</a>

								<ul class="submenu">
									<li class="item" v-for="(subItem, subIndex) in item.submenu" :key="subIndex">
										<Link 
											v-if="permissions.includes(subItem.permissionName)"
											:href="route(subItem.routeName ? subItem.routeName : 'dashboard')"
											:class="{ 'link-active': isActive(subItem.routeName)}"
											:item-link-index="index"
											class="flex link sub-link">
											{{ subItem.label }}
										</Link>
									</li>
								</ul>
							</template>

							<template v-else>
								<Link 
									:href="route(item.routeName)"
									:class="{ 'menu-active': isActive(item.routeName)}"
									:item-link-index="index"
									class="link flex submenu_item">
									<div>
										<i :class="item.icon"></i>
										<span>{{ item.label }}</span>
									</div>
								</Link>
							</template>

						</li>
					</ul>
				</div>

				<div class="sidebar_padding"></div>
			</div>
		</nav>
	</div>
</template>

<style scoped>
@import '../../../css/_Sidebar.scss';

</style>