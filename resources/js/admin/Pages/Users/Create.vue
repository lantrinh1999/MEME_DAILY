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
                            autocomplete="off"
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
                    <!--                    <div class="card-header header-elements-inline">-->
                    <!--                        <h5 class="card-title">Simple user list</h5>-->
                    <!--                        <div class="header-elements">-->
                    <!--                            <div class="list-icons">-->
                    <!--                                <a class="list-icons-item" data-action="collapse"></a>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

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
import $ from 'jquery';
export default {
    metaInfo: {
        title: "Create User",
    },
    layout: AdminLayout,
    components: {
        TextInput,
        Btn,
    },
    data() {
        return {
            loading: false,
            form: {
                first_name: "",
                last_name: "",
                email: "",
                username: "",
                password: "",
                password_confirmation: "",
                is_super: false
            },
        };
    },
    props: {
        pageTitle: String,
    },
    methods: {
        submit() {
            this.loading = true;
            this.$inertia.post(this.route("users.store"), this.form).then(() => {
                // console.log(this.$page.flash);
                if (this.$page.flash.success) {
                    this.form = {
                        first_name: "",
                        last_name: "",
                        email: "",
                        username: "",
                        password: "",
                        password_confirmation: "",
                        is_super: false
                    }
                }

                setTimeout(() => {
                    this.loading = false;
                }, 500);
            });
        },
    },
    mounted() {
        $(document).ready(function () {
            $("#mytags").tagit({
                singleField: true,
                singleFieldNode: $('#mySingleField'),
                allowSpaces: true,
                minLength: 2,
                removeConfirmation: true,
                tagSource: function (request, response) {
                    //console.log("1");
                    $.ajax({
                        url: "search.php",
                        data: {term: request.term},
                        dataType: "json",
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    label: item.label + " (" + item.id + ")",
                                    value: item.value
                                }
                            }));
                        }
                    });
                }
            });
        });
    },
};
</script>
