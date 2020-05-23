<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdmin()">

        <!-- row responsive table -->
    <section class="container">
      <div class="row mt-5">
        <div class="col-md-12">
          <div class="card card-warning card-outline">
            <div class="card-header">
              <h3 class="card-title">utilisateur</h3>

              <div class="card-tools">
               <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter
              </button>
              </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body table-responsive p-1">
              <table
                id="table"
                class="table table-striped table-bordered"
                style="width:100%"
              >
                <thead>
                  <tr>
                  <th>nom complet</th>
                  <th>Email</th>
                  <th>role</th>
                  <th>action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type | upText}}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /row responsive table -->
    </section>


    
    </div>
    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <select
                  v-model="form.type"
                  id="type"
                  name="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value>selectionner un role</option>
                  <option value="admin">Admin</option>
                  <option value="user">user</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Modifier</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notFoundComponentVue from './notFoundComponent.vue';

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    setTimeout(function() {
      $("#table").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
      });
    }, 2000);

  },
   components: {
  'not-found': notFoundComponentVue
},
  data() {
    return {
      editmode: false,
      users: {},
      // Create a new form instance
      form: new Form({
        id: "",
        name: "",
        email: "",
        type: "",
        password: "",
        photo: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/user?page=" + page).then(response => {
        this.users = response.data;
      });
    },
    updateUser(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/user/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadUsers();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "Your file has been updated.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteUser(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.form
            .delete("api/user/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadUsers() {
      if (this.$gate.isAdmin()) {
        axios.get("/api/user").then(({ data }) => (this.users = data));
      }
    },
    createUser() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/user")
        .then(() => {
          //this will update dom automatically
          //this.loadUsers();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "User created successfully"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findUser?q=" + query)
        .then(data => {
          this.users = data.data;
        })
        .catch(() => {});
    });
    this.loadUsers();
    Fire.$on("AfterCreate", () => {
      this.loadUsers();
    });
    //setInterval(()=>this.loadUsers(),10000)
  }
};
</script>
