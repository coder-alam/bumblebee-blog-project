<script setup>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
</script>

<template>
  <div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a :href="route('admin.dashboard')" class="brand-link">
        <img
          :src="'/dashboard_assets/dist/img/AdminLTELogo.png'"
          alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
          <div class="image">
            <img
              v-if="$page.props.auth.user.photo == null"
              :src="'/dashboard_assets/dist/img/default-150x150.png'"
              class="img-circle elevation-2"
              alt="User Image"
            />
            <img
              v-else
              :src="'/storage/uploads/user/' + $page.props.auth.user.photo"
              class="img-circle elevation-2"
              alt="User Image"
            />
          </div>
          <div class="info">
            <a href="#" class="d-block"> {{ $page.props.auth.user.name }}</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input
              class="form-control form-control-sidebar"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a :href="route('admin.dashboard')" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a :href="route('user.profile.index')" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>Profile</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Category
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <Link href="/category" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add New Category</p>
                  </Link>
                </li>
                <li class="nav-item">
                  <Link :href="route('user.profile.index')" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Profile</p>
                  </Link>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  </div>
</template>
