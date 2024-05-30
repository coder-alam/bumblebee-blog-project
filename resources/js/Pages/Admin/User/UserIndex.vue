<script setup>
import AdminLayout from "./../../../Layouts/AdminLayout.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, watch, computed } from "vue";
const emit = defineEmits(["customevent"]);
const props = defineProps({
  users: Object,
  total_users: Number,
  flash: {
    success: String,
    failed: String,
  },
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};

const form = useForm({});
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
</script>
<template>
  <Head title="Users" />
  <AdminLayout>
    <div class="row">
      <div class="m-auto col-md-8">
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
            <table class="table table-striped table-hover table-responsive-lg">
              <thead>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <div>
                      <Link @click="deleteUser(user.id)" class="btn btn-sm btn-danger"
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
    </div>
  </AdminLayout>
</template>
