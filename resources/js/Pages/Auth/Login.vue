<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />
    <div v-if="status" class="mb-4 font-medium text-sm text-success">
      {{ status }}
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form @submit.prevent="submit">
          <div class="input-group mb-3">
            <input
              class="form-control"
              placeholder="Email"
              type="email"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <br />
            <div v-show="form.errors.email">
              <p class="text-danger">
                {{ form.errors.email }}
              </p>
            </div>
          </div>

          <div class="input-group mb-3">
            <input
              type="password"
              class="form-control"
              v-model="form.password"
              required
              autocomplete="current-password"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div v-show="form.errors.password">
              <p class="text-danger">
                {{ form.errors.password }}
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" v-model="form.remember" />
                <label for="remember"> Remember Me </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="btn btn-primary btn-block"
              >
                Log in
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center mb-3">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a v-if="canResetPassword" :href="route('password.request')"
            >I forgot my password</a
          >
        </p>
        <p class="mb-0">
          <Link href="/register" class="text-center">Register a new membership</Link>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </GuestLayout>
  <!-- <GuestLayout>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Forgot your password?
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout> -->
</template>
