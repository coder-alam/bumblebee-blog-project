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
  roles: Object,
});

const form = useForm({
  role_name: "",
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};

const createRole = () => {
  form.post(route("role.store"), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
    onFinish: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
        form.reset();
        router.visit(route("role.index"), {
          only: ["roles"],
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
const deleteRole = (role_id) => {
  form.get(route("role.delete", role_id), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
    onSuccess: () => {
      //   form.reset();
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
  let items = props?.roles;
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
            <h4>Role Index</h4>
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
                <tr v-for="(role, index) in roles" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ role.name }}</td>
                  <td>
                    <Link
                      :href="route('role.edit', role.id)"
                      as="button"
                      class="m-1 btn btn-outline-success"
                      >Edit</Link
                    >
                    <Link
                      @click="deleteRole(role.id)"
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
            <h4>Create New Role</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="createRole">
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
