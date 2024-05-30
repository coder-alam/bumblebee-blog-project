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

  tags: Object,
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

const createTag = (event) => {
  form.post(route("tag.store"), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
    onFinish: (visit) => {
      if (usePage().props.flash.success) {
        router.visit(route("tag.index"), {
          only: ["tags"],
          preserveScroll: true,
        });
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

// watch(() => props.tags);
// const categoryDelete = (category_id) => {
//   form.get(route("category.delete", category_id), {
//     preserveScroll: true,
//     onSuccess: () => {
//       if (usePage().props.flash.success) {
//         toast.success(flashSuccess, options);
//       } else if (usePage().props.flash.failed) {
//         toast.error(flashFailed, options);
//       } else {
//         toast.error("Something Went Wrong!", options);
//       }
//     },
//   });
// };

// Data Table Section
onMounted(() => {
  let items = props?.tags;
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

watch(() => props?.tags);
</script>

<template>
  <Head title="Tag" />
  <AdminLayout>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Tag List</h4>
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
                <tr v-for="(tag, index) in tags" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ tag.tag_name }}</td>
                  <td>
                    <Link href="" as="button" class="m-1 btn btn-outline-info">Edit</Link>
                    <Link href="" as="button" class="m-1 btn btn-outline-danger"
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
            <h4>Create New Tag</h4>
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
