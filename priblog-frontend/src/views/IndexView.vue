<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">PriBlog</h1>
    <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
      <div class="bg-white px-4 py-5 sm:p-6">
        <div class="flex justify-between">
          <ul>
            <li v-for="blog in blogs" v-bind:key="blog.id">
              <a v-bind:href="'localhost:8000/api/blogs/'+ blog.id">
                {{ blog.title }}
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {useRouter} from 'vue-router'
import {onMounted, ref} from "vue";
import http from "@/helpers/http";

let blogs = null
onMounted(() => {
  fetchBlogs()
})

const fetchBlogs = () => {
  return http().get('/api/blogs')
      .then((response) => {
        console.log(response.data)
        blogs = response.data.data
      })
      .catch((error) => {
        console.error(error)
      })
}
const items = ref(blogs)
const router = useRouter()
</script>