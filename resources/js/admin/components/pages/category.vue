<template>
    <div>
        <div>
            <div class="content">
                <div class="container">
                    <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                    <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                        <p class="_title0">Category <Button type="primary" size="small" @click="showAddModal"><Icon type="md-add" />Add New</Button></p>

                        <div class="_overflow _table_div">
                            <table class="_table">
                                    <!-- TABLE TITLE -->
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                    <!-- TABLE TITLE -->


                                    <!-- ITEMS -->
                                <tr v-for="(category,i) in categories" :key="i" v-if="categories.length">
                                    <td>{{i+1}}</td>
                                    <td class="table_image">
                                        <img :src="category.iconImage">
                                    </td>
                                    <td class="_table_name">{{category.categoryName}}</td>
                                    <td>{{category.created_at}}</td>
                                    <td>
                                        <Button type="info" size="small" @click="showEditModal(category,i)"><Icon type="md-open" />Edit</Button>
                                        <Button type="error" size="small" @click="showDeleteModal(category,i)" :loading="category.isDeleting"><Icon type="ios-trash" />Delete</Button>
                                    </td>
                                </tr>
                                    <!-- ITEMS -->
                            </table>
                        </div>

                        <!-- Add Modal -->
                        <Modal
                            v-model="addModal"
                            title="Add New Category"
                            :maskClosable="false"
                            >
                            <Input v-model="data.categoryName" placeholder="Enter category name" />
                            <div class="space"></div>
                            <Upload
                                ref="uploads"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :format="['jpg','jpeg','png']"
                                :max-size="2048"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                type="drag"
                                action="/api/category/upload">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <div class="demo-upload-list" v-if="data.iconImage">
                                <template >
                                    <img :src="`/uploads/category/${data.iconImage}`">
                                    <div class="demo-upload-list-cover">
                                        <Icon type="ios-trash-outline" @click="deleteFile(data.iconImage)"></Icon>
                                    </div>
                                </template>
                                
                            </div>

                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...' : 'Add'}}</Button>
                            </div>
                        </Modal>

                        <!-- Edit Modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Category"
                            :maskClosable="false"
                            >
                            <Input v-model="editData.categoryName" placeholder="Enter category name" />
                            <div class="space"></div>
                            <Upload
                                ref="uploads"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :format="['jpg','jpeg','png']"
                                :max-size="2048"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                type="drag"
                                action="/api/category/upload">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <div class="demo-upload-list" v-if="editData.iconImage">
                                <template >
                                    <img :src="editData.iconImage">
                                    <div class="demo-upload-list-cover">
                                        <Icon type="ios-trash-outline" @click="deleteFile(editData.iconImage)"></Icon>
                                    </div>
                                </template>
                                
                            </div>

                            <div slot="footer">
                                <Button type="default" @click="editModal=false">Close</Button>
                                <Button type="primary" @click="editTags" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Editing...' : 'Edit'}}</Button>
                            </div>
                        </Modal>

                        <!-- Delete Modal -->
                        <Modal v-model="deleteModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <Icon type="ios-information-circle"></Icon>
                                <span>Delete confirmation</span>
                            </p>
                            <div style="text-align:center">
                                <p>Are you sure you want to delete this tag?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
                            </div>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default { 
    data(){
        return {
            data: {
                iconImage: '',
                categoryName: ''
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            tags: [],
            categories: [],
            editData: {
                categoryName: '',
                iconImage: ''
            },
            index: 0,
            deleteModal: false,
            isDeleting: false,
            deleteIndex: 0,
            deleteItem: {}
        }
    },

    methods: {
        async addCategory(){
            if(this.data.categoryName.trim() == "") return this.error('Oops!', 'Category name is required!')
            if(this.data.iconImage.trim() == "") return this.error('Oops!', 'Image is required!')
            this.data.iconImage = `uploads/category/${this.data.iconImage}`
            let res = await this.callApi('post', 'api/category/create', this.data)
            if(res.status == 200){
                this.categories.push(res.data.data)
                this.success('Great!', 'Category is created successfully!')
                this.addModal = false
            }else {
                if(res.status == 422){
                    if(res.data.errors.categoryName){
                        this.error('Oops!', res.data.errors.categoryName[0])
                    }
                    if(res.data.errors.iconImage){
                        this.error('Oops!', res.data.errors.iconImage[0])
                    }
                    
                }else{
                    this.error('Oops!', 'Something went wrong!')
                }
            }
        },

        async editTags(){
            if(this.editData.tagName.trim() == "") return this.error('Oops!', 'TagName is required!')
            let res = await this.callApi('post', 'api/tags/edit', this.editData)
            if(res.status == 200){
                this.tags[this.index].tagName = this.editData.tagName
                this.success('Great!', 'Tag is edited successfully!')
                this.editModal = false
            }else {
                if(res.status == 422){
                    this.error('Oops!', res.data.errors.tagName[0])
                }else{
                    this.error('Oops!', 'Something went wrong!')
                }
            }
        },

        showAddModal(){
            this.data.categoryName = ''
            this.data.iconImage = ''
            this.$refs.uploads.clearFiles()
            this.addModal = true;
        },

        showEditModal(category,index){
            console.log(category)
            let obj = {
                id : category.id,
                categoryName : category.categoryName,
                iconImage : category.iconImage
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },

        async deleteTag(){
            this.isDeleting = true
            let res = await this.callApi('post', 'api/tags/delete', this.deleteItem)
            if(res.status == 200) {
                this.tags.splice(this.deleteIndex,1)
                this.success('Great!', 'Tag is deleted successfully!')
            }else{
                this.error('Oops!', 'Something went wrong!')
            }
            this.isDeleting = false
            this.deleteModal = false
        },
        
        showDeleteModal(tag,i){
            this.deleteItem = tag
            this.deleteIndex = i
            this.deleteModal = true
        },

        handleSuccess (res) {
            this.data.iconImage = res
        },
        handleError (res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            });
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },

        async deleteFile(file){
            let image = file
            this.data.iconImage = ''
            this.$refs.uploads.clearFiles()
            let res = await this.callApi('post', 'api/category/img_delete', {iconImage: image})
            if(res.status !== 200){
                this.data.iconImage = image
                this.error('Oops!', 'Something went wrong!')
            }
        }
    },
    async created() {
        let res = await this.callApi('get', 'api/category')
        if(res.status == 200){
            this.categories = res.data.data
        }else{
            this.error('Oops!', 'Something went wrong!')
        }
    }
}
</script>