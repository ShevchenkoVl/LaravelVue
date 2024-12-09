<template lang="">
    <div>
        <div class="w-25 mt-3">
            <input v-model="title" type="text" class="form-control mb-3" paceholder="title">
            <div ref="dropzone" class="btn btn-dark d-block p-5 mb-3">
                Upload
            </div>
            <vue-editor v-model="content"
            useCustomImageHandler
            @imageRemoved="handleImageRemoved"
            @imageAdded="handleImageAdded">
            </vue-editor>
            <input @click.prevent="update" type="submit" class="btn btn-primary mt-3" value="update">
        </div>
    </div>
</template>
<script>
import Dropzone from 'dropzone';
import { VueEditor } from 'vue3-editor';
export default {
    name: "Update",
    components: { VueEditor },
    data() {
        return {
            dropzone: null,
            content: "",
            title: '',
            imageIdsForDelete: [],
            imageUrlsForDelete: [],
        }
    },
    mounted() {
        this.getPost()
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: "111",
            autoProcessQueue: false,
            addRemoveLinks: true,
        })
        this.dropzone.on('removedfile', (file) => {
            this.imageIdsForDelete.push(file.id)
        })
    },

    methods: {
        getPost() {
            axios.get('/api/posts/' + this.$route.params.id)
                .then(res => {
                    this.post = res.data.data;

                    this.content = res.data.data.content;
                    this.title = res.data.data.title;

                    this.post.images.forEach(image => {
                        let file = { id: image.id, name: image.name, size: image.size };
                        this.dropzone.displayExistingFile(file, image.url);
                    })

                })
                .catch(err => {
                    console.log(err.responce)
                })
        },
        update() {
            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                data.append('images[]', file)
            })

            this.imageIdsForDelete.forEach(idForDelete => {
                data.append('image_ids_for_delete[]', idForDelete)
            })

            this.imageUrlsForDelete.forEach(urlForDelete => {
                data.append('image_urls_for_delete[]', urlForDelete)
            })

            data.append('title', this.title)
            data.append('content', this.content)

            data.append('_method', 'PATCH')

            axios.post(`/api/posts/${this.post.id}`, data)
                .then(res => {
                    files.forEach(file => {
                        this.dropzone.removeFile(file)
                    })
                    this.$router.push({ name: 'show.post', params: { id: this.post.id } })
                }
                )
        },

        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            // An example of using FormData
            // NOTE: Your key could be different such as:
            // formData.append('file', file)

            var formData = new FormData();
            formData.append("image", file);

            axios.post(`/api/posts/images/${this.post.id}`, formData)
                .then(result => {
                    const url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });

        },

        handleImageRemoved(url) {
            this.imageUrlsForDelete.push(url)
        },
    }
}
</script>
<style>
.dz-success-mark,
.dz-error-mark {
    display: none;
}
</style>