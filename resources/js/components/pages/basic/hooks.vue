<template>
    <div>
        <h1 ref="myref">Hook tutorial</h1>
        <p>my name is {{ name }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "vue"
        };
    },
    beforeCreate() {
        console.log(this.name);
    },
    created() {
        console.log(
            "data and other function are available but not html",
            this.name
        );
    },
    mounted() {
        console.log(this.$refs.myref);
    }
};
</script>

<style></style>
