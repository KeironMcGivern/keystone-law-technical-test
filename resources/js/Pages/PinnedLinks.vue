<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const links = ref([]);
const checked = ref([]);
const loading = ref([]);

// Api to get links form database
const getLinks = (tags) => {
  axios.get(route('api.getLinks', {tags: tags}))
    .then((res) => {
      links.value = res.data;
      loading.value = false;
    })
    .catch(error => console.log(error))
}

// We set up a watcher for the checked ref where we will be storing the tags the user clicks
// once the change is noticed we set the loading ref to true again and send the axios request to get
// the new links
watch(checked, async (newChecked) => {
  loading.value = true
  getLinks(newChecked);
})

// When the page is first hit we set the loading ref to true as to show the user that an action is
// taking place, once the axios request has completed we inset the response data to the links ref
// and display the data for the user
onMounted(() => {
  loading.value = true;
  getLinks();
})

defineProps({ tags: Object })

</script>

<template>
    <div class="container mx-auto my-auto pt-8 ">

      <!-- Show the loading warning if the loading ref is set to true -->
      <!-- Otherwise show the form and all the link data -->
      <div v-if="loading">
        <p>Loading...</p>
      </div>
      <div v-else>

        <div class="flex flex-row bg-white rounded justify-center">
          <!-- Iterates over the array that holds all the tag information that was passed from the -->
          <!-- controller and displays them as checkboxes -->
          <div class="pr-2" v-for="tag in tags" :key="tag.value">
            <label class="font-bold pr-2">{{tag.label}}</label>
            <input type="checkbox" v-model="checked" :value="tag.value" />
          </div>
        </div>

        <div class="pt-4">
          <div class="font-bold text-xl">Links:</div>
          <!-- Iterates over the links that are passed from all the axios requests -->

          <div id="pinned_links_list">
            <div class="flex flex-col py-2" v-for="link in links" :key="link.id">
                <div class="text-xl"> - <a :href="link.url">{{ link.title }}</a></div>
                <div class="text-sm font-thin">Comments: {{ link.comments }}</div>
            </div>
          </div>
        </div>

      </div>
    </div>
</template>
