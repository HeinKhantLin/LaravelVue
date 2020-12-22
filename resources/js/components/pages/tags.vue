<template>
    <div>
        <div>
            <div class="content">
                <div class="container">
                    <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                    <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                        <p class="_title0">Tags <Button type="primary" size="small" @click="showModal=true"><Icon type="md-add" />Add New</Button></p>

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
                                        <Button type="info" size="small"><Icon type="md-open" />Edit</Button>
                                        <Button type="error" size="small"><Icon type="ios-trash" />Delete</Button>
                                    </td>
                                </tr>
                                    <!-- ITEMS -->
                            </table>
                        </div>

                        <Modal
                            v-model="showModal"
                            title="Add New Tag"
                            :maskClosable="false"
                            >
                            <Input v-model="data.tagName" placeholder="Enter tag name" />

                            <div slot="footer">
                                <Button type="default" @click="showModal=false">Close</Button>
                                <Button type="primary" @click="addTags" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...' : 'Add'}}</Button>
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
            showModal: false,
            isAdding: false,
            tags: []
        }
    },

    methods: {
        async addTags(){
            if(this.data.tagName.trim() == "") return this.error('Oops!', 'TagName is required!')
            let res = await this.callApi('post', 'api/tags/create', this.data)
            if(res.status == 200){
                this.tags.push(res.data.data)
                this.success('Great!', 'Tag is created successfully!')
                this.showModal = false
            }else {
                this.error('Oops!', 'Something went wrong!')
            }
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