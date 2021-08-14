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
                            ><Icon type="md-add" />Add Role</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Role Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(role, i) in roles" v-if="roles.length">
                                <td>{{ role.id }}</td>
                                <td class="_table_name">
                                    {{ role.roleName }}
                                </td>
                                <td>{{ role.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(role, i)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(role, i)"
                                        :loading="isDeleting"
                                    >
                                        Delete</Button
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
                        title="Add Role"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="data.roleName"
                            placeholder="Add Role Name"
                        />
                        <div slot="footer">
                            <Button type="default" @click="addModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="addRole"
                                :disabled="isAdding"
                                :loading="isAdding"
                                >{{
                                    isAdding ? "Adding..." : "Add Role"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!-- tag editing model -->
                    <Modal
                        v-model="editModal"
                        title="Edit Role"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="editData.roleName"
                            placeholder="Edit Role Name"
                        />
                        <div slot="footer">
                            <Button type="default" @click="editModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="editRole"
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
                roleName: ""
            },
            addModal: false,
            editModal: false,
            showDeleteModal: false,
            isAdding: false,
            isEditing: false,
            roles: [],
            editData: {
                roleName: ""
            },
            index: -1,
            isDeleting: false,
            deleteItem: {},
            deleteIndex: -1
        };
    },

    methods: {
        async addRole() {
            if (this.data.roleName.trim() == "") {
                return this.e("Role Name is required");
            }
            const res = await this.callApi(
                "post",
                "app/create_role",
                this.data
            );
            if (res.status == 201) {
                this.roles.unshift(res.data);
                this.s("Roles has been added successfully");
                this.addModal = false;
                this.data.roleName = "";
            } else if (res.status == 422) {
                if (res.data.errors.roleName) {
                    this.i(res.data.errors.roleName);
                }
            } else {
                this.swr();
            }
        },
        async editRole() {
            this.roles[this.index].roleName = this.editData.roleName;
            if (this.editData.roleName.trim() == "") {
                return this.e("Role Name is required");
            }
            const res = await this.callApi(
                "post",
                "app/edit_role",
                this.editData
            );
            if (res.status == 200) {
                this.s("Role has been updated successfully");
                this.editModal = false;
            } else if (res.status == 422) {
                if (res.data.errors.roleName) {
                    this.i(res.data.errors.roleName);
                }
            } else {
                this.swr();
            }
        },
        showEditModal(role, index) {
            let obj = {
                id: role.id,
                roleName: role.roleName
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        // async deleteTag() {
        //     // tag.isDeleting = true;
        //     // this.$set(tag, "isDeleting", true);
        //     this.isDeleting = true;
        //     const res = await this.callApi(
        //         "post",
        //         "app/delete_role",
        //         this.deleteItem
        //     );
        //     if (res.status == 200) {
        //         this.roles.splice(this.deleteIndex, 1);
        //         this.s("Role has been deleted successfully");
        //         this.isDeleting = false;
        //     } else {
        //         this.swr();
        //     }
        //     this.isDeleting = false;
        //     this.showDeleteModal = false;
        // },
        showDeletingModal(role, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_role",
                data: role,
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
        const res = await this.callApi("get", "app/get_roles");
        if (res.status == 200) {
            this.roles = res.data;
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
                this.roles.splice(obj.deleteIndex, 1);
            }
        }
    }
};
</script>

<style></style>
