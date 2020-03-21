<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des clients</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>nom</th>
                  <th>prenom</th>
                  <th>adresse</th>
                  <th>telephone</th>
                  <th>sexe</th>
                  <th>profession</th>
                  <th>nationalité</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="client in clients.data" :key="client.id">
                  <td>{{client.nom}}</td>
                  <td>{{client.prenom}}</td>
                  <td>{{client.adresse}}</td>
                  <td>{{client.tel}}</td>
                  <td>{{client.sexe}}</td>
                  <td>{{client.profession}}</td>
                  <td>{{client.nationalite}}</td>
                  <td>
                    <a href="#" @click="editModal(client)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteclient(client.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="clients" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div v-if="!$gate.isAdminOrAuthor()">
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
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update client</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateclient() : createclient()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.nom"
                  type="text"
                  name="nom"
                  placeholder="nom"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('nom') }"
                />
                <has-error :form="form" field="nom"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.prenom"
                  type="text"
                  name="prenom"
                  placeholder="prenom"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('prenom') }"
                />
                <has-error :form="form" field="prenom"></has-error>
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
                  v-model="form.tel"
                  type="number"
                  name="tel"
                  placeholder="telephone"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('tel') }"
                />
                <has-error :form="form" field="tel"></has-error>
              </div>
                 <div class="form-group">
                <select
                  v-model="form.sexe"
                  id="type"
                  name="sexe"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('sexe') }"
                >
                  <option value>selectionner un sexe</option>
                  <option value="masculin">masculin</option>
                  <option value="féminin">féminin</option>
                </select>
                <has-error :form="form" field="sexe"></has-error>
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
                  class="form-control"
                  placeholder="nationalité"
                  :class="{ 'is-invalid': form.errors.has('nationalite') }"
                />
                <has-error :form="form" field="nationalite"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
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
export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
  },
  data() {
    return {
      editmode: false,
      clients: {},
      // Create a new form instance
      form: new Form({
        id: "",
        nom: "",
        prenom: "",
        adresse: "",
        tel: "",
        sexe: "",
        profession: "",
        nationalite: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/clients?page=" + page).then(response => {
        this.clients = response.data;
      });
    },
    updateclient(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/clients/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadclients();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "le client bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(client) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(client);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteclient(id) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.form
            .delete("api/clients/" + id)
            .then(() => {
              Swal.fire("Deleted!", "le client bien été supprimé.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadclients() {
      if (this.$gate.isAdminOrAuthor()) {
        axios.get("/api/clients").then(({ data }) => (this.clients = data));
      }
    },
    createclient() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/clients")
        .then(() => {
          //this will update dom automatically
          //this.loadclients();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "client a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.loadclients();
    Fire.$on("AfterCreate", () => {
      this.loadclients();
    });
    //setInterval(()=>this.loadclients(),10000)
  }
};
</script>
