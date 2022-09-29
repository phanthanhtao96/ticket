<template>
    <div class="mt-3">
        <b-card no-body class="shadow-2 mt-2" v-for="reply in replies" :key="reply.id">
            <b-card-body>
                <b-row>
                    <b-col cols="12" sm="4" md="3" lg="2" class="reply-border mt-2 text-center">
                        <b-avatar :variant="reply.replier_type === 'User' ? 'primary' : 'secondary'" size="lg"></b-avatar>
                        <div class="w-100 mt-2 mb-2">
                            <a href="">{{reply.replier_name}}</a>
                            <p class="small text-muted mb-1">{{$moment(reply.created_at).format('HH:mm DD/MM/YYYY')}}</p>
                            <p v-if="reply.sent_mail || reply.send_mail_internal" v-b-tooltip.hover title="Sent email to customer" class="mb-1">
                                <b-icon icon="envelope"></b-icon>
                            </p>
                        </div>
                    </b-col>
                    <b-col cols="12" sm="8" md="9" lg="10" class="mt-2">
                        <div class="w-100" v-html="reply.content">
                        </div>
                        <div class="w-100 mt-3">
                            <a :href="attachment.url" target="_blank" class="attachment-box"
                               v-for="attachment in reply.attachments" :id="attachment.id">
                                <i class="fa fa-file mr-1" aria-hidden="true"></i> {{attachment.name}}
                            </a>
                        </div>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
        <b-form>
            <b-card no-body class="shadow-2 mt-3">
                <template #header>
                    <h2 class="mb-0">Message</h2>
                </template>
                <b-card-body>
                    <b-row>
                        <b-col cols="12">
                            <textarea class="content" name="post_content" spellcheck="false" required></textarea>
                        </b-col>
                        <b-col cols="12" class="mt-3" v-if="attachments.length > 0">
                            <div class="sbd-table sbd-table-light">
                                <div class="sbd-row" v-for="attachment in attachments">
                                    <div class="cell">{{attachment.name}}</div>
                                    <div class="cell cw-50">
                                    </div>
                                </div>
                            </div>
                        </b-col>
                        <b-col cols="6" class="text-left mt-3">
                            <b-button type="button" v-on:click="attachment_modal =! attachment_modal" variant="info"
                                      class="">
                                <b-icon icon="paperclip"></b-icon>
                                Attachment
                            </b-button>
                        </b-col>
                        <b-col cols="6" class="text-right mt-3">
                            <div v-if="vars.type === 'Request'" class="custom-control custom-switch mr-2"
                                 style="display: inline; vertical-align: middle">
                                <input type="checkbox" class="custom-control-input" id="disableSwitch" name="sent_mail"
                                       v-model="sent_mail" value="1">
                                <label class="custom-control-label" for="disableSwitch">Sent mail to customer</label>
                            </div>
                          <div v-if="vars.type === 'Request'" class="custom-control custom-switch mr-2"
                               style="display: inline; vertical-align: middle">
                            <input type="checkbox" class="custom-control-input" id="disableSwitchV1" name="send_mail_internal"
                                   v-model="send_mail_internal" value="1">
                            <label class="custom-control-label" for="disableSwitchV1">Sent mail to internal</label>
                          </div>
                            <b-button type="button" v-on:click="post_reply()" variant="primary"
                                      :disabled="in_process" class="main-button">
                                <b-icon icon="chat-right-fill" class="mr-1"></b-icon>
                                Reply
                            </b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>
        <!-- Attachment form -->
        <b-modal v-model="attachment_modal" :centered="true" title="Attachment">
            <input type="file" id="file" ref="file" v-on:change="handle_file_upload()"/>
            <template v-slot:modal-footer>
                <div class="w-100">
                    <b-button variant="primary" size="sm" class="float-right" :disabled="in_process"
                              v-on:click="submit_file()">Add
                    </b-button>
                </div>
            </template>
        </b-modal>
        <!---->
    </div>
</template>

<script>
    export default {
        name: "RequestReplies",
        props: ['vars'],
        data() {
            return {
                object: this.vars.object || null,
                replies: [],
                message: '',
                sent_mail: 0,
                send_mail_internal: 0,
                technical_id: 0,
                attachment_modal: false,
                file: '',
                attachments: []
            }
        },
        created: function () {
            this.get_replies()
        },
        methods: {
            get_replies: function () {
                this.get_data('/replies/' + this.vars.type + '/' + this.vars.id, true)
                    .then(response => {
                        if (typeof response === 'object') {
                            this.replies = response
                        }
                    })
                    .catch(reason => this.errors.push(reason.message))

            },
            post_reply: function () {
                if (this.object.status === 'OnHold') {
                    this.make_toast('danger', 'Failed', 'Can not reply')
                } else {
                    this.message = document.getElementsByClassName('richText-editor')[0].innerHTML
                    let data = {
                        type: this.vars.type,
                        id: this.vars.object.id,
                        name: this.vars.object.name || '',
                        message: this.message,
                        sent_mail: this.sent_mail,
                        send_mail_internal: this.send_mail_internal,
                        customer_email: this.vars.object.client_email || '',
                        technical_id: this.vars.object.technician_id || '',
                        attachments: this.attachments
                    }
                    this.post_data('/replies', data)
                        .then((response) => {
                            if (typeof response !== 'object') {
                                this.make_toast('danger', 'Failed', 'An unknown error has occurred')
                            } else {
                                if (response.status !== true)
                                    this.make_toast('danger', 'Failed', response.message)
                                else {
                                    this.make_toast('success', 'Success', response.message)
                                    this.get_replies(true)
                                    document.getElementsByClassName('richText-editor')[0].innerHTML = ''
                                    this.message = ''
                                    this.sent_mail = 0
                                    this.attachments = []
                                }
                            }
                        })
                        .catch(reason => this.errors.push(reason.message))
                }
            },
            handle_file_upload: function () {
                this.file = this.$refs.file.files[0]
            },
            submit_file: function () {
                let form_data = new FormData()
                form_data.append('file', this.file)
                this.post_data('/attachments/upload',
                    form_data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((response) => {
                    if (typeof response !== 'object') {
                        this.make_toast('danger', 'Failed', 'An unknown error has occurred')
                    } else {
                        if (response.status !== true)
                            this.make_toast('danger', 'Failed', response.message)
                        else {
                            this.attachments.push({name: response.name, url: response.url})
                            this.attachment_modal = false
                        }
                    }
                }).catch(reason => this.errors.push(reason.message))
            }
        }
    }
</script>
