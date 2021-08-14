<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Tags
                        <Button @click="addModal = true"
                            ><Icon type="md-add" />Add Tag</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(tag, i) in tags" v-if="tags.length > 0">
                                <td>{{ tag.id }}</td>
                                <td class="_table_name">
                                    {{ tag.tagName }}
                                </td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(tag, i)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(tag, i)"
                                        :loading="isDeleting"
                                    >
                                        Delete</Button
                                    >
                                    <router-link
                                        :to="{
                                            name: 'tag',
                                            params: { id: tag.id }
                                        }"
                                        >details</router-link
                                    >
                                    <!-- <button
                                        class="_btn _action_btn edit_btn1"
                                        type="button"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="_btn _action_btn make_btn1"
                                        type="button"
                                    >
                                        Delete
                                    </button> -->
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>

                    <!-- tag adding model -->
                    <Modal
                        v-model="addModal"
                        title="Add Tag"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="data.tagName"
                            placeholder="Add Tag Name"
                        />
                        <div slot="footer">
                            <Button type="default" @click="addModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="addTag"
                                :disabled="isAdding"
                                :loading="isAdding"
                                >{{
                                    isAdding ? "Adding..." : "Add Tag"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!-- tag editing model -->
                    <Modal
                        v-model="editModal"
                        title="Edit Tag"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="editData.tagName"
                            placeholder="Edit Tag Name"
                        />
                        <div slot="footer">
                            <Button type="default" @click="editModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="editTag"
                                :disabled="isEditing"
                                :loading="isEditing"
                                >{{
                                    isEditing ? "Updating..." : "Update Tag"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!-- tags deleting  Modal -->
                    <!-- <Modal v-model="showDeleteModal" width="360">
                        <p slot="header" style="color:#f60;text-align:center">
                            <Icon type="ios-information-circle"></Icon>
                            <span>Delete confirmation</span>
                        </p>
                        <div style="text-align:center">
                            <p>Are You Sure You want to delete Tag?</p>
                        </div>
                        <div slot="footer">
                            <Button
                                type="error"
                                size="large"
                                long
                                :loading="isDeleting"
                                :disabled="isDeleting"
                                @click="deleteTag"
                                >Delete</Button
                            >
                        </div>
                    </Modal> -->
                    <deleteModal></deleteModal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import deleteModal from "../components/deleteModal.vue";
export default {
    data() {
        return {
            data: {
                tagName: ""
            },
            addModal: false,
            editModal: false,
            showDeleteModal: false,
            isAdding: false,
            isEditing: false,
            tags: [],
            editData: {
                tagName: ""
            },
            index: -1,
            isDeleting: false,
            deleteItem: {},
            deleteIndex: -1
        };
    },

    methods: {
        async addTag() {
            if (this.data.tagName.trim() == "") {
                return this.e("Tag Name is required");
            }
            const res = await this.callApi("post", "app/create_tag", this.data);
            if (res.status == 201) {
                this.tags.unshift(res.data);
                this.s("Tag has been added successfully");
                this.addModal = false;
                this.data.tagName = "";
            } else if (res.status == 422) {
                if (res.data.errors.tagName) {
                    this.i(res.data.errors.tagName);
                }
            } else {
                this.swr();
            }
        },
        async editTag() {
            this.tags[this.index].tagName = this.editData.tagName;
            if (this.editData.tagName.trim() == "") {
                return this.e("Tag Name is required");
            }
            const res = await this.callApi(
                "post",
                "app/edit_tag",
                this.editData
            );
            if (res.status == 200) {
                this.s("Tag has been updated successfully");
                this.editModal = false;
            } else if (res.status == 422) {
                if (res.data.errors.tagName) {
                    this.i(res.data.errors.tagName);
                }
            } else {
                this.swr();
            }
        },
        showEditModal(tag, index) {
            let obj = {
                id: tag.id,
                tagName: tag.tagName
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        async deleteTag() {
            // tag.isDeleting = true;
            // this.$set(tag, "isDeleting", true);
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                "app/delete_tag",
                this.deleteItem
            );
            if (res.status == 200) {
                this.tags.splice(this.deleteIndex, 1);
                this.s("Tag has been deleted successfully");
                this.isDeleting = false;
            } else {
                this.swr();
            }
            this.isDeleting = false;
            this.showDeleteModal = false;
        },
        showDeletingModal(tag, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_tag",
                data: tag,
                deleteIndex: i,
                isDeleting: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
            // this.deleteItem = tag;
            // this.deleteIndex = i;
            // this.showDeleteModal = true;
        }
    },
    async created() {
        const res = await this.callApi("get", "app/get_tags");
        if (res.status == 200) {
            this.tags = res.data;
        } else {
            this.swr();
        }
    },
    components: {
        deleteModal
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleting) {
                this.tags.splice(obj.deleteIndex, 1);
            }
        }
    }
};
</script>

<style></style>
