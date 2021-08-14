<template>
    <div>
        <h1>tag details {{ id }}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: ""
        };
    },
    async created() {
        this.$store.state.user = true;

        this.id = this.$route.params.id;

        const res = await this.callApi(
            "get",
            "/app/tag/" + this.$route.params.id
        );
        console.log(res.data);
    }
};
</script>

<style></style>
