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
    border: 0.15rem solid #DA0505;
	border-radius: 2rem;
	color: #DA0505;
	font-weight: 500;
    font-size: 1.3rem;
    letter-spacing: -0.5px;
    width: 75%;
    transition: background-color ease-in-out 0.15s, transform ease-in-out 0.15s; /* Transición para color de fondo y transformación */
    transform: scale(1); /* Tamaño inicial sin escala adicional */

}

.button:hover {
    background-color: #DA0505; /* Color correspondiente a bg-gray-700 */
    color: white;
    font-weight: 600;
    transform: scale(1.02); /* Al pasar el ratón, el botón se agranda un 5% */
}

.button:focus {
    background-color: #DA0505; /* Color correspondiente a bg-gray-700 */
}

.button:active {
    background-color: #DA0505; /* Color correspondiente a bg-gray-900 */
}



</style>