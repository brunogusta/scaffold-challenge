<template>
  <div class="container">
    <modal name="preview-video" height="auto">
      <div class="card m-3">
        <video-embed :src="previewVideoUrl"></video-embed>
      </div>
    </modal>

    <div class="container p-2">
      <div class="mt-3">
        <h1 class="display-3">Let's get started...</h1>
        <h3 class="text-muted">Click in some video to play!</h3>
      </div>
      <div class="card my-3">
        <div v-if="!videos.length" class="container">
          <h1 class="text-muted mt-5 text-center">No videos added...</h1>
        </div>
        <CardsWrapper>
          <div v-for="(video, index) in videos" :key="index" class="card">
            <ShowVideoButton @click="showVideo(video.url)">
              <img class="img-thumbnail" v-bind:src="video.thumbUrl" alt="Card image cap" />
            </ShowVideoButton>
            <div class="card-body">
              <h3 class="card-title text-left text-center">{{ video.name }}</h3>
            </div>
          </div>
        </CardsWrapper>
      </div>
    </div>
  </div>
</template>

<script>
import { CardsWrapper, ShowVideoButton } from "./styles";

export default {
  name: "Videos",
  props: ["app"],
  components: {
    CardsWrapper,
    ShowVideoButton,
  },
  data() {
    return {
      videos: [],
      videoId: "",
      name: "",
      url: "",
      previewVideoUrl: "",
      loading: false,
      errors: [],
    };
  },
  methods: {
    showVideo(url) {
      this.previewVideoUrl = url;
      this.$modal.show("preview-video");
    },
    fetchVideos() {
      this.app.req
        .get("videos/watch")
        .then(({ data }) => {
          console.log(data);
          this.videos = data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
  },
  mounted() {
    this.fetchVideos();
  },
};
</script>

