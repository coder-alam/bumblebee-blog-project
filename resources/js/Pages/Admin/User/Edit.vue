<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm, usePage, Link, router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, watch, computed } from "vue";
import VueMultiselect from "vue-multiselect";
const props = defineProps({
  flash: {
    success: String,
    failed: String,
  },
  user: Object,
  roles: Array,
  permissions: Array,
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};
const form = useForm({
  name: props.user.name,
  email: props.user.email,
  roles: [],
  permissions: [],
});
const submit = () => {
  form.post(route("user.update", props.user.id), {
    onFinish: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
        form.reset();
        router.visit(route("user.update", props.user.id), {
          method: "post",
          only: ["user"],
          preserveScroll: true,
        });
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        console.log("Something went wrong!");
      }
    },
  });
};
const deleteUserRole = ([user_id, role_id]) => {
  form.delete(route("user.role.destroy", [user_id, role_id]), {
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
const deleteUserPermission = ([user_id, permission_id]) => {
  form.delete(route("user.permission.destroy", [user_id, permission_id]), {
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
  let role = props?.roles;
  $("#example1").DataTable({
    scrollY: role.length > 5 ? 400 : "",
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
  let permission = props?.permissions;
  $("#example2").DataTable({
    scrollY: permission.length > 5 ? 400 : "",
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

  form.permissions = props.user?.permissions;
  form.roles = props.user?.roles;
});

watch(
  () => props.user,
  () => ((form.permissions = props.user?.permissions), (form.roles = props.user?.roles))
);
</script>
<template>
  <AdminLayout>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Role</h4>
          </div>
          <div class="card-body">
            <!-- </DataTable> -->
            <table id="example1" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(userRole, index) in user.roles" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>
                    {{ userRole.name }} :

                    <span
                      v-for="(userPermission, index) in user.permissions"
                      :key="index"
                      class="badge bg-success m-1"
                    >
                      {{ userPermission.name }}
                    </span>
                  </td>
                  <td>
                    <Link
                      @click="deleteUserRole([user.id, userRole.id])"
                      as="button"
                      class="m-1 btn btn-outline-danger"
                      preserve-scroll
                      >Revoke</Link
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-4 card card-light">
          <div class="card-header">
            <h4>Permission</h4>
          </div>
          <div class="card-body">
            <!-- </DataTable> -->
            <table id="example2" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(userPermission, index) in user.permissions" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ userPermission.name }}</td>
                  <td>
                    <Link
                      @click="deleteUserPermission([user.id, userPermission.id])"
                      as="button"
                      class="m-1 btn btn-outline-danger"
                      preserve-scroll
                      >Revoke</Link
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card card-light mt-3">
          <div class="card-header">
            <h4>Update User</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-group">
                <label for="email" class="col-form-label">User Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  v-model="form.name"
                  placeholder="User Name"
                />
                <div v-show="form.errors.name">
                  <p class="text-danger">
                    {{ form.errors.name }}
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-form-label">User Email</label>
                <input
                  class="form-control"
                  id="email"
                  type="email"
                  v-model="form.email"
                  placeholder="User Email"
                />
                <div v-show="form.errors.email">
                  <p class="text-danger">
                    {{ form.errors.email }}
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label for="role" class="col-form-label">Select Role</label>
                <VueMultiselect
                  v-model="form.roles"
                  :options="roles"
                  :multiple="true"
                  :close-on-select="true"
                  placeholder="Pick some"
                  label="name"
                  track-by="id"
                />
              </div>
              <div class="form-group">
                <label for="permission" class="col-form-label">Select Permission</label>
                <VueMultiselect
                  v-model="form.permissions"
                  :options="permissions"
                  :multiple="true"
                  :close-on-select="true"
                  placeholder="Pick some"
                  label="name"
                  track-by="id"
                />
              </div>

              <div class="form-group d-flex">
                <Link
                  :href="route('user.index')"
                  :disabled="form.processing"
                  class="btn btn-secondary w-100 mx-1"
                >
                  Go Back
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="btn btn-primary w-100 mx-1"
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
