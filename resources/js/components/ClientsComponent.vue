<template>
  <div class="conteiner">
    <!-- Modal: modalbien -->
    <div
      class="modal fade"
      id="modaldetailCient"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bien</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th scope="row">nom</th>
                  <td>{{detailClient.nom}}</td>
                </tr>
                <tr>
                  <th scope="row">prenom</th>
                  <td>{{detailClient.prenom}}</td>
                </tr>
                <tr>
                  <th scope="row">adresse</th>
                  <td>{{detailClient.adresse}}</td>
                </tr>
                <tr>
                  <th scope="row">telephone</th>
                  <td>{{detailClient.tel}}</td>
                </tr>
                <tr>
                  <th scope="row">sexe</th>
                  <td>{{detailClient.sexe}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">profession</th>
                  <td>{{detailClient.profession}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">nationalite</th>
                  <td>{{detailClient.nationalite}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">type</th>
                  <td>{{detailClient.libelle}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">réglement</th>
                  <td>{{detailClient.solde}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">entreprise</th>
                  <td>{{detailClient.entreprise}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">commentaire</th>
                  <td>{{detailClient.commentaire}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--Footer-->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal: modalbien -->
    <div class="card collapsed-card card-warning card-outline">
      <div class="card-header border-transparent">
        <h3 class="card-title">
          <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">Client</font>
          </font>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="row mt-5" v-if="$gate.isAdminOrUser()">
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
                <table id="table" class="table table-hover">
                  <thead>
                    <tr>
                      <th>nom</th>
                      <th>prenom</th>
                      <th>adresse</th>
                      <th>telephone</th>
                      <th>profession</th>
                      <th>type</th>

                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="client in clients.data" :key="client.id">
                      <td>{{client.nom}}</td>
                      <td>{{client.prenom}}</td>
                      <td>{{client.adresse}}</td>
                      <td>{{client.tel}}</td>
                      <td>{{client.profession}}</td>
                      <td>{{client.libelle}}</td>
                      <td>
                        <a href="#" @click="editModal(client)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a
                          href="#"
                          @click="deleteclient(client.client_id)"
                        >
                          <i class="fa fa-trash red"></i>
                        </a>
                        /
                        <a href="#" @click="detailclient(client)">
                          <i class="fa fa-eye blue"></i>
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
      </div>
    </div>
    <div>
      <client-paye></client-paye>
    </div>
  <div>
      <client-non-pays></client-non-pays>
    </div>
    
    <div v-if="!$gate.isAdminOrUser()">
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
              <div class="form-group">
                <input
                  v-model="form.entreprise"
                  type="text"
                  name="entreprise"
                  class="form-control"
                  placeholder="entreprise"
                  :class="{ 'is-invalid': form.errors.has('entreprise') }"
                />
                <has-error :form="form" field="entreprise"></has-error>
              </div>
              <div class="form-group">
                <select v-model="form.type" name="type" class="form-control">
                  <option value>type de client</option>
                  <option
                    v-for="typeclient in Typeclient.data"
                    :key="typeclient.typeclients_id"
                    :value="typeclient.typeclients_id"
                  >{{typeclient.libelle}}</option>
                </select>
              </div>
              <div class="form-group">
                <textarea
                  v-model="form.commentaire"
                  name="commentaire"
                  placeholder="commentaire"
                  class="form-control"
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
import ClientsPayeComponent from "./ClientsPayeComponent.vue";
import ClientsNonPayeComponent from "./ClientsNonPayeComponent.vue";

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
    this.type();
  },
  components: {
    "not-found": notFoundComponentVue,
    "client-paye": ClientsPayeComponent,
    "client-non-pays":ClientsNonPayeComponent
  },
  data() {
    return {
      editmode: false,
      clients: {},
      Typeclient: {},
      detailClient: {},
      // Create a new form instance
      form: new Form({
        id: "",
        nom: "",
        prenom: "",
        adresse: "",
        tel: "",
        sexe: "",
        profession: "",
        nationalite: "",
        type: "",
        commentaire: "",
        entreprise: ""
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
    type(page = 1) {
      axios.get("api/typeclients?page=" + page).then(response => {
        this.Typeclient = response.data;
      });
    },
    detailclient(c) {
      $("#modaldetailCient").modal("show");
      this.detailClient = c;
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
          Swal.fire("success!", "le client bien été modifié.", "success");
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
              Swal.fire("success!", "le client bien été supprimé.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadclients() {
      if (this.$gate.isAdminOrUser()) {
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
