<template lang="">
    <div>
        <div v-if="post" >
            <h4 class="d-inline">{{ post.title }}</h4>
                <input @click.prevent="update(post.id)" type="submit" class="btn btn-primary" value="Update">
                <input @click.prevent="deletePost(post.id)" type="submit" class="btn btn-danger" value="Delete">
            <div v-for="image in post.images" class="mb-3">
                <img :src="image.preview_url" alt="preview_Image" class="mb-3">
                <div class="mb-3"><img :src="image.url" alt="Image"></div>
            </div>
            <div v-html="post.content" class="ql-editor"></div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            post: null,
        }
    },
    name: "Show",
    mounted() {
        this.getPost()
    },
    methods: {
        getPost() {
            axios.get('/api/posts/' + this.$route.params.id)
            .then (res => {
                this.post = res.data.data
            })
            .catch (err => {
                console.log(err.responce)
            })
        },
        deletePost() {
            axios.delete(`/api/posts/${this.post.id}`)
                .then(res => {
                    this.$router.push({ name: 'index.post'})
                }
                )
        },
        update(id) {
            //update one chosen post
            this.$router.push({ name: 'update.post', params: { id: id } })
        },
    }
}
</script>
<style lang="">
 
</style>