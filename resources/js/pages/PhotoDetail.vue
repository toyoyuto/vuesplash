<template>
  <div
    v-if="photo"
    class="photo-detail"
    :class="{ 'photo-detail--column': fullWidth }"
  >
    <figure
      class="photo-detail__pane photo-detail__image"
      @click="hideForm"
    >
      <img :src="photo.url" alt="">
      <figcaption>Posted by {{ photo.owner.name }}</figcaption>
    </figure>
    <div class="photo-detail__pane">
      <button class="button button--like" title="Like photo" >
        <i class="icon ion-md-heart"></i>12
      </button>
      <a
        :href="`/photos/${photo.id}/download`"
        class="button"
        title="Download photo"
      >
        <i class="icon ion-md-arrow-round-down"></i>Download
      </a>
      <h2 class="photo-detail__title">
        <i class="icon ion-md-chatboxes"></i>Comments
      </h2>
    </div>
  </div>
</template>

<script>
import { OK } from '../util'
export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      photo: null,
      fullWidth: false
    }
  },
  methods: {
    async fetchPhoto () {
      console.log('response')
      const response = await axios.get(`/api/photos/${this.id}`)
      console.log(response)
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      console.log(response.data)
      this.photo = response.data
    },
    hideForm() {
      console.log('ssss')
        this.fullWidth = ! this.fullWidth
    }
  },
  watch: {
    $route: {
      async handler () {
        console.log('3')
        await this.fetchPhoto()
      },
      immediate: true
    }
  }
}
</script>