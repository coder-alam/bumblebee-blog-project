<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, Head, router, useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, computed, defineProps, watch } from "vue";
import VueMultiselect from "vue-multiselect";
const props = defineProps({
  errors: Object,
  flash: {
    success: String,
    failed: String,
  },
  role: {
    type: Object,
    required: true,
  },
  permissions: Array,
});

const form = useForm({
  role_name: props.role.name,
  permissions: [],
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};

const updateRole = () => {
  form.post(route("role.update", props.role.id), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
    onSuccess: () => {
      //   form.reset();
      if (usePage().props.flash.success) {
        router.visit(route("role.edit", props.role.id), {
          only: {
            role: true,
            permissions: true,
          },
          preserveScroll: true,
        });
        toast.success(flashSuccess, options);
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        toast.error("Something Went Wrong!", options);
      }
    },
  });
};
const deletePermission = ([role_id, permission_id]) => {
  form.delete(route("role.permission.destroy", [role_id, permission_id]), {
    preserveScroll: true,
    onSuccess: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        toast.error("Something Went Wrong!", options);
      }
    },
  });
};

onMounted(() => {
  // Data Table Section
  let items = props?.permissions;
  $("#example2").DataTable({
    scrollY: items.length > 5 ? 400 : "",
    order: false,
    paging: true,
    searching: true,
    lengthChange: true,
    // lengthMenu: [5, 10, 20, 50],
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
  });
  $(".dataTables_length").addClass("bs-select");

  form.permissions = props.role?.permissions;
});
watch(
  () => props.role,
  () => (form.permissions = props.role?.permissions)
);
</script>

<template>
  <Head title="Update role" />
  <AdminLayout>
    <div class="content-header">
      <div class="container-fluid">
        <div class="mb-2 row">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
              <li class="breadcrumb-item active">Edit Category</li> -->
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Role with permission</h4>
          </div>
          <div class="card-body">
            <table id="example2" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(rolePermission, index) in role.permissions" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ rolePermission.name }}</td>
                  <td>
                    <Link
                      @click="deletePermission([role.id, rolePermission.id])"
                      as="button"
                      class="m-1 btn btn-outline-danger"
                      preserveScroll
                      >Revoke</Link
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- </DataTable> -->
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Updated Role</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="updateRole">
              <div class="form-group">
                <label for="inputRoleName" class="col-form-label">Role Name</label>
                <input
                  type="text"
                  v-model="form.role_name"
                  id="inputRoleName"
                  class="form-control"
                  placeholder="Name"
                />
                <div v-if="props.errors.role_name" class="text-danger">
                  {{ props.errors.role_name }}
                </div>
              </div>
              <div class="form-group">
                <label for="inputPermissionName" class="col-form-label"
                  >Permissions</label
                >
                <VueMultiselect
                  v-model="form.permissions"
                  :options="permissions"
                  :multiple="true"
                  :close-on-select="true"
                  placeholder="Pick some"
                  label="name"
                  track-by="id"
                />
                <!-- <div v-if="props.errors.permissions" class="text-danger">
                  {{ props.errors.permissions }}
                </div> -->
              </div>

              <div class="form-group d-flex">
                <Link
                  :href="route('role.index')"
                  :disabled="form.processing"
                  class="btn btn-secondary mx-1 w-100"
                >
                  Go Back
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="btn btn-primary mx-1 w-100"
                >
                  Update
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
