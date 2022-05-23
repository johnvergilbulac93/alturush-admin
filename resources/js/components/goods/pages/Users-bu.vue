<template>
  <div class="container-fluid">
    <div class="row" v-if="$gate.isAdmin()">
      <div class="col-md-12 float-right">
        <button
          type="button"
          class="btn btn-success btn-sm float-right"
          value="Add User"
          @click="showAddUserModal()"
        >
          <i class="fas fa-user-plus"></i> Add User
        </button>
      </div>
      <div class="col-md-12 mt-2">
        <div class="card">
          <!-- /.card-header -->
          <div class="col-md-12 my-2">
            <div class="table-responsive">
              <table class="table table-sm table-hover table-bordered" id="userTable">
                <thead class="font-weight-lighter">
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, i) in getList" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.username }}</td>
                    <td class="text-center" style="width: 120px">
                      <Button
                        icon="md-eye"
                        type="info"
                        shape="circle"
                        @click="viewUser(user, i)"
                      ></Button>
                      <Button
                        icon="md-create"
                        type="success"
                        shape="circle"
                        @click="editUser(user, i)"
                      ></Button>
                      <Button
                        icon="md-trash"
                        type="error"
                        shape="circle"
                        @click="deleteUser(user.id, i)"
                      ></Button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>

    <div v-if="!$gate.isAdmin()">
      <page404></page404>
    </div>
    <!-- modal user view-->
    <div
      class="modal fade"
      id="user_view"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="user_view">
              <h4 class="lead"><i class="nav-icon fas fa-user">&nbsp;</i>View User</h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="">
            <div class="modal-body">
              <table class="table table-bordered" id="userTable">
                <tbody>
                  <tr>
                    <td style="width: 150px" class="text-bold">ID:</td>
                    <td>{{ form.id }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Name</td>
                    <td>{{ form.name }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Username</td>
                    <td>{{ form.username }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                value="Close"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal user view-->

    <!-- modal user edit-->
    <div
      class="modal fade"
      id="user_edit"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="user_edit">
              <h4 v-show="editMode" class="lead">
                <i class="nav-icon fas fa-user">&nbsp;</i>Edit User
              </h4>
              <h4 v-show="!editMode" class="lead">
                <i class="nav-icon fas fa-user">&nbsp;</i>Add User
              </h4>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form v-on:submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td class="text-bold">Name</td>
                    <td>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="form.name"
                        name="name"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Username</td>
                    <td>
                      <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="form.username"
                        name="username"
                      />
                      <has-error :form="form" field="username"></has-error>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">User Type</td>
                    <td>
                      <Select
                        v-model="form.usertype"
                        filterable
                        clearable
                        placeholder="Please select picker"
                        not-found-text="User Type Not Found"
                      >
                        <Option v-for="(type, i) in types" :value="type.id" :key="i">{{
                          type.usertype
                        }}</Option>
                      </Select>
                      <has-error :form="form" field="usertype"></has-error>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Employees Id</td>
                    <td>
                      <Select
                        v-model="form.employee"
                        filterable
                        clearable
                        placeholder="Select Employee"
                        not-found-text="Employee Not Found"
                      >
                        <Option
                          v-for="(emp, i) in getListEmp"
                          :value="emp.emp_id"
                          :key="i"
                          >{{ emp.name }}</Option
                        >
                      </Select>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-bold">Password</td>
                    <td>
                      <input
                        type="password"
                        class="form-control form-control-sm"
                        v-model="form.password"
                      />
                      <has-error :form="form" field="password"></has-error>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="modal-footer">
              <input
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                value="Close"
              />
              <button v-show="editMode" type="submit" class="btn btn-primary btn-sm">
                Submit
              </button>
              <button v-show="!editMode" type="submit" class="btn btn-primary btn-sm">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal user edit-->
  </div>
</template>

<script>
import Form from "vform";

export default {
  data() {
    return {
      editMode: false,
      users: [],
      types: [],
      searchUser: "",
      employees: [],
      loading: true,

      form: new Form({
        id: "",
        name: "",
        username: "",
        usertype: "",
        password: "",
        employee: "",
        business_unit: "",
        date_register: "",
      }),
      index: -1,
    };
  },
  computed: {
    getList() {
      return this.users;
    },
    getListEmp() {
      return this.employees;
    },
  },
  methods: {
    deleteUser(id, index) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form
              .delete("api/delete_user/" + id)
              .then(() => {
                this.users.splice(index, 1);
                swal.fire("User Deleted!", "Successfully.", "success");
              })
              .catch(() => {
                swal.fire({
                  icon: "warning",
                  title: "Oops...",
                  text: "Something went wrong!",
                });
              });
          }
        });
    },
    showAddUserModal() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#user_edit").modal("show");
    },
    createUser() {
      this.form
        .post("api/add_user")
        .then((res) => {
          $("#user_edit").modal("hide");
          swal.fire("User Added!", "Successfully.", "success");
          Fire.$emit("refresh_users");
        })
        .catch(() => {});
    },
    updateUser() {
      this.form.put("api/edit_user/" + this.form.id).then(() => {
        // var _this = this;
        // _this.users[this.index].name = this.form.name;
        // _this.users[this.index].username = this.form.username;
        // _this.users[this.index].user_type = this.form.usertype;
        $("#user_edit").modal("hide");
        swal.fire("User successfully", "Updated", "success");
        Fire.$emit("refresh_users");
      });
    },
    getUsertype() {
      axios.get("api/usertypeAdmin").then((response) => {
        this.types = response.data;
      });
    },
    editUser(user, i) {
      let obj = {
        id: user.id,
        name: user.name,
        username: user.username,
        usertype: user.usertype_id,
        employee: user.emp_id,
      };
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      this.form.fill(obj);
      $("#user_edit").modal("show");
      this.index = i;
    },
    viewUser(user, i) {
      this.form.id = user.id;
      this.form.name = user.name;
      this.form.username = user.username;
      this.form.usertype = user.usertype_id;
      // this.form.date_register = user.created_at;
      $("#user_view").modal("show");
    },
    async getUsers() {
      const { data } = await axios.get("api/userAdmin");
      this.users = data;

      setTimeout(function () {
        $("#userTable").DataTable();
      }, 100);
    },
    getEmployees() {
      axios.get("api/employee").then((response) => {
        this.employees = response.data;
      });
    },
  },
  mounted() {
    this.getUsers();
    this.getUsertype();
    this.getEmployees();
    Fire.$on("refresh_users", () => {
      this.getUsers();
    });
  },
};
</script>
