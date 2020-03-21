<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des biens</h3>

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
                  <th>description</th>
                  <th>etat</th>
                  <th>type</th>
                  <th>prix</th>
                  <th>adresse</th>
                  <th>bailleur</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="biens in Biens.data" :key="biens.id">
                  <td>{{biens.details}}</td>
                  <td>{{biens.etat}}</td>
                  <td>{{biens.type}}</td>
                  <td>{{biens.prix}}</td>
                  <td>{{biens.adresse}}</td>
                  <td>{{biens.bailleur}}</td>

                  <td>
                    <a href="#" @click="editModal(biens)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteBiens(biens.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="Biens" @pagination-change-page="getResults"></pagination>
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
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update biens</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateBiens() : createBiens()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.prix"
                  type="text"
                  name="prix"
                  placeholder="prix"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('prix') }"
                />
                <has-error :form="form" field="prix"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.etat"
                  type="text"
                  name="etat"
                  placeholder="etat"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('etat') }"
                />
                <has-error :form="form" field="etat"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.details"
                  type="text"
                  name="details"
                  placeholder="description"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('details') }"
                />
                <has-error :form="form" field="details"></has-error>
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
                <select
                  v-model="form.bailleur"
                  name="bailleur"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bailleur') }"
                >
                  <option value>selectionner un bailleur</option>
                  <option
                    v-for="bailleur in Bailleurs.data"
                    :key="bailleur.nomComplet"
                    :value="bailleur.nomComplet"
                  >{{bailleur.nomComplet}}</option>
                </select>
                <has-error :form="form" field="bailleur"></has-error>
              </div>
              <div class="form-group">
                <select
                  v-model="form.type"
                  name="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value>selectionner un type</option>
                  <option
                    v-for="types in Typebiens.data"
                    :key="types.libelle"
                    :value="types.libelle"
                  >{{types.libelle}}</option>
                </select>
                <has-error :form="form" field="type"></has-error>
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
    this.type();
    this.bailleur();
  },
  data() {
    return {
      editmode: false,
      Biens: {},
      // Create a new form instance
      form: new Form({
        id: "",
        details: "",
        prix: "",
        bailleur: "",
        etat: "",
        adresse: "",
        type: ""
      }),
      Typebiens: {},
      Bailleurs: {}
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/biens?page=" + page).then(response => {
        this.Biens = response.data;
      });
    },
    bailleur(page = 1) {
      axios.get("api/bailleurs?page=" + page).then(response => {
        this.Bailleurs = response.data;
      });
    },
    type(page = 1) {
      axios.get("api/typebiens?page=" + page).then(response => {
        this.Typebiens = response.data;
      });
    },
    updateBiens(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/biens/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "le biens bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(biens) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(biens);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteBiens(id) {
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
            .delete("api/biens/" + id)
            .then(() => {
              Swal.fire("Deleted!", "le biens bien été supprimé.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadbiens() {
      if (this.$gate.isAdminOrAuthor()) {
        axios.get("/api/biens").then(({ data }) => (this.Biens = data));
      }
    },
    createBiens() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/biens")
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "biens a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.loadbiens();
    Fire.$on("AfterCreate", () => {
      this.loadbiens();
    });
    //setInterval(()=>this.loadbiens(),10000)
  }
};
</script>
