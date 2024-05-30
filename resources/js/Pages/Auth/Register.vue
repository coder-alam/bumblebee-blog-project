<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Register" />
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form @submit.prevent="submit">
          <div class="input-group mb-3">
            <input
              type="text"
              class="form-control"
              id="name"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <div v-show="form.errors.name">
              <p class="text-danger">
                {{ form.errors.name }}
              </p>
            </div>
          </div>
          <div class="input-group mb-3">
            <input
              class="form-control"
              id="email"
              type="email"
              v-model="form.email"
              required
              autocomplete="username"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <div v-show="form.errors.email">
              <p class="text-danger">
                {{ form.errors.email }}
              </p>
            </div>
          </div>
          <div class="input-group mb-3">
            <input
              class="form-control"
              id="password"
              type="password"
              v-model="form.password"
              required
              autocomplete="new-password"
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
          <div class="input-group mb-3">
            <input
              class="form-control"
              id="password_confirmation"
              type="password"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div v-show="form.errors.password_confirmation">
              <p class="text-danger">
                {{ form.errors.password_confirmation }}
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree" />
                <label for="agreeTerms"> I agree to the <a href="#">terms</a> </label>
              </div>
            </div>

            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>

        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>

        <Link :href="route('login')" class="text-center"> Already registered? </Link>
      </div>
    </div>
  </GuestLayout>
</template>
