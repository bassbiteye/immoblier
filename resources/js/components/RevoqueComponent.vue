<template>
  <div class="conteiner">
    <!-- bien -->

    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12" v-if="showTab">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des locations</h3>

            <div class="card-tools">
              <!-- <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter Equipement
              </button>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="table2" class="table table-hover">
              <thead>
                <tr>
                  <th>Nom complet</th>
                  <th>adresse</th>
                  <th>Bien</th>
                  <th>prix</th>
                  <th>Caution</th>
                  <th>numero</th>

                  <th>statut</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody v-for="operation in Operation.data" :key="operation.id">
                <tr v-if="operation.statut=='louer'" style="background-color:#5ad09e">
                  <td>{{operation.prenom}} {{operation.nom}}</td>
                  <td>{{operation.adresse}}</td>
                  <td>{{operation.details}}</td>
                  <td>{{operation.prix}}</td>
                  <td>{{operation.caution}}</td>
                  <td>{{operation.ref}}</td>
                  <td>{{operation.statut}}</td>
                  <td>
                    <button class="btn btn-success" @click="detail(operation)">
                      <i class="fas fa-rent-plus fa fw"></i> detail
                    </button>
                  </td>
                </tr>
                <tr v-if="operation.statut=='revoquer'" style="background-color:#f21d59">
                  <td>{{operation.prenom}} {{operation.nom}}</td>
                  <td>{{operation.adresse}}</td>
                  <td>{{operation.details}}</td>
                  <td>{{operation.prix}}</td>
                  <td>{{operation.caution}}</td>
                  <td>{{operation.ref}}</td>
                  <td>{{operation.statut}}</td>
                  <td>
                    <button class="btn btn-success" @click="detail(operation)">
                      <i class="fas fa-rent-plus fa fw"></i> detail
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="Operation" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>
    <section class="content" v-if="detailShow">
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
                    <strong>{{details.prenom}}</strong>
                    <strong>{{details.nom}}</strong>

                    <br />
                    Phone: {{details.tel}}
                    <br />
                    sexe: {{details.sexe}}
                    <br />
                    adresse: {{details.adresse}}
                    <br />
                    profession: {{details.profession}}
                    <br />
                    nationalité: {{details.nationalite}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>Bien</h3>

                  <b>Bien:</b>
                  {{details.details}}
                  <br />
                  <b>Prix:</b>
                  {{details.prix}}
                  <br />
                  <b>Adresse:</b>
                  {{details.adresse}}
                  <br />
                  <b>référence location:</b>
                  {{details.ref}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="form-row">
                <div
                  class="col row no-print"
                  @click="dernier(details.dernierelevé)"
                  v-if="details.dernierelevé"
                >
                  <button type="button" class="btn btn-success float-right">
                    <i class="fas fa-download"></i>
                    dernier relevé
                  </button>
                </div>
                <div class="col row no-print" @click="piece(details.piece)" v-if="details.piece">
                  <button type="button" class="btn btn-primary float-right">
                    <i class="fas fa-print"></i>
                    piece
                  </button>
                </div>
                <div class="col row no-print" v-if="statut=='louer'" @click="Revoquer(details)">
                  <button type="button" class="btn btn-danger float-right">
                    <i class="fas fa-trash"></i>
                    Revoquer
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
    setTimeout(function() {
      $("#table2").DataTable({
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
      Operation: {},
      details: {},
      detailShow: false,
      showTab: true,
      statut: "",
      date: new Date(),
      form: new Form({
        numero: "",
        operation_id: "",
        bien_id: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/revoque?page=" + page).then(response => {
        this.Operation = response.data;
      });
    },
    dernier(e) {
      window.open("img/profile/" + e);
    },
    piece(e) {
      window.open("img/profile/" + e);
    },

    Revoquer(e) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Révoquer!",
        cancelButtonText: "Annuler"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.form
            .post("/api/addrevoque")
            .then(() => {
              Swal.fire("success!", "Révocation avec success.", "success");
              this.getResults();
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
      this.$Progress.start();
      this.detailShow = false;
    },
    detail(e) {
      this.detailShow = true;
      this.details = e;
      this.statut = e.statut;
      this.form.operation_id = e.operation_id;
      this.form.bien_id = e.bien_id;
    },

    created() {
      this.getResults();
      Fire.$on("AfterCreate", () => {
        this.getResults();
      });
      //setInterval(()=>this.loadOperation(),10000)
    }
  }
};
</script>
