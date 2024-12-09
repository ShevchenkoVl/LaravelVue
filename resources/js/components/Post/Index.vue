<template lang="">
    <div>
        <div v-if="post">
            <h4>{{ post.title }}</h4>
            <div v-for="image in post.images" class="mb-3">
                <img :src="image.preview_url" alt="preview_Image" class="mb-3">
                <div class="mb-3"><img :src="image.url" alt="Image"></div>
            </div>
            <div v-html="post.content" class="ql-editor"></div>
        </div>
        <table class="table mt-5 w-75">
            <td v-for="post in posts" class="mb-3 btn"  >
                <tr @click.prevent="show(post.id)">
                    <img v-if="post.images != 0" :src="post.images[0].preview_url" alt="preview_Image" class="mb-3">
                    <img v-else alt="preview_Image" class="mb-3">
                    <h4>{{ post.title }}</h4>
                </tr>
                <input @click.prevent="update(post.id)" type="submit" class="btn btn-primary mt-3" value="update">
            </td>
        </table>
    </div>
</template>
<script>
export default {
    data() {
        return {
            post: null,
            posts: null,
            table_columns: 4,
        }
    },
    name: "Index",
    mounted() {
        this.getPost()
    },
    methods: {
        getPost() {
            axios.get('/api/posts')
                .then(res => {
                    this.posts = res.data.data
                    //this.post = res.data.data
                })
                .catch(err => {
                    console.log(err.responce)
                })
        },
        show(id) {
            this.$router.push({ name: 'show.post', params: { id: id } })
        },
        update(id) {
            this.$router.push({ name: 'update.post', params: { id: id } })
        },
    }
}
</script>
<style lang="">

</style>