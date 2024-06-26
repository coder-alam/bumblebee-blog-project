<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm, usePage, Link, router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, watch, computed } from "vue";
import VueMultiselect from "vue-multiselect";

const props = defineProps({
  total_users: Number,
  flash: {
    success: String,
    failed: String,
  },
  users: Object,
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
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  roles: [],
  permissions: [],
});
const submit = () => {
  form.post(route("user.store"), {
    onFinish: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
        form.reset();
        router.visit(route("user.index"), {
          only: ["users"],
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

const deleteUser = (user_id) => {
  form.get(route("user.delete", user_id), {
    preserveScroll: true,
    onSuccess: (resp) => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      }
    },
  });
};
// Data Table Section
onMounted(() => {
  let items = props?.users;
  $("#example2").DataTable({
    scrollY: items.length > 5 ? 400 : "",
    order: true,
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
  <Head title="Users" />
  <AdminLayout>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-light mt-3">
          <div class="card-header">
            <h4>
              User List
              <span class="float-right" v-if="total_users"
                >Total: {{ total_users }}
              </span>
            </h4>
          </div>
          <div class="card-body">
            <table id="example2" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <div>
                      <Link
                        :href="route('user.edit', user.id)"
                        as="button"
                        class="btn btn-outline-success m-1"
                        >Edit</Link
                      >
                      <Link
                        @click="deleteUser(user.id)"
                        class="btn btn-outline-danger m-1"
                        >Delete</Link
                      >
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-light mt-3">
          <div class="card-header">
            <h4>Create New User</h4>
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
                <label for="passwordn" class="col-form-label">Password</label>
                <input
                  class="form-control"
                  id="password"
                  type="password"
                  v-model="form.password"
                  placeholder="User Password"
                />
                <div v-show="form.errors.password">
                  <p class="text-danger">
                    {{ form.errors.password }}
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label for="password_confirmation" class="col-form-label"
                  >Confirmation Password</label
                >
                <input
                  class="form-control"
                  id="password_confirmation"
                  type="password"
                  v-model="form.password_confirmation"
                />
                <div v-show="form.errors.password_confirmation">
                  <p class="text-danger">
                    {{ form.errors.password_confirmation }}
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
              <div class="form-group">
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
