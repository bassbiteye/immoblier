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
    <div class="row mt-5" v-if="$gate.isAdminOrUser()" v-show="!detail">
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                   
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                
                  <address>
                    <img src="/img/logo2.png" alt="">
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <!-- <h3>Bailleur</h3>
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
                  </address> -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <!-- <h3>compte</h3>
                  <address>
                    <br />
                    numéro: {{bailleurC.numero}}
                    <br />
                    solde: {{bailleurC.solde}}
                  </address> -->
                  <p>
                    OUEST FOIRE DERRIERE St. SHELL
                    BP. 11 744 Dakar - Peytavin
                    Tél : (221) 33 820 71 90 / 33 820 71 21
                    Portable : (221)77 635 93 16
                    Email: mbolyama1@hotmail.com
                  </p>
                </div>
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <div style="margin-left:20px">
                    <H1 style="text-align:center">MANDAT DE GERANCE</H1>

                    <P>
                      <br>
                      <strong>Entre …………………………….</strong> CNI N° ……………………… délivrée le {{date|myDate}} à Dakar
                      <br />
                      <strong>Demeurant {{bailleurC.adresse}}</strong>
                      <br />
                      <strong>Tél : {{bailleurC.telephone}}</strong>
                    </P>

                    <strong style="float:right">(Propriétaire) d’une part</strong>
                    <strong>Et</strong>
                    <strong>MBOLYAMA CABINET IMMOBILIER représenté par son Administrateur, Madame MBAYE.</strong>
                    <p>
                      Sis à Ouest Foire, derrière la Station SHELL / BP. 11 744 Dakar – SENEGAL
                      <br />Tél : 33 820 71 21 Portable (221) 77 635 93 16
                      <br />Ayant satisfait aux obligations de la loi n° 71-47 du 28 juillet 1971 et à son décret d’application n° 711103 DU 11 OCTOBRE 1971, titulaire de l’autorisation d’exercer n° 0095 du 15 Février 2001.
                    </p>
                    <strong>(Mandataire) d’autre part,</strong>

                    <p>
                      Il a été convenu et arrêté ce qui suit :
                      <strong>{{bailleurC.name}} (Propriétaire)</strong>
                      <br />donne par les présentes, pouvoir au CABINET IMMOBILIER MBOLYAMA
                      <br />(Administrateur de biens), qui accepte de gérer et d’administrer le local à usage commercial ou professionnel ci-dessous désigné.
                      <br />Le présent contrat est régi par les dispositions des Articles 457 à 472 du C.O.C.C. et, prend effet à compter du …………………………….. pour une durée ………….. renouvelable.
                    </p>

                    <strong>DESIGNATION DE ……………………………</strong>

                    <table style="border: 2px">
                      <tr>
                        <th colspan="4">Immeuble ………… FAISANT OBJET DU PRESENT MANDAT</th>
                      </tr>

                      <tr>
                        <td>DESIGNATION</td>
                        <td>NOMBRE</td>
                        <td>Montant du loyer Mensuel</td>
                        <td>TOTAL LOYER</td>
                      </tr>
                      <tr>
                        <td>Ernst Handel</td>
                        <td>Roland Mendel</td>
                        <td>Austria</td>
                        <td>Mexico</td>
                      </tr>
                      <tr>
                        <td>Island Trading</td>
                        <td>Helen Bennett</td>
                        <td>UK</td>
                        <td>Mexico</td>
                      </tr>
                      <tr>
                        <td>Laughing Bacchus Winecellars</td>
                        <td>Yoshi Tannamuri</td>
                        <td>Canada</td>
                      </tr>
                      <tr>
                        <td colspan="3">TOTAL RAPPORT MENSUEL</td>
                        <td>200000</td>
                      </tr>
                    </table>
                    <p>
                      Chacune des parties pourra résilier le contrat par acte extra judiciaire avec accusé de réception,
                      <br />au moins six (06) mois avant l’expiration de chaque période.
                      <br />En cas de résiliation par anticipation du présent contrat et sans observation des six (06) mois de préavis,
                      une indemnité compensatrice équivalente au taux de gérance calculé sur les six (06)
                      <br />mois sera versée à l’autre partie.
                    </p>
                    <p>
                      En outre, le présent mandat est donné au CABINET IMMOBILIER MBOLYAMA
                      <br />(Administrateur de biens), selon les conditions suivantes :
                    </p>
                    <p>
                      1. Obligation de faire parvenir à …………………………. (propriétaire),
                      <br />le compte détaillé de sa gestion, au moins deux fois par an.
                      <br />2. Obligation de percevoir à titre d’honoraires le taux de …………. (………)% + T.V.A, sur les sommes encaissées (mensuellement, trimestriellement, semestriellement,
                      ou annuellement) avec un bordereau de reversement a l’appui établi en faveur du propriétaire ……………………………………
                      <br />3. En cas de non paiement des loyers par le locataire, tous les frais judiciaires et
                      <br />extrajudiciaires appropriés seront pré financés par le propriétaire.
                      <br />
                    </p>

                    <p>
                      Pour permettre à MBOLYAMA CABINET IMMOBILIER (Administrateur de biens)
                      <br />de remplir la mission qui lui est confiée par les présentes, ………………………. (Propriétaire),
                      <br />lui donne également pouvoir en son nom et pour son compte :
                    </p>
                    <p>
                      • De louer pour la durée et aux conditions qu’il déterminera
                      • De renouveler ou de résilier les locations avec ou sans indemnité
                      <br />• De donner et d’accepter tous congés
                      <br />• De percevoir des loyers, dépôts de garantie, pas de porte
                      <br />• D’exercer contre les défaillants toutes les actions judiciaires ou extra judiciaires appropriées, transiger, assigner, défendre ou de choisir tout défenseur, de faire exécuter
                      <br />les décisions rendues, d’exercer toutes voies de recours et de s’en désister
                      <br />• De délivrer toutes quittances, décharges, mains levées et, plus généralement, faire le nécessaire au titre des intérêts du propriétaire.
                    </p>

                    <p>
                      Le propriétaire qui désire que le mandataire fasse sa déclaration fiscale, doit faire une lettre écrite comprenant les noms et prénoms des personnes qui sont à sa charge.
                      <br />Nous vous rappelons que la déclaration annuelle des revenus est obligatoire et doit être versée à
                      <br />la fin de l’année échue et au plus tard le 28 février de l’année qui suit.
                      <br />
                    </p>
                    <p>Le propriétaire s’engage à assurer la sécurité de son bien dès que celui-ci sera vacant.</p>.
                    <p>
                      Le CABINET IMMOBILIER MBOLYAMA accepte de prendre en gérance le bien qui lui est
                      <br />confié par ………………………………………. (propriétaire) dans son état actuel, tant dans
                      <br />son ensemble que dans les détails, les erreurs ou malfaçons qui seront constatés pendant la
                      <br />gérance ne saurait engager la responsabilité du CABINET MBOLYAMA.
                      Certains travaux sont à la charge ………………………………….. (propriétaire) à savoir :
                      <br />• La peinture extérieure du bien
                      <br />• L’usure de la tuyauterie du bâtiment due à la vétusté du matériel.
                      <br />
                    </p>CLAUSES PARTICULIERES :
                    ……………………………….. M. MBAYE
                    (Propriétaire)
                    Lu et Approuvé le
                    (Signature)
                    Fait à Dakar, le ………………………………………
                    (En trois exemplaires)
                  </div>
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
          Swal.fire(
            "Deleted!",
            "La bailleur a été modifié avec success.",
            "success"
          );
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
      if (this.$gate.isAdminOrUser()) {
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
