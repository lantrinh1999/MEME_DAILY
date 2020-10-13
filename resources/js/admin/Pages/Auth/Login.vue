<template>
    <div>
        <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
<!--                        <div class="auth-brand text-center text-lg-left">-->
<!--                            <div class="auth-logo">-->
<!--                                <a href="index.html" class="logo logo-dark text-center">-->
<!--                                    <span class="logo-lg">-->
<!--                                         <img src="../assets/images/logo-dark.png" alt="" height="22">-->
<!--                                    </span>-->
<!--                                </a>-->

<!--                                <a href="index.html" class="logo logo-light text-center">-->
<!--                                    <span class="logo-lg">-->
<!--                                         <img src="../assets/images/logo-light.png" alt="" height="22"> -->
<!--                                    </span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->

                        <!-- title-->
                        <h4 class="mt-0">Sign In</h4>
                        <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>

                        <!-- form -->
                        <form @submit.prevent="submit">
                            <div v-if="typeof $page.errors.username != 'undefined'"
                        class="alert bg-danger text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <span class="font-weight-semibold">Login failed:</span> "Invalid
                        username or password.”
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="hidden" value />
                        <label for="username">Username or Email</label>
                        <input autofocus autocapitalize="off" autocomplete="false" id="username" type="text" v-model="form.username"
                            name="username" class="form-control" placeholder="Username or Email" />
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <label for="password">Password</label>
                        <input type="password" id="password" v-model="form.password" name="password" class="form-control"
                            placeholder="Password" />

                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" v-model="form.remember" name="remember"
                                id="custom_checkbox_stacked_unchecked" value="true" placeholder="Password"
                                class="custom-control-input remember" />
                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Remember
                                me</label>
                        </div>
                    </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit">Log In </button>
                            </div>
                            <!-- social-->
                            <div class="text-center mt-4">
                                <h5 class="mt-0 text-muted">Sign in with</h5>
                                <ul class="social-list list-inline mt-3 mb-0">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-purple text-purple"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <!-- <footer class="footer footer-alt">
                            <p class="text-muted">Don't have an account? <a href="auth-register-2.html" class="text-primary ml-1"><b>Sign Up</b></a></p>
                        </footer> -->

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
    </div>
</template>

<script>
import AuthLayout from "../../Shared/AuthLayout";
export default {
    layout: AuthLayout,
  components: {
  },
  data() {
    return {
      form: {
        username: "",
        password: "",
      },
    };
  },
  props: {
    auth: Object,
    errors: Object,
    flash: Object,
    post_login_url: String,
  },
  mounted() {},
  methods: {
    submit() {
      this.loading = true;
      this.$inertia.post(this.route("login.attempt"), this.form);
    },
  },
};
</script>

<style scoped>

</style>
