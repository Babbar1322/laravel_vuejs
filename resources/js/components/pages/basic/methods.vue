<template>
    <div>
        <h1>the number is : {{ views }}</h1>
        <button @click="updateCounter(1)">add 1</button>
        <button @click="updateCounter(-1)">subtract 1</button>
        <br /><br /><br />

        <div v-for="(blog, i) in blogs" :key="i">
            <h1>{{ blog.title }}</h1>
            <p>{{ blog.post }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            views: 0,
            blogs: []
        };
    },
    methods: {
        updateCounter(number) {
            this.views += number;
        }
    },
    created() {
        this.views = 100;
        let posts = [
            {
                title: "this is blog title 1",
                post: "this is the blog post 1",
                id: 1
            },
            {
                title: "this is blog title 2",
                post: "this is the blog post 2",
                id: 2
            },
            {
                title: "this is blog title 3",
                post: "this is the blog post 3",
                id: 3
            },
            {
                title: "this is blog title 4",
                post: "this is the blog post 4",
                id: 4
            }
        ];
        this.blogs = posts;
    }
};
</script>

<style></style>
