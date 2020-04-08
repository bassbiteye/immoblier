<template>
  <div class="conteiner">
    <!-- bien -->

    <div class="row mt-5" v-if="$gate.isAdminOrBailleurs()">
      <div class="col-md-12" v-if="showTab">
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
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>description</th>
                  <th>etat</th>
                  <th>type</th>
                  <th>prix</th>
                  <th>adresse</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="biens in Biens.data" :key="biens.id">
                  <td>{{biens.details}}</td>
                  <td>{{biens.etat}}</td>
                  <td>{{biens.libelle}}</td>
                  <td>{{biens.prix}}</td>
                  <td>{{biens.adresse}}</td>

                  <td>
                    <button class="btn btn-success" @click="detail(biens)">
                      <i class="fas fa-rent-plus fa fw"></i> louer
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

    <section class="container-fluid" v-if="showForm">
      <div class="row">
        <div class="col-lg-6">
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">client</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6"></div>
                  </div>
                  <form @submit.prevent="findClient">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">numéro client</label>
                          <input
                            v-model="formT.numero"
                            type="text"
                            class="form-control"
                            placeholder="numero client"
                            @keyup.enter="findClient"
                            :class="{ 'is-invalid': form.errors.has('numero') }"
                          />

                          <has-error :form="formT" field="numero"></has-error>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <button
                          class="btn btn-success"
                          type="submit"
                          style="    margin-top: 29px;"
                        >rechercher</button>
                      </div>
                    </div>
                  </form>
                  <form @submit.prevent="finaliser">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">nom client</label>
                          <input
                            v-model="form.client"
                            type="text"
                            class="form-control"
                            placeholder="nom client"
                            readonly
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">caution</label>
                          <input
                            v-model="form.caution"
                            type="number"
                            class="form-control"
                            placeholder="caution"
                            :class="{ 'is-invalid': form.errors.has('caution') }"
                          />
                          <has-error :form="form" field="caution"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">montant payé</label>
                          <input
                            v-model="form.montantPaye"
                            type="number"
                            class="form-control"
                            placeholder="montant payé"
                            :class="{ 'is-invalid': form.errors.has('montantPaye') }"
                          />
                          <has-error :form="form" field="montantPaye"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="form-control-label">Date entrée</label>
                          <input
                            v-model="form.dateEntre"
                            type="date"
                            class="form-control"
                            placeholder="Date entrée"
                            :class="{ 'is-invalid': form.errors.has('dateEntre') }"
                          />
                          <has-error :form="form" field="dateEntre"></has-error>
                        </div>
                      </div>
                      <!-- <label for=""> Date de Reception</label>
                      <input type="date" placeholder="Nom du destinataire" v-model="form.destinataire" />-->
                    </div>

                    <div clas="row">
                      <button class="btn btn-primary" type="submit">finaliser</button>
                    </div>
                    <!--  ===================================================End table d'acces=======================================================   -->
                  </form>
                  <!-- /.card-body -->
                </div>
              </div>

              <!-- /.card -->
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Bien</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                  <table class="table table-striped table-responsive-fluid">
                    <tbody>
                      <tr>
                        <td>
                          libelle
                          <input
                            :placeholder="form.libelle"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          etat
                          <input
                            :placeholder="form.etat"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          prix
                          <input
                            :placeholder="form.prix"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          adresse
                          <input
                            :placeholder="form.adresse"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          details
                          <input
                            :placeholder="form.details"
                            readonly
                            style="border:hidden;background:none;"
                          />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--  ===================================================End table d'acces=======================================================   -->
                </div>
                <!-- /.card-body -->
              </div>

              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <div v-if="!$gate.isAdminOrBailleurs()">
      <not-found></not-found>
    </div>
    <section class="content" v-if="detailOperation">
      <div class="container-fluid">
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
                  <h3>locataire</h3> 
                  <address>
                    <strong>{{client.prenom}}</strong>
                    <strong>{{client.nom}}</strong>

                    <br />
                    Phone: {{client.tel}}
                    <br />
                    sexe: {{client.sexe}}
                    <br />

                    adresse: {{client.adresse}}
                    <br />
                    profession: {{client.profession}}
                    <br />
                    nationalité: {{client.nationalite}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>Bien</h3>
                  <br />
                  <br />
                  <b>Bien:</b> {{bien.details}}
                  <br />
                  <b>Prix:</b> {{bien.prix}}
                  <br />
                  <b>Adresse:</b> {{bien.adresse}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Serial #</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Call of Duty</td>
                        <td>455-981-221</td>
                        <td>El snort testosterone trophy driving gloves handsome</td>
                        <td>$64.50</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
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
    <!-- /.content -->
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
      Biens: {},
      client: {},
      operation: {},
      bien: {},
      date: new Date(),
      showTab: true,
      detailOperation: false,
      showForm : false,
      form: new Form({
        bien_id: "",
        details: "",
        etat: "",
        libelle: "",
        prix: "",
        adresse: "",
        caution: "",
        montantPaye: "",
        dateEntre: "",
        client: "",
        numero: ""
      }),
      formT: new Form({
        numero: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/listebiens?page=" + page).then(response => {
        this.Biens = response.data;
      });
    },
    detail(bien) {
      this.showTab = false;
      this.showForm= true
      this.form.fill(bien);
    },
    finaliser() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/louer")
        .then(response => {
          //this will update dom automatically
          //this.loadUsers();
          this.operation = response.data.Operation;
          this.client = response.data.client;
          this.bien = response.data.bien;
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "User created successfully"
          });
          this.$Progress.finish();
          this.detailOperation = true;
          this.showForm= false;
          this.showTab=true
        })
        .catch(e => {
          console.log(e);
        });
    },
    findClient() {
      this.formT.post("/api/findclient").then(response => {
        let $client = response.data;
        this.form.client = $client.nom;
        this.form.numero = $client.tel;
      });
    },
        contrat() {
            this.showTab=true
      
    },
    created() {
      this.loadbiens();
      Fire.$on("AfterCreate", () => {
        this.loadbiens();
      });
      //setInterval(()=>this.loadbiens(),10000)
    }
  }
};
</script>
