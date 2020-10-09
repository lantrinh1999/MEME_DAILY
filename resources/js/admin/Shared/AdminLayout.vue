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
.btn {
    padding: 0.5rem .75rem;
}
.btn-outline-dark {
    border-color: #ced4da;
}
.dropdown-item {
    cursor: pointer;
}
</style>
