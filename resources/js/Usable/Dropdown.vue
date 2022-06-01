<template>
    <Dropdown>
        <Button type="primary">
            Welcome
            <Icon type="ios-arrow-down"></Icon>
        </Button>
        <DropdownMenu slot="list">
            <DropdownItem>
                <Button
                    to="/change_username"
                    type="info"
                    icon="ios-contact-outline"
                    style="width: 100%"
                >
                    Change Username</Button
                >
            </DropdownItem>
            <DropdownItem>
                <Button
                    to="/change_password"
                    type="info"
                    icon="ios-key-outline"
                    style="width: 100%"
                >
                    Change Password</Button
                >
            </DropdownItem>
            <DropdownItem divided>
                <Button
                    type="info"
                    icon="ios-call-outline"
                    style="width: 100%"
                    to="/contact_us"
                    >Contact Us</Button
                >
            </DropdownItem>
            <DropdownItem divided>
                <Button
                    type="error"
                    icon="ios-log-out"
                    style="width: 100%"
                    @click="logout"
                    >Logout</Button
                >
            </DropdownItem>
        </DropdownMenu>
    </Dropdown>
</template>

<script>
export default {
    methods: {
        logout() {
            let form = document.getElementById("logout-form");
            form.submit();
        }
    }
};
</script>
