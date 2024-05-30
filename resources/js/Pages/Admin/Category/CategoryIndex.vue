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
  categories: Object,
});
const form = useForm({});
let flashSuccess = computed(() => usePage().props.flash.success);
let flashFailed = computed(() => usePage().props.flash.failed);

const options = {
  position: toast.POSITION.TOP_CENTER,
  theme: "colored",
};

const categoryDelete = (category_id) => {
  form.get(route("category.delete", category_id), {
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
// Data Table Section
onMounted(() => {
  let items = props?.categories;
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

watch(() => props?.categories);
</script>

<template>
  <Head title="Category" />
  <AdminLayout>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>
              Category List
              <Link
                :href="route('category.create')"
                class="float-right btn btn-secondary"
                as="button"
                >New Category</Link
              >
            </h4>
          </div>
          <div class="card-body">
            <!-- <DataTable class="display" width="100%" :options="options_dt"> -->
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
                <tr v-for="(category, index) in categories" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ category.category_name }}</td>

                  <td>
                    <img
                      style="height: 50px; width: 70px"
                      :src="'/storage/uploads/category/' + category.category_image"
                      class="rounded"
                      alt="Category Image"
                    />
                  </td>
                  <td>
                    <Link
                      :href="route('category.edit', category.id)"
                      as="button"
                      class="btn btn-outline-info"
                      >Edit</Link
                    >
                    <Link
                      @click="categoryDelete(category.id)"
                      as="button"
                      class="ml-2 btn btn-outline-danger"
                    >
                      Delete
                    </Link>
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
