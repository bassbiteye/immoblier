<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Responsive Hover Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Add new
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>nom Complet</th>
                  <th>email</th>
                  <th>telephone</th>
                  <th>adresse</th>
                  <th>profession</th>
                  <th>nationalite</th>
                  <th>nombre Bien</th>
                  <th>Boite postale</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="bailleur in bailleurs.data" :key="bailleur.id">
                  <td>{{bailleur.name}}</td>
                  <td>{{bailleur.email}}</td>
                  <td>{{bailleur.telephone}}</td>
                  <td>{{bailleur.adresse}}</td>
                  <td>{{bailleur.profession}}</td>
                  <td>{{bailleur.nationalite}}</td>
                  <td>{{bailleur.nombreBien}}</td>
                  <td>{{bailleur.bp}}</td>

  
                  <td>
                    <a href="#" @click="editModal(bailleur)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteBailleur(bailleur.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="bailleurs" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add new</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update bailleur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateBailleur() : createBailleur()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="nom Complet"
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
                <input
                  v-model="form.telephone"
                  type="number"
                  name="telephone"
                  placeholder="telephone"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('telephone') }"
                />
                <has-error :form="form" field="telephone"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.adresse"
                  type="text"
                  name="adresse"
                  placeholder="adresse"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('adresse') }"
                />
                <has-error :form="form" field="adresse"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.nombreBien"
                  type="number"
                  name="nombreBien"
                  placeholder="nombre de Bien"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('nombreBien') }"
                />
                <has-error :form="form" field="nombreBien"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.profession"
                  type="text"
                  name="profession"
                  placeholder="profession"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('profession') }"
                />
                <has-error :form="form" field="profession"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.nationalite"
                  type="text"
                  name="nationalite"
                  placeholder="nationalite"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('nationalite') }"
                />
                <has-error :form="form" field="nationalite"></has-error>
              </div>
                    <div class="form-group">
                <input
                  v-model="form.bp"
                  type="text"
                  name="bp"
                  placeholder="boite postal"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bp') }"
                />
                <has-error :form="form" field="bp"></has-error>
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
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
  },
  components: {
    "not-found": notFoundComponentVue
  },
  data() {
    return {
      editmode: false,
      bailleurs: {},
      // Create a new form instance
      form: new Form({
        id: "",
        name: "",
        telephone: "",
        adresse: "",
        email: "",
        type: "bailleurs",
        password: "",
        photo: "",
        nombreBien: "",
        profession: "",
        nationalite: "",
        bp: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/bailleurs?page=" + page).then(response => {
        this.bailleurs = response.data;
      });
    },
    updateBailleur(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/bailleurs/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadBailleurs();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "Your file has been updated.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(bailleur) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(bailleur);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteBailleur(id) {
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
            .delete("api/bailleurs/" + id)
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
    loadBailleurs() {
      if (this.$gate.isAdmin()) {
        axios.get("/api/bailleurs").then(({ data }) => (this.bailleurs = data));
      }
    },
    createBailleur() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/bailleurs")
        .then(() => {
          //this will update dom automatically
          //this.loadBailleurs();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "Bailleur created successfully"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.loadBailleurs();
    Fire.$on("AfterCreate", () => {
      this.loadBailleurs();
    });
    //setInterval(()=>this.loadBailleurs(),10000)
  }
};
</script>
