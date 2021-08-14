<template>
    <div class="container" v-if="!$store.state.user">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div
            class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4"
        >
            <div class="login_header">
                <h1>Login</h1>
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
            <div class="login_footer">
                <Button
                    type="primary"
                    @click="login"
                    :disabled="isLogging"
                    :loading="isLogging"
                    >Login</Button
                >
                <Button type="default" @click="register">Register</Button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                email: "",
                password: ""
            },
            isLogging: false
        };
    },
    methods: {
        async login() {
            this.isLogging = true;
            const res = await this.callApi(
                "post",
                "app/admin_login",
                this.data
            );
            // console.log(res.data.user.userType);
            if (res.status === 200) {
                if (res.data.user.userType == "Admin") {
                    this.s(res.data.msg);
                    this.$store.state.user = true;
                    this.$router.push("/dashboard");
                } else {
                    this.i("you are not allowed to login in admin pannel");
                }
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
        register() {
            this.$router.push("/register");
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
