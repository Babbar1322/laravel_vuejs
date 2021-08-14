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
                            ><Icon type="md-add" />Add Admin
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(user, i) in users" v-if="users.length">
                                <td>{{ user.id }}</td>
                                <td class="_table_name">
                                    {{ user.fullName }}
                                </td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.userType }}</td>
                                <td>{{ user.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(user, i)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(user, i)"
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
                        title="Add AdminUser"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <div class="space">
                            <Input
                                v-model="data.fullName"
                                placeholder="Full Name"
                            />
                        </div>
                        <div class="space">
                            <Input v-model="data.email" placeholder="Email" />
                        </div>
                        <div class="space">
                            <Input
                                type="password"
                                v-model="data.password"
                                placeholder="Password"
                            />
                        </div>
                        <!-- <div class="space"> -->
                        <Select
                            v-model="data.userType"
                            placeholder="Select Admin"
                        >
                            <Option
                                :value="role.id"
                                v-for="role in roles"
                                :key="role.id"
                                >{{ role.roleName }}</Option
                            >
                            <!-- <Option value="Editor">Editor</Option> -->
                        </Select>
                        <!-- </div> -->
                        <div slot="footer">
                            <Button type="default" @click="addModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="addAdmin"
                                :disabled="isAdding"
                                :loading="isAdding"
                                >{{
                                    isAdding ? "Adding..." : "Add Admin"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!-- tag editing model -->
                    <Modal
                        v-model="editModal"
                        title="Edit User"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <div class="space">
                            <Input
                                v-model="editData.fullName"
                                placeholder="Full Name"
                            />
                        </div>
                        <div class="space">
                            <Input
                                v-model="editData.email"
                                placeholder="Email"
                            />
                        </div>
                        <!-- <div class="space">
                            <Input
                                type="password"
                                v-model="data.password"
                                placeholder="Password"
                            />
                        </div> -->
                        <div class="space">
                            <Select
                                v-model="editData.userType"
                                placeholder="Select Admin"
                            >
                                <Option value="Admin">Admin</Option>
                                <Option value="Editor">Editor</Option>
                            </Select>
                        </div>
                        <div slot="footer">
                            <Button type="default" @click="editModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="editUser"
                                :disabled="isEditing"
                                :loading="isEditing"
                                >{{
                                    isEditing ? "Updating..." : "Update User"
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
                fullName: "",
                email: "",
                password: "",
                userType: "Admin"
            },
            addModal: false,
            editModal: false,
            showDeleteModal: false,
            isAdding: false,
            isEditing: false,
            users: [],
            roles: [],
            editData: {
                fullName: "",
                email: "",
                userType: ""
            },
            index: -1,
            isDeleting: false,
            deleteItem: {},
            deleteIndex: -1
        };
    },

    methods: {
        async addAdmin() {
            // if (this.data.fullName.trim() == "") {
            //     return this.e("Full Name is required");
            // }
            // if (this.data.email.trim() == "") {
            //     return this.e("Email is required");
            // }
            // if (this.data.password.trim() == "") {
            //     return this.e("Password is required");
            // }
            // if (this.data.userType.trim() == "") {
            //     return this.e("User Type is required");
            // }
            const res = await this.callApi(
                "post",
                "app/create_user",
                this.data
            );
            if (res.status == 201) {
                this.users.unshift(res.data);
                this.s("User has been added successfully");
                this.addModal = false;
                this.data.fullName = "";
                this.data.email = "";
                this.data.password = "";
            } else if (res.status == 422) {
                // console.log(res.data.errors);
                for (let i in res.data.errors) {
                    this.e(res.data.errors[i][0]);
                }
                // if (res.data.errors.tagName) {
                //     this.i(res.data.errors.tagName);
                // }
            } else {
                this.swr();
            }
        },
        async editUser() {
            this.users[this.index].fullName = this.editData.fullName;
            this.users[this.index].email = this.editData.email;
            this.users[this.index].userType = this.editData.userType;
            // if (this.editData.tagName.trim() == "") {
            //     return this.e("Tag Name is required");
            // }
            const res = await this.callApi(
                "post",
                "app/edit_user",
                this.editData
            );
            if (res.status == 200) {
                this.s("User has been updated successfully");
                this.editModal = false;
            } else if (res.status == 422) {
                // if (res.data.errors.tagName) {
                //     this.i(res.data.errors.tagName);
                // }
                for (let i in res.data.errors) {
                    this.i(res.data.errors[i][0]);
                }
            } else {
                this.swr();
            }
        },
        showEditModal(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                userType: user.userType
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
                this.users.splice(this.deleteIndex, 1);
                this.s("Tag has been deleted successfully");
                this.isDeleting = false;
            } else {
                this.swr();
            }
            this.isDeleting = false;
            this.showDeleteModal = false;
        },
        showDeletingModal(user, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/deleteUser",
                data: user,
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
        const res = await this.callApi("get", "app/get_users");
        const role = await this.callApi("get", "app/get_roles");
        if (res.status == 200) {
            this.users = res.data;
        } else {
            this.swr();
        }
        if (role.status == 200) {
            this.roles = role.data;
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
                this.users.splice(obj.deleteIndex, 1);
            }
        }
    }
};
</script>

<style></style>
