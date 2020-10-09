<template>
    <button :disabled="loading" :type="type" class="btn" :id="id" :form="form">
        <i v-if="!loading" class="fa fa-save"></i>
        <i v-if="loading" class="fa fa-spinner spinner"></i>
        {{ name }}
    </button>
</template>
<script>
export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${this._uid}`;
            }
        },
        type: {
            type: String,
            default: "submit"
        },
        form: {
            type: String,
            default: "form"
        },
        name: {
            type: String,
            default: "Submit"
        },
        loading: {
            type: Boolean,
            default: false
        }
    }
};
</script>
