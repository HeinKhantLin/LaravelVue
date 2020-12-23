<template>
    <div>
        <div>
            <div class="content">
                <div class="container">
                    <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                    <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                        <p class="_title0">Tags <Button type="primary" size="small" @click="addModal=true"><Icon type="md-add" />Add New</Button></p>

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
                                <tr v-for="(tag,i) in tags" :key="i" v-if="tags.length">
                                    <td>{{i+1}}</td>
                                    <td class="_table_name">{{tag.tagName}}</td>
                                    <td>{{tag.created_at}}</td>
                                    <td>
                                        <Button type="info" size="small" @click="showEditModal(tag,i)"><Icon type="md-open" />Edit</Button>
                                        <Button type="error" size="small" @click="showDeleteModal(tag,i)" :loading="tag.isDeleting"><Icon type="ios-trash" />Delete</Button>
                                    </td>
                                </tr>
                                    <!-- ITEMS -->
                            </table>
                        </div>

                        <!-- Add Modal -->
                        <Modal
                            v-model="addModal"
                            title="Add New Tag"
                            :maskClosable="false"
                            >
                            <Input v-model="data.tagName" placeholder="Enter tag name" />

                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addTags" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...' : 'Add'}}</Button>
                            </div>
                        </Modal>

                        <!-- Edit Modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Tag"
                            :maskClosable="false"
                            >
                            <Input v-model="editData.tagName" placeholder="Enter tag name" />

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
                tagName: '',
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            tags: [],
            editData: {
                tagName: ''
            },
            index: 0,
            deleteModal: false,
            isDeleting: false,
            deleteIndex: 0,
            deleteItem: {}
        }
    },

    methods: {
        async addTags(){
            //if(this.data.tagName.trim() == "") return this.error('Oops!', 'Tag name is required!')
            let res = await this.callApi('post', 'api/tags/create', this.data)
            if(res.status == 200){
                this.tags.push(res.data.data)
                this.success('Great!', 'Tag is created successfully!')
                this.addModal = false
            }else {
                if(res.status == 422){
                    this.error('Oops!', res.data.errors.tagName[0])
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

        showEditModal(tag,index){
            let obj = {
                id : tag.id,
                tagName : tag.tagName
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
        }
    },
    async created() {
        let res = await this.callApi('get', 'api/tags')
        if(res.status == 200){
            this.tags = res.data.data
        }else{
            this.error('Oops!', 'Something went wrong!')
        }
    }
}
</script>