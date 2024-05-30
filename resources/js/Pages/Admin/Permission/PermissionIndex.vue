<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, Head, router, useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, computed, defineProps, watch } from "vue";

const props = defineProps({
  errors: Object,
  flash: {
    success: String,
    failed: String,
  },
  permissions: Object,
});

const form = useForm({
  permission_name: "",
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};
const createPermission = () => {
  form.post(route("permission.store"), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
    onSuccess: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
        form.reset();
        router.visit(route("permission.index"), {
          only: ["permissions"],
          preserveScroll: true,
        });
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        console.log("Something Went Wrong!");
      }
    },
  });
};
const deletePermission = (permission_id) => {
  form.get(route("permission.delete", permission_id), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
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
// Data Table Section
onMounted(() => {
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
});
</script>

<template>
  <Head title="Role" />
  <AdminLayout>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Permission Index</h4>
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
                <tr v-for="(permission, index) in permissions" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ permission.name }}</td>
                  <td>
                    <Link
                      :href="route('permission.edit', permission.id)"
                      as="button"
                      class="m-1 btn btn-outline-success"
                      >Edit</Link
                    >
                    <Link
                      @click="deletePermission(permission.id)"
                      as="button"
                      class="m-1 btn btn-outline-danger"
                      >Delete</Link
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
            <h4>Create New Permission</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="createPermission">
              <div class="form-group">
                <label for="inputPermissionName" class="col-form-label"
                  >Permission Name</label
                >
                <input
                  type="text"
                  v-model="form.permission_name"
                  id="inputPermissionName"
                  class="form-control"
                  placeholder="Name"
                />
                <div v-if="props.errors.permission_name" class="text-danger">
                  {{ props.errors.permission_name }}
                </div>
              </div>

              <div class="form-group d-flex justify-content-center">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="btn btn-primary btn-block"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
