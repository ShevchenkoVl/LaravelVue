<template lang="">
    <div>
        <div class="w-25 mt-3">
            <input v-model="title" type="text" class="form-control mb-3" paceholder="title">
            <div ref="dropzone" class="btn btn-dark d-block p-5 mb-3" value="Upload">
                Upload
            </div>
            <vue-editor v-model="content"
            useCustomImageHandler
            @imageAdded="handleImageAdded">
            </vue-editor>
            <input @click.prevent="store" type="submit" class="btn btn-primary mt-3" value="add">
        </div>
    </div>
</template>
<script>
import Dropzone from 'dropzone';
import { VueEditor } from 'vue3-editor';
export default {
    name: "Create",
    components: { VueEditor },
    data() {
        return {
            dropzone: null,
            content: "",
            title: '',
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: "111",
            autoProcessQueue: false,
            addRemoveLinks: true,
        })
    },

    methods: {
        store() {
            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                data.append('images[]', file)
            })
            data.append('title', this.title)
            data.append('content', this.content)
            axios.post('/api/posts', data)
                .then(res => {
                    files.forEach(file => {
                        this.dropzone.removeFile(file)
                    })
                    this.title = ''
                    this.content = ''
                }
                )
        },

        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            // An example of using FormData
            // NOTE: Your key could be different such as:
            // formData.append('file', file)

            var formData = new FormData();
            formData.append("image", file);

            axios.post('/api/posts/images', formData)
                .then(result => {
                    const url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });

        },
    }
}
</script>
<style>
.dz-success-mark,
.dz-error-mark{
    display: none;
}
</style>