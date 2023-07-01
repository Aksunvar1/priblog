<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">PriBlog</h1>
    <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
      <div class="bg-white px-4 py-5 sm:p-6">
        <div class="flex justify-between" v-if="blog">
          <h1>
            Title: {{ blog.title }}
          </h1>
          <p>
            Content: {{ blog.content }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {useRouter} from 'vue-router'
import {onMounted, ref} from "vue";
import http from "@/helpers/http";

let blog = ref(null)
let comments = ref(null)
onMounted(() => {
  fetchBlog()
  fetchComments()
})

const fetchBlog = () => {
  const url = window.location.href;
  const blogId = url.split("/").pop();
  return http().get('/api/blogs/' + blogId)
      .then((response) => {
        console.log(response.data)
        blog.value = response.data.data
      })
      .catch((error) => {
        console.error(error)
      })
}

const fetchComments = () => {
  const url = window.location.href;
  const blogId = url.split("/").pop();
  return http().get('/api/comments/' + '?blog_id=' + blogId)
      .then((response) => {
        console.log(response.data)
        comments.value = response.data.data
      })
      .catch((error) => {
        console.error(error)
      })
}
const router = useRouter()
</script>