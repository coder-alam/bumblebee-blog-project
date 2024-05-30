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
  permission: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  permission_name: props.permission.name,
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};
watch(() => {
  () => props.permission, () => (form.permission_name = props.permission?.name);
});
const updatePermission = () => {
  form.post(route("permission.update", props.permission?.id), {
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
</script>

<template>
  <Head title="Update permission" />
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
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-4">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Updated Permission</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="updatePermission">
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

              <div class="form-group d-flex">
                <Link
                  :href="route('permission.index')"
                  :disabled="form.processing"
                  class="btn btn-secondary mr-1 w-100"
                >
                  Go Back
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="btn btn-primary ml-1 w-100"
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
