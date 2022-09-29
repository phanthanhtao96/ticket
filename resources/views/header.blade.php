<b-navbar toggleable="lg" type="dark" class="top-bar">
    <b-navbar-brand href="/">
        <b-aspect aspect="1:1" class="logo-header">
            <img src="/images/sbd.svg">
        </b-aspect>
    </b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item href="/">{{__('admin.dashboard')}}</b-nav-item>
            <b-nav-item href="/requests/list">{{__('admin.requests')}}</b-nav-item>
            <b-nav-item href="/problems/list">{{__('admin.problems')}}</b-nav-item>
            <b-nav-item href="/solutions/list">{{__('admin.knowledge')}}</b-nav-item>
            <b-nav-item href="/changes/list">{{__('admin.changes')}}</b-nav-item>
            <b-nav-item href="/report">{{__('admin.report')}}</b-nav-item>
            <b-nav-item href="/customers/list">{{__('admin.customers')}}</b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
            <b-nav-item>
                <right-sidebar :vars="{{json_encode(['id' => Auth::user()->id])}}"></right-sidebar>
            </b-nav-item>
            <b-nav-item-dropdown right>
                <template #button-content>
                    {{__('admin.users')}}
                </template>
                <b-dropdown-item href="/users/list">{{__('admin.user_list')}}</b-dropdown-item>
                <b-dropdown-item href="/users/user/0">{{__('admin.add_new_user')}}</b-dropdown-item>
            </b-nav-item-dropdown>
            <b-nav-item-dropdown right>
                <template #button-content>
                    <b-icon icon="person-square"></b-icon>
                </template>
                <b-dropdown-item href="/users/user/{{Auth::user()->id}}">{{__('admin.profile')}}</b-dropdown-item>
                <b-dropdown-item href="/logout">{{__('admin.sign_out')}}</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
    </b-collapse>
</b-navbar>