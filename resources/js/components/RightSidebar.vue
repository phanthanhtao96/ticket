<template>
    <div>
        <div class="notification-icon" v-b-toggle.sidebar-right>
            <b-icon icon="bell-fill"></b-icon>
            <span class="notification-dot" v-if="notification_count > 0">
                {{notification_count < 5 ? notification_count : '5+'}}
            </span>
        </div>
        <b-sidebar id="sidebar-right" title="" right shadow>
            <div class="px-3 py-2">
                <b-button v-if="notification_count > 1" variant="light" v-on:click="mark_as_read" class="w-100 mb-2">
                    Mark as read
                </b-button>
                <ul class="list-unstyled">
                    <b-media tag="li" v-for="notification in notifications" :key="notification.id"
                             class="mb-2 notify-li"
                             v-on:click="received_notification(notification.id, notification.url)">
                        <template #aside>
                            <b-avatar variant="primary" icon="bell-fill" class="align-center" size="3em"></b-avatar>
                        </template>
                        <p class="mb-0"
                           v-html="'<span class=\'small\'>' + $moment(notification.created_at).format('HH:mm DD/MM/YYYY') +'</span> - '+ notification.description">
                        </p>
                    </b-media>
                </ul>
            </div>
        </b-sidebar>
    </div>
</template>

<script>
    export default {
        name: "RightSidebar",
        props: ['vars'],
        data() {
            return {
                notifications: [],
                notification_count: 0,
                socket: null
            }
        },
        created: function () {
            this.get_new_notifications()
            this.socket = io(this.socket_host)
        },
        mounted: function () {
            this.socket.on('data', (data) => {
                let id = this.vars.id.toString()
                if (typeof data === 'object' && data.key === 'Notification' && data.value.includes(id)) {
                    this.get_new_notifications()
                }
            })
        },
        methods: {
            get_new_notifications: function () {
                this.get_data('/notifications/new-json', true)
                    .then(response => {
                        if (typeof response === 'object') {
                            this.notifications = response
                            this.notification_count = this.notifications.length
                        }
                    })
                    .catch(reason => this.errors.push(reason.message))
            },
            received_notification: function (id, url) {
                let data = {notify_id: id}
                this.post_data('/notifications/received', data)
                    .then(response => {
                        if (typeof response === 'object') {
                            if (response.status === true) {
                                window.location.href = url
                            }
                            else {
                                this.make_toast('danger', 'Failed', response.message)
                            }
                        }
                    })
                    .catch(reason => this.make_toast('danger', 'Failed', reason.message))
            },
            mark_as_read: function () {
                this.get_data('/notifications/mark-as-read', true)
                    .then(response => {
                        if (typeof response === 'object') {
                            this.notifications = []
                            this.notification_count = 0
                        }
                    })
                    .catch(reason => this.errors.push(reason.message))
            }
        }
    }
</script>