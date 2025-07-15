<script setup>
import FullScreenLayout from '@/Layouts/FullScreenLayout.vue';
import { TextInput } from '@/Adminend/Components';
import { useAuth } from '@/Adminend/Composables';

const { form, logo, login } = useAuth();

defineOptions({ layout : FullScreenLayout });
</script>

<template>
    <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
      <div class="relative flex flex-col justify-center w-full h-screen lg:flex-row dark:bg-gray-900" >
        <div class="flex flex-col flex-1 w-full lg:w-1/2">
          <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
            <div>

                <div class="flex justify-center mb-10">
                    <img :src="logo" width="200" alt="">
                </div>

                <div class="mb-5 sm:mb-8">
                    <h1 class="mb-3 font-semibold text-gray-800 text-3xl dark:text-white/90 sm:text-4xl" > Sign In </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Enter your email and password to sign in!
                    </p>
                </div>

                <div>
                    <form @submit.prevent="login">
                        <div class="space-y-5">
                            <!-- Email -->
                            <text-input type="email" label="Email" placeholder="example@example.com" v-model="form.email" :error="form.errors.email"/>

                            <!-- Password -->
                            <text-input type="password" label="Password" placeholder="********" v-model="form.password" :error="form.errors.password"/>

                            <!-- Checkbox -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="rememberMe" class="flex items-center text-sm font-normal text-gray-700 cursor-pointer select-none dark:text-gray-400" >
                                        <div class="relative">

                                            <input v-model="form.remember_me" type="checkbox" id="rememberMe" class="sr-only" />

                                            <div :class="form.remember_me ? 'bg-brand-500 text-white border-brand-500' : 'border-gray-300 bg-transparent'" class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]" >
                                                <svg v-if="form.remember_me" width="14" height="14" viewBox="0 0 14 14" fill="none" class="text-white">
                                                    <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="orange" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>

                                        </div>

                                        Remember me
                                    </label>
                                </div>

                                <Link href="/register" class="text-sm text-brand-500 hover:text-brand-600 dark:text-blue-400" >
                                    Register
                                </Link >
                            </div>
                            <!-- Button -->

                            <div>
                                <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-md font-semibold text-white transition rounded-lg bg-orange-400 shadow-theme-xs hover:bg-orange-500">
                                    <span v-if="form.processing" class="flex items-center justify-center">
                                        <svg class="animate-spin me-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);"><path d="M2 11h5v2H2zm15 0h5v2h-5zm-6 6h2v5h-2zm0-15h2v5h-2zM4.222 5.636l1.414-1.414 3.536 3.536-1.414 1.414zm15.556 12.728-1.414 1.414-3.536-3.536 1.414-1.414zm-12.02-3.536 1.414 1.414-3.536 3.536-1.414-1.414zm7.07-7.071 3.536-3.535 1.414 1.415-3.536 3.535z"></path></svg>
                                        Loading...
                                    </span>

                                    <span v-else>Sign In</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
