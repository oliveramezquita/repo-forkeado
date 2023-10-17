<script>
import { onUpdated } from 'vue';
export default {

    setup() {
        onUpdated(() => {
            document
                .querySelectorAll('input[type=checkbox][data-toggle="toggle"]')
                .forEach(function (ele) {
                    ele.bootstrapToggle()
                })
        })
    }
}
</script>

<template>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="container-btn-close">
                    <a data-bs-dismiss="modal" aria-label="Close" class="cursor-pointer"><i
                            class="fa-regular fa-xmark"></i></a>
                </div>
                <div class="modal-header w-100">
                    <p class="modal-title">
                        <slot name="modal-header"></slot>
                    </p>
                </div>
                <div class="modal-body w-100">
                    <slot name="modal-body"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.container-btn-close {
    width: 100%;
    display: flex;
    flex-direction: row-reverse;
}

.fa-xmark {
    color: #3C7FF8;
    font-size: 1.5rem;
}

.modal {
    background: rgba(0, 0, 0, 0.45);
    z-index: 1200;
}

.modal-content {
    display: flex;
    border-radius: 3.125rem;
    border: 3px solid #3C7FF8;
    background: #FFF;
    min-height: 45rem;
    padding: 3.5rem 5.5rem;
    flex-direction: column;
    align-items: flex-start;
}

div.modal-dialog.modal-dialog-centered {
    max-width: 35rem;
}

.modal-header {
    display: flex;
    justify-content: center;
    align-items: center;
    border: 0;
}

.modal-title {
    color: #3c7ff8;
    font-size: 2rem;
    font-weight: 600;
}

.modal-body {
    padding: 0;
}
</style>