<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">Enter your email</h1>
    <form action="#" @submit.prevent="handleLogin">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <input type="text" v-model="credentials.email" name="email" id="email" placeholder="test@example.com"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:outline-none">
          </div>
          <div>
            <input type="password" v-model="credentials.password" name="password" id="password" placeholder="password"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:outline-none">
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
          <button type="submit" @submit.prevent="handleLogin"
                  class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none">
            Continue
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<style>
</style>
<script setup>
import {onMounted, reactive} from 'vue'
import axios from 'axios'
import {useRouter} from 'vue-router';

const router = useRouter()
const credentials = reactive({
  name: null,
  email: null,
  password: null,
})

onMounted(() => {
  if (localStorage.getItem('token')) {
    router.push({
      name: 'blogs.index'
    })
  }
})
const getFormattedCredentials = () => {
  return {
    email: credentials.email,
    name: credentials.name,
    password: credentials.password
  }
}

const handleLogin = () => {
  axios.post('http://localhost:8000/api/auth/login', getFormattedCredentials())
      .then((response) => {
        console.log(response);
        localStorage.setItem('token', response.data.access_token)
        router.push({
          name: 'blogs.index'
        })
      })
      .catch((error) => {
        console.error(error)
        alert(error.response.data.message)
      })
}
</script>