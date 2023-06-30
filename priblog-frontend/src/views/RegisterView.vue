<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">Enter your email</h1>
    <form action="#" @submit.prevent="handleRegister">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <input type="text" v-model="credentials.name" name="name" id="name" placeholder="Test name"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:outline-none">
          </div>
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
          <button type="submit" @submit.prevent="handleRegister"
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
import {reactive} from 'vue'
import axios from 'axios'
import {useRouter} from 'vue-router';

const router = useRouter()
const credentials = reactive({
  name: null,
  email: null,
  password: null,
})
const getFormattedCredentials = () => {
  return {
    email: credentials.email,
    name: credentials.name,
    password: credentials.password
  }
}

const handleRegister = () => {
  axios.post('http://localhost:8000/api/auth/register', getFormattedCredentials())
      .then((response) => {
        console.log(response.data)
      })
      .catch((error) => {
        console.error(error)
        alert(error.response.data.message)
      })
      .then((response) => {
        console.log(response);
        router.push({
          name: 'login'
        })
      })
}
</script>