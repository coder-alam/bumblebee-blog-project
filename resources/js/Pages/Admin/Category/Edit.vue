<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, computed, defineProps, watch } from "vue";
const props = defineProps({
  errors: Object,
  flash: {
    success: String,
    failed: String,
  },
  category: {
    type: Object,
    required: true,
  },
});
const form = useForm({
  category_name: props.category.category_name,
  category_image: props.category.category_image,
});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);
const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};
const updateCategory = () => {
  form.post(route("category.update", props.category?.id), {
    preserveScroll: true,
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
watch(
  () => props.category,
  () => {
    (form.category_name = props.category?.category_name),
      (form.category_image = props.category?.category_image);
  }
  // () => {
  //     form.permissions = props.user?.permissions,
  //     form.roles = props.user?.roles
  // }
);

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
  <Head title="Category Edit" />
  <AdminLayout>
    <div class="content-header">
      <div class="container-fluid">
        <div class="mb-2 row">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
              <li class="breadcrumb-item active">Edit Category</li>
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
              Update Category
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
            <form @submit.prevent="updateCategory">
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
                  <img
                    v-else
                    style="height: 160px; width: 200px"
                    :src="'/storage/uploads/category/' + form.category_image"
                    alt=""
                    :title="form.category_image"
                    class="rounded p-2"
                  />
                </div>
              </div>

              <div class="form-group">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="btn btn-primary w-100"
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
