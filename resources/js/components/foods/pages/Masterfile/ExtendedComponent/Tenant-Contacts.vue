<template>
    <div class="space-y-2">
        <div class="flex justify-end">
            <Tooltip content="Add Contacts" placement="left">
                <Button @click="addContact" type="primary" icon="md-add"
                    >Add</Button
                >
            </Tooltip>
        </div>
        <div class="border rounded">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="p-2 text-left">Contact Type</th>
                        <th class="p-2 text-left">Contact Number</th>
                        <th class="p-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody border-t">
                    <tr class="tr" v-if="!Contacts.length">
                        <td class="p-2 text-center" colspan="3">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr
                        class="tr"
                        v-for="(contact, index) in Contacts"
                        :key="index"
                    >
                        <td class="p-2 text-left">
                            {{ contact.contact_type }}
                        </td>
                        <td class="p-2 text-left">{{ contact.contact_num }}</td>
                        <td class="p-2 text-center">
                            <Tooltip content="Delete" placement="bottom">
                                <Button
                                    @click="removeContact(contact.id)"
                                    size="small"
                                    type="error"
                                    shape="circle"
                                    icon="ios-trash"
                                />
                            </Tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Modal
            v-model="modal"
            width="500"
            ok-text="Save"
            footer-hide
            :closable="false"
            class-name="vertical-center-modal"
        >
            <div class="text-left mb-5">
                <span class="font-semibold capitalize text-[16px]">{{
                    tenantName
                }}</span>
            </div>
            <Form label-position="left" :label-width="100">
                <FormItem label="Category">
                    <Select
                        v-model="form.contact_type"
                        placeholder="Please select a contact type"
                    >
                        <Option value>Select a contact type</Option>
                        <Option value="Telephone Number"
                            >Telephone Number</Option
                        >
                        <Option value="Mobile Number">Mobile Number</Option>
                    </Select>
                    <Error
                        :message="errors.contact_type[0]"
                        v-if="errors.contact_type"
                    />
                </FormItem>
                <FormItem label="Contact #">
                    <Input
                        v-model="form.contact_num"
                        maxlength="11"
                        show-word-limit
                        placeholder="Enter number"
                    />
                    <Error
                        :message="errors.contact_num[0]"
                        v-if="errors.contact_num"
                    />
                </FormItem>
            </Form>
            <div class="text-right mt-5">
                <Button @click="close">Cancel</Button>
                <Button @click="save" type="primary">Save</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
export default {
    props: ["tenantId", "tenantName"],
    data() {
        return {
            modal: false,
            form: {
                contact_type: "",
                contact_num: ""
            }
        };
    },
    computed: {
        ...mapState(["errors"]),
        ...mapState("Tenant", ["Contacts"])
    },
    watch: {
        tenantId() {
            this.getContacts({ id: this.tenantId });
        }
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions("Tenant", [
            "getContacts",
            "saveContact",
            "deleteContact"
        ]),
        removeContact(id) {
            this.$Modal.confirm({
                title: "Delete Contact",
                content: "<p>Do you want to delete this contact?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.deleteContact({
                        id: id
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        addContact() {
            this.reset();
            this.modal = !this.modal;
        },
        save() {
            this.saveContact({
                tenant_id: this.tenantId,
                contact_type: this.form.contact_type,
                contact_num: this.form.contact_num
            });
        },
        reset() {
            (this.form.contact_type = ""), (this.form.contact_num = "");
            this.CLEAR_ERRORS();
        },
        close() {
            this.modal = false;
        }
    },
    mounted() {
        Fire.$on("reload_foods_contacts", () => {
            this.getContacts({ id: this.tenantId });
            this.modal = false;
        });
    }
};
</script>
