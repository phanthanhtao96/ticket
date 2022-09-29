<template>
    <div>
        <div v-if="vars.enable === 0">
            <h2 class="text-white">Unavailable</h2>
        </div>
        <div v-if="success">
            <h2 class="text-white">Cảm ơn bạn đã đánh giá!</h2>
        </div>
        <div v-if="vars.enable !== 0 && !success">
            <b-card style="max-width: 650px; float: none; margin: 0 auto">
                <h1 class="text-warning">Đánh giá chất lượng dịch vụ</h1>
                <b-form-group label="1.Kiến thức & Trình độ chuyên môn của kỹ sư thực hiện dịch vụ"
                              label-cols="12" label-cols-md="7" label-cols-xl="6"
                              label-class="text-secondary">
                    <b-form-rating id="rating-lg-no-border" inline size="lg" class="rating-lg"
                                   v-model="rating1" v-if="is_view" readonly></b-form-rating>
                </b-form-group>
                <b-form-group label="2.Thái độ phục vụ của kỹ sư thực hiện dịch vụ"
                              label-cols="12" label-cols-md="7" label-cols-xl="6"
                              label-class="text-secondary">
                    <b-form-rating id="rating-lg-no-border" inline size="lg" class="rating-lg"
                                   v-model="rating2" v-if="is_view" readonly></b-form-rating>
                </b-form-group>
                <b-form-group label="3.Thời gian hoàn thành dịch vụ"
                              label-cols="12" label-cols-md="7" label-cols-xl="6"
                              label-class="text-secondary">
                    <b-form-rating id="rating-lg-no-border" inline size="lg" class="rating-lg"
                                   v-model="rating3" v-if="is_view" readonly></b-form-rating>
                </b-form-group>
                <b-form-group label="4.Mức độ hài lòng của anh nói chung về dịch vụ"
                              label-cols="12" label-cols-md="7" label-cols-xl="6"
                              label-class="text-secondary">
                    <b-form-rating id="rating-lg-no-border" inline size="lg" class="rating-lg"
                                   v-model="rating4" v-if="is_view" readonly></b-form-rating>
                </b-form-group>
                <div class="hr-radius"></div>
                <b-form-group
                        label="Kỹ sư liên lạc nhanh chóng để tiến hành xử lý, tối đa trong vòng 1 giờ kể từ khi bạn gọi cho ServiceDesk"
                        label-cols="12" label-cols-md="7" label-cols-xl="6"
                        label-class="text-secondary" style="color: black">
                    <div v-if="!is_view" class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="r1" name="gender" class="custom-control-input"
                               value="5" v-model="response_rating">
                        <label class="custom-control-label text-secondary" for="r1">Có</label>
                    </div>
                    <div v-if="!is_view" class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="r2" name="gender" class="custom-control-input"
                               value="0" v-model="response_rating">
                        <label class="custom-control-label text-secondary" for="r2">Không</label>
                    </div>
                  <div v-if="is_view">
                    {{ response_rating ? 'Có' : 'Không' }}
                  </div>
                </b-form-group>
                <b-form-group v-if="!is_view" label=""
                              label-cols="12" label-cols-md="7" label-cols-xl="6"
                              label-class="text-secondary">
                    <b-button type="button" variant="primary" class="border-0 main-button mt-3"
                              v-on:click="post_rating">Hoàn tất
                    </b-button>
                </b-form-group>
            </b-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ClientRating",
        props: ['vars'],
        data() {
            return {
                rating1: this.vars?.rating?.rating1 || 0,
                rating2: this.vars?.rating?.rating2 || 0,
                rating3: this.vars?.rating?.rating3 || 0,
                rating4: this.vars?.rating?.rating4 || 0,
                response_rating: this.vars.response_rating || 5,
                success: false,
                is_view: this.vars?.is_view || 0
            }
        },
        created: function () {

        },
        methods: {
            post_rating: function () {
                let data = {
                    uuid: this.vars.id,
                    client_email: this.vars.email,
                    rating1: this.rating1,
                    rating2: this.rating2,
                    rating3: this.rating3,
                    rating4: this.rating4,
                    response_rating: this.response_rating
                }
                this.post_data('/rating', data)
                    .then(response => {
                        if (typeof response === 'object') {
                            if (response.status === true) {
                                //this.make_toast('success', 'Successful', response.message)
                                this.success = true;
                            }
                            else {
                                this.make_toast('danger', 'Failed', response.message)
                            }
                        }
                    })
                    .catch(reason => this.make_toast('danger', 'Failed', reason.message))
            }
        }
    }
</script>
