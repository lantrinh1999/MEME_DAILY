<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mr-auto d-flex justify-content-start">
                                    <div class="mb-2">
                                        <inertia-link
                                            class="btn btn-info btn-sm"
                                            :href="route('memes.create')"
                                        >
                                            <i class="fa fa-plus"></i>
                                            <span class="d-none d-lg-inline">Create New Meme</span>
                                        </inertia-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="mr-auto d-flex justify-content-start">
                                    <div class="dropdown mr-1">
                                        <button
                                            class="btn btn-light btn-outline-dark dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            Bulk actions
                                        </button>
                                        <div
                                            class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton"
                                        >
                                            <a
                                                v-if="filters.trashed !== 'only'"
                                                class="dropdown-item"
                                                @click="bulkMoveToTrash"
                                            >Move to Trash</a
                                            >
                                            <a
                                                v-if="filters.trashed === 'only'"
                                                class="dropdown-item"
                                                @click="bulkRestore"
                                            >Restore</a
                                            >
                                            <a
                                                v-if="filters.trashed === 'only'"
                                                class="dropdown-item"
                                                @click="bulkDestroy"
                                            >Permanently Delete</a
                                            >
                                        </div>
                                    </div>
                                    <div class="filters d-flex">
                                        <div class="form-group d-none d-sm-inline-block">
                                            <text-input
                                                inputClass="form-control-sm"
                                                :maxlength="20"
                                                v-model="form.search"
                                                type="text"
                                                placeholder="Search"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-auto d-flex justify-content-end">
                                    <div class>
                                        <inertia-link
                                            class="btn btn-light"
                                            method="get"
                                            :href="route('memes.index')"
                                            :data="filters.trashed === 'only' ? {} : bin.data"
                                        >{{
                                                filters.trashed === "only" ? "Memes List" : bin.title
                                            }}
                                        </inertia-link
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                data-check-all-container
                                class="table table-striped table-borderless table-hover table-sm tablesaw tablesaw-stack table-toggle"
                            >
                                <thead>
                                <tr>
                                    <th visible>

                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                data-check-all
                                                id="checkall__all"
                                                class="custom-control-input checkall__item"/>
                                            <label class="custom-control-label" for="checkall__all">
                                            </label>
                                        </div>

                                    </th>
                                    <th data-hide="phone,tablet">
                                        ID
                                    </th>
                                    <th>
                                        Title

                                    </th>
                                    <th style="width: 100px">
                                        Status

                                    </th>
                                    <th style="width: 100px" data-hide="phone">
                                        Image

                                    </th>

                                    <th class="action">
                                        Action

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="memes.data.length > 0" v-for="meme in memes.data">
                                    <td>

                                        <div class="custom-control custom-checkbox">

                                            <input data-check-all-item
                                                v-model="checked"
                                                type="checkbox" name="id"
                                                :value="meme.id"
                                                :id="'meme_id_' + meme.id"
                                                placeholder="Password"
                                                class="custom-control-input checkall__item"/>
                                            <label class="custom-control-label" :for="'meme_id_' + meme.id">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ meme.id }}

                                    </td>
                                    <td>
                                        <a target="_blank" class="text-bold text-decoration-none text-dark"
                                           :href="'/meme/'+ meme.slug">{{ meme.title }}</a>
                                    </td>
                                    <td>
                                        <span v-if="meme.status === 'PUBLISH'" class="right badge badge-success">Published</span>
                                        <span v-else-if=" meme.status === 'DRAFT'"
                                              class="right badge badge-info">Draft</span>


                                    </td>
                                    <td>
                                        <div style="height: 50px; overflow: hidden">

                                            <img v-tooltip="{
                                                placement: 'left-center',
                                                    content: asyncContent(meme.image),
                                                    loadingContent: '<i>Loading...</i>',
                                                  }"
                                                 width="50px" :src="meme.image" alt="">
                                        </div>


                                    </td>

                                    <td>
                                        <div v-if="filters.trashed !== 'only'">
                                            <inertia-link
                                                class="btn btn-warning btn-sm"
                                                :href="route('memes.edit', meme.id)"
                                                method="get"
                                                :data="{}"
                                            >Edit
                                            </inertia-link
                                            >
                                            <inertia-link
                                                preserve-scroll
                                                preserve-state
                                                @click.prevent="confirmDel(meme.id)"
                                                class="btn btn-danger btn-sm"
                                                :href="route('memes.trashed', meme.id)"
                                                method="delete"
                                                :data="{}"
                                            >Del
                                            </inertia-link
                                            >
                                        </div>
                                        <div v-else>
                                            <inertia-link
                                                preserve-state
                                                preserve-scroll
                                                class="btn btn-warning btn-sm"
                                                :href="route('memes.restore')"
                                                method="post"
                                                :data="{ id: meme.id }"
                                            >Restore
                                            </inertia-link
                                            >
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination_ d-flex justify-content-end">
                            <pagination class="ml-auto" :links="memes.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Pagination from "../../Shared/Pagination";
import AdminLayout from "../../Shared/AdminLayout";
import TextInput from "../../Shared/TextInput";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import $ from "jquery";
import checkAll from "@github/check-all";

export default {
    metaInfo: {title: "MEME"},
    layout: AdminLayout,
    components: {
        Pagination,
        TextInput,
    },
    remember: ["bin"],
    data() {
        return {
            checked: [],
            check: false,
            test: "",
            bin: {
                title: "Go to Bin",
                data: {
                    trashed: "only",
                },
            },
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        };
    },
    props: {
        memes: Object,
        filters: {
            type: Object,
            default: null,
        },
    },
    mounted() {
        this.footable();
        console.log(this.memes);
        checkAll(document.querySelector("[data-check-all-container]"));
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route("memes.index", Object.keys(query).length ? query : {})
                );
            }, 150),
            deep: true,
        },
    },

    methods: {
        asyncContent(img) {
            return `<img alt="image" src="${img}" width="100%"/>`;
        },
        footable() {
            $(".table-toggle").footable();
        },
        bulkDestroy() {
            if (this.checked.length === 0) {
                alert("Please select at least 1 item!");
            } else {
                if (confirm("Are you sure you want to delete these items?")) {
                    console.log(this.checked);
                    this.$inertia.post(
                        this.route("memes.destroy"),
                        {id: this.checked},
                        {replace: true, preserveState: true, preserveScroll: true}
                    ).then(() => {
                        this.checked = [];
                    });
                }
            }
        },
        bulkMoveToTrash() {
            if (this.checked.length === 0) {
                alert("Please select at least 1 item!");
            } else {
                if (confirm("Are you sure you want to delete these items?")) {
                    this.$inertia.post(
                        this.route("memes.trashed"),
                        {id: this.checked},
                        {replace: true, preserveState: true, preserveScroll: true}
                    ).then(() => {
                        this.checked = [];
                    });
                }
            }
        },
        bulkRestore() {
            if (this.checked.length === 0) {
                alert("Please select at least 1 item!");
            } else {
                if (confirm("Are you sure you want to restore these items?")) {
                    this.$inertia.post(
                        this.route("memes.restore"),
                        {id: this.checked},
                        {replace: true, preserveState: true, preserveScroll: true}
                    ).then(() => {
                        this.checked = [];
                    });
                }
            }
        },
        confirmDel(id) {
            if (confirm("Are you sure you want to move to trash this meme?")) {
                this.$inertia.post(
                    this.route("memes.trashed"),
                    {id: id},
                    {replace: true, preserveState: true, preserveScroll: true}
                );
            }
        },
    },
};
</script>
