<template>
    <div>
        <Modal
            :value="getDeleteModalObj.showDeleteModal"
            :mask-closable="false"
            :closable="false"
            width="360"
        >
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Are You Sure You want to delete Tag?</p>
            </div>

            <div slot="footer">
                <Button
                    type="default"
                    size="large"
                    :loading="isDeleting"
                    :disabled="isDeleting"
                    @click="closeModal"
                    >Close</Button
                >
                <Button
                    type="error"
                    size="large"
                    :loading="isDeleting"
                    :disabled="isDeleting"
                    @click="deleteTag"
                    >Delete</Button
                >
            </div>
        </Modal>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isDeleting: false
        };
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    methods: {
        async deleteTag() {
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                this.getDeleteModalObj.deleteUrl,
                this.getDeleteModalObj.data
            );
            if (res.status == 200) {
                this.s("Tag has been deleted successfully");
                this.isDeleting = false;
                this.$store.commit("setDeleteModal", true);
            } else {
                this.swr();
                this.$store.commit("setDeleteModal", false);
            }
        },
        closeModal() {
            this.$store.commit("setDeleteModal", false);
        }
    }
};
</script>

<style></style>
