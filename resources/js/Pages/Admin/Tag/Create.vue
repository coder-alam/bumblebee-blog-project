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
});
const form = useForm({
  tag_name: "",
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);
const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};
const createTag = () => {
  form.post(route("tag.store"), {
    preserveScroll: true,
    onSuccess: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
        form.reset();
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
  <Head title="Create Category" />
  <AdminLayout>
    <div class="content-header">
      <div class="container-fluid">
        <div class="mb-2 row">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item">
                <a href="">Tag</a>
              </li>
              <li class="breadcrumb-item active">Create Tag</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-4">
        <div class="card card-light">
          <div class="card-header">
            <h4>
              Create New Tag
              <Link
                :href="route('tag.index')"
                class="btn btn-secondary float-right"
                as="button"
              >
                Go Back
              </Link>
            </h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="createTag()">
              <div class="form-group">
                <label for="inputName" class="col-form-label">Tag Name</label>
                <input
                  type="text"
                  v-model="form.tag_name"
                  id="inputName"
                  class="form-control"
                  placeholder="Name"
                />
                <div v-if="props.errors.tag_name" class="text-danger">
                  {{ props.errors.tag_name }}
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
