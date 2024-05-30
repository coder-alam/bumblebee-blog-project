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
  category_name: "",
  category_image: "",
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);
const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};
const addCategory = () => {
  form.post(route("category.store"), {
    preserveScroll: true,
    onSuccess: () => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
        form.reset();
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        console.log("Something Went Wrong!");
      }
    },
  });
};

const previewImage = ref(null);

const handleImageUpload = async (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = (event) => {
    previewImage.value = event.target.result;
  };
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
                <a href="">Category</a>
              </li>
              <li class="breadcrumb-item active">Create Category</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card card-light">
          <div class="card-header">
            <h4>
              Create New Category
              <Link
                :href="route('category.index')"
                class="btn btn-secondary float-right"
                as="button"
              >
                Go Back
              </Link>
            </h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="addCategory()">
              <div class="form-group">
                <label for="inputName" class="col-form-label">Category Name</label>
                <input
                  type="text"
                  v-model="form.category_name"
                  id="inputName"
                  class="form-control"
                  placeholder="Name"
                />
                <div v-if="props.errors.category_name" class="text-danger">
                  {{ props.errors.category_name }}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-form-label">Category Image</label>
                <input
                  type="file"
                  @input="form.category_image = $event.target.files[0]"
                  id="inputEmail"
                  class="form-control"
                  placeholder="Email"
                  @change="handleImageUpload"
                />

                <div v-if="props.errors.category_image" class="text-danger">
                  {{ props.errors.category_image }}
                </div>

                <div class="mt-2">
                  <img
                    v-if="previewImage"
                    :src="previewImage"
                    style="height: 160px; width: 200px"
                    alt="Uploaded Image"
                  />
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
