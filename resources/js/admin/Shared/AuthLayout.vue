<template>
   <div class="auth-fluid">
            <!-- Auth fluid right content -->
            <div class="auth-fluid-right">
                <div class="auth-user-testimonial">
                    <h3 class="mb-3 text-white">Very elegant & impressive!</h3>
                    <p class="lead font-weight-normal"><i class="mdi mdi-format-quote-open"></i> I've been using this theme for a while and I must say that whenever I am looking for a design - I refer to this theme for specifics & implementation. With wide arrays of components, designs, charts - I would highly recommend this theme for anyone using it for dashboard or project management usage.. <i class="mdi mdi-format-quote-close"></i>
                    </p>
                    <h5 class="text-white">
                        - Admin User
                    </h5>
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->

            <!--Auth fluid left content -->
            <slot></slot>
            <!-- end auth-fluid-form-box-->
        </div>
        <!-- end auth-fluid-->
</template>

<script>
    export default {

    }
</script>

<style>

.logout-icon {
  width: 140px
}

.auth-fluid {
  position: relative;
  display: flex;
  align-items: center;
  min-height: 100vh;
  flex-direction: row;
  align-items: stretch;
  /* background: url(../images/bg-auth.jpg) center; */
  background-size: cover
}

.auth-fluid .auth-fluid-form-box {
  max-width: 480px;
  border-radius: 0;
  z-index: 2;
  padding: 3rem 2rem;
  background-color: #fff;
  position: relative;
  width: 100%
}

.auth-fluid .auth-fluid-right {
  padding: 6rem 3rem;
  flex: 1;
  position: relative;
  color: #fff;
  background-color: rgba(0, 0, 0, .5)
}

.auth-brand {
  margin-bottom: 2rem
}

.auth-user-testimonial {
  position: absolute;
  margin: 0 auto;
  padding: 0 2.75rem;
  bottom: 3rem;
  left: 0;
  right: 0
}

.auth-user-testimonial p.lead {
  max-width: 700px
}

@media (min-width:992px) {
  .auth-brand {
    position: absolute;
    top: 3rem
  }
}

@media (max-width:991.98px) {
  .auth-fluid {
    display: block
  }

  .auth-fluid .auth-fluid-form-box {
    max-width: 100%;
    min-height: 100vh
  }

  .auth-fluid .auth-fluid-right {
    display: none
  }
}

.auth-logo .logo-light {
  display: none
}

.auth-logo .logo-dark {
  display: block
}

.social-list-item {
height: 2rem;
    width: 2rem;
    line-height: calc(2rem - 4px);
    display: block;
    border: 2px solid #adb5bd;
    border-radius: 50%;
    font-size: 1.2rem;
}

</style>