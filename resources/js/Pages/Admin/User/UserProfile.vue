<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, onMounted, computed } from "vue";
const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  errors: Object,
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

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  old_password: null,
  new_password: null,
});
const submit = () => {
  form.post(`/users/update/${props.user?.id}`, {
    preserveScroll: true,
    onSuccess: (resp) => {
      if (usePage().props.flash.success) {
        toast.success(flashSuccess, options);
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        console.log("Something Went Wrong!");
      }
    },
  });
};

const form2 = useForm({
  avatar: null,
});

const submitImg = () => {
  form2.post("/profile/photo", {
    preserveScroll: true,
    onSuccess: (response) => {
      if (usePage().props.flash.success) {
        form2.defaults("avatar");
        toast.success(flashSuccess, options);
      } else if (usePage().props.flash.failed) {
        toast.error(flashFailed, options);
      } else {
        console.log("Something Went Wrong!");
      }
    },
  });
};
</script>

<template>
  <Head title="Profile" />
  <AdminLayout>
    <div class="content-header">
      <div class="container-fluid">
        <div class="mb-2 row">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User</li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <!-- Profile Image -->
        <div class="mt-3 card card-light">
          <div class="card-body box-profile">
            <div class="text-center">
              <img
                v-if="$page.props.auth.user.photo == null"
                class="profile-user-img img-fluid img-circle"
                :src="'/dashboard_backend/dist/img/default-150x150.png'"
                alt="User profile picture"
              />
              <img
                v-else
                class="profile-user-img img-fluid img-circle"
                :src="'/storage/uploads/user/' + $page.props.auth.user.photo"
                alt="User profile picture"
              />
            </div>
            <h3 class="text-center profile-username">{{ $page.props.auth.user.name }}</h3>
            <p class="text-center text-muted">{{ $page.props.auth.user.email }}</p>
            <div class="mt-2 card">
              <div class="card-header">
                <h4>Profile Photo Update</h4>
              </div>
              <div class="card-body">
                <form @submit.prevent="submitImg">
                  <div class="form-group">
                    <label for="inputImg" class="col-form-label">Photo Upload</label>
                    <input
                      type="file"
                      @input="form2.avatar = $event.target.files[0]"
                      id="inputImg"
                      class="form-control"
                    />
                    <div v-if="props.errors.avatar" class="text-danger">
                      {{ props.errors.avatar }}
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="mt-3 card card-light">
          <div class="card-header">
            <h4>Profile Update</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-group">
                <label for="inputName" class="col-form-label">Name</label>
                <input
                  type="text"
                  v-model="form.name"
                  id="inputName"
                  class="form-control"
                  placeholder="Name"
                />
                <div v-if="props.errors.name" class="text-danger">
                  {{ props.errors.name }}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-form-label">Email</label>
                <input
                  type="email"
                  v-model="form.email"
                  id="inputEmail"
                  class="form-control"
                  placeholder="Email"
                />
                <div v-if="props.errors.email" class="text-danger">
                  {{ props.errors.email }}
                </div>
              </div>
              <div class="form-group">
                <label for="inputOldPassword" class="col-form-label">Old Password</label>
                <input
                  type="password"
                  v-model="form.old_password"
                  id="inputOldPassword"
                  class="form-control"
                  placeholder="Old Password"
                />
                <div v-if="props.errors.old_password" class="text-danger">
                  {{ props.errors.old_password }}
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-form-label">New Password</label>
                <input
                  type="password"
                  v-model="form.new_password"
                  id="inputPassword"
                  class="form-control"
                  placeholder="New Password"
                />
                <div v-if="props.errors.new_password" class="text-danger">
                  {{ props.errors.new_password }}
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
