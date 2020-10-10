<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form
                            method="post"
                            id="user_store"
                            :action="route('users.store')"
                            @submit.prevent="submit"
                        >
                            <div class="row">
                                <text-input
                                    :maxlength="50"
                                    v-model="form.first_name"
                                    :errors="$page.errors.first_name"
                                    class="col-md-6"
                                    label="First name"
                                />
                                <text-input
                                    :maxlength="50"
                                    v-model="form.last_name"
                                    :errors="$page.errors.last_name"
                                    class="col-md-6"
                                    label="Last name"
                                />
                                <text-input
                                    :maxlength="50"
                                    v-model="form.email"
                                    :errors="$page.errors.email"
                                    class="col-md-6"
                                    type="email"
                                    label="Email"
                                />
                                <text-input
                                    :maxlength="50"
                                    :disabled="true"
                                    v-model="form.username"
                                    :errors="$page.errors.username"
                                    class="col-md-6"
                                    type="text"
                                    label="Username"
                                />
                            </div>

                            <div class="row">
                                <text-input
                                    :maxlength="50"
                                    v-model="form.password"
                                    :errors="$page.errors.password"
                                    class="col-md-6"
                                    type="password"
                                    label="Password"
                                />
                                <text-input
                                    :maxlength="50"
                                    v-model="form.password_confirmation"
                                    :errors="$page.errors.password_confirmation"
                                    class="col-md-6"
                                    type="password"
                                    label="Confirm Password"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Actions</h5>
                    </div>
                    <div class="card-body">
                        <btn :loading="loading" class="btn btn-success" form="user_store" name="Save"></btn>
                        <button
                            v-if="!user.deleted_at && user.id != $page.auth.user.id"
                            @click="trashed"
                            class="btn btn-danger"
                        >
                            <i class="fa fa-trash" aria-hidden="true"></i> Move to Trash
                        </button>
                        <button v-if="user.deleted_at" @click="restore" class="btn btn-danger">Restore</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" v-model="form.is_super" name="remember"
                                   id="custom_checkbox_stacked_unchecked" value="true" placeholder="Password"
                                   class="custom-control-input remember"/>
                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">
                                Super administrator</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "../../Shared/AdminLayout";
import TextInput from "../../Shared/TextInput";
import Btn from "../../Shared/Btn";

export default {
    metaInfo: {title: "Edit User"},
    layout: AdminLayout,
    components: {
        TextInput,
        Btn,
    },
    data() {
        return {
            loading: false,
            form: {
                first_name: this.user.first_name ?? null,
                last_name: this.user.last_name ?? null,
                email: this.user.email ?? null,
                username: this.user.username ?? null,
                password: null,
                password_confirmation: null,
                is_super: this.user.is_super ?? null
            },
        };
    },
    props: {
        user: Object,
        pageTitle: String,
    },
    methods: {
        submit() {
            this.loading = true;
            this.$inertia
                .put(this.route("users.update", this.user.id), this.form)
                .then(() => {
                    setTimeout(() => {
                        this.loading = false;
                    }, 500);
                });
        },
        destroy() {
            if (confirm("Are you sure you want to delete this?")) {
                this.$inertia.delete(this.route("users.destroy", this.user.id));
            }
        },
        trashed() {
            if (confirm("Are you sure you want to move to trash this user?")) {
                this.$inertia.post(this.route("users.trashed"), {id: this.user.id});
            }
        },
        restore() {
            if (confirm("Are you sure you want to restore this organization?")) {
                this.$inertia.put(this.route("users.restore", this.user.id));
            }
        },
    },
};
</script>
