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
                                            :href="route('users.create')"
                                        >
                                            <i class="fa fa-plus"></i>
                                            <span class="d-none d-lg-inline">Create New User</span>
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
                                            :href="route('users.index')"
                                            :data="filters.trashed == 'only' ? {} : bin.data"
                                        >{{
                                                filters.trashed == "only" ? "Users List" : bin.title
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
                                        <inertia-link href method="get" :data="{}"
                                        >ID
                                        </inertia-link
                                        >
                                    </th>
                                    <th>
                                        <inertia-link href method="get" :data="{}"
                                        >Username
                                        </inertia-link
                                        >
                                    </th>
                                    <th data-hide="phone">
                                        <inertia-link href method="get" :data="{}"
                                        >Email
                                        </inertia-link
                                        >
                                    </th>
                                    <th data-hide="phone,tablet">Role</th>
                                    <th class="action">
                                        <inertia-link href method="get" :data="{}"
                                        >Action
                                        </inertia-link
                                        >
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="users.data.length > 0" v-for="user in users.data">
                                    <td>

                                        <div class="custom-control custom-checkbox">
                                            <input
                                                data-check-all-item
                                                v-model="checked"
                                                type="checkbox" name="id"
                                                :value="user.id"
                                                :id="'user_id_' + user.id"
                                                placeholder="Password"
                                                class="custom-control-input checkall__item"/>
                                            <label class="custom-control-label" :for="'user_id_' + user.id">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ user.id }}

                                    </td>
                                    <td>
                                        {{ user.username }}

                                    </td>
                                    <td>
                                        {{ user.email }}

                                    </td>
                                    <td></td>
                                    <td>
                                        <div v-if="filters.trashed != 'only'">
                                            <inertia-link
                                                class="btn btn-warning btn-sm"
                                                :href="route('users.edit', user.id)"
                                                method="get"
                                                :data="{}"
                                            >Edit
                                            </inertia-link
                                            >
                                            <inertia-link
                                                preserve-scroll
                                                preserve-state
                                                @click.prevent="confirmDel(user.id)"
                                                class="btn btn-danger btn-sm"
                                                :href="route('users.trashed', user.id)"
                                                :class="{ disabled: $page.auth.user.id === user.id }"
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
                                                :href="route('users.restore')"
                                                method="post"
                                                :data="{ id: user.id }"
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
                            <pagination class="ml-auto" :links="users.links"/>
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
    metaInfo: {title: "Users"},
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
        users: Object,
        filters: {
            type: Object,
            default: null,
        },
    },
    mounted() {
        this.footable();
        console.log(this.$page.menu);
        checkAll(document.querySelector("[data-check-all-container]"));
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route("users.index", Object.keys(query).length ? query : {})
                );
            }, 150),
            deep: true,
        },
    },

    methods: {
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
                        this.route("users.destroy"),
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
                        this.route("users.trashed"),
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
                        this.route("users.restore"),
                        {id: this.checked},
                        {replace: true, preserveState: true, preserveScroll: true}
                    ).then(() => {
                        this.checked = [];
                    });
                }
            }
        },
        confirmDel(id) {
            if (confirm("Are you sure you want to move to trash this user?")) {
                this.$inertia.post(
                    this.route("users.trashed"),
                    {id: id},
                    {replace: true, preserveState: true, preserveScroll: true}
                );
            }
        },
    },
};
</script>
