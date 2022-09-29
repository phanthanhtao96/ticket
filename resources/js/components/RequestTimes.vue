<template>
    <div>
        <b-form-group label="Start date (Open)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary" v-if="vars.type==='Request'">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="active_date_ymd" v-model="active_date_ymd" maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="active_date_hm" v-model="active_date_hm" maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>
        <b-form-group label="Due by date"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="due_by_date_ymd" v-model="due_by_date_ymd" maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="due_by_date_hm" v-model="due_by_date_hm" maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>
        <b-form-group label="Closed date"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="closed_date_ymd" v-model="closed_date_ymd" maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="closed_date_hm" v-model="closed_date_hm" maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>

        <div class="hr-radius"></div>
        <h5 class="text-warning">Response</h5>
        <b-form-group label="Response time (estimate)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="response_time_estimate_ymd" v-model="response_time_estimate_ymd"
                             maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="response_time_estimate_hm" v-model="response_time_estimate_hm"
                             maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>
        <b-form-group label="Response time"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="response_time_ymd" v-model="response_time_ymd"
                             maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="response_time_hm" v-model="response_time_hm"
                             maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>
        <b-form-group label="Reason for late response"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <b-form-textarea name="late_response_reason" rows="2" :value="vars.object.late_response_reason"
                             maxlength="5000"
                             spellcheck="false">
            </b-form-textarea>
        </b-form-group>

        <div class="hr-radius"></div>
        <h5 class="text-warning">Resolve</h5>
        <b-form-group label="Resolve time (estimate)"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="resolve_time_estimate_ymd" v-model="resolve_time_estimate_ymd"
                             maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="resolve_time_estimate_hm" v-model="resolve_time_estimate_hm"
                             maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>
        <b-form-group label="Resolve time"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <div class="datetime-input-wrap">
                <div class="input-wrap">
                    <b-input type="date" name="resolve_time_ymd" v-model="resolve_time_ymd"
                             maxlength="12"></b-input>
                </div>
                <div class="input-wrap">
                    <b-input type="time" name="resolve_time_hm" v-model="resolve_time_hm"
                             maxlength="8"></b-input>
                </div>
            </div>
        </b-form-group>
        <b-form-group label="Reason for late resolves"
                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                      label-class="text-secondary">
            <b-form-textarea name="late_resolve_reason" rows="2" :value="vars.object.late_resolve_reason"
                             maxlength="5000"
                             spellcheck="false">
            </b-form-textarea>
        </b-form-group>
      <b-form-group label="Last update"
                    label-cols="12" label-cols-md="4" label-cols-xl="3"
                    label-class="text-secondary">
        <b-form-textarea name="last_update" rows="2" :value="vars.object.last_update"
                         maxlength="5000"
                         spellcheck="false">
        </b-form-textarea>
      </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "RequestTimes",
        props: ['vars'],
        data() {
            return {
                active_date: '',
                active_date_ymd: '',
                active_date_hm: '',

                due_by_date_ymd: '',
                due_by_date_hm: '',
                due_by_date: '',

                closed_date: '',
                closed_date_ymd: '',
                closed_date_hm: '',

                response_time_estimate_datetime: '',
                response_time_estimate_ymd: '',
                response_time_estimate_hm: '',

                response_time_datetime: '',
                response_time_ymd: '',
                response_time_hm: '',

                resolve_time_estimate_datetime: '',
                resolve_time_estimate_ymd: '',
                resolve_time_estimate_hm: '',

                resolve_time_datetime: '',
                resolve_time_ymd: '',
                resolve_time_hm: '',
                last_update: ''
            }
        },
        created: function () {
            if (this.vars.object.active_date) {
                this.active_date_ymd = this.$moment(this.vars.object.active_date).format('YYYY-MM-DD') || ''
                this.active_date_hm = this.$moment(this.vars.object.active_date).format('HH:mm') || ''
            }

            if (this.vars.object.due_by_date) {
                this.due_by_date_ymd = this.$moment(this.vars.object.due_by_date).format('YYYY-MM-DD') || ''
                this.due_by_date_hm = this.$moment(this.vars.object.due_by_date).format('HH:mm') || ''
            }

            if (this.vars.object.closed_date) {
                this.closed_date_ymd = this.$moment(this.vars.object.closed_date).format('YYYY-MM-DD') || ''
                this.closed_date_hm = this.$moment(this.vars.object.closed_date).format('HH:mm') || ''
            }

            if (this.vars.object.response_time_estimate_datetime) {
                this.response_time_estimate_ymd = this.$moment(this.vars.object.response_time_estimate_datetime).format('YYYY-MM-DD') || ''
                this.response_time_estimate_hm = this.$moment(this.vars.object.response_time_estimate_datetime).format('HH:mm') || ''
            }

            if (this.vars.object.response_time_datetime) {
                this.response_time_ymd = this.$moment(this.vars.object.response_time_datetime).format('YYYY-MM-DD') || ''
                this.response_time_hm = this.$moment(this.vars.object.response_time_datetime).format('HH:mm') || ''
            }

            if (this.vars.object.resolve_time_estimate_datetime) {
                this.resolve_time_estimate_ymd = this.$moment(this.vars.object.resolve_time_estimate_datetime).format('YYYY-MM-DD') || ''
                this.resolve_time_estimate_hm = this.$moment(this.vars.object.resolve_time_estimate_datetime).format('HH:mm') || ''
            }

            if (this.vars.object.resolve_time_datetime) {
                this.resolve_time_ymd = this.$moment(this.vars.object.resolve_time_datetime).format('YYYY-MM-DD') || ''
                this.resolve_time_hm = this.$moment(this.vars.object.resolve_time_datetime).format('HH:mm') || ''
            }
        }
    }
</script>
