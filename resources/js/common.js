export default {
    data() {
        return {
            
        }
    },

    methods: {
        async callApi(method, url, data){
            try{
                return await axios({ 
                    method,
                    url,
                    data
                });
            }
            catch(e){
                return e.response
            }
        },

        info (title, desc) {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        success (title, desc) {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        warning (title, desc) {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        error (title, desc) {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    },
}