<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_one"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ tags.length }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    Total Tags
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="ios-paper" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_two"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ categories.length }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    Total Categories
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="ios-paper-outline" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_two"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ users.length }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    Total Users
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="md-copy" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tags: [],
            categories: [],
            users: []
        };
    },
    async created() {
        const res = await this.callApi("get", "app/get_tags");
        if (res.status == 200) {
            this.tags = res.data;
        } else {
            this.swr();
        }

        const res1 = await this.callApi("get", "app/get_category");
        if (res1.status == 200) {
            this.categories = res1.data;
        } else {
            this.swr();
        }

        const res2 = await this.callApi("get", "app/get_users");
        if (res2.status == 200) {
            this.users = res2.data;
        } else {
            this.swr();
        }
    }
};
</script>

<style></style>
