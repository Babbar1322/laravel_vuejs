<template>
    <div class="container">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div
            class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4"
        >
            <div class="login_header">
                <h1>Login</h1>
            </div>
            <div class="space">
                <Input v-model="data.fullName" placeholder="Full Name" />
            </div>
            <div class="space">
                <Input type="email" v-model="data.email" placeholder="Email" />
            </div>
            <div class="space">
                <Input
                    type="password"
                    v-model="data.password"
                    placeholder="Password"
                />
            </div>
            <div class="space">
                <Input
                    type="password"
                    v-model="data.confirm_password"
                    placeholder="Confirm Password"
                />
            </div>
            <div class="login_footer">
                <Button
                    type="default"
                    @click="register"
                    :disabled="isLogging"
                    :loading="isLogging"
                    >Register</Button
                >
                <Button type="primary" @click="login">Login</Button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                fullName: "",
                email: "",
                password: "",
                confirm_password: ""
            },
            isLogging: false
        };
    },
    mounted() {
        window.onpopstate = event => {
            if (this.$store.state.user == false) {
                this.$router.push("/register");
            }
        };
    },
    methods: {
        async register() {
            this.isLogging = true;
            const res = await this.callApi("post", "/register", this.data);
            if (res.status === 200) {
                this.s(res.data.msg);
                this.$router.push("/login");
            } else {
                if (res.status === 401) {
                    this.i(res.data.msg);
                } else if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
            this.isLogging = false;
        },
        login() {
            this.$router.push("/login");
        }
    }
};
</script>

<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 200px;
}
.login_footer,
.login_header {
    text-align: center;
}
</style>
