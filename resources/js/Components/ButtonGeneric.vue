<template>
    <button
        class="inline-flex justify-center items-center px-4 py-2 transition ease-in-out duration-150 button"
    >
        <slot />
    </button>
</template>

<style scoped>
.button {
    margin: auto;
	height: 3.2rem;
	background-color: #3C7FF8;
	border-radius: 2rem;
	color: #fff;
	font-weight: 600;
    font-size: 1.3rem;
    letter-spacing: -0.5px;
    width: 75%;
    transition: background-color ease-in-out 0.15s, transform ease-in-out 0.15s; /* Transición para color de fondo y transformación */
    transform: scale(1); /* Tamaño inicial sin escala adicional */
}

.button:hover {
    background-color: #055bfa; /* Color correspondiente a bg-gray-700 */
    transform: scale(1.02); /* Al pasar el ratón, el botón se agranda un 5% */
}

.button:focus {
    background-color: #3C7FF8; /* Color correspondiente a bg-gray-700 */
}

.button:active {
    background-color: #3C7FF8; /* Color correspondiente a bg-gray-900 */
}
</style>