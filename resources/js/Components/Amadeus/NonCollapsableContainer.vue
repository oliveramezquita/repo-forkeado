<script>
export default {
    props: {
        isActive: {
            type: Boolean,
            required: true
        }
    }
}
</script>

<template>
    <div class="container-fluid">
        <div :class="['container-target', { 'container-disabled': !isActive }]" class="container-rounded">
            <slot name="noncollapsablecontainer"></slot>
        </div>
</div>
</template>

<style scoped>
.container-target {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: transparent;
    min-height: 5.2rem;
    height: auto;
    padding: 0rem 4.5rem 0rem 6.5rem;
    padding-right: 8.5rem;  /* Aumentar el espacio a la derecha */
    box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.20);
    cursor: default;

}



.container-disabled {
    background-color: #E1E1E1;
    color: #9e9e9e;
}

.container-fluid {
    transition: transform 0.3s ease;  /* Añadir transición */
    transform: scale(1);  /* Escala inicial */
}

.container-fluid:hover {
    transform: scale(1.03);  /* Escala al pasar el mouse */
}




</style>
