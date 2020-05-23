<template>
  <div class="conteiner">
    <!-- Modal: modalBailleur -->
    <div
      class="modal fade"
      id="modalCart"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bailleur</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th scope="row">Nom Complet</th>
                  <td>{{DetailBailleur.name}}</td>
                </tr>
                <tr>
                  <th scope="row">Email</th>
                  <td>{{DetailBailleur.email}}</td>
                </tr>
                <tr>
                  <th scope="row">Telephone</th>
                  <td>{{DetailBailleur.telephone}}</td>
                </tr>
                <tr>
                  <th scope="row">Adresse</th>
                  <td>{{DetailBailleur.adresse}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">Profession</th>
                  <td>{{DetailBailleur.profession}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">Nationalite</th>
                  <td>{{DetailBailleur.nationalite}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">Type de Bailleur</th>
                  <td>{{DetailBailleur.typebailleur}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">NombreBien</th>
                  <td>{{nombreBien}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">Boite Postale</th>
                  <td>{{DetailBailleur.bp}}</td>
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
    <!-- Modal: modalBailleur -->
    <div class="row mt-5" v-if="$gate.isAdmin()" v-show="!detail">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des Bailleurs</h3>

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
                  <th>nom Complet</th>
                  <th>email</th>
                  <th>telephone</th>
                  <th>adresse</th>
                  <th>profession</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="bailleur in bailleurs.data" :key="bailleur.id">
                  <td>{{bailleur.name}}</td>
                  <td>{{bailleur.email}}</td>
                  <td>{{bailleur.telephone}}</td>
                  <td>{{bailleur.adresse}}</td>
                  <td>{{bailleur.profession}}</td>

                  <td>
                    <a href="#" @click="editModal(bailleur)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteBailleur(bailleur.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                    <a @click="detailBailleur(bailleur)">
                      <i class="fa fa-eye blue"></i>
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier bailleur</h5>
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
                <label>type de Bailleur</label>
                <select
                  v-model="form.typebailleurs_id"
                  name="typebailleurs_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('typebailleurs_id') }"
                >
                  <option>selectionner le compte</option>
                  <option
                    v-for="types in typebailleurs.data"
                    :key="types.typebailleurs_id"
                    :value="types.libelle"
                  >{{types.libelle}}</option>
                </select>
                <has-error :form="form" field="typebailleurs"></has-error>
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

    <!-- /.content -->

    <section class="content">
      <div class="container-fluid" v-show="detail">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> ALAWA.
                    <small class="float-right">Date: {{date|myDate}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h3>propriétaire</h3>
                  <address>
                    <strong>alawa.</strong>
                    <br />alawa
                    <br />alawa
                    <br />Phone: alawa
                    <br />Email: info@alawa.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>Bailleur</h3>
                  <address>
                    <strong>{{bailleurC.name}}</strong>
                    <br />
                    Phone: {{bailleurC.telephone}}
                    <br />
                    sexe: {{bailleurC.sexe}}
                    <br />
                    adresse: {{bailleurC.adresse}}
                    <br />
                    profession: {{bailleurC.profession}}
                    <br />
                    nationalité: {{bailleurC.nationalite}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>compte</h3>
                  <address>
                    <br />
                    numéro: {{bailleurC.numero}}
                    <br />
                    solde: {{bailleurC.solde}}
                  </address>
                </div>
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <p>
                    "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
                    1914 translation by H. Rackham
                    "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"
                    "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
                    1914 translation by H. Rackham
                    "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"
                  </p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print" @click="printDetails()">
                <div class="col-12">
                  <button type="button" class="btn btn-success float-right">
                    <i class="fas fa-print"></i>
                    contrat
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    this.getTypebailleurs();
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
      detail: false,
      editmode: false,
      bailleurs: {},
      typebailleurs: {},
      bailleurC: {},
      date: new Date(),
      DetailBailleur: {},
      nombreBien: {},

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
        sexe: "",
        profession: "",
        nationalite: "",
        bp: "",
        typebailleur: ""
      }),
      formB: new Form({
        id: ""
      })
    };
  },
  methods: {
    printDetails() {
      window.print();
      this.detail = false;
    },
    print() {
      this.detail = true;
    },
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/bailleurs?page=" + page).then(response => {
        this.bailleurs = response.data;
      });
    },
    getTypebailleurs() {
      axios.get("api/typeballieurs").then(response => {
        this.typebailleurs = response.data;
      });
    },
    detailBailleur(b) {
      this.formB.id = b.id;
      this.formB.post("api/countbiensbailleurs").then(response => {
        this.nombreBien = response.data;
      });
      $("#modalCart").modal("show");
      this.DetailBailleur = b;
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
          Swal.fire("Deleted!", "La bailleur a été modifié avec success.", "success");
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
        title: "Etes vous sure?",
        text: "Cette action est réversible!",
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
              Swal.fire("Deleted!", "Le bailleur a été supprimé.", "success");
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
        .then(response => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "Bailleur créé avec success"
          });
          this.$Progress.finish();
          this.bailleurC = response.data;
          this.detail = true;
          this.print();
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
