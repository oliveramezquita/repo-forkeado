<template>
    <button
        class="inline-flex items-center px-4 py-2 transition ease-in-out duration-150 button-danger"
    >
        <slot />
    </button>
</template>

<style scoped>
.button-danger {
	margin: auto;
	height: 3.2rem;
	background-color: #fff;
	border-radius: 2rem;
	color: #5cb85c;
	border: none;
	font-weight: 600;
    font-size: 1.5rem;
    letter-spacing: -0.5px;
    width: 75%;
	border: 2px solid #5cb85c;
    transition: background-color ease-in-out 0.15s; /* Agregado para la transición del color de fondo */
}

.button-danger:hover {
	background-color: #5cb85c;
	color: #fff;
	border: 2px solid #5cb85c;
}

.button-danger:focus {
	background-color: #5cb85c;
}

.button-danger:active {
	background-color: #5cb85c;
}
</style>