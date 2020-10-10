<template>
  <div class="wrapper">
    <!-- Navbar -->
<Navbar/>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
<Sidebar/>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <PageTitle />
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
  </div>
</template>

<script>
import Sidebar from "./Sidebar";
import Navbar from "./Navbar";
import PageTitle from "./PageTitle";
import Breadcrumb from "./Breadcrumb";
export default {
    components: {Breadcrumb, PageTitle, Navbar, Sidebar}
};
</script>

<style>
.text-sm {
    font-size: .925rem!important;
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

.footable>thead>tr>th {
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.footable.breakpoint>tbody>tr.footable-detail-show>td {
  border-bottom: 0;
}

.footable.breakpoint>tbody>tr.footable-row-detail:hover {
  background-color: transparent;
}

.footable.breakpoint>tbody>tr:hover:not(.footable-row-detail) {
  cursor: pointer;
}

.footable.breakpoint>tbody>tr>.footable-cell-detail {
  background-color: #fafafa;
  border-top: 0;
}

.footable.breakpoint>tbody>tr .footable-toggle:before {
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

.footable.breakpoint>tbody>tr.footable-detail-show .footable-toggle:before {
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
</style>
