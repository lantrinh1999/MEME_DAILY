<template>
    <div class="form-group">
        <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
        <input
            :id="id"
            :maxlength="maxlength"
            :max="max"
            :placeholder="placeholder"
            :min="min"
            :name="name"
            ref="input"
            :disabled="disabled"
            v-bind="$attrs"
            class="form-input form-control"
            :class="{ error: errors.length, overmax: typeof value == 'string' && value.length > maxlength && maxlength != null }"
            :type="type"
            :value="value"
            autocomplete="off"
            @input="$emit('input', $event.target.value)"
        />
        <div
            class="maxlength"
            :class="{overmax: typeof value == 'string' && value.length >= maxlength && maxlength != null}"
            v-if="typeof value == 'string' && value.length > 0 && maxlength != null"
        >{{ value.length + '/' + maxlength }}
        </div>
        <div v-if="errors.length" class="form-error">{{ (errors) }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    data() {
        return {};
    },
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${this._uid}`;
            },
        },
        maxlength: {
            type: Number,
            default: null,
        },
        max: {
            type: Number,
            default: null,
        },
        min: {
            type: Number,
            default: null,
        },
        type: {
            type: String,
            default: "text",
        },
        inputClass: {
            type: String,
            default: null,
        },
        name: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: null,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        value: {
            type: String,
            default: "",
        },
        label: String,
        errors: {
            type: String,
            default: '',
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
    },
};
</script>
<style scoped>
label,
.form-label {
    margin-bottom: 0.5rem;
}

.form-error {
    padding-top: 0.3rem;
    color: #f44336;
    font-weight: 400;
    font-style: italic;
}

.form-group {
    position: relative;
}

.maxlength {
    display: none;
    position: absolute;
    bottom: 0;
    right: 1%;
    transform: translateY(100%);
    font-size: 0.75rem;
}

.form-group input:focus + .maxlength {
    display: block;
}

.overmax {
    color: #f44336;
}
</style>
