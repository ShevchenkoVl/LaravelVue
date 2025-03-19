<template lang="">
    <div class="w-75 text-center">
        <div v-if="posts" class="row row-cols-5 pt-5">
            <div v-for="post in posts.data" class="col" >
                <div @click.prevent="show(post.id)" class="row btn pb-5" >
                    <div><img v-if="post.images != 0" :src="post.images[0].preview_url" alt="preview_Image" class="mb-3">
                    <img v-else alt="preview_Image" class="mb-3"></div>
                    <div><h4>{{ post.title }}</h4></div>
                    <div><input @click.prevent="update(post.id)" type="submit" class="btn btn-primary mt-3" value="update"></div>
                </div>
            </div>
        </div>
        <div>
            <a href="#" v-if="is_visible" @click.prevent="getPost()" class="d-block text-center btn btn-dark">More</a>
        </div>
    </div>
</template>
<script>
export default {
    name: "Index",

    data() {
        return {
            page: 0,
            posts: null,
            is_visible: false,
        }
    },

    mounted() {
        this.getPost()
    },
    methods: {
        getPost() {
            axios.get('/api/posts', {
                params: {
                    page: ++this.page
                }
            })
                .then(res => {
                    if (this.posts !== null) {
                        this.posts.data = [...this.posts.data, ...res.data.data]
                        this.posts.meta.to = res.data.meta.to
                    }
                    else
                        this.posts = res.data
                    //this.post = res.data.data
                    this.is_visible = this.posts.meta.to < this.posts.meta.total
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