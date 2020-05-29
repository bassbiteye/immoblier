<template>
  <div class="conteiner">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des types clients</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="table" class="table table-hover">
              <thead>
                <tr>
                  <th>locataire</th>
                  <th>bien</th>
                  <th>ref</th>
                  <th>montant</th>
                  <th>adresse</th>
                  <th>commentaire</th>
                  <th>fichier</th>
                  <!-- <th>action</th> -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="divers in divers.data" :key="divers.typeclient_id">
                  <td>{{divers.nom}} {{divers.prenom}}</td>
                  <td>{{divers.details}}</td>
                  <td>{{divers.ref}}</td>
                  <td>{{divers.montantPaye}}</td>
                  <td>{{divers.adresse}}</td>
                  <td>{{divers.comentaire}}</td>
                  <td class="btn btn-success" @click="telecharger(divers.fichier)">fichier</td>

                  <!-- <td>
                    <a href="#" @click="editModal(divers)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                  </td>-->
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="divers" @pagination-change-page="getResults"></pagination>
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">ajouter</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier divers</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updatedivers() : createdivers()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.ref"
                  type="text"
                  name="ref"
                  placeholder="reference lacation"
                  class="form-control"
                  @keyup="findOperation"
                  :class="{ 'is-invalid': form.errors.has('ref') }"
                />
                <has-error :form="form" field="details"></has-error>
              </div>
              <div>
              <div class="row" v-if="showLoc">
                <div class="col-md-4">
                  <label for>locataire: {{locataire}}</label>
                </div>
                <div class="col-md-4">
                  <label for>Bien: {{bien}}</label>
                </div>
                <div class="col-md-4">
                  <label v-if="montantPaye">montant: {{montantPaye}}</label>
                </div>
              </div>
              <div v-else-if="locataire==null"></div>
              </div>  
              <div class="form-group"  v-if="showLoc">
                <label class="form-control-label">Fichier</label>
                <input
                  type="file"
                  class="form-control"
                  @change="updateFichier"
                  name="fichier"
                  :class="{ 'is-invalid': form.errors.has('fichier') }"
                />
                <has-error :form="form" field="fichier"></has-error>
              </div>
              <div class="form-group" v-if="showLoc">
                <textarea
                  v-model="form.commentaire"
                  type="text"
                  name="commentaire"
                  placeholder="commentaire"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('commentaire') }"
                ></textarea>
                <has-error :form="form" field="commentaire"></has-error>
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
import notFoundComponentVue from "./notFoundComponent.vue";
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
    "not-found": notFoundComponentVue
  },
  data() {
    return {
      editmode: false,
      divers: {},
      montantPaye: {},
      showLoc:false,
      bien: {},
      locataire: {},
      d: {},
      // Create a new form instance
      form: new Form({
        id: "",
        commentaire: "",
        fichier: "",
        operations: ""
      }),
      fichier: ""
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/divers?page=" + page).then(response => {
        this.divers = response.data;
      });
    },
    updatedivers(id) {
      this.$Progress.start();
      // Submit the form via a POST request
   
      this.form
        .put("/api/divers/" + this.form.id)
        .then(() => {
          //this will update dom automatically
          //this.loaddivers();
          $("#addNew").modal("hide");
          Swal.fire("Deleted!", "le divers bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(divers) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(divers);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    telecharger(e) {
      window.open("img/profile/" + e);
    },
    updateFichier(e) {
      console.log(e);
      this.fichier = e.target.files[0];

      this.ext_image2 = [
        "image/jpeg",
        "application/pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "image/png",
        "application/vnd.oasis.opendocument.text"
      ];

      if (this.ext_image2.indexOf(this.fichier.type) < 0) {
        Swal.fire({
          type: "error",
          title: "Oops...",
          text:
            "Vous devez choisir soit fichier pdf, soit un fichier word, soit une image "
        });
        document.getElementById("derniereleve").value = "";
        return;
      }
    },
    loaddivers() {
      if (this.$gate.isAdmin()) {
        axios.get("/api/divers").then(({ data }) => (this.divers = data));
      }
    },
    findOperation() {
      this.form.post("/api/findoperation").then(response => {
        let operation = response.data.data;
        for (let i = 0; i < operation.length; i++) {
          this.montantPaye = operation[i].montantPaye;
          this.bien = operation[i].details;
          this.locataire = operation[i].nom;
          this.form.operations = operation[i].operation_id;
                  this.showLoc=true

        }
      });
    },
    createdivers() {
      this.$Progress.start();
      // Submit the form via a POST request
         var fichier = new FormData();
      fichier.append("id", this.form.id);
      fichier.append("fichier", this.fichier);
      fichier.append("commentaire", this.form.commentaire);
      fichier.append("operations", this.form.operations);

      axios
        .post("/api/adddivers",fichier)
        .then(() => {
          //this will update dom automatically
          //this.loaddivers();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "divers a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.loaddivers();
    Fire.$on("AfterCreate", () => {
      this.loaddivers();
    });
    //setInterval(()=>this.loaddivers(),10000)
  }
};
</script>
