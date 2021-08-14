<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Categories
                        <Button @click="addModal = true"
                            ><Icon type="md-add" />Add Category</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Icon Image</th>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(category, i) in categories"
                                v-if="categories.length > 0"
                            >
                                <td>{{ category.id }}</td>
                                <td>
                                    <div class="table_image">
                                        <img
                                            :src="
                                                `/uploads/${category.iconImage}`
                                            "
                                            width="40"
                                        />
                                    </div>
                                </td>
                                <td class="_table_name">
                                    {{ category.categoryName }}
                                </td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(category, i)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(category, i)"
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

                    <!-- category adding model -->
                    <Modal
                        v-model="addModal"
                        title="Add Category"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="data.categoryName"
                            placeholder="Add Category Name"
                        />
                        <div class="space"></div>
                        <Upload
                            ref="uploads"
                            type="drag"
                            :headers="{
                                'x-csrf-token': token,
                                'x-Requested-With': 'XMLHttpRequest'
                            }"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg', 'jpeg', 'png']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            action="/app/upload"
                        >
                            <div style="padding: 20px 0">
                                <Icon
                                    type="ios-cloud-upload"
                                    size="52"
                                    style="color: #3399ff"
                                ></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                        <div class="demo-upload-list" v-if="data.iconImage">
                            <img :src="`/uploads/${data.iconImage}`" />
                            <div class="demo-upload-list-cover">
                                <Icon
                                    type="ios-trash-outline"
                                    @click="deleteImage"
                                ></Icon>
                            </div>
                        </div>
                        <div slot="footer">
                            <Button type="default" @click="addModal = false"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="addCategory"
                                :disabled="isAdding"
                                :loading="isAdding"
                                >{{
                                    isAdding ? "Adding..." : "Add Category"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!-- category editing model -->
                    <Modal
                        v-model="editModal"
                        title="Edit Category"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="editData.categoryName"
                            placeholder="Edit Category Name"
                        />
                        <div class="space"></div>

                        <Upload
                            v-if="isIconImageNew"
                            ref="editDataUploads"
                            type="drag"
                            :headers="{
                                'x-csrf-token': token,
                                'x-Requested-With': 'XMLHttpRequest'
                            }"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg', 'jpeg', 'png']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            action="/app/upload"
                        >
                            <div style="padding: 20px 0">
                                <Icon
                                    type="ios-cloud-upload"
                                    size="52"
                                    style="color: #3399ff"
                                ></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>

                        <div class="demo-upload-list" v-if="editData.iconImage">
                            <img :src="`uploads/${editData.iconImage}`" />
                            <div class="demo-upload-list-cover">
                                <Icon
                                    type="ios-trash-outline"
                                    @click="deleteImage(false)"
                                ></Icon>
                            </div>
                        </div>

                        <div slot="footer">
                            <Button type="default" @click="closeEditModel"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="editCategory"
                                :disabled="isEditing"
                                :loading="isEditing"
                                >{{
                                    isEditing
                                        ? "Updating..."
                                        : "Update Category"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!-- category deleting  Modal -->
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
                                @click="deleteCategory"
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
import deleteModal from "../components/deleteModal.vue";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            data: {
                iconImage: "",
                categoryName: ""
            },
            addModal: false,
            editModal: false,
            showDeleteModal: false,
            isAdding: false,
            isEditing: false,
            categories: [],
            editData: {
                iconImage: "",
                categoryName: ""
            },
            index: -1,
            isDeleting: false,
            deleteItem: {},
            deleteIndex: -1,
            token: "",
            isIconImageNew: false,
            isEditingItem: false
        };
    },
    components: {
        deleteModal
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "app/get_category");
        if (res.status == 200) {
            this.categories = res.data;
        } else {
            this.swr();
        }
    },
    methods: {
        async addCategory() {
            if (this.data.categoryName.trim() == "") {
                return this.e("Category Name is required");
            }
            if (this.data.iconImage.trim() == "") {
                return this.e("Icon Image is required");
            }
            const res = await this.callApi(
                "post",
                "app/create_category",
                this.data
            );
            if (res.status == 201) {
                this.categories.unshift(res.data);
                this.s("Category has been added successfully");
                this.addModal = false;
                this.data.categoryName = "";
                this.data.iconImage = "";
            } else if (res.status == 422) {
                if (res.data.errors.categoryName) {
                    this.i(res.data.errors.categoryName);
                }
            } else {
                this.swr();
            }
        },
        async editCategory() {
            this.categories[
                this.index
            ].categoryName = this.editData.categoryName;
            if (this.editData.categoryName.trim() == "") {
                return this.e("Category Name is required");
            }
            this.categories[this.index].iconImage = this.editData.iconImage;
            if (this.editData.iconImage.trim() == "") {
                return this.e("Icon Image is required");
            }
            const res = await this.callApi(
                "post",
                "app/edit_category",
                this.editData
            );
            if (res.status == 200) {
                this.s("Category has been updated successfully");
                this.editModal = false;
            } else if (res.status == 422) {
                if (res.data.errors.categoryName) {
                    this.i(res.data.errors.categoryName);
                }
            } else {
                this.swr();
            }
        },
        showEditModal(category, index) {
            let obj = {
                id: category.id,
                categoryName: category.categoryName,
                iconImage: category.iconImage
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
            this.isEditingItem = true;
        },
        async deleteTag() {
            // tag.isDeleting = true;
            // this.$set(tag, "isDeleting", true);
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                "app/delete_category",
                this.deleteItem
            );
            if (res.status == 200) {
                this.deleteImage(true);
                this.categories.splice(this.deleteIndex, 1);
                this.s("Category has been deleted successfully");
            } else {
                this.swr();
            }
            this.isDeleting = false;
            this.showDeleteModal = false;
        },
        showDeletingModal(category, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_category",
                data: category,
                deleteIndex: i,
                isDeleting: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
            // this.deleteItem = category;
            // this.deleteIndex = i;
            // this.showDeleteModal = true;
        },

        handleSuccess(res, file) {
            if (this.isEditingItem) {
                this.editData.iconImage = res;
            }
            this.data.iconImage = res;
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc: `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "something went wrong"
                }`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M."
            });
        },
        async deleteImage(isAdd = true) {
            if (!isAdd) {
                this.isIconImageNew = true;
                var image = this.editData.iconImage;
                this.editData.iconImage = "";
                this.$refs.editDataUploads.clearFiles();
            } else {
                var image = this.data.iconImage;
                this.data.iconImage = "";
                this.$refs.uploads.clearFiles();
            }
            const res = await this.callApi("post", "/app/delete_image", {
                imageName: image
            });
            if (res.status != 200) {
                this.data.iconImage = image;
                this.swr();
            }
        },
        closeEditModel() {
            this.isEditingItem = false;
            this.editModal = false;
        }
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleting) {
                this.categories.splice(obj.deleteIndex, 1);
            }
        }
    }
};
</script>

<style>
.demo-upload-list {
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    margin-right: 4px;
}
.demo-upload-list img {
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}
.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}
.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
