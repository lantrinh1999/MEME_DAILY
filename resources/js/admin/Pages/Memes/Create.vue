<template>
    <div class="a">
        <loading :active.sync="isLoading"
                 :can-cancel="true"
                 :on-cancel="onCancel"

                 :is-full-page="fullPage"></loading>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form
                            method="post"
                            id="user_store"
                            :action="route('memes.store')"
                            @submit.prevent="submit"
                            autocomplete="off"
                        >
                            <div class="row">
                                <text-input
                                    :maxlength="500"
                                    v-model="form.title"
                                    :errors="$page.errors.title"
                                    class="col-md-12"
                                    label="Title"
                                />
                            </div>
                            <div class="row">
                                <div class="col-sm-12">


                                    <div class="row">
                                        <div class="col-12"><label>Link Image</label></div>
                                        <text-input
                                            :maxlength="1000"
                                            v-model="form.image.value"
                                            :errors="$page.errors['image.value']"
                                            class="col-9 col-md-11"

                                        />
                                        <div class="col-1">
                                            <input class="d-none" id="photo" type="file" @change="selectFile">
                                            <span @click="clickPhoto" class=""><a
                                                class="btn  btn-upload btn-info fa fa-upload"></a></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-12">
                                    <label for="content">Content</label>
                                    <div class="form-group">
                                        <editor id="content" :initialValue="editorText"
                                                :options="editorOptions"
                                                height="300px"
                                                previewStyle="vertical"
                                                ref="toastuiEditor"
                                                initialEditType="wysiwyg"
                                                class="w-100"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <btn
                            :loading="loading"
                            class="btn btn-success"
                            form="user_store"
                            name="Save"
                        ></btn>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div>
                            <vue-tags-input
                                v-model="tag"
                                :tags="tags"
                                :autocomplete-items="filteredItems"
:autocomplete-min-length="2"
                                @tags-changed="newTags => tags = newTags"
                            />
                        </div>
                    </div>
                </div>
                <div v-if="form.image.value" class="card">
                    <div class="card-body">
                        <div>
                            <img width="100%" :src="form.image.value" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import AdminLayout from "../../Shared/AdminLayout";
import TextInput from "../../Shared/TextInput";
import Btn from "../../Shared/Btn";
import $ from 'jquery';
import 'codemirror/lib/codemirror.css';
import '@toast-ui/editor/dist/toastui-editor.css';
import ImageUpload from "../../Shared/ImageUpload";
import {Editor} from '@toast-ui/vue-editor';
import VueTagsInput from '@johmun/vue-tags-input';
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";

export default {
    metaInfo: {
        title: "Create User",
    },
    layout: AdminLayout,
    components: {
        Loading,
        ImageUpload,
        TextInput,
        Btn,
        editor: Editor,
        VueTagsInput,
    },
    data() {
        return {
            tag: '',
            tags: [],
            photo: null,
            loading: false,
            isLoading: false,
            fullPage: true,
            form: {
                title: "",
                image: {
                    '_key': '_image',
                    'value': '',
                },
                content: this.editorText,

            },
            editorText: '',
            editorOptions: {
                hideModeSwitch: true,
                minHeight: '300px',
                language: 'en-US',
                useCommandShortcut: true,
                useDefaultHTMLSanitizer: true,
                usageStatistics: true,

            },
            autocompleteItems: [],
        };
    },
    props: {
        pageTitle: String,
    },
    methods: {
        clickPhoto() {
            document.getElementById('photo').click();
        },
        onCancel() {
            console.log('User cancelled the loader.')
        },
        selectFile(event) {
            // `files` is always an array because the file input may be in multiple mode
            this.photo = event.target.files[0];
            console.log(this.photo);
            let data = new FormData();
            data.append('photo', this.photo);
            this.isLoading = true;
            axios.post("/api/uploadPhoto", data).then(response => {
                this.isLoading = false;
                if (response.data.success) {
                    this.form.image = response.data.success;
                    console.log(this.form);
                }

            });
        },
        scroll() {
            this.$refs.toastuiEditor.invoke('scrollTop', 10);
        },
        moveTop() {
            this.$refs.toastuiEditor.invoke('moveCursorToStart');
        },
        getHtml() {
            return this.$refs.toastuiEditor.invoke('getHtml');
        },
        submit() {
            this.loading = true;
            this.form.content = this.getHtml();
            let form = this.form;
            form.tags = this.tags;
            this.$inertia.post(this.route("memes.store"), form).then(() => {

                if (this.$page.flash.success) {
                    this.photo = null;
                    this.form = {
                        title: "",
                        image: {
                            '_key': '_image',
                            'value': '',
                        },
                        content: this.editorText,
                    };
                    this.tags = [];
                    this.editorText = '';
                }

                setTimeout(() => {
                    this.loading = false;
                }, 500);
            });
        },


    },
    mounted() {


    },
    computed: {
        filteredItems() {
            return this.autocompleteItems;
        },
    },
    watch: {

        tag: {
            handler: throttle(function () {
                if (this.tag.length > 0) {
                    let query = pickBy({'name': this.tag});
                    axios.post("/api/getTags", query).then(response => {
                        // this.isLoading = false;
                        this.autocompleteItems = response.data;
                        console.log(response.data);

                    });
                }

            }, 500),
        },
    },
};
</script>
<style scoped>

</style>
