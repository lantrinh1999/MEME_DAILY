<template>
    <aside
        class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand"
    >
        <!-- Brand Logo -->
        <a href="../../index3.html" class="brand-link">
            <!-- <img
              src="../../dist/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3"
              style="opacity: 0.8"
            /> -->
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <!-- <img
                      src="../../dist/img/user2-160x160.jpg"
                      class="img-circle elevation-2"
                      alt="User Image"
                    /> -->
                </div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Add icons to the links using the .nav-icon class
                       with font-awesome or any other icon font library -->
                    <li v-for="menu in $page.menu" class="nav-item" :class="{
                        'has-treeview' : (typeof menu.children == 'object'),
                        'menu-open' : ( geturl(menu.url).includes($page.currentUrl)) || parent == menu.key
                    }">
                        <a :href="menu.url" :class="{'active' : ( geturl($page.currentUrl).includes(menu.url))}"
                           class="nav-link">
                            <i class="nav-icon" :class="menu.icon"></i>
                            <p>
                                {{ menu.parent_name }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul v-if="typeof menu.children == 'object'" :class="{}" :style="( geturl($page.currentUrl).includes(menu.url)) || parent == menu.key ? { 'display': 'block'}: {'display': 'none'}" class="nav nav-treeview">
                            <li class="nav-item">
                                <inertia-link @click="clickNav()" :href="menu.url"
                                              :class="{'active' : ( geturl($page.currentUrl) == geturl(menu.url))}"
                                              class="nav-link">
                                    <i class="nav-icon" :class="menu.icon"></i>
                                    <p>{{ menu.name }}</p>
                                </inertia-link>
                            </li>
                            <li v-for="child in menu.children" class="nav-item">
                                <inertia-link @click="clickNav()"
                                              :load="setParent(($page.parent) == (child.parent), child.parent)"
                                              :href="child.url"
                                              :class="{'active' : ( geturl($page.currentUrl) == geturl(child.url))}"
                                              class="nav-link">
                                    <i class="nav-icon" :class="child.icon"></i>
                                    <p>{{ child.name }}</p>
                                </inertia-link>
                            </li>

                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

</template>

<script>
import $ from 'jquery';

export default {
    name: "Sidebar",

    mounted() {
        // console.log(this.$page.currentUrl);

    },
    data() {
        return {
            pathname: window.location.origin + window.location.pathname,
            parent: '',
        }
    },
    methods: {
        geturl(url) {
            let a = new URL(url);
            // console.log(a.origin + a.pathname);
            return a.origin + a.pathname;
        },
        setParent(boo, parent) {
            if (boo) {
                console.log(parent);
                this.parent = parent;
            }
            // console.log(this.parent);
        },
        clickNav() {

        }
    }
}
</script>

<style scoped>
aside > * {
    font-size: 0.9rem;

}

.sidebar-mini .nav-legacy > .nav-item .nav-link .nav-icon, .sidebar-mini-md .nav-legacy > .nav-item .nav-link .nav-icon {
    margin-left: 0;
}

.nav-legacy.nav-sidebar > .nav-item > .nav-link.active {
    background: #5f9ea0;
    border-left: 0;
    box-shadow: none;
}
</style>
