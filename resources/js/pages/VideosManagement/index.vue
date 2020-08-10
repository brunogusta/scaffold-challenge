<template>
  <div class="container">
    <modal name="new-video" height="auto" @before-close="clearInputs" adaptive>
      <div class="container my-3 d-flex flex-column justify-content-center">
        <div class="alert alert-danger" v-if="errors.length">
          <ul class="mb-0">
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>
        <form v-on:submit.prevent="onSendNewVideo" class="w-100">
          <div class="form-group">
            <h1>Video name:</h1>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="name" />
            <h1 class="mt-2">Youtube URL:</h1>
            <input type="text" class="form-control" id="url" placeholder="URL" v-model="url" />
            <small id="emailHelp" class="form-text text-muted">Just copy youtube url and place here.</small>
          </div>
          <div class="d-flex">
            <button v-if="!loading" type="submit" class="btn btn-primary">Send</button>

            <button v-if="loading" class="btn btn-primary disabled">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Sending...
            </button>

            <button type="reset" @click="closeNewVideoModal" class="btn btn-secondary ml-2">Cancel</button>
          </div>
        </form>
      </div>
    </modal>
    <modal name="preview-video" height="auto" adaptive>
      <div class="card m-3">
        <video-embed :src="previewVideoUrl"></video-embed>
      </div>
    </modal>
    <modal name="update" height="auto" @before-close="clearInputs" adaptive>
      <div class="container my-3 d-flex flex-column justify-content-center">
        <div class="alert alert-danger" v-if="errors.length">
          <ul class="mb-0">
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>
        <form v-on:submit.prevent="onUpdateVideo" class="w-100">
          <div class="form-group">
            <h1>Video name:</h1>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="name" />
            <h1 class="mt-2">Youtube URL:</h1>
            <input type="text" class="form-control" id="url" placeholder="URL" v-model="url" />
            <small id="emailHelp" class="form-text text-muted">Just copy youtube url and place here.</small>
          </div>
          <div class="d-flex">
            <button v-if="!loading" type="submit" class="btn btn-primary">Send</button>

            <button v-if="loading" class="btn btn-primary disabled">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Sending...
            </button>

            <button
              @click="closeUpdateVideoModal"
              type="reset"
              class="btn btn-secondary ml-2"
            >Cancel</button>
          </div>
        </form>
      </div>
    </modal>

    <div class="mt-5">
      <h1>Videos Management</h1>
    </div>

    <button class="btn btn-success" @click="showNewVideoModal">New Video</button>
    <div class="card my-5 p-2">
      <div v-if="!videos.length" class="container p-5">
        <h1 class="text-muted text-center">No videos added...</h1>
      </div>
      <div class="container">
        <CardsWrapper>
          <div v-for="(video, index) in videos" :key="index" class="card">
            <ShowVideoButton @click="showVideo(video.url)">
              <img class="img-thumbnail" v-bind:src="video.thumbUrl" alt="Card image cap" />
            </ShowVideoButton>
            <div class="card-body">
              <h3 class="card-title text-left">{{ video.name }}</h3>

              <div class="d-flex mt-2">
                <button @click="showUpdateModal(video)" class="btn btn-info">Update</button>
                <button @click="deleteVideo(video.id)" class="btn btn-danger ml-2">Delete</button>
              </div>
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
  name: "VideosManagement",
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
    showNewVideoModal() {
      this.$modal.show("new-video");
    },
    closeNewVideoModal() {
      this.$modal.hide("new-video");
    },
    showVideo(url) {
      this.previewVideoUrl = url;
      this.$modal.show("preview-video");
    },
    onSendNewVideo() {
      this.errors = [];

      if (!this.errors.length) {
        this.loading = true;
        const video = {
          name: this.name,
          url: this.url,
        };

        this.app.req
          .post("videos", video)
          .then(({ data }) => {
            this.loading = false;
            this.fetchVideos();
            this.$modal.hide("new-video");
          })
          .catch((error) => {
            this.errors.push(error.response.data);
            this.loading = false;
          });
      }
    },
    fetchVideos() {
      this.app.req
        .get("videos")
        .then(({ data }) => {
          this.videos = data;
        })
        .catch((error) => {
          this.errors.push(error);
        });
    },
    deleteVideo(id) {
      this.app.req
        .delete(`videos/${id}`)
        .then(() => {
          this.fetchVideos();
        })
        .catch((error) => {
          this.errors.push(error);
        });
    },
    onUpdateVideo() {
      const data = {
        name: this.name,
        url: this.url,
      };

      this.app.req
        .put(`videos/${this.videoId}`, data)
        .then(({ data }) => {
          this.fetchVideos();
          this.$modal.hide("update");
        })
        .catch((error) => {
          this.errors.push(error.response.data);
        });
    },
    showUpdateModal(video) {
      this.name = video.name;
      this.url = video.url;
      this.videoId = video.id;

      this.$modal.show("update");
    },
    closeUpdateVideoModal() {
      this.$modal.hide("update");
    },
    clearInputs() {
      this.name = "";
      this.url = "";
      this.videoId = "";
      this.errors = "";
    },
  },
  mounted() {
    this.fetchVideos();
  },
};
</script>

