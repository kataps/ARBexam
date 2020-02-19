<template>
    <div class="main-content-container container-fluid px-4">
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">My Profile</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <form @submit="save">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" v-model="new_password" name="new_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" v-model="confirm_password" name="confirm_password" class="form-control">
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
      
        data(){
            return{
         
                new_password: '',
                confirm_password: ''
            }
        },
        mounted() {
        },
        methods: {
            save(e) {
                e.preventDefault();

                if( this.new_password != this.confirm_password ){
                    return false;
                }
                let data = {
                    newpassword: this.new_password,
                };
                axios.post('webapi/save-profile', data).then(response => {

                    if(response.data.status == true ){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: 'Password Changed',
                            footer: '<a href="javascript:void(0)" onclick="alert(\"I\' dont know!\")">Why do I have this issue?</a>'
                        });

                        this.current_password = '';
                        this.new_password = '';
                        this.confirm_password = '';


                    }else{
                    }

                });
            }
        }
    }
</script>
