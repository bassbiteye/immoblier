<template>
  <div class="conteiner">
    <!-- bien -->
    <div>
      <form @submit.prevent="editbien ? updateBiens() : createBiens()">
        <div class="card collapsed-card card-warning card-outline">
          <div class="card-header border-transparent">
            <h3 class="card-title">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Biens</font>
              </font>
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Prix</label>
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
                <!-- /.form-group -->
                <div class="form-group">
                  <label>etat</label>
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
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>description</label>
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
                <!-- /.form-group -->
                <div class="form-group">
                  <label>adresse</label>
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
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>type de bien</label>
                  <select
                    v-model="form.typebien_id"
                    name="typebien_id"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('typebien_id') }"
                  >
                    <option value>selectionner un type</option>
                    <option
                      v-for="types in Typebiens.data"
                      :key="types.libelle"
                      :value="types.typebien_id"
                    >{{types.libelle}}</option>
                  </select>
                  <has-error :form="form" field="typebien_id"></has-error>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Propriétaire</label>
                  <select
                    v-model="form.bailleur"
                    name="bailleur"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('bailleur') }"
                  >
                    <option value="1">alawa</option>
                    <option v-for="b in Bailleurs.data" :key="b.name" :value="b.id">{{b.name}}</option>
                  </select>
                  <has-error :form="form" field="bailleur"></has-error>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
     
        </div>
        <!-- /.card -->

        <!-- /.card -->
        <button v-if="editbien" type="submit" class="btn btn-success">Modifier</button>
        <button v-if="!editbien" type="submit" class="btn btn-primary">Ajouter</button>
      </form>
    </div>
    <div class="row mt-5" v-if="$gate.isAdminOrBailleurs()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des biens</h3>

            <div class="card-tools">
              <!-- <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter Equipement
              </button>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="table" class="table table-hover">
              <thead>
                <tr>
                  <th>Propriétaire</th>
                  <th>etat</th>
                  <th>type</th>
                  <th>Valeur</th>
                  <th>adresse</th>
                  <th>description</th>
                  <th>action</th>
                  <th>Etat des lieux</th>
                  <th>Equipement</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="biens in Biens.data" :key="biens.id">
                  <td>{{biens.name}}</td>
                  <td>{{biens.etat}}</td>
                  <td>{{biens.libelle}}</td>
                  <td>{{biens.prix}}</td>
                  <td>{{biens.adresse}}</td>
                  <td>{{biens.details}}</td>

                  <td>
                    <a href="#" @click="editBien(biens)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteBiens(biens.bien_id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                  <td>
                    <button class="btn btn-success" @click="newModalEtat(biens.bien_id)">
                      <i class="fas fa-user-plus fa fw"></i> Ajouter
                    </button>
                    <button class="btn btn-primary" @click="DetailEtat(biens.bien_id)">
                      <i class="fas fa-snowflake"></i> lister
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-success" @click="newModal(biens.bien_id)">
                      <i class="fas fa-user-plus fa fw"></i> Ajouter
                    </button>
                    <button class="btn btn-primary" @click="Detail(biens.bien_id)">
                      <i class="fas fa-snowflake"></i> lister
                    </button>
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
    <div v-if="!$gate.isAdminOrBailleurs()">
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
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateEquip() : createEquip()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="formE.typeEquipement"
                  type="text"
                  name="typeEquipement"
                  placeholder="type Equipement"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('typeEquipement') }"
                />
                <has-error :form="formE" field="typeEquipement"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="formE.nombre"
                  type="number"
                  name="nombre"
                  placeholder="nombre"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('nombre') }"
                />
                <has-error :form="formE" field="nombre"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="formE.etatEquipement"
                  type="text"
                  name="etatEquipement"
                  placeholder="etat Equipement"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('etatEquipement') }"
                />
                <has-error :form="formE" field="etatEquipement"></has-error>
              </div>
              <div class="form-group">
                <textarea
                  v-model="formE.commentaire"
                  type="text"
                  name="commentaire"
                  placeholder="commentaire"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('commentaire') }"
                ></textarea>
                <has-error :form="formE" field="commentaire"></has-error>
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
    <!-- Modal -->
    <div
      class="modal fade"
      id="detailModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLabel">liste des équipements</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" v-if="!Emode">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>type</th>
                    <th>nombre</th>
                    <th>etat</th>
                    <th>commentaire</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="e in Equipement" :key="e.id">
                    <td>{{e.typeEquipement}}</td>
                    <td>{{e.nombreEquipement}}</td>
                    <td>{{e.etatEquipement}}</td>
                    <td>{{e.commentaireEquipement}}</td>

                    <td>
                      <a href="#" @click="Eform(e)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteEquip(e)">
                        <i class="fa fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div v-if="Emode">
              <form @submit.prevent="updateEquip()">
                <div class="modal-body">
                  <div class="form-group">
                    <input
                      v-model="formEquip.typeEquipement"
                      type="text"
                      name="typeEquipement"
                      placeholder="type Equipement"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('typeEquipement') }"
                    />
                    <has-error :form="formEquip" field="typeEquipement"></has-error>
                  </div>
                  <div class="form-group">
                    <input
                      v-model="formEquip.nombreEquipement"
                      type="number"
                      name="nombreEquipement"
                      placeholder="nombre"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('nombreEquipement') }"
                    />
                    <has-error :form="formEquip" field="nombreEquipement"></has-error>
                  </div>
                  <div class="form-group">
                    <input
                      v-model="formEquip.etatEquipement"
                      type="text"
                      name="etatEquipement"
                      placeholder="etat Equipement"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('etatEquipement') }"
                    />
                    <has-error :form="formEquip" field="etatEquipement"></has-error>
                  </div>
                  <div class="form-group">
                    <textarea
                      v-model="formEquip.commentaireEquipement"
                      type="text"
                      name="commentaireEquipement"
                      placeholder="commentaire"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('commentaireEquipement') }"
                    ></textarea>
                    <has-error :form="formEquip" field="commentaireEquipement"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Modifier</button>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div
        class="modal fade"
        id="detailModalEtat"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNewLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addNewLabel">les etats des lieux</h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" v-if="!Etatmode">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>type</th>
                      <th>nombre</th>
                      <th>etat</th>
                      <th>commentaire</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="etat in Etat" :key="etat.id">
                      <td>{{etat.typetatetatquipetatmetatnt}}</td>
                      <td>{{etat.nombretatetatquipetatmetatnt}}</td>
                      <td>{{etat.etattatetatquipetatmetatnt}}</td>
                      <td>{{etat.commentaireEquipement}}</td>

                      <td>
                        <a href="#" @click="Etatform(etat)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteEtat(etat)">
                          <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div v-if="Etatmode">
                <form @submit.prevent="updateEtat()">
                  <div class="modal-body">
             
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Modifier</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div
        class="modal fade"
        id="addNewEtat"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNewLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode" id="addNewLabel">ajouter</h5>
              <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="createEtat()">
              <div class="modal-body"> 
                <div class="form-group">
                  <label>etat</label>
                  <input
                    v-model="formEtat.etatLieux"
                    type="text"
                    name="etatLieux"
                    placeholder="etat du Lieux"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>murs</label>
                  <input
                    v-model="formEtat.murs"
                    type="text"
                    name="murs"
                    placeholder="murs"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>sols</label>
                  <input
                    v-model="formEtat.sols"
                    type="text"
                    name="sols"
                    placeholder="sols"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>ouverture</label>
                  <input
                    v-model="formEtat.ouverture"
                    type="text"
                    name="ouverture"
                    placeholder="ouverture"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>circuit</label>
                  <input
                    v-model="formEtat.circuit"
                    name="circuit"
                    placeholder="circuit"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>divers</label>
                  <input
                    v-model="formEtat.divers"
                    name="divers"
                    placeholder="divers"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>plafonds</label>
                  <input
                    v-model="formEtat.plafonds"
                    name="plafonds"
                    placeholder="plafonds"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>cuisine</label>
                  <input
                    v-model="formEtat.cuisine"
                    name="cuisine"
                    placeholder="cuisine"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>salle de bain</label>
                  <input
                    v-model="formEtat.salledebain"
                    name="salledebain"
                    placeholder="salledebain"
                    class="form-control"
                  />
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>commentaire</label>
                  <textarea
                    v-model="formEtat.commentaire"
                    name="commentaire"
                    placeholder="commentaire"
                    class="form-control"
                  ></textarea>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
                <button  type="submit" class="btn btn-primary">Ajouter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Modal -->
    </div>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    this.type();
    this.bailleur();
    this.Equipement;
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
      editbien: false,
      Emode: false,
      Etatmode:false,
      Equipement: {},
      Etat:{},
      Biens: {},
      formE: new Form({
        bien_id: "",
        typeEquipement: "",
        nombre: "",
        etatEquipement: "",
        commentaire: ""
      }),
      formEquip: new Form({
        equipements_id: "",
        typeEquipement: "",
        nombreEquipement: "",
        etatEquipement: "",
        commentaireEquipement: "",
        bien: ""
      }),
      form: new Form({
        id: "",
        details: "",
        prix: "",
        bailleur: "",
        etat: "",
        adresse: "",
        typebien_id: "",
        etatLieux: "",
        murs: "",
        sols: "",
        ouverture: "",
        circuit: "",
        divers: "",
        commentaire: "",
        plafonds: "",
        cuisine: "",
        salledebain: ""
      }),
      formEtat: new Form({
        id: "",
        etatLieux: "",
        murs: "",
        sols: "",
        ouverture: "",
        circuit: "",
        divers: "",
        commentaire: "",
        plafonds: "",
        cuisine: "",
        salledebain: "",
        bien_id:""
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
    updateEquip(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formEquip
        .put("/api/equipements/" + this.formEquip.equipements_id)
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          Swal.fire("Deleted!", "l'équipement a bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          this.Emode = false;
          this.Detail(this.formEquip.bien);
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    deleteEquip(e) {
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
          this.formEquip
            .delete("api/equipements/" + e.equipements_id)
            .then(() => {
              Swal.fire(
                "Suppression!",
                "l'equipement a bien été supprimé.",
                "success"
              );
              Fire.$emit("AfterCreate");
              this.Emode = false;
              this.Detail(e.bien);
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
      deleteEtat(e) {
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
          this.formEtat
            .delete("api/lieux/" + e.equipements_id)
            .then(() => {
              Swal.fire(
                "Suppression!",
                "l'equipement a bien été supprimé.",
                "success"
              );
              Fire.$emit("AfterCreate");
              this.Emode = false;
              this.Detail(e.bien);
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    Eform(equipement) {
      console.log(equipement);
      this.Emode = true;
      this.formEquip.fill(equipement);
    },
      
    Etatform(etat) {
      console.log(etat);
      this.Etatmode = true;
      this.formEtat.fill(etat);
    },
    updateBiens(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/biens/" + this.form.bien_id)
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          $("#addNew").modal("hide");
          Swal.fire("Success!", "le biens bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          this.editbien = false;
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(equip) {
      this.editmode = true;
      this.formE.reset();
      $("#addNew").modal("show");
      this.formE.fill(equip);
    },
    editBien(bien) {
      this.editbien = true;
      this.form.reset();
      this.form.fill(bien);
    },
    newModal(id) {
      this.editmode = false;
      this.formE.reset();
      $("#addNew").modal("show");
      this.formE.bien_id = id;
    },
    newModalEtat(id) {
      
      this.formEtat.reset();
      $("#addNewEtat").modal("show");
      this.formEtat.bien_id = id;
    },
    DetailEtat(id) {
      axios.get("/api/lieux/" + id).then(response => {
        this.Etat = response.data.etat;
        console.log(response.data.etat);
      });
      $("#detailModalEtat").modal("show");
    },
    Detail(id) {
      axios.get("/api/biens/" + id).then(response => {
        this.Equipement = response.data.equipement;
        console.log(response.data.equipement);
      });
      $("#detailModal").modal("show");
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
      if (this.$gate.isAdminOrBailleurs()) {
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
    },
    createEquip() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formE
        .post("/api/addequip")
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
    ,
    createEtat() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formEtat
        .post("/api/lieux")
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
