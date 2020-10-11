<template>
    <div class="wrapper">
<!--        <Loading/>-->
        <!-- Navbar -->
        <Navbar/>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <Sidebar v-if="renderComponent" />
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <PageTitle/>
                        </div>
                        <div class="col-sm-6">
                            <!--                <Breadcrumb />-->
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <slot></slot>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- <footer class="main-footer">
          <div class="float-right d-none d-sm-block"><b>Version</b> 3.0.5</div>
          <strong
            >Copyright &copy; 2014-2019
            <a href="http://adminlte.io">AdminLTE.io</a>.</strong
          >
          All rights reserved.
        </footer> -->

        <!-- /.control-sidebar -->
        <FlashMessage v-if="$page.flash"/>
    </div>
</template>

<script>
import Sidebar from "./Sidebar";
import Navbar from "./Navbar";
import PageTitle from "./PageTitle";
import Breadcrumb from "./Breadcrumb";
import Loading from "./Loading";
import FlashMessage from "./FlashMessage";
export default {
    components: {Breadcrumb, PageTitle, Navbar, Sidebar, Loading,FlashMessage },
    data() {
        return {
            renderComponent: true,
        };
    },
    methods: {
        forceRerender() {
            // remove the my-component component from the DOM
            this.renderComponent = false;

            this.$nextTick(() => {
                // add my-component component in DOM
                console.log('aaâ');
                this.renderComponent = true;
            });
        }
    }
};
</script>

<style>
.text-sm {
    font-size: .925rem !important;
}

.page-link:focus {

    box-shadow: none;
}

.btn-outline-dark {
    border-color: #ced4da;
}

.dropdown-item {
    cursor: pointer;
}


/* ------------------------------------------------------------------------------
 *
 *  # Footable
 *
 *  jQuery plugin that aims to make HTML tables on smaller devices look awesome.
 *
 * ---------------------------------------------------------------------------- */

.footable {
    width: 100%;
}

.footable > thead > tr > th {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.footable.breakpoint > tbody > tr.footable-detail-show > td {
    border-bottom: 0;
}

.footable.breakpoint > tbody > tr.footable-row-detail:hover {
    background-color: transparent;
}

.footable.breakpoint > tbody > tr:hover:not(.footable-row-detail) {
    cursor: pointer;
}

.footable.breakpoint > tbody > tr > .footable-cell-detail {
    background-color: #fafafa;
    border-top: 0;
}

.footable.breakpoint > tbody > tr .footable-toggle:before {
    content: "";
    display: inline-block;
    font-family: "icomoon";
    font-size: 1rem;
    vertical-align: middle;
    position: relative;
    top: -0.09375rem;
    line-height: 1;
    padding-right: 0.625rem;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.footable.breakpoint > tbody > tr.footable-detail-show .footable-toggle:before {
    content: "";
}

.footable-row-detail-inner {
    display: table;
    table-layout: fixed;
    width: 100%;
}

.footable-row-detail-row {
    display: table-row;
}

.footable-row-detail-group {
    display: block;
    font-weight: 500;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}

.footable-row-detail-group:first-child {
    margin-top: 0.5rem;
}

.footable-row-detail-name {
    display: table-cell;
    font-weight: 500;
    padding-right: 2.5rem;
}

.footable-row-detail-value {
    display: table-cell;
    padding: 0.5rem 0;
}

th.action {
    width: 100px;
}
.tooltip {
  display: block !important;
  z-index: 10000;
}

.tooltip .tooltip-inner {
  background: black;
  color: white;
  border-radius: 16px;
  padding: 5px 10px 4px;
}

.tooltip .tooltip-arrow {
  width: 0;
  height: 0;
  border-style: solid;
  position: absolute;
  margin: 5px;
  border-color: black;
  z-index: 1;
}

.tooltip[x-placement^="top"] {
  margin-bottom: 5px;
}

.tooltip[x-placement^="top"] .tooltip-arrow {
  border-width: 5px 5px 0 5px;
  border-left-color: transparent !important;
  border-right-color: transparent !important;
  border-bottom-color: transparent !important;
  bottom: -5px;
  left: calc(50% - 5px);
  margin-top: 0;
  margin-bottom: 0;
}

.tooltip[x-placement^="bottom"] {
  margin-top: 5px;
}

.tooltip[x-placement^="bottom"] .tooltip-arrow {
  border-width: 0 5px 5px 5px;
  border-left-color: transparent !important;
  border-right-color: transparent !important;
  border-top-color: transparent !important;
  top: -5px;
  left: calc(50% - 5px);
  margin-top: 0;
  margin-bottom: 0;
}

.tooltip[x-placement^="right"] {
  margin-left: 5px;
}

.tooltip[x-placement^="right"] .tooltip-arrow {
  border-width: 5px 5px 5px 0;
  border-left-color: transparent !important;
  border-top-color: transparent !important;
  border-bottom-color: transparent !important;
  left: -5px;
  top: calc(50% - 5px);
  margin-left: 0;
  margin-right: 0;
}

.tooltip[x-placement^="left"] {
  margin-right: 5px;
}

.tooltip[x-placement^="left"] .tooltip-arrow {
  border-width: 5px 0 5px 5px;
  border-top-color: transparent !important;
  border-right-color: transparent !important;
  border-bottom-color: transparent !important;
  right: -5px;
  top: calc(50% - 5px);
  margin-left: 0;
  margin-right: 0;
}

.tooltip.popover .popover-inner {
  background: #f9f9f9;
  color: black;
  padding: 24px;
  border-radius: 5px;
  box-shadow: 0 5px 30px rgba(black, .1);
}

.tooltip.popover .popover-arrow {
  border-color: #f9f9f9;
}

.tooltip[aria-hidden='true'] {
  visibility: hidden;
  opacity: 0;
  transition: opacity .15s, visibility .15s;
}

.tooltip[aria-hidden='false'] {
  visibility: visible;
  opacity: 1;
  transition: opacity .15s;
}

</style>
